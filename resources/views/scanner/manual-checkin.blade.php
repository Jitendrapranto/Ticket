<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Manual Check-in | Ticket Kinun</title>
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
                        dark: '#0F172A',
                    },
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
</head>
<body class="bg-[#F8FAFC] text-slate-800" x-data="checkinHandler()">

    @include('scanner.sidebar')

    <div class="lg:ml-72 min-h-screen flex flex-col">
        <!-- Header -->
        <header class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-10 sticky top-0 z-40">
            <div class="flex items-center gap-4">
                <a href="{{ route('scanner.dashboard') }}" class="text-dark hover:text-primary"><i class="fas fa-arrow-left"></i></a>
                <h1 class="font-outfit text-xl font-black text-dark tracking-tight">Manual Verification</h1>
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
                            <h3 class="font-outfit text-3xl font-black italic tracking-tighter mb-1 uppercase" x-text="result?.status.replace('_', ' ') "></h3>
                            <p class="font-bold text-sm opacity-60 mb-8" x-text="result?.message"></p>
                            
                            <template x-if="result?.attendee">
                                <div class="grid grid-cols-2 gap-8 pt-8 border-t border-black/5">
                                    <div>
                                        <p class="text-[10px] font-black uppercase tracking-widest opacity-40 mb-1">Pass Holder</p>
                                        <p class="text-xl font-black tracking-tight" x-text="result.attendee.name || 'Guest Participant'"></p>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-black uppercase tracking-widest opacity-40 mb-1">Ticket Tier</p>
                                        <p class="text-xl font-black tracking-tight italic" x-text="result.attendee.ticket_type?.name || 'N/A'"></p>
                                    </div>
                                    <div class="col-span-2">
                                        <p class="text-[10px] font-black uppercase tracking-widest opacity-40 mb-1">Event Name</p>
                                        <p class="text-lg font-bold tracking-tight bg-black/5 p-4 rounded-xl" x-text="result.attendee.booking.event.title"></p>
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
                processCheckin() {
                    if(!this.ticketNumber) return;
                    this.isLoading = true;
                    this.result = null;

                    fetch("{{ route('scanner.scan.process') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ ticket_number: this.ticketNumber })
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.result = data;
                        this.isLoading = false;
                        if(data.status === 'success') this.ticketNumber = '';
                    })
                    .catch(err => {
                        this.result = { status: 'error', message: 'Connection Error' };
                        this.isLoading = false;
                    });
                }
            }
        }
    </script>
</body>
</html>
