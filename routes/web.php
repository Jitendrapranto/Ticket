<?php

use Illuminate\Support\Facades\Route;
use App\Models\EventHero;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\GalleryHero;
use App\Models\GalleryImage;
use App\Models\AboutStatistic;
use App\Models\AboutStory;
use App\Models\AboutAdvantage;
use App\Http\Controllers\Admin\EventHeroController;
use App\Http\Controllers\Admin\EventCategoryController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\GalleryHeroController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\AboutStatisticController;
use App\Http\Controllers\Admin\AboutStoryController;
use App\Http\Controllers\Admin\AboutAdvantageController;
use App\Http\Controllers\Admin\AboutCtaController;
use App\Http\Controllers\Admin\AboutHeroController;
use App\Http\Controllers\Admin\PlatformFeatureController;
use App\Models\PlatformFeature;
use App\Http\Controllers\Admin\HomeMosaicController;
use App\Models\HomeGallerySection;
use App\Models\HomeMosaicImage;
use App\Http\Controllers\Admin\HomeCtaController;
use App\Models\HomeCtaSection;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/signup', [AuthController::class, 'showSignupForm'])->name('signup');
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/my-bookings', function () {
        $bookings = \App\Models\Booking::with(['event', 'attendees.ticketType'])->where('user_id', Auth::id())->latest()->get();
        return view('auth.my-bookings', compact('bookings'));
    })->name('bookings.index');
    Route::get('/bookings/{booking_id}/download', [\App\Http\Controllers\TicketController::class, 'download'])->name('bookings.download');
});

Route::get('/', function () {
    $featuredEvents = Event::with('category')
        ->where('status', 'Live')
        ->where('is_approved', true)
        ->where('is_featured', true)
        ->where('date', '>=', now())
        ->orderBy('sort_order', 'asc')
        ->latest()->take(9)->get();

    $slideData = $featuredEvents->map(function($e) {
        return [
            'title' => $e->title,
            'date' => strtoupper($e->date->format('d M, Y')),
            'location' => strtoupper($e->location),
            'slug' => $e->slug
        ];
    });

    $upcomingEvents = Event::with('category')
        ->where('is_approved', true)
        ->where('status', 'Live')
        ->where('date', '>=', now())
        ->latest()
        ->take(6)->get();
    $pastEvents = Event::with('category')->where('is_approved', true)->where('date', '<', now())->orderBy('date', 'desc')->take(12)->get();
    $platformFeatures = PlatformFeature::active()->orderBy('sort_order')->get();
    $gallerySection   = HomeGallerySection::first();
    $homepageGalleryImages = GalleryImage::with('category')->homepage()->orderBy('homepage_sort_order')->latest()->get();
    $ctaSection       = HomeCtaSection::first();

    return view('home', compact('featuredEvents', 'upcomingEvents', 'slideData', 'pastEvents', 'platformFeatures', 'gallerySection', 'homepageGalleryImages', 'ctaSection'));
});

Route::get('/events', function (\Illuminate\Http\Request $request) {
    $hero = EventHero::first();
    $categories = EventCategory::withCount(['events' => function($q) {
        $q->where('status', 'Live')->where('is_approved', true)->where('date', '>=', now());
    }])->get();

    $featuredEvents = Event::with('category')
        ->where('status', 'Live')
        ->where('is_approved', true)
        ->where('is_featured', true)
        ->where('date', '>=', now())
        ->orderBy('sort_order', 'asc')
        ->latest()->take(3)->get();

    $eventsQuery = Event::with('category')
        ->where('status', 'Live')
        ->where('is_approved', true)
        ->where('date', '>=', now());

    // Server-side search logic
    $search = $request->input('search');

    if ($search) {
        $eventsQuery->where(function ($q) use ($search) {
            $q->where('title', 'like', '%' . $search . '%')
              ->orWhere('location', 'like', '%' . $search . '%')
              ->orWhereHas('category', function ($cq) use ($search) {
                  $cq->where('name', 'like', '%' . $search . '%');
              });
        });
    }

    $events = $eventsQuery->orderBy('sort_order', 'asc')
        ->latest()->paginate(12)
        ->appends(['search' => $search]);

    return view('events', compact('hero', 'categories', 'events', 'featuredEvents', 'search'));
})->name('events');

Route::get('/events/{slug}', function ($slug) {
    $event = Event::with(['category', 'ticketTypes'])
        ->where('slug', $slug)
        ->where('is_approved', true)
        ->where('date', '>=', now())
        ->firstOrFail();

    $relatedEvents = Event::with('category')
        ->where('category_id', $event->category_id)
        ->where('is_approved', true)
        ->where('status', 'Live')
        ->where('date', '>=', now())
        ->where('id', '!=', $event->id)
        ->take(4)->get();

    return view('events.show', compact('event', 'relatedEvents'));
})->name('events.show');

Route::get('/events/{slug}/booking', [\App\Http\Controllers\BookingController::class, 'show'])->name('events.booking');
Route::post('/events/{slug}/booking', [\App\Http\Controllers\BookingController::class, 'process'])->name('events.booking.process');
Route::get('/checkout/{booking_id}', [\App\Http\Controllers\BookingController::class, 'checkout'])->name('events.checkout');
Route::post('/checkout/complete/{booking_id}', [\App\Http\Controllers\BookingController::class, 'complete'])->name('events.checkout.complete');

Route::get('/gallery', function () {
    $hero = GalleryHero::first();
    $dbImages = GalleryImage::with('category')->latest()->paginate(12);
    return view('gallery', compact('hero', 'dbImages'));
})->name('gallery');

Route::get('/about', function () {
    $hero       = \App\Models\AboutHero::first();
    $statistics = \App\Models\AboutStatistic::orderBy('sort_order', 'asc')->get();
    $story = \App\Models\AboutStory::first();
    $advantages = \App\Models\AboutAdvantage::orderBy('sort_order', 'asc')->get();
    $cta = \App\Models\AboutCta::first();
    return view('about', compact('hero', 'statistics', 'story', 'advantages', 'cta'));
})->name('about');

Route::get('/contact', function () {
    $hero = \App\Models\ContactHero::first();
    $cards = \App\Models\ContactCard::orderBy('sort_order', 'asc')->get();
    $formContent = \App\Models\ContactFormContent::first();
    $support = \App\Models\ContactSupport::first();
    $map = \App\Models\ContactMap::first();
    return view('contact', compact('hero', 'cards', 'formContent', 'support', 'map'));
})->name('contact');

Route::prefix('admin')->name('admin.')->group(function () {
    // Admin Guest Auth
    Route::get('/login', [\App\Http\Controllers\Admin\AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [\App\Http\Controllers\Admin\AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [\App\Http\Controllers\Admin\AdminAuthController::class, 'logout'])->name('logout');

    // Protected Admin Routes
    Route::middleware(['admin'])->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

        Route::get('/events/hero', [EventHeroController::class, 'edit'])->name('events.hero');
        Route::post('/events/hero', [EventHeroController::class, 'update'])->name('events.hero.update');

        Route::get('/events/drafts', [EventController::class, 'drafts'])->name('events.drafts');
        Route::post('/events/{event}/publish', [EventController::class, 'publish'])->name('events.publish');
        Route::post('/events/{event}/approve', [EventController::class, 'approve'])->name('events.approve');
        Route::get('/events/export', [EventController::class, 'export'])->name('events.export');

        Route::get('/gallery/hero', [GalleryHeroController::class, 'edit'])->name('gallery.hero');
        Route::post('/gallery/hero', [GalleryHeroController::class, 'update'])->name('gallery.hero.update');

        Route::get('/gallery/images', [GalleryController::class, 'index'])->name('gallery.images.index');
        Route::get('/gallery/images/create', [GalleryController::class, 'create'])->name('gallery.images.create');
        Route::post('/gallery/images', [GalleryController::class, 'store'])->name('gallery.images.store');
        Route::delete('/gallery/images/{image}', [GalleryController::class, 'destroy'])->name('gallery.images.destroy');
        Route::post('/gallery/images/{image}/toggle-homepage', [GalleryController::class, 'toggleHomepage'])->name('gallery.images.toggle-homepage');

        Route::resource('categories', EventCategoryController::class);
        Route::resource('events', EventController::class);


        Route::resource('coupons', \App\Http\Controllers\Admin\CouponController::class);

        Route::get('/about/story', [AboutStoryController::class, 'edit'])->name('about.story.edit');
        Route::put('/about/story', [AboutStoryController::class, 'update'])->name('about.story.update');

        Route::get('/about/hero', [AboutHeroController::class, 'edit'])->name('about.hero.edit');
        Route::put('/about/hero', [AboutHeroController::class, 'update'])->name('about.hero.update');

        Route::get('/about/cta', [AboutCtaController::class, 'edit'])->name('about.cta.edit');
        Route::put('/about/cta', [AboutCtaController::class, 'update'])->name('about.cta.update');

        Route::resource('about/statistics', AboutStatisticController::class)->names('about.statistics');
        Route::resource('about/advantages', AboutAdvantageController::class)->names('about.advantages');

        Route::resource('home/features', PlatformFeatureController::class)->names('home.features');

        Route::get('/home/mosaic', [HomeMosaicController::class, 'index'])->name('home.mosaic.index');
        Route::put('/home/mosaic/section', [HomeMosaicController::class, 'updateSection'])->name('home.mosaic.update-section');
        Route::post('/home/mosaic/images', [HomeMosaicController::class, 'storeImage'])->name('home.mosaic.store-image');
        Route::delete('/home/mosaic/images/{image}', [HomeMosaicController::class, 'destroyImage'])->name('home.mosaic.destroy-image');
        Route::get('/home/cta', [HomeCtaController::class, 'edit'])->name('home.cta.edit');
        Route::put('/home/cta', [HomeCtaController::class, 'update'])->name('home.cta.update');

        Route::get('/contact/hero', [\App\Http\Controllers\Admin\ContactHeroController::class, 'edit'])->name('contact.hero.edit');
        Route::put('/contact/hero', [\App\Http\Controllers\Admin\ContactHeroController::class, 'update'])->name('contact.hero.update');

        Route::resource('contact/cards', \App\Http\Controllers\Admin\ContactCardController::class)->names('contact.cards');

        Route::get('/contact/form', [\App\Http\Controllers\Admin\ContactFormContentController::class, 'edit'])->name('contact.form.edit');
        Route::put('/contact/form', [\App\Http\Controllers\Admin\ContactFormContentController::class, 'update'])->name('contact.form.update');

        Route::get('/contact/support', [\App\Http\Controllers\Admin\ContactSupportController::class, 'edit'])->name('contact.support.edit');
        Route::put('/contact/support', [\App\Http\Controllers\Admin\ContactSupportController::class, 'update'])->name('contact.support.update');

        Route::get('/contact/map', [\App\Http\Controllers\Admin\ContactMapController::class, 'edit'])->name('contact.map.edit');
        Route::put('/contact/map', [\App\Http\Controllers\Admin\ContactMapController::class, 'update'])->name('contact.map.update');

        Route::get('/customers/export', [\App\Http\Controllers\Admin\UserController::class, 'export'])->name('customers.export');
        Route::get('/customers/segmentation', [\App\Http\Controllers\Admin\UserController::class, 'segmentation'])->name('customers.segmentation');
        Route::get('/customers/segmentation/export', [\App\Http\Controllers\Admin\UserController::class, 'segmentationExport'])->name('customers.segmentation.export');
        Route::get('/customers/segmentation/{id}/edit', [\App\Http\Controllers\Admin\UserController::class, 'segmentationEdit'])->name('customers.segmentation.edit');
        Route::put('/customers/segmentation/{id}', [\App\Http\Controllers\Admin\UserController::class, 'segmentationUpdate'])->name('customers.segmentation.update');
        Route::delete('/customers/segmentation/{id}', [\App\Http\Controllers\Admin\UserController::class, 'segmentationDelete'])->name('customers.segmentation.delete');
        Route::post('/customers/{id}/reset-password', [\App\Http\Controllers\Admin\UserController::class, 'resetPassword'])->name('customers.reset-password');
        Route::resource('customers', \App\Http\Controllers\Admin\UserController::class)->names('customers')->except(['edit', 'update']);

        Route::get('/finance/commission', [\App\Http\Controllers\Admin\CommissionController::class, 'index'])->name('finance.commission.index');
        Route::post('/finance/commission', [\App\Http\Controllers\Admin\CommissionController::class, 'update'])->name('finance.commission.update');
        Route::resource('finance/payment-methods', \App\Http\Controllers\Admin\PaymentMethodController::class)->names('finance.payment-methods');
        Route::get('/finance/reports/sales', [\App\Http\Controllers\Admin\ReportController::class, 'sales'])->name('finance.reports.sales');
        Route::get('/finance/reports/sales/export', [\App\Http\Controllers\Admin\ReportController::class, 'exportSales'])->name('finance.reports.sales.export');
        
        Route::get('/finance/bookings', [\App\Http\Controllers\Admin\BookingController::class, 'index'])->name('finance.bookings.index');
        Route::get('/finance/bookings/{id}', [\App\Http\Controllers\Admin\BookingController::class, 'show'])->name('finance.bookings.show');
        Route::post('/finance/bookings/{id}/approve', [\App\Http\Controllers\Admin\BookingController::class, 'approve'])->name('finance.bookings.approve');
        Route::post('/finance/bookings/{id}/reject', [\App\Http\Controllers\Admin\BookingController::class, 'reject'])->name('finance.bookings.reject');

        // Site Header & Footer
        Route::get('/site/header', [\App\Http\Controllers\Admin\SiteHeaderController::class, 'edit'])->name('site.header.edit');
        Route::put('/site/header', [\App\Http\Controllers\Admin\SiteHeaderController::class, 'update'])->name('site.header.update');
        Route::get('/site/footer', [\App\Http\Controllers\Admin\SiteFooterController::class, 'edit'])->name('site.footer.edit');
        Route::put('/site/footer', [\App\Http\Controllers\Admin\SiteFooterController::class, 'update'])->name('site.footer.update');

        // Organizer Requests
        Route::get('/organizer-requests', [\App\Http\Controllers\Admin\OrganizerRequestController::class, 'index'])->name('organizer-requests.index');
        Route::post('/organizer-requests/{id}/approve', [\App\Http\Controllers\Admin\OrganizerRequestController::class, 'approve'])->name('organizer-requests.approve');
        Route::post('/organizer-requests/{id}/reject', [\App\Http\Controllers\Admin\OrganizerRequestController::class, 'reject'])->name('organizer-requests.reject');
        Route::delete('/organizer-requests/{id}', [\App\Http\Controllers\Admin\OrganizerRequestController::class, 'destroy'])->name('organizer-requests.destroy');

        // Payout Management
        Route::get('/payout/requests', [\App\Http\Controllers\Admin\PayoutController::class, 'requests'])->name('payout.requests');
        Route::get('/payout/history', [\App\Http\Controllers\Admin\PayoutController::class, 'history'])->name('payout.history');
        Route::post('/payout/{id}/approve', [\App\Http\Controllers\Admin\PayoutController::class, 'approve'])->name('payout.approve');
        Route::post('/payout/{id}/reject', [\App\Http\Controllers\Admin\PayoutController::class, 'reject'])->name('payout.reject');
    });
});

Route::prefix('organizer')->name('organizer.')->group(function () {
    Route::get('/login', [\App\Http\Controllers\Organizer\AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [\App\Http\Controllers\Organizer\AuthController::class, 'login']);
    Route::get('/register', [\App\Http\Controllers\Organizer\AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [\App\Http\Controllers\Organizer\AuthController::class, 'register']);
    Route::get('/pending', [\App\Http\Controllers\Organizer\AuthController::class, 'showPendingPage'])->name('pending');
    Route::post('/logout', [\App\Http\Controllers\Organizer\AuthController::class, 'logout'])->name('logout');

    Route::middleware(['organizer'])->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Organizer\DashboardController::class, 'index'])->name('dashboard');

        Route::resource('events', \App\Http\Controllers\Organizer\EventController::class);
        Route::get('/get-next-code', [\App\Http\Controllers\Organizer\EventController::class, 'getNextCode'])->name('events.get-next-code');

        // Customer Management
        Route::get('/customers', [\App\Http\Controllers\Organizer\UserController::class, 'index'])->name('customers.index');
        Route::get('/customers/export', [\App\Http\Controllers\Organizer\UserController::class, 'export'])->name('customers.export');
        Route::get('/customers/segmentation', [\App\Http\Controllers\Organizer\UserController::class, 'segmentation'])->name('customers.segmentation');
        Route::get('/customers/segmentation/export', [\App\Http\Controllers\Organizer\UserController::class, 'segmentationExport'])->name('customers.segmentation.export');
        Route::get('/customers/{id}', [\App\Http\Controllers\Organizer\UserController::class, 'show'])->name('customers.show');

        Route::get('/reports/sales', [\App\Http\Controllers\Organizer\ReportController::class, 'sales'])->name('reports.sales');
        Route::get('/reports/sales/export', [\App\Http\Controllers\Organizer\ReportController::class, 'exportSales'])->name('reports.sales.export');
        Route::get('/bookings/{event_id}', [\App\Http\Controllers\Organizer\EventController::class, 'bookings'])->name('events.bookings');

        // Payout Management
        Route::get('/payout/requests', [\App\Http\Controllers\Organizer\PayoutController::class, 'requests'])->name('payout.requests');
        Route::post('/payout/requests', [\App\Http\Controllers\Organizer\PayoutController::class, 'store'])->name('payout.requests.store');
        Route::get('/payout/history', [\App\Http\Controllers\Organizer\PayoutController::class, 'history'])->name('payout.history');

        // Scanner Management
        Route::resource('scanners', \App\Http\Controllers\Organizer\ScannerController::class);
    });
});

Route::prefix('scanner')->name('scanner.')->group(function () {
    Route::middleware(['auth', 'scanner'])->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Scanner\ScannerController::class, 'dashboard'])->name('dashboard');

        Route::get('/scan', [\App\Http\Controllers\Scanner\ScannerController::class, 'showScan'])->name('scan');
        Route::post('/scan/process', [\App\Http\Controllers\Scanner\ScannerController::class, 'processScan'])->name('scan.process');

        Route::get('/manual-checkin', [\App\Http\Controllers\Scanner\ScannerController::class, 'showManualCheckin'])->name('manual-checkin');
    });
});
