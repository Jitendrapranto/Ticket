@extends('layouts.app')

@section('title', 'Contact Us - We Are Here To Help | Ticket Kinun')

@section('content')
    <!-- Hero Section -->
    <section class="relative pt-12 pb-24 bg-gradient-to-r from-[#520C6B] to-[#21032B] overflow-hidden min-h-[450px] flex items-center">
        <!-- Abstract Background Glows -->
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-primary/10 rounded-full blur-[120px] -translate-y-1/2 translate-x-1/4"></div>
        <div class="absolute bottom-0 left-0 w-[300px] h-[300px] bg-accent/5 rounded-full blur-[100px] translate-y-1/2 -translate-x-1/4"></div>

        <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
            <div class="inline-block px-4 py-1.5 rounded-full glass mb-6">
                <span class="text-accent font-black text-[10px] tracking-[0.2em] uppercase">CONTACT CENTER</span>
            </div>
            
            <h1 class="font-outfit text-6xl md:text-8xl font-black text-white leading-tight mb-6 tracking-tighter">
                Get In <br><span class="text-accent tracking-normal">Touch.</span>
            </h1>
            <p class="text-slate-400 text-lg md:text-xl mb-12 max-w-2xl mx-auto font-light leading-relaxed">
                Have a question or need assistance with your booking? Our dedicated support team is available 24/7 to ensure your experience is flawless.
            </p>
        </div>
    </section>

    <!-- Contact Info Cards -->
    <section class="py-24 bg-white relative z-20 -mt-20">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-24">
                <div class="bg-white p-10 rounded-[2.5rem] shadow-premium border border-slate-50 text-center group hover:shadow-2xl transition-all duration-500 animate-fadeInUp">
                    <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-all duration-500 mx-auto mb-8">
                        <i class="fas fa-envelope text-2xl"></i>
                    </div>
                    <h3 class="font-black text-xl text-dark mb-4 tracking-tight">Email Support</h3>
                    <p class="text-slate-400 font-medium mb-6">Response within 2 hours</p>
                    <a href="mailto:support@ticketkinun.com" class="text-primary font-black text-sm tracking-widest hover:underline uppercase">support@ticketkinun.com</a>
                </div>

                <div class="bg-dark p-10 rounded-[2.5rem] text-center group hover:shadow-2xl transition-all duration-500 animate-fadeInUp" style="animation-delay: 0.1s">
                    <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center text-white mx-auto mb-8">
                        <i class="fas fa-phone-alt text-2xl"></i>
                    </div>
                    <h3 class="font-black text-xl text-white mb-4 tracking-tight">Call Us</h3>
                    <p class="text-white/40 font-medium mb-6">24/7 Priority Hotline</p>
                    <a href="tel:+8801234567890" class="text-accent font-black text-sm tracking-widest hover:underline uppercase">+880 1234 567 890</a>
                </div>

                <div class="bg-white p-10 rounded-[2.5rem] shadow-premium border border-slate-50 text-center group hover:shadow-2xl transition-all duration-500 animate-fadeInUp" style="animation-delay: 0.2s">
                    <div class="w-16 h-16 bg-accent/10 rounded-2xl flex items-center justify-center text-accent group-hover:bg-accent group-hover:text-white transition-all duration-500 mx-auto mb-8">
                        <i class="fas fa-map-marker-alt text-2xl"></i>
                    </div>
                    <h3 class="font-black text-xl text-dark mb-4 tracking-tight">Our Office</h3>
                    <p class="text-slate-400 font-medium mb-6">Gulshan-2, Dhaka</p>
                    <a href="#" class="text-primary font-black text-sm tracking-widest hover:underline uppercase">Get Directions</a>
                </div>
            </div>

            <!-- Contact Form & Visual -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-stretch">
                <div class="animate-fadeInUp">
                    <div class="max-w-md mb-12">
                        <span class="text-primary font-black tracking-[0.3em] text-[10px] uppercase mb-4 block">SEND A MESSAGE</span>
                        <h2 class="font-outfit text-5xl font-black text-dark mb-6 tracking-tighter leading-tight">Drop Us A Line.</h2>
                        <p class="text-slate-400 text-lg font-light leading-relaxed">
                            Have something specific in mind? Fill out the form and our department leads will get back to you personally.
                        </p>
                    </div>

                    <form action="#" class="space-y-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 tracking-widest uppercase ml-4">Full Name</label>
                                <input type="text" placeholder="John Doe" class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-5 px-8 outline-none focus:border-primary/50 focus:bg-white transition-all text-dark font-medium">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 tracking-widest uppercase ml-4">Email Address</label>
                                <input type="email" placeholder="john@example.com" class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-5 px-8 outline-none focus:border-primary/50 focus:bg-white transition-all text-dark font-medium">
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 tracking-widest uppercase ml-4">Subject</label>
                            <select class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-5 px-8 outline-none focus:border-primary/50 focus:bg-white transition-all text-dark font-medium appearance-none">
                                <option>General Inquiry</option>
                                <option>Ticket Issue</option>
                                <option>Partnership</option>
                                <option>Feedback</option>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 tracking-widest uppercase ml-4">Your Message</label>
                            <textarea rows="5" placeholder="How can we help you today?" class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-5 px-8 outline-none focus:border-primary/50 focus:bg-white transition-all text-dark font-medium resize-none"></textarea>
                        </div>
                        <button type="submit" class="w-full bg-dark text-white py-6 rounded-2xl font-black text-sm tracking-[0.2em] hover:bg-primary transition-all shadow-xl shadow-dark/10 group">
                            SEND MESSAGE <i class="fas fa-paper-plane ml-3 group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform"></i>
                        </button>
                    </form>
                </div>

                <div class="relative animate-fadeInUp hidden lg:block" style="animation-delay: 0.2s">
                    <div class="h-full rounded-[3.5rem] overflow-hidden relative group">
                        <img src="https://images.unsplash.com/photo-1534536281715-e28d76689b4d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="Support representative" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-dark/80 via-transparent to-transparent"></div>
                        <div class="absolute bottom-12 left-12 right-12">
                            <div class="glass p-10 rounded-[2.5rem]">
                                <h4 class="text-white font-black text-2xl tracking-tighter mb-4">Dedicated Support Team</h4>
                                <p class="text-white/60 font-medium">Our specialists are trained to handle every request with precision and care. You're in good hands.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map/Location Section -->
    <section class="py-24 bg-[#f8fafc]">
        <div class="max-w-7xl mx-auto px-6">
            <div class="rounded-[3.5rem] overflow-hidden grayscale contrast-125 h-[500px] relative shadow-premium">
                <!-- Placeholder for map - using a stylized image -->
                <img src="https://images.unsplash.com/photo-1524661135-423995f22d0b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-primary/20 mix-blend-multiply"></div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="glass p-6 rounded-full flex items-center justify-center animate-pulse">
                        <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center text-white shadow-xl">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
