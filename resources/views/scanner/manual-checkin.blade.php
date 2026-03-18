<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Manual Check-in | Ticket Kinun</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <!-- Critical Loader Styles (Inline for speed) -->
    <style>
        :root { color-scheme: light; }
        html, body { background-color: #F8FAFC !important; margin: 0; padding: 0; }
        #top-loader {
            position: fixed; top: 0; left: 0; width: 0%; height: 3px;
            background: linear-gradient(90deg, #520C6B, #FFE700);
            z-index: 10000; pointer-events: none; transition: width 0.1s ease-out;
        }
    </style>

    <!-- Optimized Asset Bundle -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="bg-[#F8FAFC] text-slate-800" x-data="{ sidebarOpen: false, ...checkinHandler() }">

    <!-- Mobile Backdrop -->
    <div x-show="sidebarOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false" 
         class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40 lg:hidden" 
         style="display: none;">
    </div>

    @include('scanner.sidebar')

    <div class="lg:ml-72 min-h-screen flex flex-col">
        <!-- Header -->
        <header class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-10 sticky top-0 z-40">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = true" class="lg:hidden text-dark w-10 h-10 flex items-center justify-center rounded-xl bg-slate-50 hover:bg-slate-100 transition-colors mr-2">
                    <i class="fas fa-bars"></i>
                </button>
                <a href="{{ route('scanner.dashboard') }}" class="text-dark hover:text-primary hidden sm:inline-block"><i class="fas fa-arrow-left"></i></a>
                <h1 class="font-outfit text-xl font-black text-dark tracking-tight">Manual Verification</h1>
            </div>

            <!-- Profile Dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" @click.away="open = false" class="flex items-center gap-4 hover:opacity-80 transition-opacity focus:outline-none">
                    <div class="text-right hidden sm:block">
                        <p class="text-xs font-black text-dark leading-none pb-1">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] font-bold text-primary uppercase tracking-widest leading-none">Authorized Scanner</p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-primary/10 border-2 border-white shadow-lg flex items-center justify-center overflow-hidden">
                        @if(Auth::user()->avatar)
                            <img loading="lazy" src="{{ asset('storage/'.Auth::user()->avatar) }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-primary text-sm font-black">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                        @endif
                    </div>
                    <i class="fas fa-chevron-down text-[10px] text-slate-400 transition-transform duration-300" :class="open ? 'rotate-180' : ''"></i>
                </button>

                <!-- Dropdown Menu -->
                <div x-show="open" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                     x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                     class="absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-premium border border-slate-100 overflow-hidden z-50"
                     style="display: none;">
                    
                    <div class="p-4 border-b border-slate-50 bg-slate-50/50">
                        <p class="text-xs font-black text-dark leading-none mb-1">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] font-bold text-slate-400 truncate">{{ Auth::user()->email }}</p>
                    </div>

                    <div class="p-2">
                        <a href="{{ route('profile') }}" class="flex items-center gap-3 px-4 py-3 text-xs font-bold text-slate-600 hover:text-primary hover:bg-primary/5 rounded-xl transition-all group">
                            <i class="fas fa-user-circle text-slate-400 group-hover:text-primary transition-colors"></i> My Profile
                        </a>
                        
                        <hr class="my-2 border-slate-50">
                        
                        <button onclick="event.preventDefault(); document.getElementById('logout-form-header').submit();" 
                                class="w-full flex items-center gap-3 px-4 py-3 text-xs font-bold text-rose-600 hover:bg-rose-50 rounded-xl transition-all">
                            <i class="fas fa-sign-out-alt"></i> Sign Out
                        </button>
                        
                        <form id="logout-form-header" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="p-10 max-w-2xl mx-auto w-full flex-grow">
            <div class="mb-12 text-center">
                <h2 class="font-outfit text-5xl font-black text-dark tracking-tighter mb-4">Ticket Entry</h2>
                <p class="text-slate-400 font-medium text-base">Enter the unique ticket serial number from the customer's pass printed or digital copy.</p>
            </div>

            <div class="bg-white rounded-[3rem] p-12 shadow-premium border border-white space-y-8">
                <div class="space-y-4">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Serial Number</label>
                    <div class="relative group">
                        <i class="fas fa-fingerprint absolute left-8 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-primary transition-colors text-xl"></i>
                        <input type="text" x-model="ticketNumber" @keyup.enter="processCheckin"
                            class="w-full bg-slate-50 border border-slate-100 rounded-3xl pl-16 pr-8 py-8 text-2xl font-black text-dark tracking-widest focus:ring-8 focus:ring-primary/5 focus:bg-white outline-none transition-all placeholder:text-slate-200 uppercase"
                            placeholder="TKT-XXXX-XXXX">
                    </div>
                </div>

                <button @click="processCheckin" :disabled="isLoading"
                    class="w-full bg-primary text-white py-8 rounded-3xl text-sm font-black uppercase tracking-[0.3em] hover:bg-secondary transition-all shadow-premium flex items-center justify-center gap-4 disabled:opacity-50">
                    <i class="fas fa-search" x-show="!isLoading"></i>
                    <i class="fas fa-spinner animate-spin" x-show="isLoading"></i>
                    <span x-text="isLoading ? 'Verifying...' : 'Validate Ticket'"></span>
                </button>
            </div>

            <!-- Result Feedback -->
            <div x-show="result" x-transition class="mt-8 animate-fadeInUp">
                <div :class="{
                    'bg-emerald-50 border-emerald-100 text-emerald-800': result?.status === 'success',
                    'bg-amber-50 border-amber-100 text-amber-800': result?.status === 'already_scanned',
                    'bg-rose-50 border-rose-100 text-rose-800': result?.status === 'error' || result?.status === 'invalid'
                }" class="rounded-[2.5rem] border p-12 shadow-soft">
                    <div class="flex items-start gap-8">
                        <div :class="{
                            'bg-emerald-100 text-emerald-600': result?.status === 'success',
                            'bg-amber-100 text-amber-600': result?.status === 'already_scanned',
                            'bg-rose-100 text-rose-600': result?.status === 'error' || result?.status === 'invalid'
                        }" class="w-20 h-20 rounded-[1.5rem] flex items-center justify-center text-3xl shrink-0">
                            <i class="fas" :class="{
                                'fa-check-circle': result?.status === 'success',
                                'fa-exclamation-triangle': result?.status === 'already_scanned',
                                'fa-times-circle': result?.status === 'error' || result?.status === 'invalid'
                            }"></i>
                        </div>
                        <div class="flex-grow">
                            <h3 class="font-outfit text-3xl font-black tracking-tighter mb-1 uppercase" x-text="getStatusTitle(result?.status)"></h3>
                            <p class="font-bold text-sm opacity-60 mb-8" x-text="result?.message"></p>

                            <template x-if="result?.attendee">
                                <div class="grid grid-cols-2 gap-8 pt-8 border-t border-black/5">
                                    <div>
                                        <p class="text-[10px] font-black uppercase tracking-widest opacity-40 mb-1">Pass Holder</p>
                                        <p class="text-xl font-black tracking-tight" x-text="result.attendee.name || 'Guest Participant'"></p>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-black uppercase tracking-widest opacity-40 mb-1">Ticket Tier</p>
                                        <p class="text-xl font-black tracking-tight" x-text="result.attendee.ticket_type?.name || 'N/A'"></p>
                                    </div>
                                    <div class="col-span-2">
                                        <p class="text-[10px] font-black uppercase tracking-widest opacity-40 mb-1">Event Name</p>
                                        <p class="text-lg font-bold tracking-tight bg-black/5 p-4 rounded-xl" x-text="result.attendee.booking?.event?.title || 'N/A'"></p>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        function checkinHandler() {
            return {
                ticketNumber: '',
                isLoading: false,
                result: null,
                getStatusTitle(status) {
                    const titles = {
                        'success': 'Valid Entry',
                        'already_scanned': 'Already Scanned',
                        'invalid': 'Invalid Ticket',
                        'error': 'Error'
                    };
                    return titles[status] || (status ? status.replace('_', ' ') : 'Unknown');
                },
                processCheckin() {
                    if(!this.ticketNumber || this.ticketNumber.trim() === '') return;
                    this.isLoading = true;
                    this.result = null;

                    fetch("{{ route('scanner.scan.process') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ ticket_number: this.ticketNumber.trim() })
                    })
                    .then(res => res.json())
                    .then(data => {
                        console.log('Server response:', data);
                        this.result = data;
                        this.isLoading = false;
                        if(data.status === 'success') this.ticketNumber = '';
                    })
                    .catch(err => {
                        console.error('Error:', err);
                        this.result = { status: 'error', message: 'Connection Error. Please try again.' };
                        this.isLoading = false;
                    });
                }
            }
        }
    </script>
</body>
</html>
