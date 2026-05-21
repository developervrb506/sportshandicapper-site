<?php

namespace App\Providers;

use App\Models\Article;
use App\Models\Contest;
use App\Models\Expert;
use App\Models\Pick;
use App\Models\SupportTicket;
use App\Observers\PickObserver;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        Pick::observe(PickObserver::class);

        View::composer('admin.layouts.admin', function ($view) {
            $view->with('stats', [
                'picks' => Pick::count(),
                'experts' => Expert::count(),
                'tickets' => SupportTicket::count(),
                'contests' => Contest::count(),
                'articles' => Article::count(),
            ]);
        });
    }
}
