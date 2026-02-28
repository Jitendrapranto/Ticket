<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Attendee | Ticket Kinun</title>
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
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-[#F8FAFC] font-plus text-slate-800">

    @include('admin.sidebar')

    <div class="lg:ml-72 min-h-screen flex flex-col">
        <header class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-10 sticky top-0 z-40">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.customers.segmentation') }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-50 text-dark hover:bg-primary hover:text-white transition-all">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h2 class="font-outfit text-xl font-black text-dark tracking-tight">Edit Attendee</h2>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Update registration credentials</p>
                </div>
            </div>
        </header>

        <main class="p-10 flex-1 max-w-4xl mx-auto w-full">
            <div class="bg-white rounded-[2.5rem] shadow-premium border border-white overflow-hidden">
                <form action="{{ route('admin.customers.segmentation.update', $attendee->id) }}" method="POST" class="p-12 space-y-10">
                    @csrf
                    @method('PUT')

                    <!-- Visual Context Header -->
                    <div class="flex items-center gap-8 pb-10 border-b border-slate-50">
                        <div class="w-20 h-20 rounded-[2rem] bg-secondary flex items-center justify-center text-white text-3xl shadow-2xl">
                            <i class="fas fa-user-edit"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-outfit font-black text-dark tracking-tight mb-2">{{ $attendee->name }}</h3>
                            <div class="flex items-center gap-4">
                                <span class="bg-primary/5 text-primary text-[10px] font-black px-3 py-1 rounded-lg uppercase tracking-widest border border-primary/10">
                                    {{ $attendee->ticketType->name }}
                                </span>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                    {{ $attendee->booking->event->title }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        <!-- Name -->
                        <div class="space-y-3">
                            <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Attendee Name</label>
                            <div class="relative">
                                <i class="fas fa-user absolute left-6 top-1/2 -translate-y-1/2 text-slate-300"></i>
                                <input type="text" name="name" value="{{ old('name', $attendee->name) }}" required 
                                    class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-5 pl-14 pr-8 outline-none focus:border-primary/30 focus:bg-white transition-all text-sm font-bold shadow-sm">
                            </div>
                        </div>

                        <!-- Mobile -->
                        <div class="space-y-3">
                            <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Contact Mobile</label>
                            <div class="relative">
                                <i class="fas fa-phone-alt absolute left-6 top-1/2 -translate-y-1/2 text-slate-300"></i>
                                <input type="text" name="mobile" value="{{ old('mobile', $attendee->mobile) }}" required 
                                    class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-5 pl-14 pr-8 outline-none focus:border-primary/30 focus:bg-white transition-all text-sm font-bold shadow-sm">
                            </div>
                        </div>
                    </div>

                    <div class="pt-10 border-t border-slate-50 flex items-center justify-end gap-6">
                        <a href="{{ route('admin.customers.segmentation') }}" class="text-[11px] font-black text-slate-400 uppercase tracking-widest hover:text-dark transition-all">Discard Changes</a>
                        <button type="submit" class="bg-secondary hover:bg-black text-white px-12 py-5 rounded-2xl font-black text-[11px] uppercase tracking-[0.2em] shadow-xl transition-all flex items-center gap-4">
                            <i class="fas fa-save text-[14px]"></i> Update Records
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
