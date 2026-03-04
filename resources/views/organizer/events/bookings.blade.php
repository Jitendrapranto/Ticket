<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Bookings | Organizer Dashboard</title>
    <!-- Prevent FOUC: Hide body until styles are ready -->
    <style>
        html { visibility: hidden; opacity: 0; }
        html.ready { visibility: visible; opacity: 1; transition: opacity 0.15s ease-in; }
    </style>
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
                    },
                    fontFamily: {
                        outfit: ['Outfit', 'sans-serif'],
                        plus: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
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
<body class="bg-[#F8FAFC] text-slate-800 font-plus overflow-x-hidden">

    @include('organizer.sidebar')

    <div class="lg:ml-72 min-h-screen flex flex-col transition-all duration-300">
        <!-- Topbar -->
        <header class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-10 sticky top-0 z-40">
            <div class="flex items-center gap-6">
                <button id="toggle-sidebar" class="lg:hidden w-10 h-10 flex items-center justify-center rounded-xl bg-slate-50 text-dark">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            <div class="flex items-center gap-6">
                <div class="text-right">
                    <p class="text-xs font-black text-dark">{{ Auth::user()->name }}</p>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Organizer</p>
                </div>
            </div>
        </header>

        <main class="p-10 flex-1 max-w-7xl mx-auto w-full">
            <div class="mb-10 flex justify-between items-center">
                <div>
                    <h1 class="font-outfit text-3xl font-black text-dark tracking-tight">{{ $event->title }} - Bookings</h1>
                    <p class="text-slate-400 font-medium text-sm">Review incoming bookings and tickets.</p>
                </div>
                <a href="{{ route('organizer.events.index') }}" class="px-6 py-3 bg-white text-dark border border-slate-100 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-slate-50 transition-all">Back to Events</a>
            </div>

            <div class="bg-white rounded-[2.5rem] shadow-premium overflow-hidden border border-slate-50">
                <div class="p-10 border-b border-slate-50 flex items-center justify-between">
                    <div>
                        <h3 class="font-outfit text-xl font-black text-dark tracking-tight mb-1">Booking List</h3>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] bg-slate-50/30">
                                <th class="px-10 py-6">Customer</th>
                                <th class="px-8 py-6">Tickets</th>
                                <th class="px-8 py-6">Amount</th>
                                <th class="px-8 py-6">Status</th>
                                <th class="px-10 py-6 text-right">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($bookings as $booking)
                            <tr class="hover:bg-slate-50/50 transition-all">
                                <td class="px-10 py-6">
                                    <p class="text-xs font-black text-dark">{{ $booking->first_name }} {{ $booking->last_name }}</p>
                                    <p class="text-[10px] text-slate-400">{{ $booking->email }}</p>
                                    <p class="text-[10px] text-slate-400">{{ $booking->phone }}</p>
                                </td>
                                <td class="px-8 py-6">
                                    @foreach($booking->attendees as $attendee)
                                        <span class="block text-[10px] font-bold text-slate-500">{{ $attendee->ticketType->name ?? 'Ticket' }}</span>
                                    @endforeach
                                    <span class="text-xs font-black text-primary">{{ $booking->attendees->count() }} Tickets</span>
                                </td>
                                <td class="px-8 py-6 font-black text-dark">৳{{ number_format($booking->total_amount, 2) }}</td>
                                <td class="px-8 py-6">
                                    <span class="px-2 py-1 rounded-lg text-[9px] font-black uppercase tracking-wider {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }}">
                                        {{ $booking->status }}
                                    </span>
                                </td>
                                <td class="px-10 py-6 text-right text-[10px] font-bold text-slate-400">
                                    {{ $booking->created_at->format('M d, Y h:i A') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-10 py-20 text-center">
                                    <div class="flex flex-col items-center opacity-20">
                                        <i class="fas fa-ticket-alt text-6xl mb-4"></i>
                                        <p class="text-sm font-black uppercase tracking-widest">No Bookings Yet</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-6">
                    {{ $bookings->links() }}
                </div>
            </div>
        </main>
    </div>
</body>
</html>
