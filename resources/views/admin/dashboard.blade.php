<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Dashboard | Ticket Kinun</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <!-- Critical Loader Styles (Inline for speed) -->
    <style>
        :root { color-scheme: light; }
        html, body { background-color: #F1F5F9 !important; margin: 0; padding: 0; }
        #top-loader {
            position: fixed; top: 0; left: 0; width: 0%; height: 3px;
            background: linear-gradient(90deg, #520C6B, #FFE700);
            z-index: 10000; pointer-events: none; transition: width 0.1s ease-out;
        }
        [x-cloak] { display: none !important; }
    </style>

    <!-- Optimized Asset Bundle -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
@php
    $isAuthPage = Request::routeIs('admin.login*');
@endphp

<body class="bg-[#F1F5F9] text-slate-800 antialiased" x-data="{ sidebarOpen: false }">

    @if(!$isAuthPage)
    <!-- Sidebar Inclusion -->
    @include('admin.sidebar')
    @endif

    <!-- Main Content Wrapper -->
    <div id="swup-container" class="swup-transition-fade {{ $isAuthPage ? 'min-h-screen flex flex-col items-center justify-center p-6' : 'lg:ml-72 min-h-screen flex flex-col transition-all duration-300' }}">

        @if(!$isAuthPage)
        <!-- Header / Topbar -->
        <header class="h-20 glass-header border-b border-white/50 flex items-center justify-between px-8 z-40 shadow-sm w-full sticky top-0">
            <div class="flex items-center gap-6">
                <!-- Mobile Toggle -->
                <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden w-11 h-11 flex items-center justify-center rounded-xl bg-white shadow-sm border border-slate-100 text-dark hover:bg-slate-50 transition-all">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="hidden md:block">
                    <h2 class="text-xl font-black text-dark tracking-tight">System Control <span class="text-primary">Center</span></h2>
                    <p class="text-[9px] text-slate-400 font-black uppercase tracking-[0.2em]">{{ date('M d, Y • h:i A') }}</p>
                </div>
            </div>

            <!-- Header Actions -->
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-3">
                @auth
                    @include('admin.partials.profile_dropdown')
                @endauth
                </div>
            </div>
        </header>
        @endif

        <!-- Main Content Wrapper -->
        <main class="{{ $isAuthPage ? 'w-full flex items-center justify-center relative' : 'p-8 md:p-12 flex-1 relative' }}">
            @yield('admin_content')
            @include('admin.partials.toasts')
        </main>

        @stack('scripts')
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
    </script>

    <!-- Global Helper Scripts -->
    <script>
        function confirmDelete(formId, message = 'Are you sure you want to delete this?') {
            Swal.fire({
                title: 'Are you sure?',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#520C6B',
                cancelButtonColor: '#F1556C',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                background: '#ffffff',
                color: '#1e293b',
                borderRadius: '2rem',
                customClass: {
                    popup: 'rounded-[2rem] border border-slate-100 shadow-2xl',
                    confirmButton: 'rounded-xl px-8 py-4 font-black tracking-widest uppercase text-xs shadow-lg',
                    cancelButton: 'rounded-xl px-8 py-4 font-black tracking-widest uppercase text-xs shadow-lg'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById(formId);
                    if (form) form.submit();
                }
            });
        }
    </script>
</body>
</html>
