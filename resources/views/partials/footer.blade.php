<!-- Footer -->
@php
    $f = $siteFooter ?? null;
    $fLogoSrc = $f && $f->logo_path
        ? (str_starts_with($f->logo_path, 'site/') ? asset('storage/'.$f->logo_path) : asset($f->logo_path))
        : asset('Blue_Simple_Technology_Logo.png');
    $fDescription      = $f->description ?? 'Ticket Kinun is your premier gateway to life\'s most unforgettable experiences. Discover, book, and enjoy.';
    $fFacebook         = $f->facebook_url ?? '#';
    $fTwitter          = $f->twitter_url ?? '#';
    $fInstagram        = $f->instagram_url ?? '#';
    $fLinkedin         = $f->linkedin_url ?? '#';
    $fExplorerTitle    = $f->explorer_title ?? 'Explorer';
    $fExplorerLinks    = $f->explorer_links ?? [['label'=>'Discover Events','url'=>'/events'],['label'=>'Trending Now','url'=>'/#trending'],['label'=>'The Kinun Story','url'=>'/about'],['label'=>'Contact Us','url'=>'/contact']];
    $fCollectionsTitle = $f->collections_title ?? 'Collections';
    $fCollectionsItems = $f->collections_items ?? [['label'=>'Live Concerts'],['label'=>'Elite Sports'],['label'=>'Cinema Premiers'],['label'=>'Culture Fests']];
    $fContactTitle     = $f->contact_title ?? 'Get In Touch';
    $fEmail            = $f->contact_email ?? 'support@ticketkinun.com';
    $fPhone            = $f->contact_phone ?? '+880 1234 567 890';
    $fAddress          = $f->contact_address ?? 'Gulshan, Dhaka, BD';
    $fCopyright        = $f->copyright_text ?? 'Copyright © 2024 Ticket Kinun. Crafted with precision for the ultimate fans.';
    $fPrivacy          = $f->privacy_url ?? '#';
    $fTerms            = $f->terms_url ?? '#';
    $fCookies          = $f->cookies_url ?? '#';
@endphp
<footer class="bg-gradient-to-r from-[#520C6B] to-[#1B2B46] text-white pt-16 md:pt-24 pb-12 shadow-[0_-10px_40px_-15px_rgba(82,12,107,0.3)]">
    <div class="max-w-7xl mx-auto px-4 md:px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 md:gap-16 mb-16 md:mb-20">
            <!-- Branding -->
            <div class="col-span-1">
                <a href="/" class="flex-shrink-0 mb-8 block">
                    <img loading="lazy" src="{{ $fLogoSrc }}" alt="Ticket Kinun Logo" class="h-16 w-auto object-contain brightness-0 invert">
                </a>
                <p class="text-slate-400 leading-relaxed mb-8 max-w-xs font-light">
                    {{ $fDescription }}
                </p>
                <div class="flex gap-4">
                    <a href="{{ $fFacebook }}" class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center border border-white/10 hover:bg-primary hover:border-primary transition-all group">
                        <i class="fab fa-facebook-f text-white/40 group-hover:text-white"></i>
                    </a>
                    <a href="{{ $fTwitter }}" class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center border border-white/10 hover:bg-primary hover:border-primary transition-all group">
                        <i class="fab fa-twitter text-white/40 group-hover:text-white"></i>
                    </a>
                    <a href="{{ $fInstagram }}" class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center border border-white/10 hover:bg-primary hover:border-primary transition-all group">
                        <i class="fab fa-instagram text-white/40 group-hover:text-white"></i>
                    </a>
                    <a href="{{ $fLinkedin }}" class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center border border-white/10 hover:bg-primary hover:border-primary transition-all group">
                        <i class="fab fa-linkedin-in text-white/40 group-hover:text-white"></i>
                    </a>
                </div>
            </div>

            <!-- Explorer -->
            <div class="lg:pl-10">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-1 h-5 bg-accent"></div>
                    <h3 class="font-black text-xs tracking-[0.2em] uppercase">{{ $fExplorerTitle }}</h3>
                </div>
                <ul class="space-y-4 text-slate-400 font-medium text-sm">
                    @foreach($fExplorerLinks as $link)
                        <li><a href="{{ $link['url'] }}" class="hover:text-white transition-colors">{{ $link['label'] }}</a></li>
                    @endforeach
                </ul>
            </div>

            <!-- Collections -->
            <div class="lg:pl-10">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-1 h-5 bg-accent"></div>
                    <h3 class="font-black text-xs tracking-[0.2em] uppercase">{{ $fCollectionsTitle }}</h3>
                </div>
                <ul class="space-y-4 text-slate-400 font-medium text-sm">
                    @foreach($fCollectionsItems as $item)
                        <li>{{ $item['label'] }}</li>
                    @endforeach
                </ul>
            </div>

            <!-- Get In Touch -->
            <div class="lg:pl-10">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-1 h-5 bg-accent"></div>
                    <h3 class="font-black text-xs tracking-[0.2em] uppercase">{{ $fContactTitle }}</h3>
                </div>
                <ul class="space-y-6">
                    <li class="flex items-start gap-4 group">
                        <div class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center border border-white/10 group-hover:bg-primary/20 transition-all">
                            <i class="fas fa-envelope text-[10px] text-accent"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-1">EMAIL</span>
                            <span class="text-slate-200 text-sm font-medium leading-none">{{ $fEmail }}</span>
                        </div>
                    </li>
                    <li class="flex items-start gap-4 group">
                        <div class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center border border-white/10 group-hover:bg-primary/20 transition-all">
                            <i class="fas fa-phone-alt text-[10px] text-accent"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-1">HOTLINE</span>
                            <span class="text-slate-200 text-sm font-medium leading-none">{{ $fPhone }}</span>
                        </div>
                    </li>
                    <li class="flex items-start gap-4 group">
                        <div class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center border border-white/10 group-hover:bg-primary/20 transition-all">
                            <i class="fas fa-map-marker-alt text-[10px] text-accent"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-1">LOCATION</span>
                            <span class="text-slate-200 text-sm font-medium leading-none">{{ $fAddress }}</span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="pt-12 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-white/5 border border-white/10 rounded-xl flex items-center justify-center text-white/20 text-[10px] font-black">N</div>
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest leading-loose">
                    {{ $fCopyright }}
                </p>
            </div>
            <div class="flex gap-8 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">
                <a href="{{ $fPrivacy }}" class="hover:text-white transition-colors">Privacy</a>
                <a href="{{ $fTerms }}" class="hover:text-white transition-colors">Terms</a>
                <a href="{{ $fCookies }}" class="hover:text-white transition-colors">Cookies</a>
            </div>
        </div>
    </div>
</footer>
