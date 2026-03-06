<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Profile | Organizer Insights</title>
    <!-- Prevent FOUC: Hide body until styles are ready -->
    <style>
        html { visibility: hidden; opacity: 0; }
        html.ready { visibility: visible; opacity: 1; transition: opacity 0.15s ease-in; }
    </style>
    <!-- Tailwind & Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#520C6B',
                        secondary: '#21032B',
                        accent: '#FF7D52',
                        dark: '#0F172A',
                    },
                    fontFamily: {
                        outfit: ['Arial', 'Helvetica', 'sans-serif'],
                        plus: ['Arial', 'Helvetica', 'sans-serif'],
                    },
                    boxShadow: {
                        'premium': '0 25px 50px -12px rgba(82, 12, 107, 0.08)',
                        'soft': '0 4px 15px -5px rgba(0, 0, 0, 0.05)',
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: Arial, Helvetica, sans-serif; background: #F8FAFC; }
    </style>
    <!-- Reveal page once Tailwind is ready -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.documentElement.classList.add('ready');
        });
        setTimeout(function() { document.documentElement.classList.add('ready'); }, 100);
    </script>
</head>
<body class="text-slate-800">

    @include('organizer.sidebar')

    <div class="lg:ml-72 min-h-screen flex flex-col">
        <!-- Topbar -->
        <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-100 flex items-center justify-between px-10 sticky top-0 z-50">
            <div class="flex items-center gap-4">
                <a href="{{ route('organizer.customers.index') }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-50 text-dark hover:bg-primary hover:text-white transition-all">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div class="flex flex-col">
                    <h2 class="font-outfit text-xl font-black text-dark tracking-tight leading-none mb-1">Customer Insight</h2>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-[0.2em]">Detailed Attendee Profile</p>
                </div>
            </div>
        </header>

        <main class="p-10 flex-1 max-w-[1600px] mx-auto w-full">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                <!-- Left: Profile Identity -->
                <div class="lg:col-span-4 space-y-10">
                    <div class="bg-white rounded-[3rem] p-10 shadow-premium border border-white text-center transition-transform hover:scale-[1.02]">
                        <div class="relative inline-block mb-8">
                            <div class="w-36 h-36 rounded-[2.5rem] bg-gradient-to-br from-slate-50 to-slate-100 border-8 border-white shadow-2xl mx-auto flex items-center justify-center overflow-hidden">
                                <span class="text-5xl font-black text-primary/40">{{ substr($user->name, 0, 1) }}</span>
                            </div>
                            <div class="absolute -bottom-2 -right-2 w-10 h-10 rounded-2xl bg-brand-green border-4 border-white flex items-center justify-center text-white shadow-lg">
                                <i class="fas fa-check text-sm"></i>
                            </div>
                        </div>
                        <h3 class="font-outfit text-3xl font-black text-dark tracking-tight mb-2">{{ $user->name }}</h3>
                        <p class="text-[10px] font-black text-primary uppercase tracking-[0.3em] mb-6">Confirmed Attendee</p>

                        <div class="flex items-center justify-center gap-2">
                            <span class="px-5 py-2 bg-slate-50 text-slate-400 text-[9px] font-black rounded-xl border border-slate-100 uppercase tracking-[0.1em]">Joined {{ $user->created_at->format('M Y') }}</span>
                        </div>
                    </div>

                    <div class="bg-white rounded-[3rem] p-10 shadow-premium border border-white space-y-8">
                        <h4 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.3em] mb-4">Contact Metadata</h4>

                        <div class="flex flex-col gap-6">
                            <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50/50 border border-slate-100">
                                <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-primary shadow-sm">
                                    <i class="far fa-envelope"></i>
                                </div>
                                <div>
                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Email Address</p>
                                    <p class="text-xs font-black text-dark">{{ $user->email }}</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50/50 border border-slate-100">
                                <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-accent shadow-sm">
                                    <i class="fas fa-mobile-alt"></i>
                                </div>
                                <div>
                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Mobile Contact</p>
                                    <p class="text-xs font-black text-dark">+880 1XXX-XXXXXX</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50/50 border border-slate-100">
                                <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-emerald-400 shadow-sm">
                                    <i class="far fa-calendar-alt"></i>
                                </div>
                                <div>
                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">First Interaction</p>
                                    <p class="text-xs font-black text-dark">{{ $user->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Stats & Booking History -->
                <div class="lg:col-span-8 space-y-10">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                        <div class="bg-dark rounded-[2.5rem] p-10 text-white relative overflow-hidden group">
                            <i class="fas fa-ticket-alt absolute -right-6 -bottom-6 text-9xl text-white/5 transform rotate-12 group-hover:scale-110 transition-transform"></i>
                            <div class="relative z-10">
                                <p class="text-[10px] font-black tracking-[0.2em] text-white/30 uppercase mb-4">Personal Reach</p>
                                <h3 class="font-outfit text-5xl font-black tracking-tighter mb-2">{{ $bookings->count() }}</h3>
                                <p class="text-[11px] font-bold text-white/40 uppercase tracking-widest">Confirmed Events with You</p>
                            </div>
                        </div>

                        <div class="bg-white rounded-[2.5rem] p-10 shadow-premium border border-white relative overflow-hidden group">
                            <i class="fas fa-star absolute -right-6 -bottom-6 text-9xl text-primary/5 transform -rotate-12 group-hover:scale-110 transition-transform"></i>
                            <div class="relative z-10">
                                <p class="text-[10px] font-black tracking-[0.2em] text-slate-400 uppercase mb-4">Retention Index</p>
                                <h3 class="font-outfit text-5xl font-black text-dark tracking-tighter mb-2">
                                    @if($bookings->count() > 3) Platinum @elseif($bookings->count() > 1) Gold @else Base @endif
                                </h3>
                                <p class="text-[11px] font-bold text-slate-300 uppercase tracking-widest">Audience Segment</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-[3rem] p-12 shadow-premium border border-white min-h-[500px]">
                        <div class="flex items-center justify-between mb-12">
                            <h3 class="font-outfit text-2xl font-black text-dark tracking-tight">Booking History with You</h3>
                            <div class="flex items-center gap-3">
                                <span class="w-2 h-2 rounded-full bg-brand-green animate-pulse"></span>
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest font-plus">Synced Ledger</span>
                            </div>
                        </div>

                        <div class="space-y-6">
                            @forelse($bookings as $booking)
                            <div class="flex items-center justify-between p-6 rounded-3xl bg-slate-50/50 border border-slate-100 hover:bg-white hover:shadow-soft transition-all group">
                                <div class="flex items-center gap-6">
                                    <div class="w-14 h-14 rounded-2xl bg-white border border-slate-100 flex items-center justify-center text-primary text-xl shadow-sm">
                                        <i class="fas fa-calendar-check"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-dark group-hover:text-primary transition-colors">{{ $booking->event->title ?? 'Deleted Event' }}</p>
                                        <p class="text-[10px] font-bold text-slate-400 mt-1 uppercase tracking-widest">Order #{{ $booking->booking_id }} • {{ $booking->created_at->format('M d') }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-black text-dark tracking-tight">৳{{ number_format($booking->total_amount, 2) }}</p>
                                    <span class="text-[9px] font-black uppercase tracking-widest text-brand-green bg-brand-green/10 px-3 py-1 rounded-lg border border-brand-green/20 mt-1 inline-block">{{ $booking->status }}</span>
                                </div>
                            </div>
                            @empty
                            <div class="flex flex-col items-center justify-center py-20 bg-slate-50/30 rounded-[2rem] border-2 border-dashed border-slate-100">
                                <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center text-slate-200 mb-6 shadow-sm">
                                    <i class="fas fa-receipt text-3xl"></i>
                                </div>
                                <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.3em]">No Transactions Found</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <footer class="p-10 text-center">
            <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.3em]">Audience Intelligence Ledger • Ticket Kinun</p>
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('toggle-sidebar');
            const sidebar = document.getElementById('organizer-sidebar');
            if(toggleBtn && sidebar) {
                toggleBtn.addEventListener('click', () => {
                    sidebar.classList.toggle('-translate-x-full');
                });
            }
        });
    </script>
</body>
</html>
