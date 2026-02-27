@extends('layouts.app')

@section('title', 'About Us - Reimagining the Fan Journey | Ticket Kinun')

@section('content')
    <!-- Statistics Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">

                @forelse($statistics as $stat)
                <div class="bg-white rounded-[2rem] py-10 px-6 text-center flex flex-col items-center justify-center border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] relative overflow-hidden">
                    <div class="absolute top-0 left-0 right-0 h-1.5" style="background: {{ $stat->color }};"></div>
                    <div class="w-14 h-14 rounded-[1rem] flex items-center justify-center text-white mb-6" style="background: {{ $stat->color }};">
                        <i class="{{ $stat->icon }} text-2xl"></i>
                    </div>
                    <h3 class="text-[2.5rem] leading-none font-bold text-[#111827] mb-3">{{ $stat->value }}</h3>
                    <p class="text-[10px] font-bold text-[#9ca3af] uppercase tracking-wider">{{ $stat->label }}</p>
                </div>
                @empty
                <!-- Fallback Static Content -->
                <div class="bg-white rounded-[2rem] py-10 px-6 text-center flex flex-col items-center justify-center border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] relative overflow-hidden">
                    <div class="absolute top-0 left-0 right-0 h-1.5 bg-[#3b82f6]"></div>
                    <div class="w-14 h-14 bg-[#3b82f6] rounded-[1rem] flex items-center justify-center text-white mb-6">
                        <i class="fas fa-globe text-2xl"></i>
                    </div>
                    <h3 class="text-[2.5rem] leading-none font-bold text-[#111827] mb-3">500+</h3>
                    <p class="text-[10px] font-bold text-[#9ca3af] uppercase tracking-wider">GLOBAL EVENTS</p>
                </div>
                
                <div class="bg-white rounded-[2rem] py-10 px-6 text-center flex flex-col items-center justify-center border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] relative overflow-hidden">
                    <div class="absolute top-0 left-0 right-0 h-1.5 bg-[#10b981]"></div>
                    <div class="w-14 h-14 bg-[#10b981] rounded-[1rem] flex items-center justify-center text-white mb-6">
                        <i class="fas fa-users text-2xl"></i>
                    </div>
                    <h3 class="text-[2.5rem] leading-none font-bold text-[#111827] mb-3">1M+</h3>
                    <p class="text-[10px] font-bold text-[#9ca3af] uppercase tracking-wider">HAPPY FANS</p>
                </div>

                <div class="bg-white rounded-[2rem] py-10 px-6 text-center flex flex-col items-center justify-center border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] relative overflow-hidden">
                    <div class="absolute top-0 left-0 right-0 h-1.5 bg-[#f59e0b]"></div>
                    <div class="w-14 h-14 bg-[#f59e0b] rounded-[1rem] flex items-center justify-center text-white mb-6">
                        <i class="fas fa-award text-2xl"></i>
                    </div>
                    <h3 class="text-[2.5rem] leading-none font-bold text-[#111827] mb-3">25+</h3>
                    <p class="text-[10px] font-bold text-[#9ca3af] uppercase tracking-wider">INDUSTRY AWARDS</p>
                </div>

                <div class="bg-white rounded-[2rem] py-10 px-6 text-center flex flex-col items-center justify-center border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] relative overflow-hidden">
                    <div class="absolute top-0 left-0 right-0 h-1.5 bg-[#6366f1]"></div>
                    <div class="w-14 h-14 bg-[#6366f1] rounded-[1rem] flex items-center justify-center text-white mb-6">
                        <i class="fas fa-shield-alt text-2xl"></i>
                    </div>
                    <h3 class="text-[2.5rem] leading-none font-bold text-[#111827] mb-3">100%</h3>
                    <p class="text-[10px] font-bold text-[#9ca3af] uppercase tracking-wider">SECURE SALES</p>
                </div>
                @endforelse

            </div>
        </div>
    </section>

    <!-- Hero / Mission Section -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-24 items-center">
                <!-- Image -->
                <div class="relative w-full">
                    <div class="rounded-3xl overflow-hidden shadow-2xl relative">
                        <!-- Bridge image -->
                        <img src="{{ $story->image ?? 'https://images.unsplash.com/photo-1513635269975-59663e0ac1ad?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80' }}" alt="Our Story" class="w-full h-auto object-cover aspect-[4/3] brightness-75">
                    </div>
                </div>

                <!-- Content -->
                <div class="flex flex-col">
                    <div class="mb-6">
                        <span class="inline-block px-3 py-1 bg-slate-50 border border-slate-200 text-slate-500 text-[10px] font-bold tracking-widest uppercase rounded">
                            {{ $story->badge_text ?? 'OUR STORY' }}
                        </span>
                    </div>
                    
                    <h2 class="font-outfit text-5xl md:text-[3.5rem] font-black text-[#1e293b] leading-[1.1] mb-2 tracking-tighter">
                        {{ $story->title_main ?? 'Reimagining the' }} <br>
                        <span class="text-slate-400">{{ $story->title_highlight ?? 'Fan Journey' }}</span>
                    </h2>
                    
                    <div class="w-full max-w-[200px] h-[2px] bg-red-100 my-8 relative">
                        <div class="absolute right-0 top-0 h-full w-16 bg-red-200"></div>
                    </div>

                    <p class="text-slate-600 text-[15px] leading-relaxed mb-6 font-medium">
                        {{ $story->paragraph_1 ?? 'We founded Ticket Kinun with a simple mission: to bridge the gap between complex event logistics and the pure joy of the experience.' }}
                    </p>
                    <p class="text-slate-600 text-[15px] leading-relaxed mb-10 font-medium">
                        {{ $story->paragraph_2 ?? 'Today, we empower thousands of organizers and millions of fans with a platform that prioritizes speed, security, and style above all else.' }}
                    </p>

                    <!-- Mini Cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div class="rounded-2xl p-5 flex items-start gap-4" style="background: {{ $story->card_1_bg_color ?? '#f0f5ff' }}">
                            <div class="w-8 h-8 rounded flex-shrink-0 flex items-center justify-center text-white mt-1 shadow-sm {{ $story->card_1_icon_color ?? 'bg-blue-500' }}">
                                <i class="{{ $story->card_1_icon ?? 'fas fa-fire' }} text-xs"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-[#1e293b] text-[15px] mb-1">{{ $story->card_1_title ?? 'Passion' }}</h4>
                                <p class="text-slate-500 text-xs leading-relaxed font-medium">{{ $story->card_1_description ?? 'What drives us to build the best experience.' }}</p>
                            </div>
                        </div>

                        <div class="rounded-2xl p-5 flex items-start gap-4" style="background: {{ $story->card_2_bg_color ?? '#fff0f2' }}">
                            <div class="w-8 h-8 rounded flex-shrink-0 flex items-center justify-center text-white mt-1 shadow-sm {{ $story->card_2_icon_color ?? 'bg-rose-500' }}">
                                <i class="{{ $story->card_2_icon ?? 'fas fa-heart' }} text-xs"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-[#1e293b] text-[15px] mb-1">{{ $story->card_2_title ?? 'Community' }}</h4>
                                <p class="text-slate-500 text-xs leading-relaxed font-medium">{{ $story->card_2_description ?? 'More than just a platform, it is a movement.' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- The Kinun Advantage Section -->
    <section class="py-24 bg-[#f8fafc]">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="font-outfit text-4xl md:text-[2.75rem] font-black text-[#1e293b] tracking-tight mb-4">The Kinun Advantage</h2>
                <p class="text-slate-500 text-[15px] font-medium">Built on a foundation of technology and a passion for live events.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @forelse($advantages as $advantage)
                <div class="rounded-[2rem] p-10 shadow-sm border hover:shadow-md transition-shadow {{ $advantage->border_class }}" style="background: {{ $advantage->card_bg_color }}">
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-white mb-8 shadow-sm" style="background: {{ $advantage->icon_bg_color }}">
                        <i class="{{ $advantage->icon }}"></i>
                    </div>
                    <h3 class="font-bold text-xl mb-3 tracking-tight" style="color: {{ $advantage->title_color }}">{{ $advantage->title }}</h3>
                    <p class="text-sm leading-relaxed font-medium" style="color: {{ $advantage->desc_color }}">
                        {{ $advantage->description }}
                    </p>
                </div>
                @empty
                <!-- Fallback content if empty -->
                <div class="col-span-1 md:col-span-3 text-center text-slate-400 py-10">
                    Advantages are currently being updated. Please check back later!
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="py-24 bg-white">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h2 class="font-outfit text-4xl md:text-[2.75rem] font-black text-[#1e293b] tracking-tight mb-4">{{ $cta->title ?? 'Ready to partner?' }}</h2>
            <p class="text-slate-500 text-[15px] mb-10 font-medium">{{ $cta->subtitle ?? 'Join our global network of organizers and bring your events to millions.' }}</p>
            
            <a href="{{ $cta->button_url ?? '#' }}" class="inline-flex items-center justify-center gap-3 bg-[#111827] text-white px-10 py-4 rounded-full font-bold text-sm tracking-wide hover:bg-[#1f2937] transition-all shadow-lg shadow-gray-900/30">
                {{ $cta->button_text ?? 'CONTACT US TODAY' }}
                <i class="fas fa-arrow-right text-[10px]"></i>
            </a>
        </div>
    </section>
@endsection
