<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer Settings | Ticket Kinun Admin</title>
    <style>html { visibility: hidden; opacity: 0; } html.ready { visibility: visible; opacity: 1; transition: opacity 0.15s ease-in; }</style>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { primary: '#520C6B', secondary: '#1B2B46', accent: '#2563EB', dark: '#0F172A', 'slate-custom': '#F8FAFC' },
                    fontFamily: { outfit: ['Arial', 'Helvetica', 'sans-serif'], plus: ['Arial', 'Helvetica', 'sans-serif'] },
                    boxShadow: { 'premium': '0 20px 50px -12px rgba(82, 12, 107, 0.25)' }
                }
            }
        }
    </script>
    <script>document.addEventListener('DOMContentLoaded', () => document.documentElement.classList.add('ready')); setTimeout(() => document.documentElement.classList.add('ready'), 100);</script>
</head>
<body class="bg-[#F1F5F9] font-plus"
      x-data="{
          successModal: {{ session('success') ? 'true' : 'false' }},
          showToast: {{ session('success') ? 'true' : 'false' }},
          toastMessage: '{{ session('success') ?? '' }}',
          explorerLinks: {{ json_encode(old('explorer_links', $footer->explorer_links ?? [['label'=>'Discover Events','url'=>'/events'],['label'=>'Trending Now','url'=>'/#trending'],['label'=>'The Kinun Story','url'=>'/about'],['label'=>'Contact Us','url'=>'/contact']])) }},
          collectionsItems: {{ json_encode(old('collections_items', $footer->collections_items ?? [['label'=>'Live Concerts'],['label'=>'Elite Sports'],['label'=>'Cinema Premiers'],['label'=>'Culture Fests']])) }},
          logoPreview: '{{ $footer && $footer->logo_path ? (str_starts_with($footer->logo_path, 'site/') ? asset('storage/'.$footer->logo_path) : asset($footer->logo_path)) : asset('Blue_Simple_Technology_Logo.png') }}',
      }"
      x-init="if(showToast) { setTimeout(() => showToast = false, 4000); }">

    @include('admin.sidebar')

    <!-- Toast Notification -->
    <div x-show="showToast" x-cloak
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="fixed top-6 right-6 z-[9999] flex items-center gap-3 bg-green-500 text-white px-6 py-4 rounded-2xl shadow-2xl shadow-green-500/30">
        <div class="w-8 h-8 bg-white/20 rounded-xl flex items-center justify-center">
            <i class="fas fa-check text-sm"></i>
        </div>
        <span class="text-sm font-bold" x-text="toastMessage"></span>
        <button @click="showToast = false" class="ml-2 text-white/60 hover:text-white"><i class="fas fa-times text-xs"></i></button>
    </div>

    <div class="lg:ml-72 min-h-screen flex flex-col">
        <!-- Header Bar -->
        <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-100 flex items-center justify-between px-8 sticky top-0 z-40">
            <div>
                <h2 class="font-outfit text-xl font-black text-dark tracking-tight">Footer Settings</h2>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Site Settings — Footer Configuration</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 bg-slate-100 text-slate-600 px-5 py-2.5 rounded-xl text-xs font-black tracking-widest hover:bg-slate-200 transition-all uppercase">
                <i class="fas fa-th-large"></i> Dashboard
            </a>
        </header>

        <main class="p-8 flex-1">
            @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-2xl p-5 mb-6 flex items-start gap-4">
                <i class="fas fa-exclamation-circle text-red-500 mt-0.5"></i>
                <ul class="text-sm text-red-600 font-semibold space-y-1">
                    @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('admin.site.footer.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Main Form -->
                    <div class="lg:col-span-2 space-y-6">

                        <!-- Branding Section -->
                        <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100 space-y-6">
                            <h3 class="font-outfit font-black text-dark text-lg border-b border-slate-100 pb-4">
                                <i class="fas fa-palette text-primary mr-2"></i> Branding
                            </h3>
                            <div class="flex items-center gap-6">
                                <div class="w-24 h-24 rounded-2xl bg-secondary flex items-center justify-center overflow-hidden">
                                    <img :src="logoPreview" class="max-w-full max-h-full object-contain brightness-0 invert" alt="Footer Logo">
                                </div>
                                <div class="flex-1">
                                    <label class="block text-xs font-black text-dark uppercase tracking-widest mb-2">Upload Footer Logo</label>
                                    <input type="file" name="logo" accept="image/*"
                                           @change="logoPreview = URL.createObjectURL($event.target.files[0])"
                                           class="w-full text-sm file:mr-4 file:py-2.5 file:px-5 file:rounded-xl file:border-0 file:text-xs file:font-black file:bg-primary/10 file:text-primary hover:file:bg-primary/20 file:tracking-widest file:uppercase cursor-pointer">
                                    <p class="text-[10px] text-slate-400 mt-2 font-medium">Recommended: PNG with transparent background. Max 5MB.</p>
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-black text-dark uppercase tracking-widest mb-2">Description</label>
                                <textarea name="description" rows="3"
                                          class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary resize-none">{{ old('description', $footer->description ?? '') }}</textarea>
                            </div>
                        </div>

                        <!-- Social Media -->
                        <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100 space-y-6">
                            <h3 class="font-outfit font-black text-dark text-lg border-b border-slate-100 pb-4">
                                <i class="fas fa-share-alt text-primary mr-2"></i> Social Media Links
                            </h3>
                            <div class="grid grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-xs font-black text-dark uppercase tracking-widest mb-2"><i class="fab fa-facebook-f mr-1 text-blue-600"></i> Facebook</label>
                                    <input type="text" name="facebook_url" value="{{ old('facebook_url', $footer->facebook_url ?? '') }}"
                                           placeholder="https://facebook.com/..."
                                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                                </div>
                                <div>
                                    <label class="block text-xs font-black text-dark uppercase tracking-widest mb-2"><i class="fab fa-twitter mr-1 text-sky-500"></i> Twitter</label>
                                    <input type="text" name="twitter_url" value="{{ old('twitter_url', $footer->twitter_url ?? '') }}"
                                           placeholder="https://twitter.com/..."
                                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                                </div>
                                <div>
                                    <label class="block text-xs font-black text-dark uppercase tracking-widest mb-2"><i class="fab fa-instagram mr-1 text-pink-500"></i> Instagram</label>
                                    <input type="text" name="instagram_url" value="{{ old('instagram_url', $footer->instagram_url ?? '') }}"
                                           placeholder="https://instagram.com/..."
                                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                                </div>
                                <div>
                                    <label class="block text-xs font-black text-dark uppercase tracking-widest mb-2"><i class="fab fa-linkedin-in mr-1 text-blue-700"></i> LinkedIn</label>
                                    <input type="text" name="linkedin_url" value="{{ old('linkedin_url', $footer->linkedin_url ?? '') }}"
                                           placeholder="https://linkedin.com/..."
                                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                                </div>
                            </div>
                        </div>

                        <!-- Explorer Links -->
                        <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100 space-y-6">
                            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                                <h3 class="font-outfit font-black text-dark text-lg">
                                    <i class="fas fa-compass text-primary mr-2"></i> Explorer Section
                                </h3>
                                <button type="button" @click="explorerLinks.push({label:'', url:''})"
                                        class="flex items-center gap-2 bg-primary/10 text-primary px-4 py-2 rounded-xl text-xs font-black tracking-widest hover:bg-primary/20 transition-all uppercase">
                                    <i class="fas fa-plus"></i> Add
                                </button>
                            </div>
                            <div>
                                <label class="block text-xs font-black text-dark uppercase tracking-widest mb-2">Section Title <span class="text-red-500">*</span></label>
                                <input type="text" name="explorer_title" value="{{ old('explorer_title', $footer->explorer_title ?? 'Explorer') }}"
                                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                            </div>
                            <template x-for="(link, index) in explorerLinks" :key="index">
                                <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                                    <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center text-primary text-xs font-black" x-text="index + 1"></div>
                                    <div class="flex-1 grid grid-cols-2 gap-3">
                                        <input type="text" :name="'explorer_links[' + index + '][label]'" x-model="link.label" placeholder="Label"
                                               class="w-full px-3 py-2.5 bg-white border border-slate-200 rounded-xl text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-primary/30">
                                        <input type="text" :name="'explorer_links[' + index + '][url]'" x-model="link.url" placeholder="URL"
                                               class="w-full px-3 py-2.5 bg-white border border-slate-200 rounded-xl text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-primary/30">
                                    </div>
                                    <button type="button" @click="explorerLinks.splice(index, 1)"
                                            class="w-9 h-9 bg-red-50 text-red-400 rounded-xl flex items-center justify-center hover:bg-red-100 hover:text-red-600 transition-all">
                                        <i class="fas fa-trash-alt text-xs"></i>
                                    </button>
                                </div>
                            </template>
                        </div>

                        <!-- Collections Section -->
                        <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100 space-y-6">
                            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                                <h3 class="font-outfit font-black text-dark text-lg">
                                    <i class="fas fa-layer-group text-primary mr-2"></i> Collections Section
                                </h3>
                                <button type="button" @click="collectionsItems.push({label:''})"
                                        class="flex items-center gap-2 bg-primary/10 text-primary px-4 py-2 rounded-xl text-xs font-black tracking-widest hover:bg-primary/20 transition-all uppercase">
                                    <i class="fas fa-plus"></i> Add
                                </button>
                            </div>
                            <div>
                                <label class="block text-xs font-black text-dark uppercase tracking-widest mb-2">Section Title <span class="text-red-500">*</span></label>
                                <input type="text" name="collections_title" value="{{ old('collections_title', $footer->collections_title ?? 'Collections') }}"
                                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                            </div>
                            <template x-for="(item, index) in collectionsItems" :key="index">
                                <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                                    <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center text-primary text-xs font-black" x-text="index + 1"></div>
                                    <div class="flex-1">
                                        <input type="text" :name="'collections_items[' + index + '][label]'" x-model="item.label" placeholder="Collection name"
                                               class="w-full px-3 py-2.5 bg-white border border-slate-200 rounded-xl text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-primary/30">
                                    </div>
                                    <button type="button" @click="collectionsItems.splice(index, 1)"
                                            class="w-9 h-9 bg-red-50 text-red-400 rounded-xl flex items-center justify-center hover:bg-red-100 hover:text-red-600 transition-all">
                                        <i class="fas fa-trash-alt text-xs"></i>
                                    </button>
                                </div>
                            </template>
                        </div>

                        <!-- Contact Info -->
                        <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100 space-y-6">
                            <h3 class="font-outfit font-black text-dark text-lg border-b border-slate-100 pb-4">
                                <i class="fas fa-address-card text-primary mr-2"></i> Contact Information
                            </h3>
                            <div>
                                <label class="block text-xs font-black text-dark uppercase tracking-widest mb-2">Section Title <span class="text-red-500">*</span></label>
                                <input type="text" name="contact_title" value="{{ old('contact_title', $footer->contact_title ?? 'Get In Touch') }}"
                                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                                <div>
                                    <label class="block text-xs font-black text-dark uppercase tracking-widest mb-2"><i class="fas fa-envelope mr-1 text-accent"></i> Email</label>
                                    <input type="text" name="contact_email" value="{{ old('contact_email', $footer->contact_email ?? '') }}"
                                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                                </div>
                                <div>
                                    <label class="block text-xs font-black text-dark uppercase tracking-widest mb-2"><i class="fas fa-phone-alt mr-1 text-accent"></i> Phone</label>
                                    <input type="text" name="contact_phone" value="{{ old('contact_phone', $footer->contact_phone ?? '') }}"
                                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                                </div>
                                <div>
                                    <label class="block text-xs font-black text-dark uppercase tracking-widest mb-2"><i class="fas fa-map-marker-alt mr-1 text-accent"></i> Address</label>
                                    <input type="text" name="contact_address" value="{{ old('contact_address', $footer->contact_address ?? '') }}"
                                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                                </div>
                            </div>
                        </div>

                        <!-- Bottom Bar -->
                        <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100 space-y-6">
                            <h3 class="font-outfit font-black text-dark text-lg border-b border-slate-100 pb-4">
                                <i class="fas fa-copyright text-primary mr-2"></i> Bottom Bar
                            </h3>
                            <div>
                                <label class="block text-xs font-black text-dark uppercase tracking-widest mb-2">Copyright Text</label>
                                <input type="text" name="copyright_text" value="{{ old('copyright_text', $footer->copyright_text ?? '') }}"
                                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                            </div>
                            <div class="grid grid-cols-3 gap-5">
                                <div>
                                    <label class="block text-xs font-black text-dark uppercase tracking-widest mb-2">Privacy URL</label>
                                    <input type="text" name="privacy_url" value="{{ old('privacy_url', $footer->privacy_url ?? '#') }}"
                                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                                </div>
                                <div>
                                    <label class="block text-xs font-black text-dark uppercase tracking-widest mb-2">Terms URL</label>
                                    <input type="text" name="terms_url" value="{{ old('terms_url', $footer->terms_url ?? '#') }}"
                                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                                </div>
                                <div>
                                    <label class="block text-xs font-black text-dark uppercase tracking-widest mb-2">Cookies URL</label>
                                    <input type="text" name="cookies_url" value="{{ old('cookies_url', $footer->cookies_url ?? '#') }}"
                                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                                </div>
                            </div>
                        </div>

                        <!-- Save Button -->
                        <button type="submit" class="w-full py-4 bg-primary text-white font-black text-sm tracking-widest uppercase rounded-2xl hover:bg-secondary transition-all shadow-lg shadow-primary/20">
                            <i class="fas fa-save mr-2"></i> Save Footer Settings
                        </button>
                    </div>

                    <!-- Live Preview -->
                    <div class="lg:col-span-1">
                        <div class="sticky top-28">
                            <p class="text-xs font-black text-dark uppercase tracking-widest mb-4">Live Preview</p>
                            <div class="bg-gradient-to-r from-[#520C6B] to-[#1B2B46] rounded-3xl overflow-hidden shadow-sm p-6 space-y-5">
                                <!-- Logo & Desc -->
                                <div>
                                    <img :src="logoPreview" class="h-10 w-auto object-contain brightness-0 invert mb-3" alt="Footer Logo">
                                    <p class="text-white/40 text-[9px] leading-relaxed">{{ Str::limit($footer->description ?? 'Your description here...', 120) }}</p>
                                </div>
                                <!-- Social Icons -->
                                <div class="flex gap-2">
                                    <div class="w-7 h-7 rounded-lg bg-white/5 flex items-center justify-center"><i class="fab fa-facebook-f text-white/30 text-[8px]"></i></div>
                                    <div class="w-7 h-7 rounded-lg bg-white/5 flex items-center justify-center"><i class="fab fa-twitter text-white/30 text-[8px]"></i></div>
                                    <div class="w-7 h-7 rounded-lg bg-white/5 flex items-center justify-center"><i class="fab fa-instagram text-white/30 text-[8px]"></i></div>
                                    <div class="w-7 h-7 rounded-lg bg-white/5 flex items-center justify-center"><i class="fab fa-linkedin-in text-white/30 text-[8px]"></i></div>
                                </div>
                                <!-- Explorer -->
                                <div>
                                    <p class="text-[8px] font-black text-white/50 uppercase tracking-widest mb-2">Explorer</p>
                                    <template x-for="(link, idx) in explorerLinks" :key="idx">
                                        <p class="text-[9px] text-white/30 mb-1" x-text="link.label || 'Link'"></p>
                                    </template>
                                </div>
                                <!-- Collections -->
                                <div>
                                    <p class="text-[8px] font-black text-white/50 uppercase tracking-widest mb-2">Collections</p>
                                    <template x-for="(item, idx) in collectionsItems" :key="idx">
                                        <p class="text-[9px] text-white/30 mb-1" x-text="item.label || 'Item'"></p>
                                    </template>
                                </div>
                                <!-- Bottom -->
                                <div class="pt-3 border-t border-white/5">
                                    <p class="text-[8px] text-white/20 font-medium">{{ Str::limit($footer->copyright_text ?? 'Copyright text here...', 80) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>

    <!-- Success Popup Modal -->
    <div x-show="successModal" x-cloak
         class="fixed inset-0 z-[9999] flex items-center justify-center p-4"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100">
        <div class="absolute inset-0 bg-dark/60 backdrop-blur-sm" @click="successModal = false"></div>
        <div class="relative bg-white rounded-3xl p-10 max-w-sm w-full shadow-2xl text-center"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-90"
             x-transition:enter-end="opacity-100 scale-100">
            <div class="w-20 h-20 bg-green-50 rounded-3xl flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-check-circle text-green-500 text-4xl"></i>
            </div>
            <h3 class="font-outfit font-black text-dark text-2xl mb-2">Footer Updated!</h3>
            <p class="text-slate-400 text-sm font-medium mb-8">The site footer has been updated successfully and is now live across all pages.</p>
            <div class="flex gap-3">
                <button @click="successModal = false" class="flex-1 py-3.5 bg-slate-100 text-slate-600 font-black text-xs tracking-widest uppercase rounded-2xl hover:bg-slate-200 transition-all">
                    Close
                </button>
                <a href="/" target="_blank" class="flex-1 py-3.5 bg-primary text-white font-black text-xs tracking-widest uppercase rounded-2xl hover:bg-secondary transition-all text-center">
                    View Site
                </a>
            </div>
        </div>
    </div>
</body>
</html>
