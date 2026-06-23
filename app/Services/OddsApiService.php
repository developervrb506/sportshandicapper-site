<?php

namespace App\Services;

use App\Models\LiveOdds;
use App\Support\TeamBranding;
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

    /**
     * Fetch upcoming games (next 7 days) with per-bookmaker odds, ready for display.
     * Shared by the public and subscriber odds pages.
     */
    public function getUpcomingGames(?string $sport = null): array
    {
        $sportKey = $sport ? (self::SPORTS[$sport] ?? null) : null;

        $games = LiveOdds::query()
            ->upcoming()
            ->where('commence_time', '<=', now()->addDays(7))
            ->when($sportKey, fn ($q) => $q->sport($sportKey))
            ->get()
            ->groupBy('event_id')
            ->map(function ($rows) {
                $first = $rows->first();

                $bookmakers = $rows->groupBy('bookmaker_key')->map(function ($bookRows) {
                    $book = $bookRows->first();

                    return [
                        'key' => $book->bookmaker_key,
                        'title' => $book->bookmaker_title,
                        'markets' => $bookRows->keyBy('market_key')->map(fn ($row) => $row->outcomes),
                    ];
                })->values();

                return [
                    'event_id' => $first->event_id,
                    'sport_title' => $first->sport_title,
                    'commence_time' => $first->commence_time,
                    'home_team' => $first->home_team,
                    'away_team' => $first->away_team,
                    'away_brand' => TeamBranding::forTeam($first->away_team, $first->sport_title),
                    'home_brand' => TeamBranding::forTeam($first->home_team, $first->sport_title),
                    'books' => $bookmakers->pluck('title'),
                    'markets' => $this->buildOddsMarkets($bookmakers, $first->home_team, $first->away_team),
                ];
            })
            ->sortBy('commence_time')
            ->take(25)
            ->values();

        return [
            'games' => $games,
            'sports' => array_keys(self::SPORTS),
            'lastSync' => ($lastSync = LiveOdds::max('last_update')) ? \Carbon\Carbon::parse($lastSync) : null,
            'liveConfigured' => $this->isConfigured(),
        ];
    }

    /**
     * Build per-market rows (Moneyline / Spread / Total) with one cell per
     * bookmaker, flagging the best price in each row for highlighting.
     */
    private function buildOddsMarkets($bookmakers, string $homeTeam, string $awayTeam): array
    {
        $h2hRows = [
            'away' => ['label' => $awayTeam, 'cells' => []],
            'home' => ['label' => $homeTeam, 'cells' => []],
        ];
        $spreadRows = [
            'away' => ['label' => $awayTeam, 'cells' => []],
            'home' => ['label' => $homeTeam, 'cells' => []],
        ];
        $totalRows = [
            'over' => ['label' => 'Over', 'cells' => []],
            'under' => ['label' => 'Under', 'cells' => []],
        ];

        foreach ($bookmakers as $book) {
            $h2h = collect($book['markets']['h2h'] ?? []);
            $h2hRows['away']['cells'][] = ['price' => $h2h->firstWhere('name', $awayTeam)['price'] ?? null];
            $h2hRows['home']['cells'][] = ['price' => $h2h->firstWhere('name', $homeTeam)['price'] ?? null];

            $spreads = collect($book['markets']['spreads'] ?? []);
            $awaySpread = $spreads->firstWhere('name', $awayTeam);
            $homeSpread = $spreads->firstWhere('name', $homeTeam);
            $spreadRows['away']['cells'][] = ['price' => $awaySpread['price'] ?? null, 'point' => $awaySpread['point'] ?? null];
            $spreadRows['home']['cells'][] = ['price' => $homeSpread['price'] ?? null, 'point' => $homeSpread['point'] ?? null];

            $totals = collect($book['markets']['totals'] ?? []);
            $over = $totals->firstWhere('name', 'Over');
            $under = $totals->firstWhere('name', 'Under');
            $totalRows['over']['cells'][] = ['price' => $over['price'] ?? null, 'point' => $over['point'] ?? null];
            $totalRows['under']['cells'][] = ['price' => $under['price'] ?? null, 'point' => $under['point'] ?? null];
        }

        $markets = ['h2h' => $h2hRows, 'spreads' => $spreadRows, 'totals' => $totalRows];

        foreach ($markets as &$rows) {
            foreach ($rows as &$row) {
                $best = collect($row['cells'])->pluck('price')->filter(fn ($p) => $p !== null)->max();

                foreach ($row['cells'] as &$cell) {
                    $cell['is_best'] = $cell['price'] !== null && $cell['price'] === $best;
                }
            }
        }

        return [
            'h2h' => array_values($markets['h2h']),
            'spreads' => array_values($markets['spreads']),
            'totals' => array_values($markets['totals']),
        ];
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
