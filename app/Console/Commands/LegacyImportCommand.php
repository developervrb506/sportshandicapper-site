<?php

namespace App\Console\Commands;

use App\Models\Contest;
use App\Models\SupportTicket;
use App\Models\Tip;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class LegacyImportCommand extends Command
{
    protected $signature = 'legacy:import
        {--tips : Import tips from inspin_main.sql}
        {--tickets : Import tickets from inspin_tickets.sql}
        {--contests : Import contests from inspin_superbowl_contest.sql and inspin_march_madness.sql}
        {--all : Import all supported modules}
        {--truncate : Truncate target tables before import}
        {--dry-run : Parse files and print counters without writing data}';

    protected $description = 'Import legacy SQL dump data into Laravel module tables';

    public function handle(): int
    {
        $runAll = (bool) $this->option('all');
        $runTips = $runAll || (bool) $this->option('tips');
        $runTickets = $runAll || (bool) $this->option('tickets');
        $runContests = $runAll || (bool) $this->option('contests');

        if (! $runTips && ! $runTickets && ! $runContests) {
            $runAll = true;
            $runTips = true;
            $runTickets = true;
            $runContests = true;
        }

        $dryRun = (bool) $this->option('dry-run');
        $truncate = (bool) $this->option('truncate');

        if ($truncate && ! $dryRun) {
            if ($runTips) {
                DB::table('tips')->truncate();
            }
            if ($runTickets) {
                DB::table('support_tickets')->truncate();
            }
            if ($runContests) {
                DB::table('contests')->truncate();
            }
        }

        if ($runTips) {
            $count = $this->importTips($dryRun);
            $this->info("Tips parsed/imported: {$count}");
        }

        if ($runTickets) {
            $count = $this->importTickets($dryRun);
            $this->info("Tickets parsed/imported: {$count}");
        }

        if ($runContests) {
            $count = $this->importContests($dryRun);
            $this->info("Contests parsed/imported: {$count}");
        }

        return self::SUCCESS;
    }

    private function importTips(bool $dryRun): int
    {
        $file = $this->legacySqlPath('inspin_main.sql');
        $rows = $this->parseInsertRows($file, 'wp_dailytipdata');
        $count = 0;

        foreach ($rows as $row) {
            $payload = [
                'id' => (int) $row['id'],
                'added_date' => $this->nullDate($row['added_date']),
                'tip_title' => $this->nullString($row['tip_title']),
                'tip_text' => $this->nullString($row['tip_text']),
                'group_name' => $this->nullString($row['group_name']),
                'display_yearly' => $this->toBool($row['Display_yearly'] ?? null),
                'display_date' => $this->nullDate($row['display_date']),
                'shown_date' => $this->nullDate($row['shown_date']),
                'display_day' => $this->nullInt($row['display_day']),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if (! $dryRun) {
                DB::table('tips')->updateOrInsert(['id' => $payload['id']], $payload);
            }

            $count++;
        }

        return $count;
    }

    private function importTickets(bool $dryRun): int
    {
        $file = $this->legacySqlPath('inspin_tickets.sql');
        $rows = $this->parseInsertRows($file, 'ticket');
        $count = 0;

        foreach ($rows as $row) {
            $legacyDate = $this->nullDateTime($row['tdate']);
            $payload = [
                'id' => (int) $row['id'],
                'source_system' => 'inspin_tickets',
                'external_id' => $this->nullString($row['id_external']),
                'customer_name' => $this->nullString($row['name']),
                'customer_email' => $this->nullString($row['email']),
                'subject' => $this->nullString($row['subject']),
                'message' => $this->nullString($row['message']),
                'status' => $this->toBool($row['open']) ? 'open' : 'closed',
                'priority' => null,
                'legacy_created_at' => $legacyDate,
                'legacy_updated_at' => $legacyDate,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if (! $dryRun) {
                DB::table('support_tickets')->updateOrInsert(['id' => $payload['id']], $payload);
            }

            $count++;
        }

        return $count;
    }

    private function importContests(bool $dryRun): int
    {
        $count = 0;

        $superbowlRows = $this->parseInsertRows($this->legacySqlPath('inspin_superbowl_contest.sql'), 'contests');
        foreach ($superbowlRows as $row) {
            $payload = [
                'id' => (int) $row['id'],
                'name' => (string) $row['name'],
                'contest_type' => 'superbowl',
                'description' => null,
                'starts_at' => null,
                'ends_at' => null,
                'status' => $this->toBool($row['active']) ? 'active' : 'inactive',
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if (! $dryRun) {
                DB::table('contests')->updateOrInsert(['id' => $payload['id']], $payload);
            }

            $count++;
        }

        $marchRows = $this->parseInsertRows($this->legacySqlPath('inspin_march_madness.sql'), 'contest');
        foreach ($marchRows as $row) {
            $payload = [
                'id' => 100000 + (int) ($row['contestID'] ?? 0),
                'name' => (string) ($row['contestName'] ?? 'March Madness Contest'),
                'contest_type' => 'march_madness',
                'description' => null,
                'status' => $this->toBool($row['active'] ?? null) ? 'active' : 'inactive',
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if (! $dryRun) {
                DB::table('contests')->updateOrInsert(['id' => $payload['id']], $payload);
            }

            $count++;
        }

        return $count;
    }

    private function parseInsertRows(string $filePath, string $table): array
    {
        if (! file_exists($filePath)) {
            $this->warn("Missing file: {$filePath}");
            return [];
        }

        $sql = file_get_contents($filePath);
        if ($sql === false) {
            return [];
        }

        $pattern = '/INSERT INTO `'.preg_quote($table, '/').'` \((.*?)\) VALUES (.*?);/s';
        preg_match_all($pattern, $sql, $matches, PREG_SET_ORDER);

        $parsed = [];
        foreach ($matches as $match) {
            $columns = array_map(
                fn ($col) => trim($col, " `\r\n\t"),
                explode(',', $match[1])
            );

            $rowChunks = $this->splitSqlRows($match[2]);
            foreach ($rowChunks as $chunk) {
                $values = $this->splitSqlValues($chunk);
                if (count($values) !== count($columns)) {
                    continue;
                }
                $parsed[] = array_combine($columns, $values);
            }
        }

        return $parsed;
    }

    private function splitSqlRows(string $valuesPart): array
    {
        $rows = [];
        $buffer = '';
        $depth = 0;
        $inString = false;
        $len = strlen($valuesPart);

        for ($i = 0; $i < $len; $i++) {
            $ch = $valuesPart[$i];
            $prev = $i > 0 ? $valuesPart[$i - 1] : '';

            if ($ch === "'" && $prev !== '\\') {
                $inString = ! $inString;
            }

            if (! $inString) {
                if ($ch === '(') {
                    $depth++;
                } elseif ($ch === ')') {
                    $depth--;
                }
            }

            $buffer .= $ch;

            if (! $inString && $depth === 0 && trim($buffer) !== '') {
                $clean = trim($buffer);
                if (str_starts_with($clean, '(') && str_ends_with($clean, ')')) {
                    $rows[] = substr($clean, 1, -1);
                }
                $buffer = '';
                while ($i + 1 < $len && ($valuesPart[$i + 1] === ',' || ctype_space($valuesPart[$i + 1]))) {
                    $i++;
                }
            }
        }

        return $rows;
    }

    private function splitSqlValues(string $row): array
    {
        $values = [];
        $buffer = '';
        $inString = false;
        $len = strlen($row);

        for ($i = 0; $i < $len; $i++) {
            $ch = $row[$i];
            $prev = $i > 0 ? $row[$i - 1] : '';

            if ($ch === "'" && $prev !== '\\') {
                $inString = ! $inString;
                $buffer .= $ch;
                continue;
            }

            if ($ch === ',' && ! $inString) {
                $values[] = $this->normalizeSqlValue($buffer);
                $buffer = '';
                continue;
            }

            $buffer .= $ch;
        }

        $values[] = $this->normalizeSqlValue($buffer);

        return $values;
    }

    private function normalizeSqlValue(string $value): mixed
    {
        $trimmed = trim($value);
        if (strtoupper($trimmed) === 'NULL') {
            return null;
        }

        if (str_starts_with($trimmed, "'") && str_ends_with($trimmed, "'")) {
            $content = substr($trimmed, 1, -1);
            $content = str_replace("\\'", "'", $content);
            $content = str_replace('\\\\', '\\', $content);
            return $content;
        }

        return $trimmed;
    }

    private function legacySqlPath(string $file): string
    {
        return base_path('..'.DIRECTORY_SEPARATOR.'cpmove-inspin'.DIRECTORY_SEPARATOR.'mysql'.DIRECTORY_SEPARATOR.$file);
    }

    private function nullString(mixed $value): ?string
    {
        if ($value === null) {
            return null;
        }
        $text = trim((string) $value);
        return $text === '' ? null : $text;
    }

    private function nullInt(mixed $value): ?int
    {
        if ($value === null || $value === '') {
            return null;
        }
        return (int) $value;
    }

    private function nullDate(mixed $value): ?string
    {
        if ($value === null) {
            return null;
        }
        $text = trim((string) $value);
        if ($text === '' || $text === '0000-00-00') {
            return null;
        }
        return $text;
    }

    private function nullDateTime(mixed $value): ?Carbon
    {
        if ($value === null) {
            return null;
        }
        $text = trim((string) $value);
        if ($text === '' || $text === '0000-00-00 00:00:00') {
            return null;
        }
        return Carbon::parse($text);
    }

    private function toBool(mixed $value): bool
    {
        $text = strtolower(trim((string) ($value ?? '')));
        return in_array($text, ['1', 'on', 'true', 'yes'], true);
    }
}
