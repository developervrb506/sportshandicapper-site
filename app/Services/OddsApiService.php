<?php

namespace App\Services;

use App\Models\LiveOdds;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OddsApiService
{
    /**
     * Sports we track, mapped to The Odds API sport keys.
     */
    public const SPORTS = [
        'NFL' => 'americanfootball_nfl',
        'NBA' => 'basketball_nba',
        'MLB' => 'baseball_mlb',
        'NHL' => 'icehockey_nhl',
        'NCAAF' => 'americanfootball_ncaaf',
        'NCAAB' => 'basketball_ncaab',
    ];

    protected string $baseUrl;
    protected ?string $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.odds_api.base_url');
        $this->apiKey = config('services.odds_api.key');
    }

    public function isConfigured(): bool
    {
        return ! empty($this->apiKey);
    }

    /**
     * Fetch and store odds for a single sport. Returns the number of events synced.
     */
    public function syncSport(string $sportLabel, string $sportKey): int
    {
        if (! $this->isConfigured()) {
            Log::warning("OddsApiService: ODDS_API_KEY not set, skipping sync for {$sportLabel}");

            return 0;
        }

        $response = Http::get("{$this->baseUrl}/sports/{$sportKey}/odds", [
            'apiKey' => $this->apiKey,
            'regions' => 'us',
            'markets' => 'h2h,spreads,totals',
            'oddsFormat' => 'american',
            'dateFormat' => 'iso',
        ]);

        if (! $response->successful()) {
            Log::error("OddsApiService: failed to fetch odds for {$sportLabel}", [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return 0;
        }

        $events = $response->json();

        foreach ($events as $event) {
            $this->storeEvent($sportLabel, $sportKey, $event);
        }

        return count($events);
    }

    /**
     * Sync odds for every tracked sport.
     */
    public function syncAll(): array
    {
        $results = [];

        foreach (self::SPORTS as $label => $key) {
            $results[$label] = $this->syncSport($label, $key);
        }

        return $results;
    }

    protected function storeEvent(string $sportLabel, string $sportKey, array $event): void
    {
        foreach ($event['bookmakers'] ?? [] as $bookmaker) {
            foreach ($bookmaker['markets'] ?? [] as $market) {
                LiveOdds::updateOrCreate(
                    [
                        'event_id' => $event['id'],
                        'bookmaker_key' => $bookmaker['key'],
                        'market_key' => $market['key'],
                    ],
                    [
                        'sport_key' => $sportKey,
                        'sport_title' => $sportLabel,
                        'commence_time' => $event['commence_time'],
                        'home_team' => $event['home_team'],
                        'away_team' => $event['away_team'],
                        'bookmaker_title' => $bookmaker['title'],
                        'outcomes' => $market['outcomes'],
                        'last_update' => $market['last_update'] ?? $bookmaker['last_update'] ?? now(),
                    ]
                );
            }
        }
    }
}
