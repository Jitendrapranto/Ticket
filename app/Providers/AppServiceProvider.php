<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer(['partials.header', 'partials.footer'], function ($view) {
            $viewName = $view->getName();
            if ($viewName === 'partials.header') {
                $view->with('siteHeader', \App\Models\SiteHeader::first());
            }
            if ($viewName === 'partials.footer') {
                $view->with('siteFooter', \App\Models\SiteFooter::first());
            }
        });
    }
}
