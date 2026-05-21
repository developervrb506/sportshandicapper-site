<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pick;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PerformanceController extends Controller
{
    public function index(Request $request): View
    {
        $sport    = $request->query('sport', '');
        $dateFrom = $request->query('date_from', '');
        $dateTo   = $request->query('date_to', '');

        $query = Pick::whereNotNull('units_result')
            ->where('result', '!=', 'pending')
            ->when($sport !== '', fn($q) => $q->where('sport', $sport))
            ->when($dateFrom !== '', fn($q) => $q->whereDate('game_date', '>=', $dateFrom))
            ->when($dateTo !== '', fn($q) => $q->whereDate('game_date', '<=', $dateTo));

        $bySport = (clone $query)
            ->selectRaw("sport,
                COUNT(*) as total,
                SUM(units_result) as total_units,
                SUM(CASE WHEN result = 'win'  THEN 1 ELSE 0 END) as wins,
                SUM(CASE WHEN result = 'loss' THEN 1 ELSE 0 END) as losses,
                SUM(CASE WHEN result = 'push' THEN 1 ELSE 0 END) as pushes")
            ->groupBy('sport')
            ->orderByDesc('total_units')
            ->get();

        $totals = [
            'total'       => $bySport->sum('total'),
            'total_units' => $bySport->sum('total_units'),
            'wins'        => $bySport->sum('wins'),
            'losses'      => $bySport->sum('losses'),
            'pushes'      => $bySport->sum('pushes'),
        ];

        // All-time summary for the dashboard card (no filters)
        $allTime = Pick::whereNotNull('units_result')
            ->where('result', '!=', 'pending')
            ->selectRaw("COUNT(*) as total, SUM(units_result) as total_units,
                SUM(CASE WHEN result = 'win' THEN 1 ELSE 0 END) as wins,
                SUM(CASE WHEN result = 'loss' THEN 1 ELSE 0 END) as losses")
            ->first();

        $sports = Pick::distinct()->orderBy('sport')->pluck('sport')->filter()->values();

        return view('admin.performance.index', compact(
            'bySport', 'totals', 'allTime', 'sports', 'sport', 'dateFrom', 'dateTo'
        ));
    }
}
