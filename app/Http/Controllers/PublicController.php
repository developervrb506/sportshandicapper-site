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
        $expertPicks = Pick::where('is_active', true)
            ->where('result', 'pending')
            ->orderBy('game_date', 'asc')
            ->orderBy('game_time', 'asc')
            ->limit(4)
            ->get();

        return view('public.home', [
            'articles' => Article::published()->latest()->limit(3)->get(),
            'expertPicks' => $expertPicks,
            'hotStreaks' => $this->streakService->getHotStreaks(),
            'packages' => Package::active()->get(),
            'whalePackages' => WhalePackage::active()->get(),
        ]);
    }

    public function articles()
    {
        $category = request('category');
        $sport = request('sport');

        $articles = Article::published()
            ->when($category, fn($q) => $q->category($category))
            ->when($sport, fn($q) => $q->sport($sport))
            ->paginate(12);

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
        $consensus = BettingConsensus::query()
            ->when($sport, fn($q) => $q->sport($sport))
            ->orderBy('game_date')
            ->paginate(15);

        return view('public.consensus', [
            'consensus' => $consensus,
            'sport' => $sport,
        ]);
    }

    public function odds()
    {
        return view('public.odds', [
            'consensus' => BettingConsensus::orderBy('game_date')->limit(10)->get(),
        ]);
    }

    public function about()
    {
        return view('public.about', [
            'aboutContent' => SiteSetting::get('about_content', ''),
            'experts'      => Expert::where('is_active', true)->get(),
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
        $picks = Pick::where('is_active', true)
            ->when($sport, fn($q) => $q->where('sport', $sport))
            ->orderBy('game_date', 'desc')
            ->orderBy('game_time', 'asc')
            ->paginate(10);

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
