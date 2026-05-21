<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\Tip;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ImportWordPressData extends Command
{
    protected $signature = 'import:wordpress {--type=all : all, tips, articles, users}';
    protected $description = 'Import WordPress data from legacy SQL dumps into Laravel tables';

    protected $sqlPath;

    public function handle()
    {
        $this->sqlPath = base_path('../cpmove-inspin/mysql/inspin_main.sql');

        if (!file_exists($this->sqlPath)) {
            $this->error("SQL file not found at: {$this->sqlPath}");
            return Command::FAILURE;
        }

        $type = $this->option('type');

        if ($type === 'all' || $type === 'tips') {
            $this->importTips();
        }
        if ($type === 'all' || $type === 'articles') {
            $this->importArticles();
        }
        if ($type === 'all' || $type === 'users') {
            $this->importUsers();
        }

        $this->info('Import complete!');
        return Command::SUCCESS;
    }

    protected function importTips()
    {
        $this->info('Importing tips from wp_dailytipdata...');
        $count = 0;

        $this->processInsertStatements('wp_dailytipdata', function ($values) use (&$count) {
            if (count($values) < 9) return;

            $addedDate = $this->clean($values[1]);
            $displayDate = $this->clean($values[6]);
            $shownDate = $this->clean($values[7]);
            $displayYearly = strtolower($this->clean($values[5]));

            Tip::updateOrCreate(
                ['id' => (int) $this->clean($values[0])],
                [
                    'added_date' => $addedDate && $addedDate !== '0000-00-00' ? $addedDate : null,
                    'tip_title' => $this->clean($values[2]),
                    'tip_text' => $this->clean($values[3]),
                    'group_name' => $this->clean($values[4]),
                    'display_yearly' => $displayYearly === 'on' || $displayYearly === '1',
                    'display_date' => $displayDate && $displayDate !== '0000-00-00' ? $displayDate : null,
                    'shown_date' => $shownDate && $shownDate !== '0000-00-00' ? $shownDate : null,
                    'display_day' => isset($values[8]) ? (int) $this->clean($values[8]) : null,
                ]
            );
            $count++;
        });

        $this->info("Imported $count tips.");
    }

    protected function importArticles()
    {
        $this->info('Importing articles from wp_posts...');
        $count = 0;

        $this->processInsertStatements('wp_posts', function ($values) use (&$count) {
            if (count($values) < 17) return;

            $status = $this->clean($values[11]);
            $postType = $this->clean($values[16]);

            if ($status !== 'publish' || $postType !== 'post') return;

            $title = $this->clean($values[6]);
            $slug = $this->clean($values[12]);
            $publishedAt = $this->clean($values[3]);

            if (!$slug) {
                $slug = Str::slug($title);
            }

            if (Article::where('slug', $slug)->exists()) {
                return;
            }

            Article::create([
                'title' => $title,
                'slug' => $slug,
                'excerpt' => $this->clean($values[7]),
                'content' => $this->clean($values[5]),
                'category' => $this->detectCategory($title),
                'sport' => $this->detectSport($title),
                'author' => 'INSPIN Staff',
                'is_premium' => false,
                'is_published' => true,
                'published_at' => $publishedAt ?: now(),
            ]);
            $count++;
        });

        $this->info("Imported $count articles.");
    }

    protected function importUsers()
    {
        $this->info('Importing users from wp_users...');
        $count = 0;

        $this->processInsertStatements('wp_users', function ($values) use (&$count) {
            if (count($values) < 10) return;

            $email = $this->clean($values[2]);
            $login = $this->clean($values[1]);

            if (User::where('email', $email)->exists()) {
                return;
            }

            User::create([
                'name' => $login ?: $email,
                'email' => $email,
                'password' => Hash::make('inspin2024'),
                'role' => 'member',
            ]);
            $count++;
        });

        $this->info("Imported $count users. Default password: inspin2024");
    }

    protected function processInsertStatements($table, callable $callback)
    {
        $handle = fopen($this->sqlPath, 'r');
        if (!$handle) {
            $this->error("Cannot open SQL file");
            return;
        }

        $inInsert = false;
        $currentTable = '';
        $buffer = '';
        $lineCount = 0;

        while (($line = fgets($handle)) !== false) {
            $lineCount++;

            if (preg_match("/INSERT INTO `{$table}`\s*\(/", $line) || preg_match("/INSERT INTO `{$table}`\s*VALUES/", $line)) {
                $inInsert = true;
                $currentTable = $table;
                $buffer = $line;
                continue;
            }

            if ($inInsert && $currentTable === $table) {
                $buffer .= $line;

                if (str_contains(rtrim($line), ');') || str_contains(rtrim($line), ');')) {
                    $this->parseInsertValues($buffer, $callback);
                    $buffer = '';
                    $inInsert = false;
                    $currentTable = '';
                }
            }

            if ($lineCount % 10000 === 0) {
                $this->output->write('.');
            }
        }

        fclose($handle);
        $this->line('');
    }

    protected function parseInsertValues($insertSql, callable $callback)
    {
        $valuesStart = strpos($insertSql, 'VALUES');
        if ($valuesStart === false) return;

        $valuesPart = substr($insertSql, $valuesStart + 6);
        $valuesPart = trim($valuesPart);
        $valuesPart = rtrim($valuesPart, ';');
        $valuesPart = trim($valuesPart);

        $rows = $this->splitRows($valuesPart);

        foreach ($rows as $row) {
            $row = trim($row);
            if (empty($row)) continue;

            $row = trim($row, '()');
            $values = $this->parseValues($row);

            if (!empty($values)) {
                $callback($values);
            }
        }
    }

    protected function splitRows($valuesPart)
    {
        $rows = [];
        $current = '';
        $inQuotes = false;
        $escape = false;

        for ($i = 0; $i < strlen($valuesPart); $i++) {
            $char = $valuesPart[$i];

            if ($escape) {
                $current .= $char;
                $escape = false;
                continue;
            }

            if ($char === '\\') {
                $escape = true;
                $current .= $char;
                continue;
            }

            if ($char === "'") {
                $inQuotes = !$inQuotes;
                $current .= $char;
                continue;
            }

            if ($char === ')' && !$inQuotes) {
                $rows[] = $current;
                $current = '';
                continue;
            }

            if ($char === '(' && trim($current) === '') {
                continue;
            }

            if ($char === ',' && !$inQuotes && trim($current) === '') {
                continue;
            }

            $current .= $char;
        }

        return $rows;
    }

    protected function parseValues($row)
    {
        $values = [];
        $current = '';
        $inQuotes = false;
        $escape = false;

        for ($i = 0; $i < strlen($row); $i++) {
            $char = $row[$i];

            if ($escape) {
                $current .= $char;
                $escape = false;
                continue;
            }

            if ($char === '\\') {
                $escape = true;
                $current .= $char;
                continue;
            }

            if ($char === "'") {
                $inQuotes = !$inQuotes;
                $current .= $char;
                continue;
            }

            if ($char === ',' && !$inQuotes) {
                $values[] = $this->clean($current);
                $current = '';
                continue;
            }

            $current .= $char;
        }

        if (trim($current) !== '') {
            $values[] = $this->clean($current);
        }

        return $values;
    }

    protected function clean($value)
    {
        $value = trim($value);
        $value = trim($value, "'");
        $value = str_replace("\\'", "'", $value);
        $value = str_replace('\\"', '"', $value);
        $value = str_replace('\\\\', '\\', $value);
        $value = str_replace('\\n', "\n", $value);
        $value = str_replace('\\r', "\r", $value);
        $value = str_replace('\\t', "\t", $value);
        return trim($value);
    }

    protected function detectSport($text)
    {
        $upper = strtoupper($text);
        if (strpos($upper, 'NFL') !== false || strpos($upper, 'FOOTBALL') !== false || strpos($upper, 'COWBOYS') !== false || strpos($upper, 'SAINTS') !== false || strpos($upper, 'COLTS') !== false || strpos($upper, 'EAGLES') !== false || strpos($upper, 'BUCCANEERS') !== false) return 'NFL';
        if (strpos($upper, 'NBA') !== false || strpos($upper, 'BASKETBALL') !== false || strpos($upper, 'CELTICS') !== false || strpos($upper, 'LAKERS') !== false || strpos($upper, 'KNICKS') !== false || strpos($upper, 'HEAT') !== false || strpos($upper, '76ERS') !== false || strpos($upper, 'JAZZ') !== false || strpos($upper, 'RAPTORS') !== false) return 'NBA';
        if (strpos($upper, 'MLB') !== false || strpos($upper, 'BASEBALL') !== false || strpos($upper, 'YANKEES') !== false || strpos($upper, 'RED SOX') !== false) return 'MLB';
        if (strpos($upper, 'NHL') !== false || strpos($upper, 'HOCKEY') !== false || strpos($upper, 'LIGHTNING') !== false || strpos($upper, 'BLACKHAWKS') !== false || strpos($upper, 'STANLEY CUP') !== false) return 'NHL';
        if (strpos($upper, 'NCAA') !== false || strpos($upper, 'COLLEGE') !== false) return 'NCAA';
        return 'general';
    }

    protected function detectCategory($text)
    {
        $upper = strtoupper($text);
        if (strpos($upper, 'CONSENSUS') !== false) return 'consensus';
        if (strpos($upper, 'TREND') !== false || strpos($upper, 'SPLIT') !== false) return 'trends';
        if (strpos($upper, 'PICK') !== false || strpos($upper, 'BETTING') !== false) return 'picks';
        if (strpos($upper, 'NEWS') !== false) return 'news';
        return 'analysis';
    }
}
