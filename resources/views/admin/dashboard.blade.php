<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Dashboard | Ticket Kinun</title>
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
                        primary: '#520C6B',     // Brand Purple
                        secondary: '#21032B',   // Deep Plum
                        accent: '#FF7D52',      // Brand Orange
                        dark: '#0F172A',
                        'slate-custom': '#F8FAFC'
                    },
                    brand: '#520C6B',
                    fontFamily: {
                        outfit: ['Outfit', 'sans-serif'],
                        plus: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    boxShadow: {
                        'premium': '0 20px 50px -12px rgba(82, 12, 107, 0.15)',
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .glass-dark {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
    </style>
</head>
<body class="bg-[#F1F5F9] text-slate-800">

    <!-- Sidebar Inclusion -->
    @include('admin.sidebar')

    <!-- Main Content Wrapper -->
    <div class="lg:ml-72 min-h-screen flex flex-col">
        
        <!-- Header / Topbar -->
        <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-100 flex items-center justify-between px-8 sticky top-0 z-40 transition-all duration-300 shadow-sm">
            <div class="flex items-center gap-4">
                <!-- Mobile Toggle -->
                <button id="toggle-sidebar" class="lg:hidden w-10 h-10 flex items-center justify-center rounded-xl bg-slate-50 text-dark">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="hidden md:block">
                    <h2 class="font-outfit text-xl font-black text-dark tracking-tight">System Overview</h2>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Feb 26, 2026 • 12:45 AM</p>
                </div>
            </div>

            <!-- Header Actions -->
            <div class="flex items-center gap-4">
                <div class="hidden sm:flex items-center relative group">
                    <i class="fas fa-search absolute left-4 text-slate-400 text-xs"></i>
                    <input type="text" placeholder="Quick Search..." class="bg-slate-50 border border-slate-100 rounded-2xl pl-10 pr-6 py-2.5 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all w-64">
                </div>
                
                <button class="relative w-11 h-11 flex items-center justify-center rounded-2xl bg-slate-50 text-slate-500 hover:bg-primary/5 transition-colors">
                    <i class="far fa-bell"></i>
                    <span class="absolute top-3 right-3 w-2 h-2 bg-red-500 border-2 border-white rounded-full"></span>
                </button>
                
                <div class="flex items-center gap-3 pl-4 border-l border-slate-100 ml-2" x-data="{ open: false }">
                    <div class="relative">
                        <button @click="open = !open" @click.away="open = false" class="flex items-center gap-3 group focus:outline-none">
                            <div class="text-right hidden sm:block">
                                <p class="text-xs font-black text-dark group-hover:text-primary transition-colors">Super Admin</p>
                                <p class="text-[10px] font-bold text-primary italic uppercase tracking-tighter">Master Control</p>
                            </div>
                            <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-primary to-primary-dark p-0.5 shadow-premium group-hover:scale-105 transition-transform">
                                <div class="w-full h-full rounded-[14px] bg-white flex items-center justify-center overflow-hidden">
                                     <i class="fas fa-crown text-primary text-xs"></i>
                                </div>
                            </div>
                        </button>

                        <!-- Admin Action Dropdown -->
                        <div x-show="open" 
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                            x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                            class="absolute right-0 mt-3 w-56 bg-white rounded-3xl shadow-2xl border border-slate-100 py-3 z-50 overflow-hidden"
                            style="display: none;">
                            
                            <div class="px-6 py-4 border-b border-slate-50 mb-2">
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Authenticated As</p>
                                <p class="text-xs font-bold text-dark truncate">{{ Auth::user()->email }}</p>
                            </div>

                            <a href="/" target="_blank" class="flex items-center gap-4 px-6 py-3 text-slate-600 hover:text-primary hover:bg-primary/5 transition-all group">
                                <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center group-hover:bg-white shadow-sm transition-all text-xs"><i class="fas fa-external-link-alt"></i></div>
                                <span class="text-[11px] font-black uppercase tracking-wider">Live Site</span>
                            </a>

                            <div class="mt-2 pt-2 border-t border-slate-50">
                                <form action="{{ route('admin.logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-4 px-6 py-3 text-red-500 hover:bg-red-50 transition-all group">
                                        <div class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center group-hover:bg-white shadow-sm transition-all text-red-400 text-xs"><i class="fas fa-power-off"></i></div>
                                        <span class="text-[11px] font-black uppercase tracking-wider">Logout Portal</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Dashboard Content -->
        <main class="p-8 flex-1">
            
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-10">
                <!-- Total Sales -->
                <div class="bg-white p-8 rounded-[2.5rem] shadow-premium border border-slate-50 group hover:-translate-y-2 transition-all duration-500">
                    <div class="flex items-start justify-between mb-8">
                        <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 transition-all group-hover:bg-blue-600 group-hover:text-white">
                            <i class="fas fa-chart-line text-xl"></i>
                        </div>
                        <span class="px-3 py-1 bg-green-50 text-green-600 text-[10px] font-black rounded-full">+12%</span>
                    </div>
                    <p class="text-[10px] font-black tracking-widest text-slate-400 uppercase mb-2">Total Revenue</p>
                    <h3 class="font-outfit text-3xl font-black text-dark tracking-tighter">$142,500.00</h3>
                </div>

                <!-- Active Tickets -->
                <div class="bg-white p-8 rounded-[2.5rem] shadow-premium border border-slate-50 group hover:-translate-y-2 transition-all duration-500">
                    <div class="flex items-start justify-between mb-8">
                        <div class="w-14 h-14 bg-purple-50 rounded-2xl flex items-center justify-center text-primary transition-all group-hover:bg-primary group-hover:text-white">
                            <i class="fas fa-ticket-alt text-xl"></i>
                        </div>
                        <span class="px-3 py-1 bg-blue-50 text-blue-600 text-[10px] font-black rounded-full">LIVE</span>
                    </div>
                    <p class="text-[10px] font-black tracking-widest text-slate-400 uppercase mb-2">Active Bookings</p>
                    <h3 class="font-outfit text-3xl font-black text-dark tracking-tighter">8,432</h3>
                </div>

                <!-- Total Events -->
                <div class="bg-white p-8 rounded-[2.5rem] shadow-premium border border-slate-50 group hover:-translate-y-2 transition-all duration-500">
                    <div class="flex items-start justify-between mb-8">
                        <div class="w-14 h-14 bg-orange-50 rounded-2xl flex items-center justify-center text-orange-600 transition-all group-hover:bg-orange-600 group-hover:text-white">
                            <i class="fas fa-calendar-check text-xl"></i>
                        </div>
                        <span class="px-3 py-1 bg-orange-50 text-orange-600 text-[10px] font-black rounded-full">ALL TIME</span>
                    </div>
                    <p class="text-[10px] font-black tracking-widest text-slate-400 uppercase mb-2">Upcoming Events</p>
                    <h3 class="font-outfit text-3xl font-black text-dark tracking-tighter">154</h3>
                </div>

                <!-- New Users -->
                <div class="bg-white p-8 rounded-[2.5rem] shadow-premium border border-slate-50 group hover:-translate-y-2 transition-all duration-500">
                    <div class="flex items-start justify-between mb-8">
                        <div class="w-14 h-14 bg-teal-50 rounded-2xl flex items-center justify-center text-teal-600 transition-all group-hover:bg-teal-600 group-hover:text-white">
                            <i class="fas fa-users-cog text-xl"></i>
                        </div>
                        <span class="px-3 py-1 bg-red-50 text-red-600 text-[10px] font-black rounded-full">URGENT</span>
                    </div>
                    <p class="text-[10px] font-black tracking-widest text-slate-400 uppercase mb-2">Pending Inquiries</p>
                    <h3 class="font-outfit text-3xl font-black text-dark tracking-tighter">24</h3>
                </div>
            </div>

            <!-- Grid Layout for Tables & Details -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Recent Sales Table -->
                <div class="lg:col-span-2 bg-white rounded-[3rem] shadow-premium border border-slate-50 overflow-hidden">
                    <div class="p-8 border-b border-slate-50 flex items-center justify-between bg-slate-50/50">
                        <h3 class="font-outfit text-xl font-black text-dark tracking-tight">Recent Transactions</h3>
                        <a href="#" class="text-[10px] font-black text-primary tracking-widest uppercase hover:underline">View All Activities</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="bg-slate-50/20 text-[10px] font-black tracking-widest text-slate-400 uppercase border-b border-slate-50">
                                    <th class="px-8 py-5">Event</th>
                                    <th class="px-8 py-5">User</th>
                                    <th class="px-8 py-5">Amount</th>
                                    <th class="px-8 py-5">Status</th>
                                    <th class="px-8 py-5">Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50 font-medium text-sm">
                                <tr>
                                    <td class="px-8 py-6 font-bold text-dark">Rock Revolution 2026</td>
                                    <td class="px-8 py-6 text-slate-500">rahim_khan@email.com</td>
                                    <td class="px-8 py-6 font-black text-primary">$120.00</td>
                                    <td class="px-8 py-6">
                                        <span class="px-3 py-1 bg-green-100 text-green-700 text-[10px] font-black rounded-lg">PAID</span>
                                    </td>
                                    <td class="px-8 py-6 text-[10px] font-bold text-slate-400">10 MIN AGO</td>
                                </tr>
                                <tr>
                                    <td class="px-8 py-6 font-bold text-dark">Annual Iftar Meet</td>
                                    <td class="px-8 py-6 text-slate-500">sara_ahmed@email.com</td>
                                    <td class="px-8 py-6 font-black text-primary">$45.00</td>
                                    <td class="px-8 py-6">
                                        <span class="px-3 py-1 bg-green-100 text-green-700 text-[10px] font-black rounded-lg">PAID</span>
                                    </td>
                                    <td class="px-8 py-6 text-[10px] font-bold text-slate-400">25 MIN AGO</td>
                                </tr>
                                <tr>
                                    <td class="px-8 py-6 font-bold text-dark">Stadium Symphony</td>
                                    <td class="px-8 py-6 text-slate-500">tanvir_bd@email.com</td>
                                    <td class="px-8 py-6 font-black text-primary">$85.00</td>
                                    <td class="px-8 py-6">
                                        <span class="px-3 py-1 bg-orange-100 text-orange-700 text-[10px] font-black rounded-lg">PENDING</span>
                                    </td>
                                    <td class="px-8 py-6 text-[10px] font-bold text-slate-400">1 HOUR AGO</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Recent Events Sidebar -->
                <div class="bg-[#21032B] rounded-[3rem] p-10 text-white relative overflow-hidden flex flex-col justify-between">
                    <div class="relative z-10">
                        <span class="text-primary-light font-black tracking-[0.3em] text-[10px] uppercase mb-12 block">Live Monitoring</span>
                        <h3 class="font-outfit text-4xl font-black tracking-tighter mb-10 leading-none">The <br><span class="text-accent tracking-normal">Pulse</span> of Events.</h3>
                        
                        <div class="space-y-6">
                            <div class="flex items-center gap-4 bg-white/5 p-5 rounded-3xl border border-white/5">
                                <div class="w-10 h-10 rounded-full bg-green-500/20 flex items-center justify-center animate-pulse">
                                    <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                </div>
                                <div>
                                    <p class="text-xs font-black">Rock Revolution</p>
                                    <p class="text-[10px] text-white/40">12k Users Online</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 bg-white/5 p-5 rounded-3xl border border-white/5">
                                <div class="w-10 h-10 rounded-full bg-blue-500/20 flex items-center justify-center animate-pulse">
                                    <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                                </div>
                                <div>
                                    <p class="text-xs font-black">Sports Gala 2026</p>
                                    <p class="text-[10px] text-white/40">5.4k Active Sales</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Decorative Background Icon -->
                    <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/5 rounded-full flex items-center justify-center group-hover:rotate-12 transition-transform duration-700">
                        <i class="fas fa-satellite-dish text-[80px] text-white/[0.03]"></i>
                    </div>
                    
                    <a href="#" class="relative z-10 mt-12 w-full py-5 glass rounded-2xl text-center font-black text-xs tracking-widest hover:bg-white hover:text-primary transition-all uppercase">
                        Real-time Analytics
                    </a>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="p-8 text-center text-[10px] font-black text-slate-400 tracking-widest uppercase border-t border-slate-100 bg-white">
            Ticket Kinun • Alpha Control System V4.0.2 • © 2026
        </footer>
    </div>

    <!-- Mobile Sidebar Interaction Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('admin-sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const toggleBtn = document.getElementById('toggle-sidebar');

            function toggleMenu() {
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
                setTimeout(() => {
                    overlay.classList.toggle('opacity-0');
                }, 10);
            }

            if (toggleBtn) {
                toggleBtn.addEventListener('click', toggleMenu);
            }
            if (overlay) {
                overlay.addEventListener('click', toggleMenu);
            }
        });
    </script>
</body>
</html>
