<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Support Section | Ticket Kinun Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { primary: '#520C6B', 'primary-dark': '#21032B', secondary: '#21032B', accent: '#FF7D52', dark: '#0F172A' },
                    fontFamily: { outfit: ['Outfit', 'sans-serif'], plus: ['"Plus Jakarta Sans"', 'sans-serif'] },
                }
            }
        }
    </script>
</head>
<body class="bg-[#F1F5F9] text-slate-800 font-plus">
    @include('admin.sidebar')

    <div class="lg:ml-72 min-h-screen flex flex-col">
        <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-100 flex items-center justify-between px-8 sticky top-0 z-40">
            <div>
                <h2 class="font-outfit text-xl font-black text-dark tracking-tight">Support Visual Section</h2>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest"><a href="#" class="hover:text-primary">Contact Page</a> / Edit Visual Content</p>
            </div>
        </header>

        <main class="p-8 flex-1">
            @if(session('success'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" 
                     x-transition:enter="transition ease-out duration-500"
                     x-transition:enter-start="translate-x-full opacity-0"
                     x-transition:enter-end="translate-x-0 opacity-100"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-end="translate-x-full opacity-0"
                     class="fixed top-8 right-8 z-[100] max-w-sm w-full">
                    <div class="bg-secondary rounded-[2rem] shadow-2xl p-6 flex items-center gap-6 relative overflow-hidden text-white border border-white/5">
                        <div class="absolute left-0 top-0 bottom-0 w-2 bg-primary"></div>
                        <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center text-xl shadow-inner"><i class="fas fa-check-circle"></i></div>
                        <div class="flex-1 text-left">
                            <h4 class="text-sm font-black tracking-tight">Operation Successful</h4>
                            <p class="text-[11px] text-white/60 mt-0.5 leading-tight">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('admin.contact.support.update') }}" method="POST" enctype="multipart/form-data" class="max-w-4xl mx-auto bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
                @csrf
                @method('PUT')
                
                <div class="p-10 space-y-10">
                    
                    <!-- Top Badge & Image -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h3 class="font-outfit text-lg font-black text-dark mb-6 border-b border-slate-100 pb-2 uppercase tracking-tighter"><i class="fas fa-image mr-2 text-primary"></i> Visual Basics</h3>
                            
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Badge Text</label>
                                    <input type="text" name="badge_text" value="{{ old('badge_text', $support->badge_text) }}" class="w-full bg-slate-50 border border-slate-200 text-dark rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all font-bold">
                                    @error('badge_text') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Background Image URL</label>
                                    <input type="text" name="image_url" value="{{ old('image_url', $support->image) }}" class="w-full bg-slate-50 border border-slate-200 text-dark rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all text-sm">
                                    <p class="text-[9px] text-slate-400 mt-1 font-bold italic tracking-wider">Note: You can paste a link or upload a file below.</p>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Upload Image File</label>
                                    <input type="file" name="image_file" class="w-full bg-slate-50 border border-slate-200 text-dark rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all text-xs">
                                    @error('image_file') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="bg-slate-50 rounded-[2rem] p-6 flex items-center justify-center border border-dashed border-slate-200">
                             @if($support->image)
                                <div class="text-center">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Current Preview</p>
                                    <img src="{{ $support->image }}" alt="Preview" class="w-full max-h-48 object-cover rounded-2xl shadow-xl">
                                </div>
                             @else
                                <div class="text-center py-12">
                                    <i class="fas fa-image text-slate-200 text-5xl mb-4"></i>
                                    <p class="text-xs font-bold text-slate-400">No image set</p>
                                </div>
                             @endif
                        </div>
                    </div>

                    <!-- Contact Details -->
                    <div>
                        <h3 class="font-outfit text-lg font-black text-dark mb-6 border-b border-slate-100 pb-2 uppercase tracking-tighter"><i class="fas fa-address-card mr-2 text-primary"></i> Contact Details</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Email Address</label>
                                <input type="email" name="email" value="{{ old('email', $support->email) }}" class="w-full bg-slate-50 border border-slate-200 text-dark rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all font-bold">
                                @error('email') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Phone Number</label>
                                <input type="text" name="phone" value="{{ old('phone', $support->phone) }}" class="w-full bg-slate-50 border border-slate-200 text-dark rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all font-bold">
                                @error('phone') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Physical Address</label>
                                <input type="text" name="address" value="{{ old('address', $support->address) }}" class="w-full bg-slate-50 border border-slate-200 text-dark rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all font-bold">
                                @error('address') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Card Content -->
                    <div class="bg-[#F8FAFC] rounded-[2.5rem] p-10 border border-slate-100">
                        <h3 class="font-outfit text-lg font-black text-dark mb-6 border-b border-slate-200 pb-2 uppercase tracking-tighter"><i class="fas fa-info-circle mr-2 text-primary"></i> Info Card & Buttons</h3>
                        
                        <div class="space-y-6">
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Card Title</label>
                                <input type="text" name="card_title" value="{{ old('card_title', $support->card_title) }}" class="w-full bg-white border border-slate-200 text-dark rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all font-black text-lg">
                                @error('card_title') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Card Description</label>
                                <textarea name="card_description" rows="3" class="w-full bg-white border border-slate-200 text-dark rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all font-medium text-sm leading-relaxed">{{ old('card_description', $support->card_description) }}</textarea>
                                @error('card_description') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4">
                                <div>
                                    <label class="block text-[10px] font-black text-[#EF4444] uppercase tracking-widest mb-2"><i class="fas fa-phone mr-1"></i> Call Now URL (tel:+880...)</label>
                                    <input type="text" name="call_url" value="{{ old('call_url', $support->call_url) }}" class="w-full bg-white border border-slate-200 text-dark rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-500/10 transition-all font-bold text-sm" placeholder="tel:+8801234567890">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-[#22C55E] uppercase tracking-widest mb-2"><i class="fab fa-whatsapp mr-1"></i> WhatsApp URL (https://wa.me/...)</label>
                                    <input type="text" name="whatsapp_url" value="{{ old('whatsapp_url', $support->whatsapp_url) }}" class="w-full bg-white border border-slate-200 text-dark rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500/10 transition-all font-bold text-sm" placeholder="https://wa.me/8801234567890">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                
                <div class="bg-slate-50 p-8 border-t border-slate-100 flex justify-end gap-4">
                    <button type="submit" class="bg-dark text-white px-10 py-4 rounded-xl font-black tracking-widest uppercase hover:bg-primary transition-all shadow-xl hover:shadow-primary/20 transform active:scale-95">
                        <i class="fas fa-save mr-2"></i> Save Changes
                    </button>
                </div>
            </form>
        </main>
    </div>
</body>
</html>
