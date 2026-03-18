@php
    $currentRoute = Route::currentRouteName();
    $module = null;
    $links = [];

    // Define Module Submenus
    if (Str::startsWith($currentRoute, 'admin.events.') || Str::startsWith($currentRoute, 'admin.categories.')) {
        $module = 'Event Management';
        $links = [
            ['name' => 'Hero Section', 'route' => 'admin.events.hero', 'icon' => 'fa-star'],
            ['name' => 'Published', 'route' => 'admin.events.index', 'icon' => 'fa-check-circle'],
            ['name' => 'Drafts', 'route' => 'admin.events.drafts', 'icon' => 'fa-file-lines'],
            ['name' => 'Categories', 'route' => 'admin.categories.index', 'icon' => 'fa-tags'],
        ];
    } elseif (Str::startsWith($currentRoute, 'admin.home.')) {
        $module = 'Home Configuration';
        $links = [
            ['name' => 'Platform Features', 'route' => 'admin.home.features.index', 'icon' => 'fa-list-check'],
            ['name' => 'CTA Section', 'route' => 'admin.home.cta.edit', 'icon' => 'fa-bullhorn'],
        ];
    } elseif (Str::startsWith($currentRoute, 'admin.gallery.')) {
        $module = 'Gallery Management';
        $links = [
            ['name' => 'Hero Section', 'route' => 'admin.gallery.hero', 'icon' => 'fa-image'],
            ['name' => 'Manage Images', 'route' => 'admin.gallery.images.index', 'icon' => 'fa-images'],
        ];
    } elseif (Str::startsWith($currentRoute, 'admin.about.')) {
        $module = 'About Page';
        $links = [
            ['name' => 'Hero', 'route' => 'admin.about.hero.edit', 'icon' => 'fa-heading'],
            ['name' => 'Story', 'route' => 'admin.about.story.edit', 'icon' => 'fa-book-open'],
            ['name' => 'Stats', 'route' => 'admin.about.statistics.index', 'icon' => 'fa-chart-simple'],
            ['name' => 'Advantages', 'route' => 'admin.about.advantages.index', 'icon' => 'fa-thumbs-up'],
            ['name' => 'CTA', 'route' => 'admin.about.cta.edit', 'icon' => 'fa-reply'],
        ];
    } elseif (Str::startsWith($currentRoute, 'admin.contact.')) {
        $module = 'Contact System';
        $links = [
            ['name' => 'Hero', 'route' => 'admin.contact.hero.edit', 'icon' => 'fa-envelope'],
            ['name' => 'Cards', 'route' => 'admin.contact.cards.index', 'icon' => 'fa-address-card'],
            ['name' => 'Form', 'route' => 'admin.contact.form.edit', 'icon' => 'fa-pen-to-square'],
            ['name' => 'Support', 'route' => 'admin.contact.support.edit', 'icon' => 'fa-headset'],
            ['name' => 'Map', 'route' => 'admin.contact.map.edit', 'icon' => 'fa-location-dot'],
            ['name' => 'Messages', 'route' => 'admin.contact.messages.index', 'icon' => 'fa-message'],
        ];
    } elseif (Str::startsWith($currentRoute, 'admin.finance.') || Str::startsWith($currentRoute, 'admin.reports.')) {
        $module = 'Finance & Audits';
        $links = [
            ['name' => 'Commission', 'route' => 'admin.finance.commission.index', 'icon' => 'fa-percentage'],
            ['name' => 'Booking Approval', 'route' => 'admin.finance.bookings.index', 'icon' => 'fa-receipt'],
            ['name' => 'Sales Audits', 'route' => 'admin.finance.reports.sales', 'icon' => 'fa-magnifying-glass-dollar'],
            ['name' => 'Methods', 'route' => 'admin.finance.payment-methods.index', 'icon' => 'fa-credit-card'],
        ];
    } elseif (Str::startsWith($currentRoute, 'admin.payout.')) {
        $module = 'Payout System';
        $links = [
            ['name' => 'Withdrawals', 'route' => 'admin.payout.requests', 'icon' => 'fa-money-bill-transfer'],
            ['name' => 'History', 'route' => 'admin.payout.history', 'icon' => 'fa-clock-rotate-left'],
        ];
    } elseif (Str::startsWith($currentRoute, 'admin.site.')) {
        $module = 'Site Settings';
        $links = [
            ['name' => 'Header Setup', 'route' => 'admin.site.header.edit', 'icon' => 'fa-window-maximize'],
            ['name' => 'Footer Config', 'route' => 'admin.site.footer.edit', 'icon' => 'fa-window-minimize'],
        ];
    } elseif (Str::startsWith($currentRoute, 'admin.customers.')) {
        $module = 'Customer Intelligence';
        $links = [
            ['name' => 'Database', 'route' => 'admin.customers.index', 'icon' => 'fa-database'],
            ['name' => 'Segmentation', 'route' => 'admin.customers.segmentation', 'icon' => 'fa-users-viewfinder'],
        ];
    }
@endphp

@if($module && count($links) > 0)
<div class="mb-8 sticky top-[80px] z-30 animate-fadeIn">
    <div class="bg-white/80 backdrop-blur-xl border border-white/50 shadow-premium rounded-[2rem] p-2 flex items-center gap-1 overflow-x-auto no-scrollbar">
        @foreach($links as $link)
            @php $isActive = request()->routeIs($link['route'] . '*'); @endphp
            <a href="{{ route($link['route']) }}" 
               class="flex items-center gap-3 px-6 py-3.5 rounded-2xl text-xs font-black uppercase tracking-widest transition-all whitespace-nowrap
               {{ $isActive ? 'bg-primary text-white shadow-lg shadow-primary/20 scale-[1.02]' : 'text-slate-400 hover:text-primary hover:bg-primary/5' }}">
                <i class="fa-solid {{ $link['icon'] }} {{ $isActive ? 'text-white' : 'text-primary' }}"></i>
                {{ $link['name'] }}
            </a>
        @endforeach
    </div>
</div>
@endif
