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
        // On cPanel: public_html IS the public folder, storage lives one level up
        if (is_dir(dirname(base_path()) . '/storage')) {
            $this->app->useStoragePath(dirname(base_path()) . '/storage');
        }
        if (file_exists(base_path('index.php'))) {
            $this->app->usePublicPath(base_path());
        }
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
