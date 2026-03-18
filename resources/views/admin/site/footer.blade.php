@extends('admin.dashboard')

@section('admin_content')
<div x-data="{
          explorerLinks: Object.values({{ json_encode(old('explorer_links', $footer->explorer_links ?? [['label'=>'Discover Events','url'=>'/events'],['label'=>'Trending Now','url'=>'/#trending'],['label'=>'The Kinun Story','url'=>'/about'],['label'=>'Contact Us','url'=>'/contact']])) }} || {}),
          collectionsItems: Object.values({{ json_encode(old('collections_items', $footer->collections_items ?? [['label'=>'Live Concerts'],['label'=>'Elite Sports'],['label'=>'Cinema Premiers'],['label'=>'Culture Fests']])) }} || {}),
          logoPreview: '{{ $footer && $footer->logo_path ? (str_starts_with($footer->logo_path, 'site/') ? asset('storage/'.$footer->logo_path) : asset($footer->logo_path)) : asset('Blue_Simple_Technology_Logo.png') }}',
      }" class="px-8 py-8 flex-1 animate-fadeIn">

    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="font-outfit text-2xl font-black text-dark tracking-tight">Footer Settings</h2>
            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">Site Settings — Footer Configuration</p>
        </div>
    </div>
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
                                    <img loading="lazy" :src="logoPreview" class="max-w-full max-h-full object-contain brightness-0 invert" alt="Footer Logo">
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
                                <button type="button" @click="explorerLinks = [...explorerLinks, {label:'', url:''}]"
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
                                <button type="button" @click="collectionsItems = [...collectionsItems, {label:''}]"
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
                                    <img loading="lazy" :src="logoPreview" class="h-10 w-auto object-contain brightness-0 invert mb-3" alt="Footer Logo">
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
        </div>
@endsection
