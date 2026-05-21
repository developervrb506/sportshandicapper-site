<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\BettingConsensus;
use App\Models\Package;
use App\Models\Pick;
use App\Models\WhalePackage;
use App\Services\StreakService;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function __construct(private SubscriptionService $subscriptionService) {}

    public function dashboard()
    {
        $user = auth()->user();

        // Admins go to admin dashboard
        if ($user->isAdmin()) {
            return redirect()->route('dashboard');
        }

        // Run subscription renewal check
        $this->subscriptionService->checkAndUpdateSubscription($user);
        $user->refresh();

        $sub = $user->activeSubscription()?->load('package');

        $picksSinceStart = 0;
        $activePicks     = collect();
        $recentPicks     = collect();
        $latestArticles  = collect();
        $sportRecord     = [];
        $wins = $losses = $pushes = 0;

        if ($sub) {
            $startDate = $sub->starts_at->toDateString();

            // Total picks in tier since sign-up
            $picksSinceStart = Pick::where('is_active', true)
                ->where('game_date', '>=', $startDate)
                ->where('stars', '<=', $sub->max_stars)
                ->count();

            // Active picks today (for the "Today's Picks" section)
            $activePicks = Pick::where('is_active', true)
                ->where('result', 'pending')
                ->where('stars', '<=', $sub->max_stars)
                ->orderBy('game_date')->orderBy('game_time')
                ->limit(4)->get();

            // Recent picks (last 8 including graded)
            $recentPicks = Pick::where('is_active', true)
                ->where('game_date', '>=', $startDate)
                ->where('stars', '<=', $sub->max_stars)
                ->orderByDesc('game_date')
                ->limit(8)->get();

            // Win/loss record
            $gradedPicks = Pick::where('is_active', true)
                ->where('game_date', '>=', $startDate)
                ->where('stars', '<=', $sub->max_stars)
                ->whereIn('result', ['win','loss','push'])->get();

            $wins   = $gradedPicks->where('result','win')->count();
            $losses = $gradedPicks->where('result','loss')->count();
            $pushes = $gradedPicks->where('result','push')->count();

            // Performance by sport
            foreach(['MLB','NFL','NBA','NHL','NCAAF','NCAAB'] as $sport) {
                $sp = $gradedPicks->where('sport', $sport);
                if($sp->count() > 0) {
                    $sportRecord[$sport] = [
                        'wins'   => $sp->where('result','win')->count(),
                        'losses' => $sp->where('result','loss')->count(),
                        'pushes' => $sp->where('result','push')->count(),
                        'units'  => round($sp->sum('units_result'), 2),
                    ];
                }
            }

            // Latest 3 articles
            $latestArticles = Article::published()->limit(3)->get();
        }

        return view('subscriber.dashboard', compact(
            'user','sub','picksSinceStart','activePicks','recentPicks',
            'latestArticles','sportRecord','wins','losses','pushes'
        ));
    }

    public function picks(Request $request)
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return redirect()->route('dashboard');
        }

        $this->subscriptionService->checkAndUpdateSubscription($user);
        $user->refresh();

        $sub = $user->activeSubscription();

        if (!$sub) {
            return redirect('/subscriber/packages')->with('expired', true);
        }

        $sport  = $request->get('sport');
        $tab    = $request->get('tab', 'all');    // 'all', 'pending', 'results'
        $period = $request->get('period', 'all'); // 'week', 'month', 'all'

        $baseQuery = Pick::where('is_active', true)
            ->where('game_date', '>=', $sub->starts_at->toDateString())
            ->where('stars', '<=', $sub->max_stars)
            ->when($sport, fn($q) => $q->where('sport', $sport))
            ->when($period === 'week',  fn($q) => $q->where('game_date', '>=', now()->subDays(7)->toDateString()))
            ->when($period === 'month', fn($q) => $q->where('game_date', '>=', now()->subDays(30)->toDateString()));

        // Tab filter
        $query = (clone $baseQuery);
        if ($tab === 'pending') {
            $query->where('result', 'pending');
        } elseif ($tab === 'results') {
            $query->whereIn('result', ['win','loss','push']);
        }

        $picks = $query->orderByDesc('game_date')->orderBy('game_time')->paginate(10)->withQueryString();

        // Stats for this filter
        $allGraded = (clone $baseQuery)->whereIn('result', ['win','loss','push'])->get();
        $wins   = $allGraded->where('result','win')->count();
        $losses = $allGraded->where('result','loss')->count();
        $pushes = $allGraded->where('result','push')->count();
        $units  = round($allGraded->sum('units_result'), 2);
        $total  = $wins + $losses + $pushes;
        $wr     = $total > 0 ? round(($wins/$total)*100,1) : 0;

        // Tab counts
        $countAll     = (clone $baseQuery)->count();
        $countPending = (clone $baseQuery)->where('result','pending')->count();
        $countResults = (clone $baseQuery)->whereIn('result',['win','loss','push'])->count();

        return view('subscriber.picks', compact(
            'user','sub','picks','sport','period','tab',
            'wins','losses','pushes','units','wr','total',
            'countAll','countPending','countResults'
        ));
    }

    public function articles(Request $request)
    {
        $sport    = $request->get('sport');
        $articles = Article::published()
            ->when($sport, fn($q) => $q->sport($sport))
            ->paginate(12);
        return view('subscriber.articles', compact('articles', 'sport'));
    }

    public function article(Article $article)
    {
        if (!$article->is_published) abort(404);
        $article->load('supplements');
        $related = Article::published()
            ->where('id', '!=', $article->id)
            ->where('sport', $article->sport)
            ->limit(3)->get();
        return view('subscriber.article', compact('article', 'related'));
    }

    public function consensus(Request $request)
    {
        $sport     = $request->get('sport');
        $consensus = BettingConsensus::query()
            ->when($sport, fn($q) => $q->sport($sport))
            ->orderBy('game_date')
            ->paginate(15);
        return view('subscriber.consensus', compact('consensus', 'sport'));
    }

    public function trends()
    {
        $streakService = new StreakService();
        return view('subscriber.trends', [
            'streaks'   => $streakService->calculateStreaks(),
            'hotStreaks' => $streakService->getHotStreaks(),
        ]);
    }

    public function odds()
    {
        return view('subscriber.odds', [
            'consensus' => BettingConsensus::orderBy('game_date')->limit(10)->get(),
        ]);
    }

    public function packages()
    {
        $featuredSlugs = ['free-trial','1-week','2-weeks','monthly','quarterly','semi-annual'];
        $packages = Package::active()->get();
        $featuredPackages = $packages
            ->filter(fn($p) => in_array($p->slug, $featuredSlugs))
            ->sortBy(fn($p) => array_search($p->slug, $featuredSlugs));

        // Use same whale logic as main join page: prefer Package slug 'whale-package', fallback to WhalePackage
        $whalePackages = WhalePackage::active()->get();
        $whaleRegular  = $packages->firstWhere('slug', 'whale-package');

        $currentSub = auth()->user()->activeSubscription()?->load('package');

        return view('subscriber.packages', compact('featuredPackages', 'whalePackages', 'whaleRegular', 'currentSub'));
    }
}
