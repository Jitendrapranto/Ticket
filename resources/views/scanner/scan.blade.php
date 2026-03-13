<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>QR Scanner | Ticket Kinun</title>

    <!-- Prevent FOUC: Hide body until styles are ready -->
    <style>
        /* FAST LOAD */
        html.ready { visibility: visible; opacity: 1; transition: opacity 0.15s ease-in; }
    </style>

    <!-- Tailwind & Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- html5-qrcode library - use specific version -->
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
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
                        sans: ['Arial', 'Helvetica', 'sans-serif'],
                        outfit: ['Arial', 'Helvetica', 'sans-serif'],
                        plus: ['Arial', 'Helvetica', 'sans-serif'],
                    },
                    boxShadow: {
                        'premium': '0 20px 50px -12px rgba(82, 12, 107, 0.25)',
                    }
                }
            }
        }
    </script>

    <!-- Reveal page once Tailwind is ready -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.documentElement.classList.add('ready');
        });
        setTimeout(function() { document.documentElement.classList.add('ready'); }, 100);
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

        <!-- Start Camera Button (shown initially) -->
        <div id="startCameraOverlay" class="absolute inset-0 flex flex-col items-center justify-center bg-black z-20">
            <div class="text-center p-8">
                <div class="w-20 h-20 rounded-full bg-primary/20 flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-camera text-3xl text-primary"></i>
                </div>
                <h2 class="text-xl font-black text-white mb-2">Start Scanner</h2>
                <p class="text-white/50 mb-6 text-sm max-w-xs">Tap the button below to activate the camera and start scanning QR codes.</p>
                <button id="startCameraBtn" class="px-8 py-4 bg-primary text-white rounded-2xl font-black text-sm uppercase tracking-wider hover:bg-primary/80 transition-all shadow-premium">
                    <i class="fas fa-video mr-2"></i> Enable Camera
                </button>
                <p id="cameraError" class="text-rose-400 text-sm mt-4 hidden"></p>
            </div>
        </div>

        <!-- Loading State -->
        <div id="loadingOverlay" class="absolute inset-0 flex flex-col items-center justify-center bg-black z-20 hidden">
            <div class="text-center">
                <i class="fas fa-spinner fa-spin text-4xl text-primary mb-4"></i>
                <p class="text-white/60 text-sm">Starting camera...</p>
            </div>
        </div>

        <!-- Framing Overlay -->
        <div id="framingOverlay" class="absolute inset-0 pointer-events-none flex items-center justify-center hidden">
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
        #reader video { 
            object-fit: cover !important; 
            width: 100% !important;
            height: 100% !important; 
        }
        #reader__dashboard { display: none !important; }
        #reader__dashboard_section { display: none !important; }
        #reader__dashboard_section_csr { display: none !important; }
    </style>

    <script>
        let html5QrCode = null;
        const modal = document.getElementById('resultModal');
        const modalContent = document.getElementById('modalContent');
        const startCameraOverlay = document.getElementById('startCameraOverlay');
        const loadingOverlay = document.getElementById('loadingOverlay');
        const framingOverlay = document.getElementById('framingOverlay');
        const startCameraBtn = document.getElementById('startCameraBtn');
        const cameraError = document.getElementById('cameraError');
        let isProcessing = false;

        const startScanner = async () => {
            try {
                // Show loading
                startCameraOverlay.classList.add('hidden');
                loadingOverlay.classList.remove('hidden');
                cameraError.classList.add('hidden');

                // Initialize scanner
                html5QrCode = new Html5Qrcode("reader");

                const qrConfig = { 
                    fps: 10, 
                    qrbox: { width: 280, height: 280 },
                    aspectRatio: 1.0,
                    disableFlip: false
                };

                await html5QrCode.start(
                    { facingMode: "environment" },
                    qrConfig,
                    onScanSuccess,
                    onScanFailure
                );

                // Camera started successfully
                loadingOverlay.classList.add('hidden');
                framingOverlay.classList.remove('hidden');
                console.log('Camera started successfully');

            } catch (err) {
                console.error('Camera start error:', err);
                loadingOverlay.classList.add('hidden');
                startCameraOverlay.classList.remove('hidden');
                cameraError.textContent = 'Error: ' + (err.message || 'Unable to access camera. Please check permissions.');
                cameraError.classList.remove('hidden');
            }
        };

        const onScanSuccess = (decodedText, decodedResult) => {
            if (isProcessing) return;
            isProcessing = true;

            console.log('QR Code scanned:', decodedText);

            // Visual feedback
            vibrate();
            playBeep();

            fetch("{{ route('scanner.scan.process') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ ticket_number: decodedText })
            })
            .then(res => res.json())
            .then(data => {
                console.log('Server response:', data);
                showResult(data);
            })
            .catch(err => {
                console.error('Fetch error:', err);
                showResult({ status: 'error', message: 'Connection Error. Please try again.' });
            });
        };

        const onScanFailure = (error) => {
            // Silent - this is called continuously when no QR is found
        };

        const vibrate = () => {
            if (window.navigator && window.navigator.vibrate) {
                window.navigator.vibrate([100, 50, 100]);
            }
        };

        const playBeep = () => {
            try {
                const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
                const oscillator = audioCtx.createOscillator();
                const gainNode = audioCtx.createGain();
                oscillator.connect(gainNode);
                gainNode.connect(audioCtx.destination);
                oscillator.frequency.value = 1200;
                oscillator.type = 'sine';
                gainNode.gain.setValueAtTime(0.3, audioCtx.currentTime);
                oscillator.start(audioCtx.currentTime);
                oscillator.stop(audioCtx.currentTime + 0.15);
            } catch(e) {
                console.log('Audio not available');
            }
        };

        const showResult = (data) => {
            let icon = 'fa-check-circle text-emerald-500';
            let bg = 'bg-emerald-50';
            let statusTitle = 'Success';

            if (data.status === 'error' || data.status === 'invalid') {
                icon = 'fa-times-circle text-rose-500';
                bg = 'bg-rose-50';
                statusTitle = data.status === 'invalid' ? 'Invalid' : 'Error';
            } else if (data.status === 'already_scanned') {
                icon = 'fa-exclamation-triangle text-amber-500';
                bg = 'bg-amber-50';
                statusTitle = 'Already Scanned';
            } else if (data.status === 'success') {
                statusTitle = 'Valid Entry';
            }

            let attendeeInfo = '';
            if (data.attendee) {
                const attendee = data.attendee;
                const ticketTypeName = attendee.ticket_type?.name || 'N/A';
                const bookingId = attendee.booking?.booking_id || 'N/A';
                const eventTitle = attendee.booking?.event?.title || 'N/A';
                const guestName = attendee.name || 'Guest Participant';

                attendeeInfo = `
                    <div class="mt-8 space-y-4 border-t border-slate-100 pt-8">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Pass Holder</p>
                            <p class="text-xl font-black text-dark tracking-tight leading-none">${guestName}</p>
                        </div>
                        <div class="flex items-center gap-8">
                            <div class="flex-grow">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Tier</p>
                                <p class="text-xs font-bold text-dark">${ticketTypeName}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Order Ref</p>
                                <p class="text-xs font-bold text-primary font-mono">${bookingId}</p>
                            </div>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-2xl">
                             <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Associated Event</p>
                             <p class="text-xs font-bold text-dark truncate">${eventTitle}</p>
                        </div>
                    </div>
                `;
            }

            modalContent.innerHTML = `
                <div class="flex flex-col items-center text-center">
                    <div class="w-24 h-24 rounded-[2rem] ${bg} flex items-center justify-center text-4xl mb-8">
                        <i class="fas ${icon}"></i>
                    </div>
                    <h2 class="font-outfit text-3xl font-black text-dark tracking-tighter mb-2 uppercase">${statusTitle}</h2>
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

        // Event listener for start button
        startCameraBtn.addEventListener('click', startScanner);

        // Do NOT auto-start - require user interaction for camera permissions
    </script>
</body>
</html>
