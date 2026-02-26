<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Event | Ticket Kinun Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { primary: '#520C6B', 'primary-dark': '#21032B', secondary: '#21032B', accent: '#FF7D52', dark: '#0F172A', 'slate-custom': '#F8FAFC' },
                    fontFamily: { outfit: ['Outfit', 'sans-serif'], plus: ['"Plus Jakarta Sans"', 'sans-serif'] },
                    boxShadow: { 'premium': '0 20px 50px -12px rgba(82, 12, 107, 0.15)' }
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
        .form-input { @apply w-full bg-slate-50 border border-slate-200 rounded-xl py-4 px-6 outline-none focus:border-primary/30 focus:bg-white transition-all text-dark font-medium text-sm; }
        .form-label { @apply text-xs font-bold text-slate-500 mb-2 block; }
    </style>
</head>
<body class="bg-[#F1F5F9] text-slate-800 font-plus overflow-x-hidden">
    @include('admin.sidebar')

    <div class="lg:ml-72 min-h-screen flex flex-col">
        <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data" x-data="{ 
            tickets: [{ name: 'General Admission', price: '25', quantity: '100' }],
            addTicket() { this.tickets.push({ name: '', price: '', quantity: '' }) },
            removeTicket(index) { this.tickets.splice(index, 1) }
        }">
            @csrf
            
            <!-- Header Section -->
            <header class="h-24 bg-white/80 backdrop-blur-md border-b border-slate-100 flex items-center justify-between px-12 sticky top-0 z-40">
                <div class="flex items-center gap-6">
                    <a href="{{ route('admin.events.index') }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-50 text-dark hover:bg-white transition-all border border-slate-100 shadow-sm">
                        <i class="fas fa-arrow-left text-xs"></i>
                    </a>
                    <div>
                        <h2 class="font-outfit text-2xl font-black text-dark tracking-tight">Create New Event</h2>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Launch a new experience or save it for later review.</p>
                    </div>
                </div>
                <div class="flex items-center gap-6">
                    <button type="submit" name="status" value="Draft" class="text-xs font-bold text-slate-500 hover:text-primary transition-colors uppercase tracking-widest">Save as Draft</button>
                    <button type="submit" name="status" value="Live" class="bg-primary text-white px-8 py-3.5 rounded-xl text-xs font-black tracking-widest hover:bg-primary-dark transition-all uppercase shadow-xl shadow-primary/20 flex items-center gap-3">
                        <i class="fas fa-rocket text-[10px]"></i> Launch Event
                    </button>
                </div>
            </header>

            @if(session('error') || $errors->any())
                <!-- Error Notification -->
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 10000)" x-show="show" 
                     x-transition:enter="transition ease-out duration-500"
                     x-transition:enter-start="translate-x-full opacity-0"
                     x-transition:enter-end="translate-x-0 opacity-100"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-end="translate-x-full opacity-0"
                     class="fixed top-8 right-8 z-[150] max-w-sm w-full">
                    <div class="bg-red-950 rounded-[2rem] shadow-2xl p-6 flex flex-col gap-4 relative overflow-hidden text-white border border-red-500/20">
                        <div class="absolute left-0 top-0 bottom-0 w-2 bg-red-500"></div>
                        <div class="flex items-center gap-6">
                            <div class="w-12 h-12 bg-red-500/20 rounded-2xl flex items-center justify-center text-xl shadow-inner text-red-500"><i class="fas fa-exclamation-triangle"></i></div>
                            <div class="flex-1 text-left">
                                <h4 class="text-sm font-black tracking-tight uppercase">Action Required</h4>
                                <p class="text-[10px] text-red-200/60 mt-0.5 leading-tight font-bold tracking-widest">Verification failed</p>
                            </div>
                        </div>
                        <div class="space-y-1 bg-black/20 p-4 rounded-xl">
                            @if(session('error'))
                                <p class="text-[11px] text-red-100 font-medium">{{ session('error') }}</p>
                            @endif
                            @foreach ($errors->all() as $error)
                                <p class="text-[10px] text-red-100/80 font-medium flex items-center gap-2">
                                    <span class="w-1 h-1 bg-red-400 rounded-full"></span>
                                    {{ $error }}
                                </p>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <main class="p-12 max-w-6xl mx-auto space-y-8">

                <!-- Basic Information -->
                <div class="bg-white rounded-[2rem] p-10 shadow-sm border border-slate-100">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-10 h-10 rounded-xl bg-primary/5 text-primary flex items-center justify-center">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <h3 class="font-outfit text-lg font-black text-dark tracking-tight">Basic Information</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-4">
                            <label class="form-label">Event ID</label>
                            <input type="text" value="{{ 'EVP-'.strtoupper(Str::random(6)) }}" readonly class="w-full bg-slate-50/50 border border-slate-100 rounded-xl py-4 px-6 outline-none text-slate-400 font-bold text-sm cursor-not-allowed">
                        </div>
                        <div class="space-y-4">
                            <label class="form-label">Event Name</label>
                            <input type="text" name="title" required class="w-full bg-slate-50 border border-slate-100 rounded-xl py-4 px-6 outline-none focus:border-primary/30 focus:bg-white transition-all text-dark font-bold text-sm" placeholder="e.g. Summer Music Festival">
                        </div>
                        <div class="space-y-4">
                            <label class="form-label">Organizer Name</label>
                            <input type="text" name="organizer" required class="w-full bg-slate-50 border border-slate-100 rounded-xl py-4 px-6 outline-none focus:border-primary/30 focus:bg-white transition-all text-dark font-bold text-sm" placeholder="e.g. LiveNation Events">
                        </div>
                        <div class="space-y-4">
                            <label class="form-label">Category</label>
                            <select name="category_id" required class="w-full bg-slate-50 border border-slate-100 rounded-xl py-4 px-6 outline-none focus:border-primary/30 focus:bg-white transition-all text-dark font-bold text-sm appearance-none">
                                <option value="" disabled selected>Select event category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="md:col-span-2 space-y-4">
                            <label class="form-label">Venue / Location</label>
                            <div class="relative group">
                                <i class="fas fa-map-marker-alt absolute left-6 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-primary transition-colors"></i>
                                <input type="text" name="location" required class="w-full bg-slate-50 border border-slate-100 rounded-xl py-4 pl-14 pr-6 outline-none focus:border-primary/30 focus:bg-white transition-all text-dark font-bold text-sm" placeholder="e.g. Madison Square Garden">
                            </div>
                        </div>
                        <div class="md:col-span-2 space-y-4">
                            <label class="form-label">Event Description</label>
                            <textarea name="description" rows="5" class="w-full bg-slate-50 border border-slate-100 rounded-2xl p-6 outline-none focus:border-primary/30 focus:bg-white transition-all text-dark font-medium text-sm leading-relaxed" placeholder="Provide a detailed overview of what attendees can expect..."></textarea>
                        </div>
                    </div>
                </div>

                <!-- Media & Branding -->
                <div class="bg-white rounded-[2rem] p-10 shadow-sm border border-slate-100" 
                     x-data="{ 
                        preview: null, 
                        imageError: null,
                        imageMeta: { size: 0, w: 0, h: 0 },
                        handleFile(e) {
                            const file = e.target.files[0];
                            if (!file) return;

                            this.imageError = null;
                            const sizeMB = (file.size / (1024 * 1024)).toFixed(2);
                            this.imageMeta.size = sizeMB;

                            if (sizeMB > 5) {
                                this.imageError = 'File size (' + sizeMB + 'MB) exceeds the 5MB limit';
                                this.preview = null;
                                e.target.value = '';
                                return;
                            }

                            const reader = new FileReader();
                            reader.onload = (event) => {
                                const img = new Image();
                                img.onload = () => {
                                    this.imageMeta.w = img.width;
                                    this.imageMeta.h = img.height;
                                    this.preview = event.target.result;
                                };
                                img.src = event.target.result;
                            };
                            reader.readAsDataURL(file);
                        }
                     }">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-10 h-10 rounded-xl bg-primary/5 text-primary flex items-center justify-center">
                            <i class="fas fa-image"></i>
                        </div>
                        <h3 class="font-outfit text-lg font-black text-dark tracking-tight">Media & Branding</h3>
                    </div>

                    <div class="space-y-6">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <label class="form-label">Event Banner</label>
                                <span class="text-[10px] font-black text-primary uppercase tracking-widest">Recommended: 1280x720px • < 5MB</span>
                            </div>
                            
                            <div class="flex gap-4">
                                <div class="flex-1 bg-slate-50 border border-slate-100 rounded-xl py-4 px-6 flex items-center justify-between overflow-hidden">
                                    <span class="text-xs font-bold text-slate-400 truncate" x-text="imageError ? 'Invalid File' : (preview ? 'Image selected' : 'No file chosen')"></span>
                                    <div x-show="preview && !imageError" class="flex gap-4 items-center pl-4 bg-slate-50 ml-auto" x-cloak>
                                        <span class="text-[9px] font-black text-dark bg-white px-2 py-1 rounded-md border border-slate-100 transition-all" x-text="imageMeta.w + 'x' + imageMeta.h + 'px'"></span>
                                        <span class="text-[9px] font-black text-primary bg-primary/5 px-2 py-1 rounded-md transition-all" x-text="imageMeta.size + ' MB'"></span>
                                    </div>
                                </div>
                                <label class="bg-primary-dark text-white px-8 py-4 rounded-xl text-[10px] font-black tracking-widest cursor-pointer hover:bg-black transition-all flex items-center gap-3 shadow-lg shadow-primary/10">
                                    <i class="fas fa-camera"></i> Select Photo
                                    <input type="file" name="image" class="hidden" accept="image/*" @change="handleFile($event)">
                                </label>
                            </div>
                            
                            <template x-if="imageError">
                                <div class="flex items-center gap-3 py-3 px-5 bg-red-50 border border-red-100 rounded-xl text-red-500 animate-fadeInUp">
                                    <i class="fas fa-exclamation-circle text-xs"></i>
                                    <span class="text-[10px] font-black uppercase tracking-tight" x-text="imageError"></span>
                                </div>
                            </template>
                        </div>

                        <!-- Preview Window -->
                        <div class="w-full aspect-video bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200 flex items-center justify-center relative overflow-hidden group shadow-inner transition-all duration-500"
                             :class="imageError ? 'border-red-200 bg-red-50/10' : (preview ? 'border-primary/20' : 'border-slate-200')">
                            <template x-if="preview">
                                <img :src="preview" class="w-full h-full object-cover animate-fadeInUp">
                            </template>
                            <template x-if="!preview">
                                <div class="text-center">
                                    <i class="fas fa-image text-4xl text-slate-200 mb-4 transition-transform group-hover:scale-110 duration-500"></i>
                                    <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Awaiting Media Asset</p>
                                </div>
                            </template>
                            
                            <!-- Floating Overlay Info -->
                            <div x-show="preview" x-cloak class="absolute bottom-4 left-4 right-4 flex justify-between items-end pointer-events-none">
                                <div class="bg-dark/80 backdrop-blur-md px-4 py-2 rounded-xl border border-white/10">
                                    <p class="text-[8px] font-black text-white/40 uppercase tracking-[0.2em] mb-0.5">Specifications</p>
                                    <p class="text-[10px] font-bold text-white tracking-widest">Vivid Capture • High Fidelity</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Scheduling -->
                <div class="bg-white rounded-[2rem] p-10 shadow-sm border border-slate-100">
                    <div class="flex items-center gap-4 mb-2">
                        <div class="w-10 h-10 rounded-xl bg-primary/5 text-primary flex items-center justify-center">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <h3 class="font-outfit text-lg font-black text-dark tracking-tight">Scheduling</h3>
                    </div>
                    <p class="text-[10px] text-slate-400 font-bold mb-8 uppercase tracking-widest">Set the dates and times for your event and registration period.</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-4">
                            <label class="form-label">Event Start Date & Time</label>
                            <div class="relative group">
                                <i class="fas fa-calendar absolute right-6 top-1/2 -translate-y-1/2 text-slate-300 pointer-events-none group-focus-within:text-primary transition-colors"></i>
                                <input type="datetime-local" name="date" required class="w-full bg-slate-50 border border-slate-100 rounded-xl py-4 px-6 outline-none focus:border-primary/30 focus:bg-white transition-all text-dark font-bold text-sm">
                            </div>
                        </div>
                        <div class="space-y-4">
                            <label class="form-label">Registration Last Date</label>
                            <div class="relative group">
                                <i class="fas fa-calendar absolute right-6 top-1/2 -translate-y-1/2 text-slate-300 pointer-events-none group-focus-within:text-primary transition-colors"></i>
                                <input type="datetime-local" name="registration_deadline" required class="w-full bg-slate-50 border border-slate-100 rounded-xl py-4 px-6 outline-none focus:border-primary/30 focus:bg-white transition-all text-dark font-bold text-sm">
                            </div>
                            <p class="text-[10px] text-slate-400 font-medium">When will ticket sales close for this event?</p>
                        </div>
                    </div>
                </div>

                <!-- Experience Settings -->
                <div class="bg-white rounded-[2rem] p-10 shadow-sm border border-slate-100">
                    <div class="flex items-center gap-4 mb-2">
                        <div class="w-10 h-10 rounded-xl bg-primary/5 text-primary flex items-center justify-center">
                            <i class="fas fa-sliders-h"></i>
                        </div>
                        <h3 class="font-outfit text-lg font-black text-dark tracking-tight">Experience Settings</h3>
                    </div>
                    <p class="text-[10px] text-slate-400 font-bold mb-8 uppercase tracking-widest">Configure how this event appears in the gallery and listing views.</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-4">
                            <label class="form-label">Presentation Order</label>
                            <div class="relative group">
                                <i class="fas fa-sort-numeric-down absolute left-6 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-primary transition-colors"></i>
                                <input type="number" name="sort_order" value="0" min="0" required class="w-full bg-slate-50 border border-slate-100 rounded-xl py-4 pl-14 pr-6 outline-none focus:border-primary/30 focus:bg-white transition-all text-dark font-bold text-sm" placeholder="e.g. 1">
                            </div>
                            <p class="text-[10px] text-slate-400 font-medium italic">Lower numbers appear first in the listing.</p>
                        </div>
                        <div class="space-y-4">
                            <label class="form-label">Featured Experience</label>
                            <label class="relative inline-flex items-center cursor-pointer group">
                                <input type="checkbox" name="is_featured" value="1" class="sr-only peer">
                                <div class="w-14 h-8 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:start-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-primary"></div>
                                <span class="ms-4 text-xs font-bold text-slate-500 group-hover:text-dark transition-colors">Mark as Featured</span>
                            </label>
                            <p class="text-[10px] text-slate-400 font-medium">Featured events are highlighted in the hero or spotlight sections.</p>
                        </div>
                    </div>
                </div>

                <!-- Ticketing -->
                <div class="bg-white rounded-[2rem] p-10 shadow-sm border border-slate-100">
                    <div class="flex items-center justify-between mb-8">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-primary/5 text-primary flex items-center justify-center">
                                <i class="fas fa-ticket-alt"></i>
                            </div>
                            <div>
                                <h3 class="font-outfit text-lg font-black text-dark tracking-tight">Ticketing</h3>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">Add different ticket types for your event.</p>
                            </div>
                        </div>
                        <button type="button" @click="addTicket()" class="bg-primary-dark text-white px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-black transition-all flex items-center gap-3">
                            <i class="fas fa-plus"></i> Add Ticket Type
                        </button>
                    </div>

                    <div class="space-y-4">
                        <template x-for="(ticket, index) in tickets" :key="index">
                            <div class="grid grid-cols-12 gap-6 items-end group animate-fadeInUp">
                                <div class="col-span-5 space-y-3">
                                    <label class="form-label text-[10px]">Ticket Name</label>
                                    <input type="text" :name="'tickets['+index+'][name]'" x-model="ticket.name" required class="w-full bg-slate-50 border border-slate-100 rounded-xl py-4 px-6 outline-none text-sm font-bold opacity-80 focus:opacity-100 transition-all shadow-inner" placeholder="General Admission">
                                </div>
                                <div class="col-span-3 space-y-3">
                                    <label class="form-label text-[10px]">Price ($)</label>
                                    <input type="number" :name="'tickets['+index+'][price]'" x-model="ticket.price" required class="w-full bg-slate-50 border border-slate-100 rounded-xl py-4 px-6 outline-none text-sm font-black tracking-tighter shadow-inner">
                                </div>
                                <div class="col-span-3 space-y-3">
                                    <label class="form-label text-[10px]">Quantity</label>
                                    <input type="number" :name="'tickets['+index+'][quantity]'" x-model="ticket.quantity" required class="w-full bg-slate-50 border border-slate-100 rounded-xl py-4 px-6 outline-none text-sm font-bold shadow-inner">
                                </div>
                                <div class="col-span-1 pb-1">
                                    <button type="button" @click="removeTicket(index)" class="w-12 h-12 flex items-center justify-center rounded-xl bg-red-50 text-red-400 border border-red-100 hover:bg-red-500 hover:text-white transition-all shadow-sm">
                                        <i class="fas fa-trash-alt text-[10px]"></i>
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="pt-12 flex items-center justify-between">
                    <a href="{{ route('admin.events.index') }}" class="text-xs font-bold text-slate-500 hover:text-dark transition-colors uppercase tracking-widest">Cancel</a>
                    <div class="flex items-center gap-6">
                        <button type="submit" name="status" value="Draft" class="bg-slate-100 text-slate-600 px-8 py-4 rounded-2xl text-xs font-black tracking-[0.2em] hover:bg-slate-200 transition-all uppercase flex items-center gap-3">
                            <i class="fas fa-save text-[10px]"></i> Save as Draft
                        </button>
                        <!-- Added hidden price for main event if needed by back-end schema, taking from first ticket -->
                        <input type="hidden" name="price" :value="tickets[0] ? tickets[0].price : 0">
                        <button type="submit" name="status" value="Live" class="bg-primary-dark text-white px-12 py-4 rounded-2xl font-black text-xs tracking-[0.3em] shadow-xl shadow-primary/20 hover:-translate-y-1 transition-all active:scale-95 uppercase flex items-center gap-3">
                             <i class="fas fa-paper-plane text-[10px]"></i> Launch Event
                        </button>
                    </div>
                </div>
            </main>
        </form>
    </div>

    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeInUp { animation: fadeInUp 0.4s ease forwards; }
    </style>
</body>
</html>
