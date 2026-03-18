<?php

namespace App\Providers;

use Illuminate\Support\Facades\Cache;
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
                $view->with('siteHeader', Cache::remember('site_header', 3600, function () {
                    return \App\Models\SiteHeader::first();
                }));
                $view->with('activeCategories', Cache::remember('active_event_categories', 3600, function () {
                    return \App\Models\EventCategory::all(); // Adjust query if you have a status column
                }));
            }
            if ($viewName === 'partials.footer') {
                $view->with('siteFooter', Cache::remember('site_footer', 3600, function () {
                    return \App\Models\SiteFooter::first();
                }));
            }
        });

        // Provide Admin Stats to all admin views
        View::composer('admin.*', function ($view) {
            $stats = [
                'totalSales' => \App\Models\Booking::where('status', 'confirmed')->sum('total_amount'),
                'todaySales' => \App\Models\Booking::where('status', 'confirmed')->whereDate('created_at', now())->sum('total_amount'),
                'totalEvents' => \App\Models\Event::count(),
                'todayEvents' => \App\Models\Event::whereDate('date', now())->count(),
                'totalOrganizers' => \App\Models\User::where('role', 'organizer')->count(),
                'organizerRequests' => \App\Models\User::where('role', 'pending_organizer')->count(),
                'eventApprovalRequests' => \App\Models\Event::where('is_approved', false)->count(),
                'paymentApprovalRequests' => \App\Models\Booking::where('status', 'pending')->count(),
                'totalCustomers' => \App\Models\User::where('role', 'user')->count(),
                'totalBookings' => \App\Models\Booking::count(),
            ];
            $view->with($stats);
        });
    }
}
