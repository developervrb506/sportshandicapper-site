<?php

namespace App\Http\Controllers;

use App\Models\Pick;
use App\Models\Article;
use App\Models\Expert;
use App\Models\TeamLogo;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class PickController extends Controller
{
    // Show all active picks (public)
    public function publicIndex()
    {
        $picks = Pick::active()
            ->with('relatedArticle')
            ->orderBy('game_date', 'desc')
            ->orderBy('game_time', 'desc')
            ->paginate(20);

        return view('picks.index', compact('picks'));
    }

    // Show picks for homepage carousel
    public function homepage()
    {
        return Pick::active()
            ->today()
            ->orderBy('game_time', 'asc')
            ->limit(10)
            ->get();
    }

    // Simulate a pick (requires login)
    public function simulate(Pick $pick)
    {
        // If already simulated, return result
        if ($pick->simulation_result) {
            return response()->json([
                'success' => true,
                'simulation_result' => $pick->simulation_result,
            ]);
        }

        // Generate simulation (simplified - in real app would use actual simulation engine)
        $simulationResults = ['Win', 'Loss', 'Push'];
        $result = $simulationResults[array_rand($simulationResults)];

        $pick->update(['simulation_result' => $result]);

        return response()->json([
            'success' => true,
            'simulation_result' => $result,
        ]);
    }

    // Admin: List all picks
    public function index()
    {
        $picks = Pick::with('relatedArticle')
            ->orderBy('game_date', 'desc')
            ->paginate(20);

        return view('admin.picks.index', compact('picks'));
    }

    // Admin: Show create form
    public function create()
    {
        $sports = ['NFL', 'NCAAF', 'NBA', 'NCAAB', 'NHL', 'MLB'];
        // Only show articles not already linked to another pick
        $usedArticleIds = Pick::whereNotNull('related_article_id')->pluck('related_article_id');
        $articles = Article::where('is_published', true)->whereNotIn('id', $usedArticleIds)->get();
        $experts = Expert::where('is_active', true)->orderBy('name')->get();
        $teamLogos = TeamLogo::active()->orderBy('sport')->orderBy('team_name')->get();
        return view('admin.picks.form', [
            'pick' => new Pick(),
            'sports' => $sports,
            'articles' => $articles,
            'experts' => $experts,
            'teamLogos' => $teamLogos,
        ]);
    }

    // Admin: Store new pick
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'sport' => 'required|string|in:NFL,NCAAF,NBA,NCAAB,NHL,MLB',
            'game_date' => 'required|date',
            'game_time' => 'nullable',
            'team1_name' => 'required|string',
            'team1_rotation' => 'nullable|integer',
            'team2_name' => 'required|string',
            'team2_rotation' => 'nullable|integer',
            'venue' => 'nullable|string',
            'pick' => 'required|string',
            'stars' => 'required|integer|in:1,2,3,4,5,10',
            'simulation_result' => 'nullable|string|in:Win,Loss,Push',
            'result' => 'nullable|string|in:pending,win,loss,push',
            'units' => 'nullable|numeric',
            'units_result' => 'nullable|numeric',
            'expert_name' => 'nullable|string',
            'related_article_id' => 'nullable|exists:articles,id',
            'team1_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'team2_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'team1_percent' => 'nullable|integer|min:0|max:100',
            'team2_percent' => 'nullable|integer|min:0|max:100',
            'pick_type' => 'nullable|in:Pointspread,Moneyline,Total',
            'is_active' => 'boolean',
            'is_whale_exclusive' => 'boolean',
        ]);

        // Handle team logo uploads
        if ($request->hasFile('team1_logo')) {
            $validated['team1_logo'] = $request->file('team1_logo')->store('uploads/teams', 'public');
        } else {
            unset($validated['team1_logo']);
        }

        if ($request->hasFile('team2_logo')) {
            $validated['team2_logo'] = $request->file('team2_logo')->store('uploads/teams', 'public');
        } else {
            unset($validated['team2_logo']);
        }

        // Ensure game_time has seconds (MySQL TIME requires HH:MM:SS)
        if (!empty($validated['game_time']) && substr_count($validated['game_time'], ':') === 1) {
            $validated['game_time'] = $validated['game_time'] . ':00';
        }

        $validated['is_whale_exclusive'] = $request->boolean('is_whale_exclusive') || $validated['stars'] === 10;
        $validated['is_active'] = $request->boolean('is_active', true);

        Pick::create($validated);

        return redirect()->route('admin.picks.index')->with('success', 'Pick created successfully.');
    }

    // Admin: Show edit form
    public function edit(Pick $pick)
    {
        $sports = ['NFL', 'NCAAF', 'NBA', 'NCAAB', 'NHL', 'MLB'];
        // Exclude articles linked to OTHER picks (keep current pick's article available)
        $usedArticleIds = Pick::whereNotNull('related_article_id')->where('id', '!=', $pick->id)->pluck('related_article_id');
        $articles = Article::where('is_published', true)->whereNotIn('id', $usedArticleIds)->get();
        $experts = Expert::where('is_active', true)->orderBy('name')->get();
        $teamLogos = TeamLogo::active()->orderBy('sport')->orderBy('team_name')->get();
        return view('admin.picks.form', compact('pick', 'sports', 'articles', 'experts', 'teamLogos'));
    }

    // Admin: Update pick
    public function update(Request $request, Pick $pick): RedirectResponse
    {
        $validated = $request->validate([
            'sport' => 'required|string|in:NFL,NCAAF,NBA,NCAAB,NHL,MLB',
            'game_date' => 'required|date',
            'game_time' => 'nullable',
            'team1_name' => 'required|string',
            'team1_rotation' => 'nullable|integer',
            'team2_name' => 'required|string',
            'team2_rotation' => 'nullable|integer',
            'venue' => 'nullable|string',
            'pick' => 'required|string',
            'stars' => 'required|integer|in:1,2,3,4,5,10',
            'simulation_result' => 'nullable|string|in:Win,Loss,Push',
            'result' => 'nullable|in:pending,win,loss,push',
            'units' => 'nullable|numeric',
            'units_result' => 'nullable|numeric',
            'expert_name' => 'nullable|string',
            'related_article_id' => 'nullable|exists:articles,id',
            'team1_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'team2_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'team1_percent' => 'nullable|integer|min:0|max:100',
            'team2_percent' => 'nullable|integer|min:0|max:100',
            'pick_type' => 'nullable|in:Pointspread,Moneyline,Total',
            'is_active' => 'boolean',
            'is_whale_exclusive' => 'boolean',
        ]);

        // Handle team logo uploads
        if ($request->hasFile('team1_logo')) {
            // Delete old logo if exists
            if ($pick->team1_logo && Storage::disk('public')->exists($pick->team1_logo)) {
                Storage::disk('public')->delete($pick->team1_logo);
            }
            $path = $request->file('team1_logo')->store('uploads/teams', 'public');
            $validated['team1_logo'] = $path;
        } else {
            // Keep existing path if not uploading new file
            $validated['team1_logo'] = $validated['team1_logo'] ?? $pick->team1_logo;
        }

        if ($request->hasFile('team2_logo')) {
            // Delete old logo if exists
            if ($pick->team2_logo && Storage::disk('public')->exists($pick->team2_logo)) {
                Storage::disk('public')->delete($pick->team2_logo);
            }
            $path = $request->file('team2_logo')->store('uploads/teams', 'public');
            $validated['team2_logo'] = $path;
        } else {
            $validated['team2_logo'] = $validated['team2_logo'] ?? $pick->team2_logo;
        }

        // Ensure game_time has seconds (MySQL TIME requires HH:MM:SS)
        if (!empty($validated['game_time']) && substr_count($validated['game_time'], ':') === 1) {
            $validated['game_time'] = $validated['game_time'] . ':00';
        }

        // Handle checkbox booleans
        if (! $request->has('is_active')) {
            $validated['is_active'] = $pick->is_active;
        }
        $validated['is_whale_exclusive'] = $request->boolean('is_whale_exclusive') || $validated['stars'] === 10;

        $pick->update($validated);

        return redirect()->route('admin.picks.index')->with('success', 'Pick updated successfully.');
    }

    // Admin: Delete pick
    public function destroy(Pick $pick): RedirectResponse
    {
        $pick->delete();
        return redirect()->route('admin.picks.index')->with('success', 'Pick deleted successfully.');
    }
}
