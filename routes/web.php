<?php

use Illuminate\Support\Facades\Route;
use App\Models\EventHero;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\GalleryHero;
use App\Http\Controllers\Admin\EventHeroController;
use App\Http\Controllers\Admin\EventCategoryController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\GalleryHeroController;
use App\Http\Controllers\Admin\GalleryController;

Route::get('/', function () {
    return view('home');
});

Route::get('/events', function () {
    $hero = EventHero::first();
    $categories = EventCategory::withCount('events')->get();
    $events = Event::with('category')->where('status', 'Live')->latest()->paginate(12);
    return view('events', compact('hero', 'categories', 'events'));
})->name('events');

Route::get('/gallery', function () {
    $hero = GalleryHero::first();
    return view('gallery', compact('hero'));
})->name('gallery');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
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
});
