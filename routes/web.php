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

Route::get('/', function () {
    $featuredEvents = Event::with('category')->where('status', 'Live')->where('is_featured', true)->orderBy('sort_order', 'asc')->latest()->take(2)->get();
    
    $slideData = $featuredEvents->map(function($e) {
        return [
            'title' => $e->title,
            'date' => strtoupper($e->date->format('d M, Y')),
            'location' => strtoupper($e->location)
        ];
    });

    $trendingEvents = Event::with('category')->where('status', 'Live')->orderBy('sort_order', 'asc')->latest()->take(4)->get();
    $upcomingEvents = Event::with('category')->where('status', 'Live')->orderBy('sort_order', 'asc')->latest()->take(8)->get();
    
    return view('home', compact('featuredEvents', 'trendingEvents', 'upcomingEvents', 'slideData'));
});

Route::get('/events', function () {
    $hero = EventHero::first();
    $categories = EventCategory::withCount('events')->get();
    $featuredEvents = Event::with('category')->where('status', 'Live')->where('is_featured', true)->orderBy('sort_order', 'asc')->latest()->take(3)->get();
    $events = Event::with('category')->where('status', 'Live')->orderBy('sort_order', 'asc')->latest()->paginate(12);
    return view('events', compact('hero', 'categories', 'events', 'featuredEvents'));
})->name('events');

Route::get('/events/{slug}', function ($slug) {
    $event = Event::with(['category', 'ticketTypes'])->where('slug', $slug)->firstOrFail();
    $relatedEvents = Event::with('category')->where('category_id', $event->category_id)->where('id', '!=', $event->id)->take(4)->get();
    return view('events.show', compact('event', 'relatedEvents'));
})->name('events.show');

Route::get('/gallery', function () {
    $hero = GalleryHero::first();
    $dbImages = GalleryImage::with('category')->latest()->paginate(12);
    return view('gallery', compact('hero', 'dbImages'));
})->name('gallery');

Route::get('/about', function () {
    $statistics = \App\Models\AboutStatistic::orderBy('sort_order', 'asc')->get();
    $story = \App\Models\AboutStory::first();
    $advantages = \App\Models\AboutAdvantage::orderBy('sort_order', 'asc')->get();
    $cta = \App\Models\AboutCta::first();
    return view('about', compact('statistics', 'story', 'advantages', 'cta'));
})->name('about');

Route::get('/contact', function () {
    $hero = \App\Models\ContactHero::first();
    $cards = \App\Models\ContactCard::orderBy('sort_order', 'asc')->get();
    $formContent = \App\Models\ContactFormContent::first();
    $support = \App\Models\ContactSupport::first();
    $map = \App\Models\ContactMap::first();
    return view('contact', compact('hero', 'cards', 'formContent', 'support', 'map'));
})->name('contact');

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/events/hero', [EventHeroController::class, 'edit'])->name('events.hero');
    Route::post('/events/hero', [EventHeroController::class, 'update'])->name('events.hero.update');
    
    Route::get('/events/drafts', [EventController::class, 'drafts'])->name('events.drafts');
    Route::post('/events/{event}/publish', [EventController::class, 'publish'])->name('events.publish');
    
    Route::get('/gallery/hero', [GalleryHeroController::class, 'edit'])->name('gallery.hero');
    Route::post('/gallery/hero', [GalleryHeroController::class, 'update'])->name('gallery.hero.update');
    
    Route::get('/gallery/images', [GalleryController::class, 'index'])->name('gallery.images.index');
    Route::get('/gallery/images/create', [GalleryController::class, 'create'])->name('gallery.images.create');
    Route::post('/gallery/images', [GalleryController::class, 'store'])->name('gallery.images.store');
    Route::delete('/gallery/images/{image}', [GalleryController::class, 'destroy'])->name('gallery.images.destroy');

    Route::resource('categories', EventCategoryController::class);
    Route::resource('events', EventController::class);
    
    Route::get('/about/story', [AboutStoryController::class, 'edit'])->name('about.story.edit');
    Route::put('/about/story', [AboutStoryController::class, 'update'])->name('about.story.update');

    Route::get('/about/cta', [AboutCtaController::class, 'edit'])->name('about.cta.edit');
    Route::put('/about/cta', [AboutCtaController::class, 'update'])->name('about.cta.update');
    
    Route::resource('about/statistics', AboutStatisticController::class)->names('about.statistics');
    Route::resource('about/advantages', AboutAdvantageController::class)->names('about.advantages');

    Route::get('/contact/hero', [\App\Http\Controllers\Admin\ContactHeroController::class, 'edit'])->name('contact.hero.edit');
    Route::put('/contact/hero', [\App\Http\Controllers\Admin\ContactHeroController::class, 'update'])->name('contact.hero.update');

    Route::resource('contact/cards', \App\Http\Controllers\Admin\ContactCardController::class)->names('contact.cards');

    Route::get('/contact/form', [\App\Http\Controllers\Admin\ContactFormContentController::class, 'edit'])->name('contact.form.edit');
    Route::put('/contact/form', [\App\Http\Controllers\Admin\ContactFormContentController::class, 'update'])->name('contact.form.update');

    Route::get('/contact/support', [\App\Http\Controllers\Admin\ContactSupportController::class, 'edit'])->name('contact.support.edit');
    Route::put('/contact/support', [\App\Http\Controllers\Admin\ContactSupportController::class, 'update'])->name('contact.support.update');

    Route::get('/contact/map', [\App\Http\Controllers\Admin\ContactMapController::class, 'edit'])->name('contact.map.edit');
    Route::put('/contact/map', [\App\Http\Controllers\Admin\ContactMapController::class, 'update'])->name('contact.map.update');
});
