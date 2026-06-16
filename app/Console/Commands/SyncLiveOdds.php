<?php

namespace App\Console\Commands;

use App\Services\OddsApiService;
use Illuminate\Console\Command;

class SyncLiveOdds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'odds:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch the latest sportsbook odds from The Odds API and store them';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(OddsApiService $oddsApi)
    {
        if (! $oddsApi->isConfigured()) {
            $this->warn('ODDS_API_KEY is not set in .env — skipping sync.');

            return Command::SUCCESS;
        }

        $results = $oddsApi->syncAll();

        foreach ($results as $sport => $count) {
            $this->info("{$sport}: synced {$count} events");
        }

        return Command::SUCCESS;
    }
}
