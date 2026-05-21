<?php

namespace App\Services;

use App\Models\Pick;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class StreakService
{
    /**
     * Calculate winning streaks by sport
     */
    public function calculateStreaks(): array
    {
        $sports = ['NFL', 'NBA', 'NHL', 'MLB', 'NCAAF', 'NCAAB'];
        $streaks = [];

        foreach ($sports as $sport) {
            $streaks[$sport] = [
                'last_10_days' => $this->getStreakForPeriod($sport, 10),
                'last_30_picks' => $this->getStreakForPicks($sport, 30),
                'last_10_picks' => $this->getStreakForPicks($sport, 10),
            ];
        }

        return $streaks;
    }

    /**
     * Get streak for a specific time period (days)
     */
    public function getStreakForPeriod(string $sport, int $days): array
    {
        $picks = Pick::where('sport', $sport)
            ->where('game_date', '>=', Carbon::today()->subDays($days))
            ->where('result', '!=', 'pending')
            ->orderBy('game_date', 'desc')
            ->get();

        return $this->calculateWinStreak($picks);
    }

    /**
     * Get streak for a specific number of picks
     */
    public function getStreakForPicks(string $sport, int $limit): array
    {
        $picks = Pick::where('sport', $sport)
            ->where('result', '!=', 'pending')
            ->orderBy('game_date', 'desc')
            ->limit($limit)
            ->get();

        return $this->calculateWinStreak($picks);
    }

    /**
     * Calculate the current winning streak from a collection of picks
     */
    private function calculateWinStreak(Collection $picks): array
    {
        $streak = 0;
        $totalWins = 0;
        $totalLosses = 0;
        $totalPushes = 0;
        $totalUnits = 0;
        $currentStreak = 0;
        $bestStreak = 0;

        foreach ($picks as $pick) {
            if ($pick->result === 'win') {
                $totalWins++;
                $currentStreak++;
                $bestStreak = max($bestStreak, $currentStreak);
                $totalUnits += $pick->units ?? 0;
            } elseif ($pick->result === 'loss') {
                $totalLosses++;
                $currentStreak = 0;
                $totalUnits += $pick->units ?? 0;
            } elseif ($pick->result === 'push') {
                $totalPushes++;
                $totalUnits += $pick->units ?? 0;
            }
        }

        // Current streak is from the most recent picks working backwards
        $currentStreak = 0;
        foreach ($picks as $pick) {
            if ($pick->result === 'win') {
                $currentStreak++;
            } else {
                break;
            }
        }

        $totalPicks = $totalWins + $totalLosses + $totalPushes;
        $winRate = $totalPicks > 0 ? round(($totalWins / $totalPicks) * 100, 1) : 0;

        return [
            'current_streak' => $currentStreak,
            'best_streak' => $bestStreak,
            'total_wins' => $totalWins,
            'total_losses' => $totalLosses,
            'total_pushes' => $totalPushes,
            'total_picks' => $totalPicks,
            'win_rate' => $winRate,
            'total_units' => round($totalUnits, 2),
            'is_hot' => $currentStreak >= 3, // 3+ wins in a row is "hot"
        ];
    }

    /**
     * Get all hot streaks across sports
     */
    public function getHotStreaks(): array
    {
        $streaks = $this->calculateStreaks();
        $hotStreaks = [];

        foreach ($streaks as $sport => $periods) {
            foreach ($periods as $period => $data) {
                if ($data['is_hot']) {
                    $hotStreaks[] = [
                        'sport'        => $sport,
                        'period'       => $period,
                        'streak'       => $data['current_streak'],
                        'win_rate'     => $data['win_rate'],
                        'units'        => $data['total_units'],
                        'picks'        => $data['total_picks'],
                        'total_wins'   => $data['total_wins'],
                        'total_losses' => $data['total_losses'],
                        'total_pushes' => $data['total_pushes'],
                    ];
                }
            }
        }

        // Sort by current streak (descending)
        usort($hotStreaks, fn($a, $b) => $b['streak'] <=> $a['streak']);

        return $hotStreaks;
    }
}
