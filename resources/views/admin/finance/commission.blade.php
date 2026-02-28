<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commission Strategy | Ticket Kinun</title>
    <!-- Tailwind & Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#520C6B',
                        secondary: '#1B2B46',
                        accent: '#FF7D52',
                        dark: '#0F172A',
                        'brand-green': '#10B981',
                        'brand-red': '#EF4444',
                        'brand-amber': '#F59E0B',
                    },
                    fontFamily: {
                        outfit: ['Outfit', 'sans-serif'],
                        plus: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    boxShadow: {
                        'premium': '0 25px 60px -15px rgba(27, 43, 70, 0.08)',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-[#F8FAFC] text-slate-800 font-plus overflow-x-hidden">

    @include('admin.sidebar')

    <div class="lg:ml-72 min-h-screen flex flex-col transition-all duration-300">
        <!-- Topbar -->
        <header class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-10 sticky top-0 z-40">
            <div class="flex items-center gap-6">
                <button id="toggle-sidebar" class="lg:hidden w-10 h-10 flex items-center justify-center rounded-xl bg-slate-50 text-dark">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="relative w-80 group">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-primary transition-colors"></i>
                    <input type="text" placeholder="Search platform resources.." class="w-full bg-slate-50 border-none rounded-xl pl-12 pr-4 py-2.5 text-xs font-bold text-dark focus:ring-2 focus:ring-primary/10 transition-all">
                </div>
            </div>
            
            <div class="flex items-center gap-6">
                <button class="w-10 h-10 rounded-xl bg-slate-50 text-slate-400 flex items-center justify-center hover:bg-primary/5 hover:text-primary transition-all relative">
                    <i class="far fa-bell"></i>
                    <span class="absolute top-2.5 right-2.5 w-2 h-2 bg-brand-red rounded-full border-2 border-white"></span>
                </button>
                <div class="flex items-center gap-3 pl-6 border-l border-slate-100">
                    <div class="text-right">
                        <p class="text-xs font-black text-dark">Super Admin</p>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Administrator</p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-slate-200 border-2 border-white shadow-sm overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&q=80" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>
        </header>

        <main class="p-10 flex-1 max-w-7xl mx-auto w-full">
            <form action="{{ route('admin.finance.commission.update') }}" method="POST">
                @csrf
                <!-- Header -->
                <div class="flex items-center justify-between mb-10">
                    <div>
                        <h1 class="font-outfit text-3xl font-black text-dark tracking-tight mb-2">Commission Strategy</h1>
                        <p class="text-slate-400 font-medium text-sm">Define platform earning models and specific event-level overrides.</p>
                    </div>
                    <button type="submit" class="bg-secondary text-white px-8 py-4 rounded-2xl text-[11px] font-black uppercase tracking-widest hover:bg-dark transition-all flex items-center gap-3 shadow-xl shadow-secondary/20">
                        <i class="fas fa-save text-[13px]"></i> Save Configuration
                    </button>
                </div>

                <!-- Summary Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                    <!-- Revenue Model Badge -->
                    <div class="bg-white p-8 rounded-[2rem] border border-slate-50 shadow-premium flex items-start justify-between group hover:border-primary/20 transition-all">
                        <div>
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 block">Revenue Model</span>
                            <h3 class="font-outfit text-2xl font-black text-dark tracking-tight mb-1">
                                {{ ucfirst($setting->revenue_model) }}
                            </h3>
                            <p class="text-[10px] font-bold text-slate-400">Default active strategy</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center text-sm group-hover:bg-blue-500 group-hover:text-white transition-all">
                            <i class="fas fa-hand-holding-usd"></i>
                        </div>
                    </div>

                    <!-- Avg Earnings -->
                    <div class="bg-white p-8 rounded-[2rem] border border-slate-50 shadow-premium flex items-start justify-between group hover:border-brand-green/20 transition-all">
                        <div>
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 block">Default Percentage</span>
                            <h3 class="font-outfit text-2xl font-black text-dark tracking-tight mb-1">
                                {{ $setting->default_percentage }}%
                            </h3>
                            <p class="text-[10px] font-bold text-brand-green tracking-tight">Active platform fee</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-brand-green/5 text-brand-green flex items-center justify-center text-sm group-hover:bg-brand-green group-hover:text-white transition-all">
                            <i class="fas fa-percent"></i>
                        </div>
                    </div>

                    <!-- Overrides -->
                    <div class="bg-white p-8 rounded-[2rem] border border-slate-50 shadow-premium flex items-start justify-between group hover:border-accent/20 transition-all">
                        <div>
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 block">Active Overrides</span>
                            <h3 class="font-outfit text-2xl font-black text-dark tracking-tight mb-1">0 Rules</h3>
                            <p class="text-[10px] font-bold text-slate-400">Specific event/category settings</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-accent/5 text-accent flex items-center justify-center text-sm group-hover:bg-accent group-hover:text-white transition-all">
                            <i class="fas fa-bolt"></i>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                    <!-- Set Default Fees -->
                    <div class="lg:col-span-12 xl:col-span-4 space-y-8">
                        <div class="bg-white rounded-[2.5rem] border border-slate-50 shadow-premium overflow-hidden">
                            <div class="p-10 pb-0">
                                <h3 class="font-outfit text-xl font-black text-dark mb-2 tracking-tight">Global Default Fees</h3>
                                <p class="text-[11px] font-medium text-slate-400 leading-relaxed">Primary rates applied when no specific override exists across the board.</p>
                            </div>
                            
                            <div class="p-10 space-y-8">
                                <!-- Model Select -->
                                <div class="space-y-4">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Revenue Collection Model</label>
                                    <select name="revenue_model" class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-6 py-4 text-xs font-bold text-dark focus:ring-4 focus:ring-primary/5 focus:bg-white outline-none transition-all cursor-pointer">
                                        <option value="percentage" {{ $setting->revenue_model == 'percentage' ? 'selected' : '' }}>Percentage-based (%)</option>
                                        <option value="fixed" {{ $setting->revenue_model == 'fixed' ? 'selected' : '' }}>Fixed Amount ($)</option>
                                    </select>
                                </div>

                                <!-- Percentage Input -->
                                <div class="space-y-4">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">% Default Percentage</label>
                                    <div class="relative">
                                        <input type="number" step="0.01" name="default_percentage" value="{{ $setting->default_percentage }}"
                                            class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-6 py-4 text-xs font-bold text-dark focus:ring-4 focus:ring-primary/5 focus:bg-white transition-all outline-none">
                                        <div class="absolute right-6 top-1/2 -translate-y-1/2 text-[10px] font-black text-slate-300 uppercase tracking-widest">Percent</div>
                                    </div>
                                </div>

                                <!-- Toggle -->
                                <div class="pt-6 border-t border-slate-50 flex items-center justify-between">
                                    <div>
                                        <p class="text-xs font-black text-dark mb-1">Active Platform Fee</p>
                                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Toggle earning system globally.</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="is_active" value="1" {{ $setting->is_active ? 'checked' : '' }} class="sr-only peer">
                                        <div class="w-12 h-6 bg-slate-100 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-secondary border border-slate-200"></div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Pro Tip Card -->
                        <div class="bg-gradient-to-br from-primary/95 to-secondary rounded-[2.5rem] p-10 text-white relative overflow-hidden group shadow-2xl shadow-primary/20">
                            <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700"></div>
                            <div class="relative z-10">
                                <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-sm mb-6">
                                    <i class="fas fa-bolt"></i>
                                </div>
                                <h4 class="font-outfit text-lg font-black mb-3 tracking-tight">Pro-Tip: Flex Pricing</h4>
                                <p class="text-[11px] font-medium leading-[1.8] opacity-70">You can set different commission models for specific events. Free events are great for community growth and attracting new organizers!</p>
                            </div>
                        </div>
                    </div>

                    <!-- Overrides List -->
                    <div class="lg:col-span-12 xl:col-span-8 flex flex-col">
                        <div class="bg-white rounded-[2.5rem] border border-slate-50 shadow-premium overflow-hidden flex-1 h-fit">
                            <div class="p-10 flex items-center justify-between border-b border-slate-50">
                                <div>
                                    <h3 class="font-outfit text-xl font-black text-dark mb-1 tracking-tight">Event & Category Overrides</h3>
                                    <p class="text-[11px] font-medium text-slate-400">Custom rules for specific platform entities that override global settings.</p>
                                </div>
                                <button type="button" class="bg-slate-50 border border-slate-100 text-dark px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-100 transition-all flex items-center gap-3">
                                    <i class="fas fa-plus text-[9px]"></i> Add Event Override
                                </button>
                            </div>

                            <div class="p-0 overflow-x-auto no-scrollbar">
                                <table class="w-full text-left">
                                    <thead>
                                        <tr class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] bg-slate-50/30">
                                            <th class="px-10 py-6">Target Entity</th>
                                            <th class="px-8 py-6 text-center">Level</th>
                                            <th class="px-8 py-6 text-center">Custom Rule</th>
                                            <th class="px-10 py-6 text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-50">
                                        <tr class="group hover:bg-slate-50/50 transition-all">
                                            <td class="px-10 py-8">
                                                <div class="flex items-center gap-4">
                                                    <div class="w-10 h-10 rounded-xl bg-brand-green/5 text-brand-green flex items-center justify-center text-xs">
                                                        <i class="fas fa-university"></i>
                                                    </div>
                                                    <span class="text-xs font-black text-dark">School Programs</span>
                                                </div>
                                            </td>
                                            <td class="px-8 py-8 text-center">
                                                <span class="px-3 py-1 rounded-lg bg-slate-100 text-[9px] font-black text-slate-400 uppercase tracking-widest leading-none">Category</span>
                                            </td>
                                            <td class="px-8 py-8 text-center">
                                                <span class="px-4 py-1.5 rounded-full bg-brand-green/10 text-brand-green text-[9px] font-black uppercase tracking-wider">Free (0%)</span>
                                            </td>
                                            <td class="px-10 py-8 text-right">
                                                <button type="button" class="w-8 h-8 rounded-lg bg-slate-50 text-slate-300 flex items-center justify-center hover:bg-slate-100 transition-all"><i class="fas fa-ellipsis-h text-[10px]"></i></button>
                                            </td>
                                        </tr>
                                        <tr class="group hover:bg-slate-50/50 transition-all">
                                            <td class="px-10 py-8">
                                                <div class="flex items-center gap-4">
                                                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center text-xs">
                                                        <i class="fas fa-calendar-star"></i>
                                                    </div>
                                                    <span class="text-xs font-black text-dark">Tomorrowland 2024</span>
                                                </div>
                                            </td>
                                            <td class="px-8 py-8 text-center">
                                                <span class="px-3 py-1 rounded-lg bg-slate-100 text-[9px] font-black text-slate-400 uppercase tracking-widest leading-none">Event</span>
                                            </td>
                                            <td class="px-8 py-8 text-center">
                                                <span class="px-4 py-1.5 rounded-full bg-accent/10 text-accent text-[9px] font-black uppercase tracking-wider">Custom ($2.50)</span>
                                            </td>
                                            <td class="px-10 py-8 text-right">
                                                <button type="button" class="w-8 h-8 rounded-lg bg-slate-50 text-slate-300 flex items-center justify-center hover:bg-slate-100 transition-all"><i class="fas fa-ellipsis-h text-[10px]"></i></button>
                                            </td>
                                        </tr>
                                        <tr class="group hover:bg-slate-50/50 transition-all">
                                            <td class="px-10 py-8">
                                                <div class="flex items-center gap-4">
                                                    <div class="w-10 h-10 rounded-xl bg-orange-50 text-orange-500 flex items-center justify-center text-xs">
                                                        <i class="fas fa-users-crown"></i>
                                                    </div>
                                                    <span class="text-xs font-black text-dark">Non-Profit Galas</span>
                                                </div>
                                            </td>
                                            <td class="px-8 py-8 text-center">
                                                <span class="px-3 py-1 rounded-lg bg-slate-100 text-[9px] font-black text-slate-400 uppercase tracking-widest leading-none">Category</span>
                                            </td>
                                            <td class="px-8 py-8 text-center">
                                                <span class="px-4 py-1.5 rounded-full bg-brand-amber/10 text-brand-amber text-[9px] font-black uppercase tracking-wider">Reduced (2%)</span>
                                            </td>
                                            <td class="px-10 py-8 text-right">
                                                <button type="button" class="w-8 h-8 rounded-lg bg-slate-50 text-slate-300 flex items-center justify-center hover:bg-slate-100 transition-all"><i class="fas fa-ellipsis-h text-[10px]"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="p-10 bg-slate-50/30 flex items-center justify-center gap-3">
                                <i class="fas fa-info-circle text-[10px] text-slate-300"></i>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Event-level overrides always take precedence over global settings.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>

    <!-- Feedback Toasts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if(session('success'))
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                customClass: {
                    popup: 'rounded-2xl shadow-premium'
                }
            });
        @endif
    </script>

</body>
</html>
