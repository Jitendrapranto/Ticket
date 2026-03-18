@extends('layouts.app')

@section('title', 'Contact Us - We Are Here To Help | Ticket Kinun')

@section('content')
    <!-- Hero Section -->
    <section class="relative pt-10 pb-16 md:pt-12 md:pb-24 bg-gradient-to-r from-[#520C6B] to-[#1B2B46] overflow-hidden min-h-[320px] md:min-h-[450px] flex items-center">
        <!-- Abstract Background Glows -->
        <div class="absolute top-0 right-0 w-[250px] md:w-[500px] h-[250px] md:h-[500px] bg-primary/10 rounded-full blur-[80px] md:blur-[120px] -translate-y-1/2 translate-x-1/4"></div>
        <div class="absolute bottom-0 left-0 w-[150px] md:w-[300px] h-[150px] md:h-[300px] bg-accent/5 rounded-full blur-[60px] md:blur-[100px] translate-y-1/2 -translate-x-1/4"></div>

        <div class="max-w-7xl mx-auto px-4 md:px-6 relative z-10 text-center">

            <h1 class="font-outfit text-4xl md:text-6xl lg:text-8xl font-black text-white leading-tight mb-4 md:mb-6 tracking-tighter">
                {{ $hero->title_main ?? 'Get In' }} <span class="text-[#FFE700] tracking-normal">{{ $hero->title_accent ?? 'Touch.' }}</span>
            </h1>
            <p class="text-slate-400 text-sm md:text-lg lg:text-xl mb-8 md:mb-12 max-w-2xl mx-auto font-light leading-relaxed px-2">
                {{ $hero->subtitle ?? 'Have a question or need assistance with your booking? Our dedicated support team is available 24/7 to ensure your experience is flawless.' }}
            </p>
        </div>
    </section>

    <!-- Contact Info Cards -->
    <section class="py-10 md:py-24 bg-white relative z-20 -mt-10 md:-mt-20">
        <div class="max-w-7xl mx-auto px-4 md:px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 mb-10 md:mb-24">
                @foreach($cards as $card)
                <div class="animate-fadeInUp rounded-[1.5rem] md:rounded-[1.75rem] p-6 md:p-8 flex flex-row md:flex-col gap-4 md:gap-6 hover:shadow-lg transition-all duration-300 group"
                     style="background: {{ $card->bg_color }}; border-top: 3px solid {{ $card->theme_color }};">
                    <!-- Icon badge -->
                    <div class="w-12 h-12 md:w-14 md:h-14 rounded-[0.85rem] md:rounded-[1rem] flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform duration-300"
                         style="background: {{ $card->theme_color }};">
                        <i class="{{ $card->icon }} text-white text-lg md:text-xl"></i>
                    </div>
                    <!-- Text -->
                    <div>
                        <h3 class="font-black text-base md:text-[1.1rem] mb-1 md:mb-2 leading-snug" style="color: {{ $card->title_color }};">{{ $card->title }}</h3>
                        <p class="text-sm leading-relaxed font-medium" style="color: {{ $card->desc_color }};">
                            {{ $card->description }}
                        </p>
                        @if($card->action_text)
                        <a href="{{ $card->action_url ?? '#' }}"
                           class="inline-block mt-3 font-black text-[11px] tracking-widest uppercase hover:underline"
                           style="color: {{ $card->theme_color }};">{{ $card->action_text }}</a>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Contact Form & Visual -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8 items-stretch">

                <!-- ── Form Card (outlined) ── -->
                <div class="animate-fadeInUp rounded-[1.75rem] p-8 sm:p-10 flex flex-col bg-white shadow-[0_8px_48px_rgba(82,12,107,0.18)]" style="border: 2px solid #520C6B;">

                    <!-- Section label -->
                    <span class="text-[11px] font-black tracking-[0.3em] uppercase mb-3 block" style="color:#520C6B;">{{ $formContent->badge_text ?? 'SEND A MESSAGE' }}</span>
                    <h2 class="font-outfit text-3xl sm:text-4xl font-black text-[#111827] mb-3 tracking-tight leading-tight">{{ $formContent->title ?? 'Drop Us A Line.' }}</h2>
                    <p class="text-slate-400 text-[14px] font-medium leading-relaxed mb-8">
                        {{ $formContent->description ?? 'Fill out the form and our team will get back to you within 2 hours.' }}
                    </p>

                    <form action="{{ route('contact.store') }}" method="POST" class="space-y-4 flex-1 flex flex-col">
                        @csrf
                        <!-- Row: Full Name + Email -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="flex flex-col gap-1.5">
                                <label class="text-[10px] font-black text-slate-400 tracking-[0.18em] uppercase pl-1">{{ $formContent->name_label ?? 'Full Name' }}</label>
                                <input type="text" name="full_name" placeholder="{{ $formContent->name_placeholder ?? 'John Doe' }}" required
                                       class="w-full bg-white border border-slate-200 rounded-xl py-3.5 px-4 text-[14px] text-[#111827] font-medium placeholder-slate-300 outline-none transition-all duration-200 focus:border-[#520C6B] focus:ring-2 focus:ring-[#520C6B]/10 hover:border-slate-300">
                            </div>
                            <div class="flex flex-col gap-1.5">
                                <label class="text-[10px] font-black text-slate-400 tracking-[0.18em] uppercase pl-1">{{ $formContent->email_label ?? 'Email Address' }}</label>
                                <input type="email" name="email" placeholder="{{ $formContent->email_placeholder ?? 'john@example.com' }}" required
                                       class="w-full bg-white border border-slate-200 rounded-xl py-3.5 px-4 text-[14px] text-[#111827] font-medium placeholder-slate-300 outline-none transition-all duration-200 focus:border-[#520C6B] focus:ring-2 focus:ring-[#520C6B]/10 hover:border-slate-300">
                            </div>
                        </div>

                        <!-- Row: Phone + Subject -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="flex flex-col gap-1.5">
                                <label class="text-[10px] font-black text-slate-400 tracking-[0.18em] uppercase pl-1">{{ $formContent->phone_label ?? 'Phone Number' }}</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-[13px]">
                                        <i class="fas fa-phone-alt"></i>
                                    </span>
                                    <input type="tel" name="phone" placeholder="{{ $formContent->phone_placeholder ?? '+880 1234 567 890' }}"
                                           class="w-full bg-white border border-slate-200 rounded-xl py-3.5 pl-10 pr-4 text-[14px] text-[#111827] font-medium placeholder-slate-300 outline-none transition-all duration-200 focus:border-[#520C6B] focus:ring-2 focus:ring-[#520C6B]/10 hover:border-slate-300">
                                </div>
                            </div>
                            <div class="flex flex-col gap-1.5">
                                <label class="text-[10px] font-black text-slate-400 tracking-[0.18em] uppercase pl-1">{{ $formContent->subject_label ?? 'Subject' }}</label>
                                <div class="relative">
                                    <select name="subject" class="w-full bg-white border border-slate-200 rounded-xl py-3.5 px-4 text-[14px] text-[#111827] font-medium outline-none transition-all duration-200 focus:border-[#520C6B] focus:ring-2 focus:ring-[#520C6B]/10 hover:border-slate-300 appearance-none cursor-pointer">
                                        <option value="General Inquiry">General Inquiry</option>
                                        <option value="Ticket Issue">Ticket Issue</option>
                                        <option value="Partnership">Partnership</option>
                                        <option value="Feedback">Feedback</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-4 flex items-center">
                                        <i class="fas fa-chevron-down text-slate-400 text-[11px]"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Message -->
                        <div class="flex flex-col gap-1.5 flex-1">
                            <label class="text-[10px] font-black text-slate-400 tracking-[0.18em] uppercase pl-1">{{ $formContent->message_label ?? 'Your Message' }}</label>
                            <textarea name="message" rows="5" placeholder="{{ $formContent->message_placeholder ?? 'How can we help you today?' }}" required
                                      class="w-full flex-1 bg-white border border-slate-200 rounded-xl py-3.5 px-4 text-[14px] text-[#111827] font-medium placeholder-slate-300 outline-none transition-all duration-200 focus:border-[#520C6B] focus:ring-2 focus:ring-[#520C6B]/10 hover:border-slate-300 resize-none"></textarea>
                        </div>

                        <!-- Divider -->
                        <div class="border-t border-slate-100 pt-4">
                            <button type="submit"
                                    class="w-full py-4 rounded-xl font-black text-[13px] tracking-[0.18em] uppercase text-white transition-all duration-300 hover:opacity-90 hover:shadow-xl active:scale-[0.98] flex items-center justify-center gap-3"
                                    style="background:linear-gradient(135deg,#520C6B,#7c3aed);">
                                {{ $formContent->button_text ?? 'SEND MESSAGE' }}
                                <i class="fas fa-paper-plane text-sm"></i>
                            </button>
                        </div>

                    </form>
                </div>

                <!-- ── Image Card (same height as form) ── -->
                <div class="animate-fadeInUp hidden lg:flex flex-col" style="animation-delay:0.15s;">
                    <div class="flex-1 rounded-[1.75rem] overflow-hidden relative border border-slate-200 shadow-[0_4px_32px_rgba(82,12,107,0.07)]"
                         style="min-height: 100%;">
                        <img src="{{ $support->image ?? 'https://images.unsplash.com/photo-1534536281715-e28d76689b4d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80' }}"
                             alt="Support representative"
                             class="w-full h-full object-cover absolute inset-0">
                        <!-- Overlay -->
                        <div class="absolute inset-0" style="background:linear-gradient(to top, rgba(33,3,43,0.92) 0%, rgba(82,12,107,0.3) 50%, transparent 100%);"></div>
                        <!-- Content on image -->
                        <div class="absolute inset-0 flex flex-col justify-between p-8 z-20">
                            <!-- Top badge -->
                            <div class="self-start">
                                <span class="text-white/80 font-black text-[10px] tracking-[0.25em] uppercase px-3 py-1.5 rounded-full"
                                      style="background:rgba(255,255,255,0.12); backdrop-filter:blur(8px); border:1px solid rgba(255,255,255,0.15);">
                                    {{ $support->badge_text ?? '24 / 7 Support' }}
                                </span>
                            </div>
                            <!-- Bottom info -->
                            <div>
                                <!-- Quick contact info -->
                                <div class="flex flex-col gap-3 mb-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0" style="background:rgba(255,255,255,0.15);">
                                            <i class="fas fa-envelope text-white text-xs"></i>
                                        </div>
                                        <span class="text-white/80 text-[13px] font-semibold">{{ $support->email ?? 'support@ticketkinun.com' }}</span>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0" style="background:rgba(255,255,255,0.15);">
                                            <i class="fas fa-phone-alt text-white text-xs"></i>
                                        </div>
                                        <span class="text-white/80 text-[13px] font-semibold">{{ $support->phone ?? '+880 1234 567 890' }}</span>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0" style="background:rgba(255,255,255,0.15);">
                                            <i class="fas fa-map-marker-alt text-white text-xs"></i>
                                        </div>
                                        <span class="text-white/80 text-[13px] font-semibold">{{ $support->address ?? 'Gulshan-2, Dhaka, Bangladesh' }}</span>
                                    </div>
                                </div>
                                <!-- Glass card -->
                                <div class="rounded-[1.25rem] p-6 relative z-30"
                                     style="background:rgba(255,255,255,0.08); backdrop-filter:blur(14px); border:1px solid rgba(255,255,255,0.15);">
                                    <h4 class="text-white font-black text-lg tracking-tight mb-2">{{ $support->card_title ?? 'Dedicated Support Team' }}</h4>
                                    <p class="text-white/60 text-[13px] font-medium leading-relaxed mb-6">{{ $support->card_description ?? 'Our specialists handle every request with precision and care. You\'re in good hands.' }}</p>

                                    <!-- Dynamic Buttons -->
                                    <div x-data="{}" class="flex flex-wrap gap-3 relative z-40">
                                        @if($support->call_url)
                                        <a href="{{ trim($support->call_url) }}" 
                                           @click="if(window.innerWidth > 1024) { $event.preventDefault(); ensureSwal(() => Swal.fire({ title: '<span class=\'font-outfit font-black text-dark\'>Call from Phone</span>', html: '<p class=\'text-slate-500 font-medium\'>Please dial this number from your mobile device:<br><br><span class=\'text-2xl font-black text-primary\'>{{ $support->phone }}</span></p>', icon: 'info', confirmButtonText: 'Got it', confirmButtonColor: '#520C6B', customClass: { popup: 'rounded-[2rem]', confirmButton: 'rounded-xl font-bold uppercase tracking-widest text-xs px-8 py-3' } })) }"
                                           class="flex-1 flex items-center justify-center gap-2 bg-[#EF4444] text-white py-3 rounded-xl text-[11px] font-black tracking-widest uppercase hover:bg-red-600 transition-all shadow-lg shadow-red-500/20 cursor-pointer pointer-events-auto active:scale-95">
                                            <i class="fas fa-phone-alt"></i> Call Now
                                        </a>
                                        @endif
                                        @if($support->whatsapp_url)
                                        <a href="{{ trim($support->whatsapp_url) }}" class="flex-1 flex items-center justify-center gap-2 bg-[#22C55E] text-white py-3 rounded-xl text-[11px] font-black tracking-widest uppercase hover:bg-green-600 transition-all shadow-lg shadow-green-500/20 cursor-pointer pointer-events-auto active:scale-95">
                                            <i class="fab fa-whatsapp text-sm"></i> WhatsApp
                                        </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>



    <!-- Map/Location Section -->
    <section class="py-12 md:py-24 bg-[#f8fafc]">
        <div class="max-w-7xl mx-auto px-4 md:px-6">
            @if($map->title || $map->subtitle)
            <div class="text-center mb-8 md:mb-12">
                <h2 class="font-outfit text-2xl md:text-3xl font-black text-dark tracking-tight mb-3 uppercase">{{ $map->title }}</h2>
                <p class="text-slate-400 font-bold uppercase tracking-[0.2em] text-[10px]">{{ $map->subtitle }}</p>
            </div>
            @endif

            <div class="rounded-[2rem] md:rounded-[3.5rem] overflow-hidden grayscale contrast-125 h-[300px] md:h-[500px] relative shadow-premium border border-slate-200">
                @if($map->google_map_url)
                    <iframe
                        src="{{ $map->google_map_url }}"
                        width="100%"
                        height="100%"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                @else
                    <img src="{{ $map->map_image ?? 'https://images.unsplash.com/photo-1524661135-423995f22d0b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80' }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-primary/20 mix-blend-multiply"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="glass p-6 rounded-full flex items-center justify-center animate-pulse">
                            <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center text-white shadow-xl">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@section('scripts')
    @if(session('success'))
    <div x-data="{ open: true }" 
         x-show="open" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-90"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-90"
         class="fixed inset-0 z-[100] flex items-center justify-center px-4 py-6 pointer-events-none">
        
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-dark/60 backdrop-blur-sm pointer-events-auto" @click="open = false"></div>

        <!-- Modal Content -->
        <div class="relative w-full max-w-md bg-white rounded-[2rem] shadow-2xl pointer-events-auto overflow-hidden animate-fadeInUp">
            <!-- Top design element -->
            <div class="h-2 w-full bg-gradient-to-r from-[#520C6B] to-[#7c3aed]"></div>
            
            <div class="p-8 text-center">
                <!-- Success Icon -->
                <div class="w-20 h-20 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-6 border border-green-100">
                    <div class="w-14 h-14 bg-green-500 rounded-full flex items-center justify-center text-white shadow-lg shadow-green-200 animate-bounce">
                        <i class="fas fa-check text-2xl"></i>
                    </div>
                </div>

                <h3 class="font-outfit text-2xl font-black text-dark mb-3 tracking-tight">Success!</h3>
                <p class="text-slate-500 font-medium leading-relaxed mb-8">
                    {{ session('success') }}
                </p>

                <button @click="open = false" 
                        class="w-full py-4 rounded-xl font-black text-[13px] tracking-[0.18em] uppercase text-white transition-all duration-300 hover:shadow-lg active:scale-[0.98]"
                        style="background:#520C6B;">
                    Got It, Thanks!
                </button>
            </div>
        </div>
    </div>
    @endif
@endsection
@endsection
