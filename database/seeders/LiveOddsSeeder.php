<?php

namespace Database\Seeders;

use App\Models\LiveOdds;
use App\Services\OddsApiService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class LiveOddsSeeder extends Seeder
{
    /**
     * Mock games used to preview the Live Odds UI before a real API key is connected.
     */
    protected array $games = [
        [
            'sport' => 'NFL',
            'away_team' => 'Buffalo Bills', 'home_team' => 'Kansas City Chiefs',
            'commence_time_offset' => 26,
            'h2h' => ['away' => 145, 'home' => -165],
            'spread' => ['point' => 3.5, 'price' => -110],
            'total' => ['point' => 47.5, 'price' => -110],
        ],
        [
            'sport' => 'NFL',
            'away_team' => 'San Francisco 49ers', 'home_team' => 'Dallas Cowboys',
            'commence_time_offset' => 50,
            'h2h' => ['away' => -135, 'home' => 115],
            'spread' => ['point' => 2.5, 'price' => -110],
            'total' => ['point' => 44.5, 'price' => -110],
        ],
        [
            'sport' => 'NBA',
            'away_team' => 'Boston Celtics', 'home_team' => 'Denver Nuggets',
            'commence_time_offset' => 5,
            'h2h' => ['away' => 120, 'home' => -142],
            'spread' => ['point' => 3.5, 'price' => -110],
            'total' => ['point' => 224.5, 'price' => -110],
        ],
        [
            'sport' => 'NBA',
            'away_team' => 'Golden State Warriors', 'home_team' => 'Los Angeles Lakers',
            'commence_time_offset' => 28,
            'h2h' => ['away' => 105, 'home' => -125],
            'spread' => ['point' => 2.5, 'price' => -110],
            'total' => ['point' => 232.5, 'price' => -110],
        ],
        [
            'sport' => 'MLB',
            'away_team' => 'New York Yankees', 'home_team' => 'Houston Astros',
            'commence_time_offset' => 7,
            'h2h' => ['away' => -120, 'home' => 102],
            'spread' => ['point' => 1.5, 'price' => 145],
            'total' => ['point' => 8.5, 'price' => -105],
        ],
        [
            'sport' => 'NHL',
            'away_team' => 'Edmonton Oilers', 'home_team' => 'Florida Panthers',
            'commence_time_offset' => 31,
            'h2h' => ['away' => 130, 'home' => -150],
            'spread' => ['point' => 1.5, 'price' => -185],
            'total' => ['point' => 6.5, 'price' => -110],
        ],
    ];

    /**
     * Bookmakers and a small per-book jitter so prices vary across the board.
     */
    protected array $bookmakers = [
        'draftkings' => ['title' => 'DraftKings', 'jitter' => 0],
        'fanduel' => ['title' => 'FanDuel', 'jitter' => 5],
        'betmgm' => ['title' => 'BetMGM', 'jitter' => -8],
        'caesars' => ['title' => 'Caesars', 'jitter' => 10],
    ];

    public function run()
    {
        foreach ($this->games as $game) {
            $eventId = 'mock-'.Str::slug($game['away_team'].'-'.$game['home_team']);
            $sportKey = OddsApiService::SPORTS[$game['sport']] ?? 'unknown';
            $commenceTime = now()->addHours($game['commence_time_offset']);

            foreach ($this->bookmakers as $bookKey => $book) {
                $jitter = $book['jitter'];

                LiveOdds::updateOrCreate(
                    [
                        'event_id' => $eventId,
                        'bookmaker_key' => $bookKey,
                        'market_key' => 'h2h',
                    ],
                    [
                        'sport_key' => $sportKey,
                        'sport_title' => $game['sport'],
                        'commence_time' => $commenceTime,
                        'home_team' => $game['home_team'],
                        'away_team' => $game['away_team'],
                        'bookmaker_title' => $book['title'],
                        'outcomes' => [
                            ['name' => $game['away_team'], 'price' => $this->jitterPrice($game['h2h']['away'], $jitter)],
                            ['name' => $game['home_team'], 'price' => $this->jitterPrice($game['h2h']['home'], $jitter)],
                        ],
                        'last_update' => now(),
                    ]
                );

                LiveOdds::updateOrCreate(
                    [
                        'event_id' => $eventId,
                        'bookmaker_key' => $bookKey,
                        'market_key' => 'spreads',
                    ],
                    [
                        'sport_key' => $sportKey,
                        'sport_title' => $game['sport'],
                        'commence_time' => $commenceTime,
                        'home_team' => $game['home_team'],
                        'away_team' => $game['away_team'],
                        'bookmaker_title' => $book['title'],
                        'outcomes' => [
                            ['name' => $game['away_team'], 'price' => $this->jitterPrice($game['spread']['price'], $jitter), 'point' => $game['spread']['point']],
                            ['name' => $game['home_team'], 'price' => $this->jitterPrice($game['spread']['price'], -$jitter), 'point' => -$game['spread']['point']],
                        ],
                        'last_update' => now(),
                    ]
                );

                LiveOdds::updateOrCreate(
                    [
                        'event_id' => $eventId,
                        'bookmaker_key' => $bookKey,
                        'market_key' => 'totals',
                    ],
                    [
                        'sport_key' => $sportKey,
                        'sport_title' => $game['sport'],
                        'commence_time' => $commenceTime,
                        'home_team' => $game['home_team'],
                        'away_team' => $game['away_team'],
                        'bookmaker_title' => $book['title'],
                        'outcomes' => [
                            ['name' => 'Over', 'price' => $this->jitterPrice($game['total']['price'], $jitter), 'point' => $game['total']['point']],
                            ['name' => 'Under', 'price' => $this->jitterPrice($game['total']['price'], -$jitter), 'point' => $game['total']['point']],
                        ],
                        'last_update' => now(),
                    ]
                );
            }
        }
    }

    protected function jitterPrice(int $price, int $jitter): int
    {
        return $price + $jitter;
    }
}
