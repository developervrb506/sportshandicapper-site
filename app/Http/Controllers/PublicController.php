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
            $articles = Article::published()->latest()->limit(3)->get();
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
        try {
            $consensus = BettingConsensus::orderBy('game_date')->limit(10)->get();
        } catch (\Exception $e) {
            $consensus = collect();
        }
        return view('public.odds', ['consensus' => $consensus]);
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

        return view('public.picks', [
            'picks' => $picks,
            'sport' => $sport,
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
