<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Segmentation | Ticket Kinun</title>
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
                        secondary: '#21032B',
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
                        'premium': '0 25px 60px -15px rgba(82, 12, 107, 0.08)',
                        'soft': '0 4px 20px -5px rgba(0, 0, 0, 0.05)',
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #F8FAFC; }
        .glass-card { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); }
    </style>
</head>
<body class="text-slate-800">

    @include('admin.sidebar')

    <div class="lg:ml-72 min-h-screen flex flex-col">
        <!-- Topbar -->
        <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-100 flex items-center justify-between px-10 sticky top-0 z-50">
            <div class="flex items-center gap-4">
                <button id="toggle-sidebar" class="lg:hidden w-10 h-10 flex items-center justify-center rounded-xl bg-slate-50 text-dark">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="flex flex-col">
                    <h2 class="font-outfit text-xl font-black text-dark tracking-tight leading-none mb-1">Customer Segmentation</h2>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-[0.2em]">Audience Intelligence Dashboard</p>
                </div>
            </div>
            
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-3 pl-6 border-l border-slate-100">
                    <div class="text-right">
                        <p class="text-xs font-black text-dark">Super Admin</p>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Administrator</p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-slate-200 border-2 border-white shadow-sm overflow-hidden transform rotate-3">
                        <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&q=80" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>
        </header>

        <main class="p-10 flex-1 max-w-[1600px] mx-auto w-full">
            <!-- Header Section -->
            <div class="flex items-center justify-between mb-12">
                <div class="max-w-xl">
                    <h1 class="font-outfit text-5xl font-black text-dark tracking-tighter mb-4">Targeted Analytics</h1>
                    <p class="text-slate-400 font-medium text-base leading-relaxed">Break down your event attendance by ticket categories, attendee behavior, and specific registration data to better understand your audience.</p>
                </div>
                <div>
                    <a href="{{ route('admin.customers.segmentation.export', request()->all()) }}" class="bg-secondary text-white px-10 py-5 rounded-[1.5rem] text-xs font-black uppercase tracking-widest hover:bg-black transition-all flex items-center gap-4 shadow-2xl shadow-secondary/20 group">
                        <i class="fas fa-cloud-download-alt text-[14px] group-hover:-translate-y-1 transition-transform"></i> 
                        <span>Download Segment Data</span>
                    </a>
                </div>
            </div>

            <!-- Smart Filter Engine -->
            <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-premium mb-12">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-10 h-10 rounded-xl bg-primary/5 text-primary flex items-center justify-center text-sm">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                    <h3 class="text-xs font-black text-dark uppercase tracking-[0.2em]">Refine Your Search</h3>
                </div>

                <form action="{{ route('admin.customers.segmentation') }}" method="GET" id="filterForm" x-data x-ref="filterForm" class="grid grid-cols-1 md:grid-cols-12 gap-6 items-center">
                    <!-- Event Select -->
                    <div class="md:col-span-4 group">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1 group-focus-within:text-primary transition-colors">By Event</label>
                        <select name="event_id" onchange="this.form.submit()" class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-6 py-4 text-xs font-bold text-dark focus:ring-4 focus:ring-primary/5 focus:bg-white outline-none transition-all appearance-none cursor-pointer">
                            <option value="">Search across all events</option>
                            @foreach($events as $event)
                                <option value="{{ $event->id }}" {{ request('event_id') == $event->id ? 'selected' : '' }}>
                                    {{ $event->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Ticket Type Select -->
                    <div class="md:col-span-3 group">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1 group-focus-within:text-primary transition-colors">By Tier</label>
                        <select name="ticket_type_id" onchange="this.form.submit()" class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-6 py-4 text-xs font-bold text-dark focus:ring-4 focus:ring-primary/5 focus:bg-white outline-none transition-all appearance-none cursor-pointer">
                            <option value="">Any ticket type</option>
                            @foreach($ticketTypes as $type)
                                <option value="{{ $type->id }}" {{ request('ticket_type_id') == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Search Input -->
                    <div class="md:col-span-5 group">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1 group-focus-within:text-primary transition-colors">Quick Lookup</label>
                        <div class="relative">
                            <i class="fas fa-search absolute left-6 top-1/2 -translate-y-1/2 text-slate-300"></i>
                            <input type="text" name="search" id="segSearch" value="{{ request('search') }}" 
                                @input.debounce.500ms="$refs.filterForm.submit()"
                                placeholder="Attendee name or contact mobile..." 
                                class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-14 pr-8 py-4 text-xs font-bold text-dark focus:ring-4 focus:ring-primary/5 focus:bg-white transition-all outline-none">
                        </div>
                    </div>
                </form>
            </div>

            <!-- Main Data View -->
            <div class="bg-white rounded-[3rem] shadow-premium border border-white overflow-hidden relative">
                <!-- Data Header -->
                <div class="p-12 pb-8 flex flex-col md:flex-row md:items-center justify-between gap-8 border-b border-slate-50">
                    <div class="flex items-center gap-6">
                        <div class="w-16 h-16 rounded-[1.5rem] bg-secondary flex items-center justify-center text-white text-2xl shadow-xl shadow-secondary/10">
                            <i class="fas fa-id-badge"></i>
                        </div>
                        <div>
                            <h3 class="font-outfit text-3xl font-black text-dark tracking-tight mb-1">
                                @if(request('event_id') && $events->find(request('event_id')))
                                    {{ $events->find(request('event_id'))->title }}
                                @else
                                    Global Segments
                                @endif
                            </h3>
                            <div class="flex items-center gap-3">
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.15em]">Total Registered Souls:</span>
                                <span class="bg-primary/5 text-primary text-[11px] font-black px-3 py-1 rounded-lg">{{ number_format($attendees->total()) }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-4">
                        <button class="bg-slate-50 text-slate-500 font-bold text-[10px] uppercase tracking-widest px-6 py-3 rounded-xl border border-slate-100 hover:bg-slate-100 transition-all">
                            Bulk Actions
                        </button>
                    </div>
                </div>

                <!-- Modern Table Layout -->
                <div class="overflow-x-auto no-scrollbar">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/30 text-[10px] font-black tracking-[0.2em] text-slate-400 uppercase">
                                <th class="px-12 py-6 font-black w-[30%]">Attendee Identity</th>
                                <th class="px-8 py-6 font-black w-[20%]">Assigned Event</th>
                                <th class="px-8 py-6 font-black w-[15%] text-center">Ticket Tier</th>
                                <th class="px-8 py-6 font-black w-[15%] text-center">Entry Status</th>
                                <th class="px-12 py-6 font-black w-[20%] text-right whitespace-nowrap">Timestamp & Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100/50">
                            @forelse($attendees as $attendee)
                            <tr class="hover:bg-slate-50/50 transition-all group">
                                <td class="px-12 py-8">
                                    <div class="flex items-center gap-5">
                                        <div class="relative">
                                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-slate-100 to-slate-200 border-2 border-white shadow-soft flex items-center justify-center overflow-hidden transition-transform group-hover:scale-110">
                                                @if($attendee->booking->user && $attendee->booking->user->profile_picture)
                                                    <img src="{{ asset('storage/' . $attendee->booking->user->profile_picture) }}" class="w-full h-full object-cover">
                                                @else
                                                    <span class="text-base font-black text-slate-400 uppercase">{{ substr($attendee->name ?: 'U', 0, 1) }}</span>
                                                @endif
                                            </div>
                                            <div class="absolute -bottom-1 -right-1 w-5 h-5 rounded-lg bg-white border border-slate-100 flex items-center justify-center shadow-sm">
                                                <i class="fas fa-check-circle text-[9px] text-brand-green"></i>
                                            </div>
                                        </div>
                                        <div class="space-y-1">
                                            <p class="text-[15px] font-black text-dark tracking-tight leading-none group-hover:text-primary transition-colors">
                                                {{ $attendee->name ?: 'Unnamed Attendee' }}
                                            </p>
                                            <div class="flex items-center gap-2 mt-1">
                                                <div class="px-2 py-0.5 rounded bg-slate-100 text-[9px] font-black text-slate-400 uppercase tracking-widest">Mobile</div>
                                                <span class="text-xs font-bold text-slate-500">{{ $attendee->mobile ?: 'N/A' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-8">
                                    <div class="space-y-1.5">
                                        <div class="flex items-center gap-2">
                                            <span class="w-1.5 h-1.5 rounded-full bg-primary/40"></span>
                                            <p class="text-xs font-black text-slate-700 leading-tight">
                                                {{ $attendee->booking->event->title ?? 'N/A' }}
                                            </p>
                                        </div>
                                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest ml-3">
                                            Event ID: #E-{{ str_pad($attendee->booking->event_id ?? 0, 4, '0', STR_PAD_LEFT) }}
                                        </p>
                                    </div>
                                </td>
                                <td class="px-8 py-8 text-center">
                                    <div class="inline-flex items-center gap-2.5 px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest border border-slate-100 bg-white shadow-soft text-slate-600 group-hover:border-primary/20 group-hover:text-primary transition-all">
                                        <i class="fas fa-ticket-alt text-[11px] opacity-30 group-hover:opacity-100 transition-opacity"></i>
                                        {{ $attendee->ticketType->name ?? 'N/A' }}
                                    </div>
                                </td>
                                <td class="px-8 py-8 text-center">
                                    <div class="inline-flex items-center gap-2 px-5 py-2 rounded-xl text-[9px] font-black uppercase tracking-[0.1em] border
                                        @if($attendee->booking->status == 'confirmed') bg-brand-green/10 text-brand-green border-brand-green/20 @else bg-brand-amber/10 text-brand-amber border-brand-amber/20 @endif">
                                        <span class="w-1.5 h-1.5 rounded-full bg-current shadow-[0_0_8px_currentColor]"></span>
                                        {{ $attendee->booking->status }}
                                    </div>
                                </td>
                                <td class="px-12 py-8 text-right">
                                    <div class="flex flex-col items-end gap-4">
                                        <div class="text-right">
                                            <p class="text-xs font-black text-dark tracking-tight">{{ $attendee->created_at->format('M d, Y') }}</p>
                                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">at {{ $attendee->created_at->format('h:i A') }}</p>
                                        </div>
                                        <div class="flex items-center justify-end gap-3">
                                            <!-- Edit Action -->
                                            <a href="{{ route('admin.customers.segmentation.edit', $attendee->id) }}" class="w-9 h-9 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-400 hover:bg-primary hover:text-white hover:border-primary transition-all shadow-sm group/btn">
                                                <i class="fas fa-edit text-[11px]"></i>
                                            </a>
                                            
                                            <!-- Delete Action -->
                                            <form action="{{ route('admin.customers.segmentation.delete', $attendee->id) }}" method="POST" id="delete-attendee-{{ $attendee->id }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="confirmDeleteAttendee({{ $attendee->id }})" class="w-9 h-9 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-400 hover:bg-brand-red hover:text-white hover:border-brand-red transition-all shadow-sm group/btn">
                                                    <i class="fas fa-trash-alt text-[11px]"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-12 py-24 text-center">
                                    <div class="flex flex-col items-center gap-4 max-w-sm mx-auto">
                                        <div class="w-20 h-20 rounded-[2rem] bg-slate-50 flex items-center justify-center text-3xl text-slate-200">
                                            <i class="fas fa-user-secret"></i>
                                        </div>
                                        <h4 class="text-xl font-outfit font-black text-slate-400">No Target Found</h4>
                                        <p class="text-xs font-medium text-slate-300">We couldn't find any attendees matching those specific segment parameters. Try broadening your filters.</p>
                                        <a href="{{ route('admin.customers.segmentation') }}" class="mt-4 text-[10px] font-black text-primary uppercase tracking-[0.2em] border-b-2 border-primary/20 hover:border-primary transition-all">Clear All Filters</a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Posh Pagination -->
                <div class="p-12 bg-slate-50/30 border-t border-slate-50 flex flex-col md:flex-row items-center justify-between gap-8">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                        Displaying <span class="text-dark">{{ $attendees->firstItem() ?? 0 }}</span> to <span class="text-dark">{{ $attendees->lastItem() ?? 0 }}</span> of <span class="text-dark">{{ $attendees->total() }}</span> unique records
                    </p>
                    <div class="group">
                        {{ $attendees->links() }}
                    </div>
                </div>
            </div>
        </main>

        <footer class="p-10 text-center">
            <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.3em]">Audience Intel • Ticket Kinun OS v2.0</p>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Maintain cursor position for the segmentation search
        window.addEventListener('load', function() {
            const input = document.getElementById('segSearch');
            if (input && "{{ request('search') }}") {
                input.focus();
                const length = input.value.length;
                input.setSelectionRange(length, length);
            }
        });

        // Professional Deletion Confirmation
        function confirmDeleteAttendee(id) {
            Swal.fire({
                title: 'Remove Attendee?',
                text: "This will remove this specific registration from the segment. This action cannot be undone.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#F1F5F9',
                confirmButtonText: 'Yes, Remove!',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
                customClass: {
                    container: 'font-plus',
                    popup: 'rounded-[2rem]',
                    confirmButton: 'rounded-xl px-10 py-4 font-black text-xs uppercase tracking-widest',
                    cancelButton: 'rounded-xl px-10 py-4 font-black text-xs uppercase tracking-widest text-slate-400'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-attendee-' + id).submit();
                }
            });
        }

        // Success/Error Toasts
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
