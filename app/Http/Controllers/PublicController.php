<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\BettingConsensus;
use App\Models\Contest;
use App\Models\Expert;
use App\Models\Package;
use App\Models\Pick;
use App\Models\SiteSetting;
use App\Models\SupportTicket;
use App\Models\WhalePackage;
use App\Services\OddsApiService;
use App\Services\StreakService;

class PublicController extends Controller
{
    protected $streakService;

    public function __construct(StreakService $streakService)
    {
        $this->streakService = $streakService;
    }

    public function home()
    {
        try {
            $expertPicks = Pick::where('is_active', true)
                ->where('result', 'pending')
                ->orderBy('game_date', 'asc')
                ->orderBy('game_time', 'asc')
                ->limit(4)
                ->get();
        } catch (\Exception $e) {
            $expertPicks = collect();
        }

        try {
            $articles = Article::published()->latest()->limit(4)->get();
        } catch (\Exception $e) {
            $articles = collect();
        }

        try {
            $hotStreaks = $this->streakService->getHotStreaks();
        } catch (\Exception $e) {
            $hotStreaks = collect();
        }

        return view('public.home', [
            'articles' => $articles,
            'expertPicks' => $expertPicks,
            'hotStreaks' => $hotStreaks,
            'packages' => Package::active()->get(),
            'whalePackages' => WhalePackage::active()->get(),
        ]);
    }

    public function articles()
    {
        $category = request('category');
        $sport = request('sport');

        try {
            $articles = Article::published()
                ->when($category, fn($q) => $q->category($category))
                ->when($sport, fn($q) => $q->sport($sport))
                ->paginate(7);
        } catch (\Exception $e) {
            $articles = new \Illuminate\Pagination\LengthAwarePaginator(collect(), 0, 7);
        }

        return view('public.articles', [
            'articles' => $articles,
            'category' => $category,
            'sport' => $sport,
        ]);
    }

    public function article(Article $article)
    {
        if (!$article->is_published) {
            abort(404);
        }

        $article->load('supplements');

        $related = Article::published()
            ->where('id', '!=', $article->id)
            ->where('sport', $article->sport)
            ->limit(3)
            ->get();

        return view('public.article', [
            'article' => $article,
            'related' => $related,
        ]);
    }

    public function consensus()
    {
        $sport = request('sport');
        try {
            $consensus = BettingConsensus::query()
                ->when($sport, fn($q) => $q->sport($sport))
                ->orderBy('game_date')
                ->paginate(15);
        } catch (\Exception $e) {
            $consensus = new \Illuminate\Pagination\LengthAwarePaginator(collect(), 0, 15);
        }

        return view('public.consensus', [
            'consensus' => $consensus,
            'sport' => $sport,
        ]);
    }

    public function odds()
    {
        $sport = request('sport');
        $data = app(OddsApiService::class)->getUpcomingGames($sport);

        return view('public.odds', $data + ['sport' => $sport]);
    }

    public function about()
    {
        try {
            $aboutContent = SiteSetting::get('about_content', '');
            $experts = Expert::where('is_active', true)->get();
        } catch (\Exception $e) {
            $aboutContent = '';
            $experts = collect();
        }
        return view('public.about', [
            'aboutContent' => $aboutContent,
            'experts'      => $experts,
        ]);
    }

    public function contact()
    {
        return view('public.contact');
    }

    public function submitContactTicket(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'customer_name'  => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'subject'        => 'required|string|max:255',
            'message'        => 'required|string',
        ]);

        \App\Models\SupportTicket::create([
            'customer_name'  => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'subject'        => $validated['subject'],
            'message'        => $validated['message'],
            'source_system'  => 'SPORTSHANDICAPPER',
            'status'         => 'open',
            'priority'       => 1,
        ]);

        return redirect()->route('contact')
            ->with('ticket_success', true)
            ->with('ticket_email', $validated['customer_email']);
    }

    public function trends()
    {
        $streakService = new StreakService();
        return view('public.trends', [
            'streaks' => $streakService->calculateStreaks(),
            'hotStreaks' => $streakService->getHotStreaks(),
        ]);
    }

    public function picks()
    {
        $sport = request('sport');
        try {
            $picks = Pick::where('is_active', true)
                ->when($sport, fn($q) => $q->where('sport', $sport))
                ->orderBy('game_date', 'desc')
                ->orderBy('game_time', 'asc')
                ->paginate(10);
        } catch (\Exception $e) {
            $picks = new \Illuminate\Pagination\LengthAwarePaginator(collect(), 0, 10);
        }

        $statsBySport = [];
        try {
            $sports = ['ALL', 'NFL', 'NCAAF', 'NBA', 'NCAAB', 'MLB', 'NHL'];
            foreach ($sports as $s) {
                $row = Pick::whereNotNull('units_result')
                    ->where('result', '!=', 'pending')
                    ->when($s !== 'ALL', fn($q) => $q->where('sport', $s))
                    ->selectRaw("SUM(units_result) as total_units, COUNT(*) as total,
                        SUM(CASE WHEN result = 'win' THEN 1 ELSE 0 END) as wins,
                        SUM(CASE WHEN result = 'loss' THEN 1 ELSE 0 END) as losses,
                        SUM(CASE WHEN result = 'push' THEN 1 ELSE 0 END) as pushes")
                    ->first();

                $totalUnits = round((float) ($row->total_units ?? 0), 2);
                $statsBySport[$s] = [
                    'units'    => $totalUnits,
                    'winRate'  => $row->total > 0 ? round($row->wins / $row->total * 100, 1) : 0,
                    'bettor'   => round($totalUnits * 100),
                    'wins'     => (int) $row->wins,
                    'losses'   => (int) $row->losses,
                    'pushes'   => (int) $row->pushes,
                ];
            }
        } catch (\Exception $e) {
            $statsBySport = [];
        }

        return view('public.picks', [
            'picks' => $picks,
            'sport' => $sport,
            'statsBySport' => $statsBySport,
        ]);
    }

    public function join()
    {
        $packages = Package::active()->get();
        $whalePackages = WhalePackage::active()->get();
        
        return view('public.join', [
            'packages' => $packages,
            'whalePackages' => $whalePackages,
        ]);
    }

    public function profile()
    {
        $user = auth()->user();
        $tickets = SupportTicket::where('customer_email', $user->email)->latest()->paginate(10);

        return view('public.profile', [
            'tickets' => $tickets,
        ]);
    }
}
