<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Profile | Ticket Kinun</title>
    <!-- Tailwind & Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-[#F1F5F9] font-plus text-slate-800">

    @include('admin.sidebar')

    <div class="lg:ml-72 min-h-screen flex flex-col">
        <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-100 flex items-center justify-between px-8 sticky top-0 z-40 shadow-sm">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.customers.index') }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-50 text-dark hover:bg-primary hover:text-white transition-all">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h2 class="font-outfit text-xl font-black text-dark tracking-tight">Profile Summary</h2>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Customer Insight & History</p>
                </div>
            </div>
        </header>

        <main class="p-8 flex-1 max-w-5xl mx-auto w-full">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Profile Identity -->
                <div class="md:col-span-1 space-y-8">
                    <div class="bg-white rounded-[2.5rem] p-8 shadow-premium border border-slate-50 text-center">
                        <div class="w-32 h-32 rounded-[2.5rem] bg-slate-50 border-8 border-white shadow-2xl mx-auto mb-6 flex items-center justify-center overflow-hidden">
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-4xl font-black text-primary">{{ substr($user->name, 0, 1) }}</span>
                            @endif
                        </div>
                        <h3 class="font-outfit text-2xl font-black text-dark tracking-tight">{{ $user->name }}</h3>
                        <p class="text-xs font-bold text-primary mb-4 italic">Registered Fan</p>
                        
                        <div class="flex items-center justify-center gap-3">
                            <span class="px-4 py-1.5 bg-green-50 text-green-600 text-[9px] font-black rounded-full border border-green-100 uppercase tracking-widest">Account Active</span>
                            <span class="px-4 py-1.5 bg-slate-50 text-slate-400 text-[9px] font-black rounded-full border border-slate-100 uppercase tracking-widest">Verified</span>
                        </div>
                    </div>

                    <div class="bg-white rounded-[2.5rem] p-8 shadow-premium border border-slate-50 space-y-6">
                        <h4 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Identity Details</h4>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Email</span>
                            <span class="text-xs font-black text-dark">{{ $user->email }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Joined At</span>
                            <span class="text-xs font-black text-dark">{{ $user->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Customer ID</span>
                            <span class="text-xs font-black text-dark">#{{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Booking Statistics/History Placeholder -->
                <div class="md:col-span-2 space-y-8">
                    <div class="grid grid-cols-2 gap-6">
                        <div class="bg-secondary rounded-3xl p-8 text-white relative overflow-hidden">
                            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-white/5 rounded-full flex items-center justify-center">
                                <i class="fas fa-ticket-alt text-4xl text-white/5"></i>
                            </div>
                            <p class="text-[10px] font-black tracking-widest text-white/30 uppercase mb-2">Total Bookings</p>
                            <h3 class="font-outfit text-4xl font-black tracking-tighter">03</h3>
                        </div>
                        <div class="bg-white rounded-3xl p-8 border border-slate-50 shadow-premium relative overflow-hidden group hover:bg-primary transition-all">
                            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center group-hover:bg-white/5">
                                <i class="fas fa-award text-4xl text-slate-200 group-hover:text-white/5"></i>
                            </div>
                            <p class="text-[10px] font-black tracking-widest text-slate-400 group-hover:text-white/30 uppercase mb-2">Loyalty Tier</p>
                            <h3 class="font-outfit text-4xl font-black text-dark group-hover:text-white tracking-tighter">Silver</h3>
                        </div>
                    </div>

                    <div class="bg-white rounded-[2.5rem] p-10 shadow-premium border border-slate-50 min-h-[400px]">
                        <div class="flex items-center justify-between mb-10">
                            <h3 class="font-outfit text-xl font-black text-dark tracking-tight">Recent Activity</h3>
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Latest 5 Transactions</span>
                        </div>
                        
                        <div class="flex flex-col items-center justify-center h-64 border-2 border-dashed border-slate-100 rounded-[2rem]">
                            <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-300 mb-4">
                                <i class="fas fa-history text-2xl"></i>
                            </div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Integrating Transaction History...</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
