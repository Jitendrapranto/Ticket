@extends('layouts.app')

@section('title', 'About Us - Redefining the Event Experience | Ticket Kinun')

@section('content')
    <!-- Hero Section -->
    <section class="relative pt-12 pb-24 bg-gradient-to-r from-[#520C6B] to-[#21032B] overflow-hidden min-h-[450px] flex items-center">
        <!-- Abstract Background Glows -->
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-primary/10 rounded-full blur-[120px] -translate-y-1/2 translate-x-1/4"></div>
        <div class="absolute bottom-0 left-0 w-[300px] h-[300px] bg-accent/5 rounded-full blur-[100px] translate-y-1/2 -translate-x-1/4"></div>

        <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
            <div class="inline-block px-4 py-1.5 rounded-full glass mb-6">
                <span class="text-accent font-black text-[10px] tracking-[0.2em] uppercase">OUR STORY</span>
            </div>
            
            <h1 class="font-outfit text-6xl md:text-8xl font-black text-white leading-tight mb-6 tracking-tighter">
                Redefining The <br><span class="text-accent tracking-normal">Experience.</span>
            </h1>
            <p class="text-slate-400 text-lg md:text-xl mb-12 max-w-2xl mx-auto font-light leading-relaxed">
                Ticket Kinun is more than a ticketing platform. We are the bridge between fans and their favorite memories, built with advanced technology and a passion for culture.
            </p>
        </div>
    </section>

    <!-- Mission & Statistics -->
    <section class="py-24 bg-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center mb-32">
                <div class="animate-fadeInUp text-left">
                    <span class="text-primary font-black tracking-[0.3em] text-[10px] uppercase mb-4 block">WHO WE ARE</span>
                    <h2 class="font-outfit text-5xl font-black text-dark mb-8 tracking-tighter leading-tight">Elevating Every Event, One Ticket At A Time.</h2>
                    <p class="text-slate-400 text-lg font-light leading-relaxed mb-8">
                        Founded in 2024, Ticket Kinun set out with a simple goal: to eliminate the friction between discovery and excitement. We've built a digital-first ecosystem that prioritizes security, speed, and the sheer joy of the live experience.
                    </p>
                    <div class="grid grid-cols-2 gap-8">
                        <div>
                            <span class="block font-black text-4xl text-dark mb-1 tracking-tighter">2.5M+</span>
                            <span class="text-slate-400 text-xs font-bold tracking-widest uppercase">Global Fans</span>
                        </div>
                        <div>
                            <span class="block font-black text-4xl text-dark mb-1 tracking-tighter">15k+</span>
                            <span class="text-slate-400 text-xs font-bold tracking-widest uppercase">Premier Events</span>
                        </div>
                    </div>
                </div>
                <div class="relative animate-fadeInUp" style="animation-delay: 0.2s">
                    <div class="rounded-[3rem] overflow-hidden shadow-premium aspect-[4/5] relative group">
                        <img src="https://images.unsplash.com/photo-1492684223066-81342ee5ff30?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="Concert scene" class="w-full h-full object-cover grayscale-[0.2] group-hover:grayscale-0 transition-all duration-700">
                        <div class="absolute inset-x-8 bottom-8 glass p-8 rounded-[2rem]">
                            <p class="text-dark font-black text-xl leading-tight">"The energy of the crowd is our greatest inspiration."</p>
                        </div>
                    </div>
                    <!-- Decorative shapes -->
                    <div class="absolute -top-10 -right-10 w-32 h-32 bg-primary/5 rounded-full blur-2xl"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Values - Bento Grid -->
    <section class="py-32 bg-[#f8fafc]">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-left mb-20 max-w-2xl px-4">
                <span class="text-primary font-black tracking-widest text-[10px] uppercase mb-4 block">OUR CORE VALUES</span>
                <h2 class="font-outfit text-5xl font-black text-dark leading-[1.1] tracking-tighter mb-4">Built On Trust, Driven By Passion</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 h-auto lg:h-[600px]">
                <div class="md:col-span-4 bg-white p-12 rounded-[2.5rem] shadow-premium border border-slate-50 bento-card flex flex-col justify-between group">
                    <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-all duration-500 mb-8">
                        <i class="fas fa-shield-alt text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="font-black text-2xl text-dark mb-4 tracking-tight">Security First</h3>
                        <p class="text-slate-400 font-medium leading-relaxed">
                            Every transaction is encrypted with industry-leading technology to ensure your peace of mind.
                        </p>
                    </div>
                </div>

                <div class="md:col-span-8 bg-dark p-12 rounded-[2.5rem] bento-card flex flex-col justify-between group overflow-hidden relative">
                    <div class="relative z-10 w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center text-white mb-8">
                        <i class="fas fa-bolt text-2xl"></i>
                    </div>
                    <div class="relative z-10 max-w-sm">
                        <h3 class="font-black text-3xl text-white mb-4 tracking-tighter">Zero-Wait Philosophy</h3>
                        <p class="text-white/40 font-medium leading-relaxed">
                            Our platform is optimized for speed. From search to booking, we've eliminated every unnecessary click.
                        </p>
                    </div>
                    <!-- Decorative Background Icon -->
                    <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-white/5 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-700">
                        <i class="fas fa-tachometer-alt text-[150px] text-white/[0.03]"></i>
                    </div>
                </div>

                <div class="md:col-span-7 bg-primary p-12 rounded-[2.5rem] bento-card text-white flex flex-col justify-between group">
                    <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center text-white mb-8">
                        <i class="fas fa-heart text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="font-black text-3xl mb-4 tracking-tighter">Community Centered</h3>
                        <p class="text-white/60 font-medium leading-relaxed">
                            We listen to our fans. Every update we ship is inspired by the needs and desires of our global community.
                        </p>
                    </div>
                </div>

                <div class="md:col-span-5 bg-white p-12 rounded-[2.5rem] shadow-premium border border-slate-50 bento-card flex flex-col justify-between group">
                    <div class="w-16 h-16 bg-accent/10 rounded-2xl flex items-center justify-center text-accent group-hover:bg-accent group-hover:text-white transition-all duration-500 mb-8">
                        <i class="fas fa-seedling text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="font-black text-2xl text-dark mb-4 tracking-tight">Constant Innovation</h3>
                        <p class="text-slate-400 font-medium leading-relaxed">
                            The tech world never stops, and neither do we. We're constantly exploring AI and web3 integrations.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Partner Shoutout -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <span class="text-slate-300 font-black tracking-[0.4em] text-[9px] uppercase mb-12 block">TRUSTED BY GLOBAL LEADERS</span>
            <div class="flex flex-wrap justify-center items-center gap-16 opacity-30 grayscale hover:grayscale-0 transition-all duration-700">
                <i class="fab fa-apple text-5xl"></i>
                <i class="fab fa-spotify text-5xl"></i>
                <i class="fab fa-nike text-5xl"></i>
                <i class="fab fa-amazon text-5xl"></i>
                <i class="fab fa-playstation text-5xl"></i>
            </div>
        </div>
    </section>

    <!-- Final CTA -->
    <section class="py-40 relative bg-dark overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1540575861501-7ad05823123d?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80')] bg-cover bg-center opacity-10 grayscale scale-110"></div>
        <div class="max-w-5xl mx-auto px-6 text-center relative z-10 animate-fadeInUp">
            <h2 class="font-outfit text-6xl md:text-8xl font-black text-white leading-[0.8] mb-12 tracking-tighter">Join The <br><span class="text-primary tracking-normal">Revolution.</span></h2>
            <p class="text-xl text-white/40 mb-16 max-w-2xl mx-auto font-light">Whether you're a fan searching for magic or a creator ready to build it, we have a place for you.</p>
            
            <div class="flex flex-col sm:flex-row justify-center gap-6">
                <a href="{{ route('events') }}" class="bg-white text-dark px-16 py-6 rounded-3xl font-black text-lg hover:bg-primary hover:text-white transition-all transform hover:-rotate-2 hover:scale-105 shadow-2xl">DISCOVER EVENTS</a>
                <a href="#" class="glass text-white px-16 py-6 rounded-3xl font-black text-lg hover:bg-white hover:text-dark transition-all">BE A PARTNER</a>
            </div>
        </div>
    </section>
@endsection
