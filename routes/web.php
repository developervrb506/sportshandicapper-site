<?php

use App\Http\Controllers\Admin\AboutController as AdminAboutController;
use App\Http\Controllers\Admin\AiController as AdminAiController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\PerformanceController as AdminPerformanceController;
use App\Http\Controllers\Admin\ExpertController as AdminExpertController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\WhalePackageController as AdminWhalePackageController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\ContestController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\SupportTicketController;
use App\Http\Controllers\PickController;
use Illuminate\Support\Facades\Route;

// ==========================================
// PUBLIC PAGES (no login required)
// ==========================================
Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/articles', [PublicController::class, 'articles'])->name('articles');
Route::get('/articles/{article}', [PublicController::class, 'article'])->name('article.show');
// Coming Soon — original views preserved, restore by swapping back to PublicController methods
Route::get('/top-consensus', fn() => view('public.consensus'))->name('consensus');
Route::get('/live-odds', fn() => view('public.odds'))->name('odds');
Route::get('/trends', fn() => view('public.trends'))->name('trends');
Route::get('/join', [PublicController::class, 'join'])->name('join');
Route::get('/picks', [PublicController::class, 'picks'])->name('picks');
Route::post('/picks/{pick}/simulate', [PickController::class, 'simulate'])->name('picks.simulate')->middleware('auth');
Route::get('/about', [PublicController::class, 'about'])->name('about');
Route::get('/reviews', function () { return view('public.reviews'); })->name('reviews');
Route::get('/betting-tools', fn() => view('public.tools'))->name('tools');
Route::get('/buy-bitcoin', function () { return view('public.bitcoin'); })->name('bitcoin');
Route::get('/terms-of-service', function () { return view('public.terms'); })->name('terms');
Route::get('/privacy-policy', function () { return view('public.privacy'); })->name('privacy');
Route::post('/chat', [\App\Http\Controllers\ChatController::class, 'respond'])->name('chat');

// ==========================================
// AUTH ROUTES (guests only)
// ==========================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Email verification routes
Route::get('/email/verify', fn() => view('auth.verify-email'))->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', function (\Illuminate\Http\Request $request, $id, $hash) {
    $user = \App\Models\User::findOrFail($id);

    // Validate the signed URL and hash
    if (!$request->hasValidSignature() || !hash_equals(sha1($user->getEmailForVerification()), $hash)) {
        abort(403, 'Invalid or expired verification link.');
    }

    // If already verified — link has already been used, redirect to login
    if ($user->hasVerifiedEmail()) {
        return redirect('/')->with('info', 'This verification link has already been used. Please log in to access your account.');
    }

    // First click — mark as verified and auto-login
    $user->markEmailAsVerified();
    \Illuminate\Support\Facades\Auth::login($user);

    return redirect('/subscriber/dashboard')->with('verified', true);
})->middleware('signed')->name('verification.verify');
Route::post('/email/verification-notification', function (\Illuminate\Http\Request $request) {
    // Works for both logged-in users and unverified users by email lookup
    $user = $request->user() ?? \App\Models\User::where('email', $request->input('email'))->first();
    if ($user && !$user->hasVerifiedEmail()) {
        $user->sendEmailVerificationNotification();
    }
    return response()->json(['success' => true]);
})->middleware('throttle:6,1')->name('verification.send');

// ==========================================
// USER ROUTES (any logged-in user)
// ==========================================
Route::middleware('auth')->group(function () {
    // Subscriber dashboard & portal
    Route::get('/subscriber/dashboard', [\App\Http\Controllers\SubscriberController::class, 'dashboard'])->name('subscriber.dashboard');
    Route::get('/subscriber/picks', [\App\Http\Controllers\SubscriberController::class, 'picks'])->name('subscriber.picks');
    Route::get('/subscriber/articles', [\App\Http\Controllers\SubscriberController::class, 'articles'])->name('subscriber.articles');
    Route::get('/subscriber/articles/{article}', [\App\Http\Controllers\SubscriberController::class, 'article'])->name('subscriber.article');
    Route::get('/subscriber/consensus', fn() => view('subscriber.coming-soon', ['pageTitle'=>'Consensus','pageIcon'=>'📊','pageDesc'=>'Public betting splits and sharp money data are coming soon. You\'ll be able to see where the smart money is going before every game.']))->name('subscriber.consensus');
    Route::get('/subscriber/trends', fn() => view('subscriber.coming-soon', ['pageTitle'=>'Betting Trends','pageIcon'=>'📈','pageDesc'=>'Hot streak tracking, sport-by-sport performance trends, and historical unit data are coming soon.']))->name('subscriber.trends');
    Route::get('/subscriber/odds', fn() => view('subscriber.coming-soon', ['pageTitle'=>'Live Odds','pageIcon'=>'⚡','pageDesc'=>'Real-time odds comparison across all major sportsbooks is coming soon. Never miss the best line again.']))->name('subscriber.odds');
    Route::get('/subscriber/betting-tools', fn() => view('subscriber.coming-soon', ['pageTitle'=>'Betting Tools','pageIcon'=>'🛠️','pageDesc'=>'Calculators, trackers, and betting tools to help you manage your bankroll and maximize your edge are coming soon.']))->name('subscriber.betting-tools');
    Route::get('/subscriber/packages', [\App\Http\Controllers\SubscriberController::class, 'packages'])->name('subscriber.packages');

    Route::get('/profile', [PublicController::class, 'profile'])->name('profile');
    Route::get('/account/settings', [App\Http\Controllers\AccountSettingsController::class, 'index'])->name('account.settings');
    Route::put('/account/settings/profile', [App\Http\Controllers\AccountSettingsController::class, 'updateProfile'])->name('account.settings.profile');
    Route::put('/account/settings/password', [App\Http\Controllers\AccountSettingsController::class, 'updatePassword'])->name('account.settings.password');
});

// ==========================================
// ADMIN ROUTES (admin role only)
// ==========================================
Route::middleware('admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        $unitsRow = App\Models\Pick::whereNotNull('units_result')
            ->where('result', '!=', 'pending')
            ->selectRaw("SUM(units_result) as total_units, SUM(CASE WHEN result='win' THEN 1 ELSE 0 END) as wins, SUM(CASE WHEN result='loss' THEN 1 ELSE 0 END) as losses")
            ->first();
        return view('dashboard', [
            'stats' => [
                'picks'    => App\Models\Pick::count(),
                'tickets'  => App\Models\SupportTicket::count(),
                'contests' => App\Models\Contest::count(),
                'articles' => App\Models\Article::count(),
            ],
            'unitsRow' => $unitsRow,
        ]);
    })->name('dashboard');

    // Module overview pages
    Route::get('/modules', [ModuleController::class, 'index'])->name('modules.index');
    Route::get('/modules/tickets', [ModuleController::class, 'tickets'])->name('modules.tickets');
    Route::get('/modules/contests', [ModuleController::class, 'contests'])->name('modules.contests');
    Route::patch('/modules/tickets/{ticket}/status', [ModuleController::class, 'updateTicketStatus'])->name('modules.tickets.status');
    Route::patch('/modules/contests/{contest}/status', [ModuleController::class, 'updateContestStatus'])->name('modules.contests.status');

    // Tips CRUD (redirect to new picks interface)
    Route::get('/modules/tips', function () { return redirect()->route('admin.picks.index'); })->name('modules.tips.index');
    Route::get('/modules/tips/create', function () { return redirect()->route('admin.picks.create'); })->name('modules.tips.create');
    Route::get('/modules/tips/{tip}/edit', function () { return redirect()->route('admin.picks.index'); })->name('modules.tips.edit');

    // Tickets CRUD
    Route::resource('tickets', SupportTicketController::class)->names('tickets');

    // Contests CRUD
    Route::resource('contests', ContestController::class)->names('contests');

    // Admin: Articles CRUD
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('articles', AdminArticleController::class)->except(['show']);
        Route::post('articles/{article}/supplements', [AdminArticleController::class, 'addSupplement'])->name('articles.supplements.store');
        Route::delete('articles/{article}/supplements/{supplement}', [AdminArticleController::class, 'deleteSupplement'])->name('articles.supplements.destroy');
        Route::post('articles/{article}/generate-sidebar', [AdminArticleController::class, 'generateSidebar'])->name('articles.supplements.generate');
        Route::resource('experts', AdminExpertController::class)->except(['show']);
        Route::resource('users', AdminUserController::class)->except(['create', 'store', 'show']);
        Route::resource('whale-packages', AdminWhalePackageController::class)->except(['show']);
        Route::resource('picks', PickController::class)->except(['show']);
        Route::post('ai/parse-pdf', [AdminAiController::class, 'parsePdf'])->name('ai.parse-pdf');
        Route::post('ai/generate-article', [AdminAiController::class, 'generateArticle'])->name('ai.generate-article');
        Route::post('ai/generate-excerpt', [AdminAiController::class, 'generateExcerpt'])->name('ai.generate-excerpt');
        Route::post('ai/check-pick', [AdminAiController::class, 'checkPick'])->name('ai.check-pick');
        Route::get('about', [AdminAboutController::class, 'edit'])->name('about.edit');
        Route::put('about', [AdminAboutController::class, 'update'])->name('about.update');
        Route::get('performance', [AdminPerformanceController::class, 'index'])->name('performance.index');
    });
});

Route::get('/health', function () { return response()->json(['status' => 'ok']); });
