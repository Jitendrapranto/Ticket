@extends('layouts.app')

@section('title', 'Application Pending - Ticket Kinun')

@section('content')
<div class="min-h-screen flex items-center justify-center py-20 px-4 bg-[#21032B] relative overflow-hidden" style="margin-top: -100px;">
    <!-- Background Decoration -->
    <div class="absolute inset-0 pointer-events-none opacity-20">
        <div class="absolute -top-32 -left-32 w-[500px] h-[500px] bg-[#520C6B] rounded-full blur-[180px]"></div>
        <div class="absolute -bottom-32 -right-32 w-[500px] h-[500px] bg-[#520C6B] rounded-full blur-[180px]"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[700px] bg-[#FFE700]/5 rounded-full blur-[250px]"></div>
    </div>

    <div class="relative z-10 max-w-lg w-full text-center space-y-8 animate-fadeInUp">
        <!-- Logo -->
        <a href="/" class="inline-block">
            <img src="{{ asset('Blue_Simple_Technology_Logo.png') }}" alt="Ticket Kinun" class="h-14 mx-auto brightness-0 invert">
        </a>

        <!-- Status Card -->
        <div class="bg-white/5 backdrop-blur border border-white/10 rounded-[2.5rem] p-10 shadow-2xl">
            <!-- Icon -->
            <div class="w-24 h-24 rounded-full bg-[#FFE700]/10 border-2 border-[#FFE700]/30 flex items-center justify-center mx-auto mb-8 relative">
                <i class="fas fa-clock text-[#FFE700] text-4xl"></i>
                <span class="absolute top-1 right-1 w-4 h-4 rounded-full bg-[#FFE700] animate-ping opacity-60"></span>
                <span class="absolute top-1 right-1 w-4 h-4 rounded-full bg-[#FFE700]"></span>
            </div>

            <h1 class="font-outfit text-3xl font-black text-white tracking-tight mb-3">
                Application <span class="text-[#FFE700]">Under Review</span>
            </h1>
            <p class="text-slate-400 font-medium leading-relaxed">
                Your organizer application has been submitted successfully. Our admin team is reviewing your details and will approve your account shortly.
            </p>

            <!-- Info Steps -->
            <div class="mt-8 space-y-4 text-left">
                <div class="flex items-start gap-4">
                    <div class="w-9 h-9 rounded-xl bg-[#FFE700]/10 border border-[#FFE700]/20 flex items-center justify-center shrink-0 mt-0.5">
                        <i class="fas fa-paper-plane text-[#FFE700] text-xs"></i>
                    </div>
                    <div>
                        <p class="text-white font-black text-sm">Application Submitted</p>
                        <p class="text-slate-500 text-xs font-medium mt-0.5">Your request has been received and is queued for review</p>
                    </div>
                    <i class="fas fa-check-circle text-green-400 text-sm mt-1 ml-auto shrink-0"></i>
                </div>

                <div class="flex items-start gap-4">
                    <div class="w-9 h-9 rounded-xl bg-[#FFE700]/10 border border-[#FFE700]/30 flex items-center justify-center shrink-0 mt-0.5">
                        <i class="fas fa-user-shield text-[#FFE700] text-xs animate-pulse"></i>
                    </div>
                    <div>
                        <p class="text-white font-black text-sm">Admin Review</p>
                        <p class="text-slate-500 text-xs font-medium mt-0.5">Our team is verifying your information</p>
                    </div>
                    <span class="flex items-center gap-1 ml-auto shrink-0">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#FFE700] animate-pulse"></span>
                        <span class="text-[#FFE700] text-[10px] font-black uppercase tracking-widest">Pending</span>
                    </span>
                </div>

                <div class="flex items-start gap-4 opacity-40">
                    <div class="w-9 h-9 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center shrink-0 mt-0.5">
                        <i class="fas fa-door-open text-white/50 text-xs"></i>
                    </div>
                    <div>
                        <p class="text-white font-black text-sm">Access Granted</p>
                        <p class="text-slate-500 text-xs font-medium mt-0.5">Full organizer dashboard access will be unlocked</p>
                    </div>
                </div>
            </div>

            @if(Auth::check())
            <!-- Applicant Info -->
            <div class="mt-8 bg-white/5 rounded-2xl p-4 border border-white/5 text-left">
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3">Your Application</p>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#21032B] to-[#520C6B] flex items-center justify-center shrink-0">
                        <span class="text-[#FFE700] font-black text-sm">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                    </div>
                    <div>
                        <p class="text-white font-black text-sm">{{ Auth::user()->name }}</p>
                        <p class="text-slate-400 text-xs font-medium">{{ Auth::user()->email }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Actions -->
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="/" class="flex-1 py-4 rounded-2xl bg-[#FFE700] text-[#21032B] font-black text-xs uppercase tracking-widest hover:bg-yellow-300 transition-all flex items-center justify-center gap-2">
                <i class="fas fa-home"></i> Go to Homepage
            </a>
            <form action="{{ route('organizer.logout') }}" method="POST" class="flex-1">
                @csrf
                <button type="submit" class="w-full py-4 rounded-2xl bg-white/5 border border-white/10 text-white/70 font-black text-xs uppercase tracking-widest hover:bg-white/10 transition-all flex items-center justify-center gap-2">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>

        <p class="text-slate-600 text-xs font-medium">
            Once approved, you can login at
            <a href="{{ route('organizer.login') }}" class="text-[#FFE700] font-black hover:underline">organizer login</a>
        </p>
    </div>
</div>

<style>
    body { background-color: #21032B !important; }
    header, footer { display: none !important; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fadeInUp { animation: fadeInUp 0.5s ease forwards; }
</style>
@endsection
