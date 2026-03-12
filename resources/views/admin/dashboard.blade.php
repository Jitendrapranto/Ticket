<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Dashboard | Ticket Kinun</title>
    <!-- Prevent FOUC -->
    <style>
        html { visibility: hidden; opacity: 0; }
        html.ready { visibility: visible; opacity: 1; transition: opacity 0.15s ease-in; }
    </style>
    <!-- Tailwind & Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#520C6B',     // Brand Purple
                        secondary: '#1B2B46',   // Deep Plum
                        accent: '#2563EB',      // Vibrant Blue
                        vibrant: '#F1556C',     // Pinkish Red (from Book Now)
                        dark: '#0F172A',
                        'slate-custom': '#F8FAFC'
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        outfit: ['Inter', 'sans-serif'],
                    },
                    brand: '#520C6B',
                    boxShadow: {
                        'premium': '0 20px 50px -12px rgba(82, 12, 107, 0.15)',
                        'vibrant': '0 15px 30px -5px rgba(241, 85, 108, 0.3)',
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');
        body { font-family: 'Inter', sans-serif !important; font-style: normal !important; }
        * { font-style: normal !important; }
        *:not(i):not([class*="fa"]) { font-family: 'Inter', sans-serif !important; }
        .fas, .far, .fab, .fa-solid, .fa-regular, .fa-brands { font-family: "Font Awesome 6 Free", "Font Awesome 6 Brands" !important; }
        i, em, q, dfn { font-style: normal !important; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .glass-header {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.documentElement.classList.add('ready');
        });
        setTimeout(function() { document.documentElement.classList.add('ready'); }, 100);
    </script>
</head>
<body class="bg-[#F1F5F9] text-slate-800 antialiased">

    <!-- Sidebar Inclusion -->
    @include('admin.sidebar')

    <!-- Main Content Wrapper -->
    <div class="lg:ml-72 min-h-screen flex flex-col transition-all duration-300">

        <!-- Header / Topbar -->
        <header class="h-20 glass-header border-b border-white/50 flex items-center justify-between px-8 sticky top-0 z-40 shadow-sm">
            <div class="flex items-center gap-6">
                <!-- Mobile Toggle -->
                <button id="toggle-sidebar" class="lg:hidden w-11 h-11 flex items-center justify-center rounded-2xl bg-white shadow-sm border border-slate-100 text-dark hover:bg-slate-50 transition-all">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="hidden md:block">
                    <h2 class="text-xl font-black text-dark tracking-tight">System Control <span class="text-primary">Center</span></h2>
                    <p class="text-[9px] text-slate-400 font-black uppercase tracking-[0.2em]">{{ date('M d, Y • h:i A') }}</p>
                </div>
            </div>

            <!-- Header Actions -->
            <div class="flex items-center gap-6">
                <div class="hidden lg:flex items-center relative">
                    <i class="fas fa-search absolute left-4 text-slate-400 text-xs"></i>
                    <input type="text" placeholder="Search commands..." class="bg-slate-100/50 border border-slate-200 rounded-2xl pl-10 pr-6 py-2.5 text-xs font-bold focus:outline-none focus:ring-2 focus:ring-primary/10 transition-all w-72">
                </div>

                <div class="flex items-center gap-3">
                    <button class="relative w-11 h-11 flex items-center justify-center rounded-2xl bg-white border border-slate-100 text-slate-500 hover:text-primary transition-all shadow-sm">
                        <i class="far fa-bell"></i>
                        <span class="absolute top-3 right-3 w-2 h-2 bg-vibrant border-2 border-white rounded-full"></span>
                    </button>

                    <div class="flex items-center gap-3 pl-6 border-l border-slate-100 ml-2" x-data="{ open: false }">
                        <div class="relative">
                            <button @click="open = !open" @click.away="open = false" class="flex items-center gap-4 group focus:outline-none">
                                <div class="text-right hidden sm:block">
                                    <p class="text-xs font-black text-dark group-hover:text-primary transition-colors">Super Admin</p>
                                    <p class="text-[9px] font-black text-primary uppercase tracking-widest">Master Portal</p>
                                </div>
                                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-primary to-secondary p-0.5 shadow-premium group-hover:scale-105 transition-transform">
                                    <div class="w-full h-full rounded-[14px] bg-white flex items-center justify-center overflow-hidden">
                                        @if(Auth::user()->avatar)
                                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-full h-full object-cover">
                                        @else
                                            <i class="fas fa-crown text-primary text-xs"></i>
                                        @endif
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
                                class="absolute right-0 mt-4 w-64 bg-white rounded-[2rem] shadow-2xl border border-slate-50 py-4 z-50 overflow-hidden"
                                style="display: none;">

                                <div class="px-8 py-5 border-b border-slate-50 mb-3 bg-slate-50/50">
                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Authenticated via SSL</p>
                                    <p class="text-[11px] font-black text-dark truncate">{{ Auth::user()->email }}</p>
                                </div>

                                <a href="{{ route('profile') }}" class="flex items-center gap-4 px-8 py-3.5 text-slate-600 hover:text-primary hover:bg-primary/5 transition-all group">
                                    <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center group-hover:bg-white shadow-sm transition-all text-xs"><i class="fas fa-user-edit"></i></div>
                                    <span class="text-[10px] font-black uppercase tracking-widest">Edit Profile</span>
                                </a>

                                <a href="/" target="_blank" class="flex items-center gap-4 px-8 py-3.5 text-slate-600 hover:text-primary hover:bg-primary/5 transition-all group">
                                    <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center group-hover:bg-white shadow-sm transition-all text-xs"><i class="fas fa-external-link-alt"></i></div>
                                    <span class="text-[10px] font-black uppercase tracking-widest">Visit Front End</span>
                                </a>

                                <div class="mt-3 pt-3 border-t border-slate-50 px-4">
                                    <form action="{{ route('admin.logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center gap-4 px-6 py-4 bg-vibrant/5 text-vibrant hover:bg-vibrant hover:text-white rounded-[1.5rem] transition-all group">
                                            <div class="w-10 h-10 rounded-xl bg-vibrant/10 flex items-center justify-center group-hover:bg-white/20 shadow-sm transition-all text-vibrant group-hover:text-white text-xs"><i class="fas fa-power-off"></i></div>
                                            <span class="text-[10px] font-black uppercase tracking-widest">Secure Logout</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Main Content Wrapper -->
        <main class="p-8 md:p-12 flex-1 overflow-hidden h-[calc(100vh-5rem)]">
            @yield('admin_content')
        </main>
    </div>

    <!-- SweetAlert Success/Error Handler -->
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        @if(session('success'))
            Toast.fire({
                icon: 'success',
                title: '{{ session('success') }}',
                background: '#ffffff',
                color: '#1e293b',
                className: 'rounded-3xl shadow-2xl border border-slate-100 font-sans'
            });
        @endif

        @if(session('error'))
            Toast.fire({
                icon: 'error',
                title: '{{ session('error') }}',
                background: '#ffffff',
                color: '#1e293b',
                className: 'rounded-3xl shadow-2xl border border-slate-100 font-sans'
            });
        @endif
    </script>

    <!-- Sidebar Interaction Script -->
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

            if (toggleBtn) toggleBtn.addEventListener('click', toggleMenu);
            if (overlay) overlay.addEventListener('click', toggleMenu);
        });
    </script>
    @stack('scripts')
</body>
</html>
