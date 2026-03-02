<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>QR Scanner | Ticket Kinun</title>
    <!-- Tailwind & Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- html5-qrcode library -->
    <script src="https://unpkg.com/html5-qrcode"></script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#520C6B',     // Brand Purple
                        accent: '#FF7D52',      // Brand Orange
                        dark: '#0F172A',
                    },
                    fontFamily: {
                        outfit: ['Outfit', 'sans-serif'],
                        plus: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    boxShadow: {
                        'premium': '0 20px 50px -12px rgba(82, 12, 107, 0.25)',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-black text-white font-plus overflow-hidden h-screen flex flex-col">

    <!-- Header Overlay -->
    <div class="fixed top-0 left-0 w-full p-6 flex items-center justify-between z-50 bg-gradient-to-b from-black/80 to-transparent">
        <a href="{{ route('scanner.dashboard') }}" class="w-12 h-12 rounded-2xl bg-white/10 backdrop-blur-xl flex items-center justify-center text-white hover:bg-white/20 transition-all shadow-premium">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="text-center">
            <h1 class="font-outfit text-xl font-black tracking-tight leading-none">Smart Scanner</h1>
            <p class="text-[8px] font-black uppercase tracking-[0.3em] text-white/40 mt-1">Live QR Verification</p>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-emerald-500/20 backdrop-blur-xl flex items-center justify-center text-emerald-500 shadow-premium pulse-emerald">
            <i class="fas fa-sync-alt animate-spin-slow"></i>
        </div>
    </div>

    <!-- Scanner Viewport -->
    <div class="flex-grow flex items-center justify-center relative">
        <div id="reader" class="w-full h-full object-cover"></div>
        
        <!-- Framing Overlay -->
        <div class="absolute inset-0 pointer-events-none flex items-center justify-center">
            <div class="w-72 h-72 border-2 border-white/20 rounded-[3rem] relative shadow-[0_0_0_1000px_rgba(0,0,0,0.6)]">
                <!-- Bezel Corners -->
                <div class="absolute -top-1 -left-1 w-12 h-12 border-t-8 border-l-8 border-primary rounded-tl-3xl"></div>
                <div class="absolute -top-1 -right-1 w-12 h-12 border-t-8 border-r-8 border-primary rounded-tr-3xl"></div>
                <div class="absolute -bottom-1 -left-1 w-12 h-12 border-b-8 border-l-8 border-primary rounded-bl-3xl"></div>
                <div class="absolute -bottom-1 -right-1 w-12 h-12 border-b-8 border-r-8 border-primary rounded-br-3xl"></div>
                
                <!-- Scanning Line -->
                <div class="absolute top-0 left-0 w-full h-[2px] bg-gradient-to-r from-transparent via-primary to-transparent animate-scan"></div>
            </div>
        </div>
    </div>

    <!-- Result Modal (Self-handling via JS) -->
    <div id="resultModal" class="hidden fixed inset-0 z-[60] flex items-end sm:items-center justify-center p-6 bg-black/60 backdrop-blur-sm transition-all duration-300">
        <div class="bg-white text-dark w-full max-w-sm rounded-[3rem] p-10 transform translate-y-full transition-transform duration-500" id="modalContent">
            <!-- Dynamic Content Injected Here -->
        </div>
    </div>

    <style>
        @keyframes scan {
            0% { top: 10%; }
            100% { top: 90%; }
        }
        .animate-scan { animation: scan 2s ease-in-out infinite alternate; }
        .pulse-emerald { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4); animation: pulse 2s infinite; }
        @keyframes pulse { 70% { box-shadow: 0 0 0 20px rgba(16, 185, 129, 0); } 100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); } }
        #reader__scan_region video { object-fit: cover !important; height: 100vh !important; }
        #reader__dashboard { display: none !important; }
    </style>

    <script>
        const html5QrCode = new Html5Qrcode("reader");
        const modal = document.getElementById('resultModal');
        const modalContent = document.getElementById('modalContent');
        let isProcessing = false;

        const startScanner = () => {
             const qrConfig = { fps: 10, qrbox: { width: 300, height: 300 } };
             html5QrCode.start(
                { facingMode: "environment" }, 
                qrConfig, 
                onScanSuccess
            );
        };

        const onScanSuccess = (decodedText) => {
            if (isProcessing) return;
            isProcessing = true;
            
            // Visual feedback
            vibrate();
            
            fetch("{{ route('scanner.scan.process') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ ticket_number: decodedText })
            })
            .then(res => res.json())
            .then(data => showResult(data))
            .catch(err => {
                showResult({ status: 'error', message: 'Connection Error' });
            });
        };

        const vibrate = () => {
            if (window.navigator && window.navigator.vibrate) {
                window.navigator.vibrate([100, 50, 100]);
            }
        };

        const showResult = (data) => {
            let icon = 'fa-check-circle text-emerald-500';
            let bg = 'bg-emerald-50';
            
            if (data.status === 'error' || data.status === 'invalid') {
                icon = 'fa-times-circle text-rose-500';
                bg = 'bg-rose-50';
            } else if (data.status === 'already_scanned') {
                icon = 'fa-exclamation-triangle text-amber-500';
                bg = 'bg-amber-50';
            }

            let attendeeInfo = '';
            if (data.attendee) {
                attendeeInfo = `
                    <div class="mt-8 space-y-4 border-t border-slate-100 pt-8">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Pass Holder</p>
                            <p class="text-xl font-black text-dark tracking-tight leading-none">${data.attendee.name || 'Guest Participant'}</p>
                        </div>
                        <div class="flex items-center gap-8">
                            <div class="flex-grow">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Tier</p>
                                <p class="text-xs font-bold text-dark">${data.attendee.ticket_type?.name || 'N/A'}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Order Ref</p>
                                <p class="text-xs font-bold text-primary italic font-mono">${data.attendee.booking.booking_id}</p>
                            </div>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-2xl">
                             <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Associated Event</p>
                             <p class="text-xs font-bold text-dark truncate">${data.attendee.booking.event.title}</p>
                        </div>
                    </div>
                `;
            }

            modalContent.innerHTML = `
                <div class="flex flex-col items-center text-center">
                    <div class="w-24 h-24 rounded-[2rem] ${bg} flex items-center justify-center text-4xl mb-8">
                        <i class="fas ${icon}"></i>
                    </div>
                    <h2 class="font-outfit text-3xl font-black text-dark tracking-tighter mb-2 italic uppercase">${data.status.replace('_', ' ')}</h2>
                    <p class="text-sm font-bold text-slate-400">${data.message}</p>
                    ${attendeeInfo}
                    <button onclick="closeModal()" class="w-full mt-10 bg-dark text-white py-5 rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-primary transition-all shadow-premium">
                        Next Scan
                    </button>
                </div>
            `;

            modal.classList.remove('hidden');
            setTimeout(() => {
                modalContent.classList.remove('translate-y-full');
            }, 10);
        };

        const closeModal = () => {
            modalContent.classList.add('translate-y-full');
            setTimeout(() => {
                modal.classList.add('hidden');
                isProcessing = false;
            }, 300);
        };

        window.onload = startScanner;
    </script>
</body>
</html>
