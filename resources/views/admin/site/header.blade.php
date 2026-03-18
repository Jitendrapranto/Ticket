@extends('admin.dashboard')

@section('admin_content')
<div x-data="{
        navLinks: Object.values({{ json_encode(old('nav_links', $header->nav_links ?? [['label'=>'HOME','url'=>'/'],['label'=>'EVENTS','url'=>'/events'],['label'=>'GALLERY','url'=>'/gallery'],['label'=>'ABOUT','url'=>'/about'],['label'=>'CONTACT','url'=>'/contact']])) }} || {}),
        logoPreview: '{{ $header && $header->logo_path ? (str_starts_with($header->logo_path, 'site/') ? asset('storage/'.$header->logo_path) : asset($header->logo_path)) : asset('Blue_Simple_Technology_Logo.png') }}',
    }" class="px-8 py-8 flex-1 animate-fadeIn">

    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="font-outfit text-2xl font-black text-dark tracking-tight">Header Settings</h2>
            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">Site Settings — Header Configuration</p>
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

            <form action="{{ route('admin.site.header.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Main Form -->
                    <div class="lg:col-span-2 space-y-6">

                        <!-- Logo Section -->
                        <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100 space-y-6">
                            <h3 class="font-outfit font-black text-dark text-lg border-b border-slate-100 pb-4">
                                <i class="fas fa-image text-primary mr-2"></i> Logo
                            </h3>
                            <div class="flex items-center gap-6">
                                <div class="w-24 h-24 rounded-2xl bg-slate-50 border-2 border-dashed border-slate-200 flex items-center justify-center overflow-hidden">
                                    <img loading="lazy" :src="logoPreview" class="max-w-full max-h-full object-contain" alt="Logo Preview">
                                </div>
                                <div class="flex-1">
                                    <label class="block text-xs font-black text-dark uppercase tracking-widest mb-2">Upload New Logo</label>
                                    <input type="file" name="logo" accept="image/*"
                                           @change="logoPreview = URL.createObjectURL($event.target.files[0])"
                                           class="w-full text-sm file:mr-4 file:py-2.5 file:px-5 file:rounded-xl file:border-0 file:text-xs file:font-black file:bg-primary/10 file:text-primary hover:file:bg-primary/20 file:tracking-widest file:uppercase cursor-pointer">
                                    <p class="text-[10px] text-slate-400 mt-2 font-medium">Recommended: PNG with transparent background. Max 5MB.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Search & Auth Text -->
                        <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100 space-y-6">
                            <h3 class="font-outfit font-black text-dark text-lg border-b border-slate-100 pb-4">
                                <i class="fas fa-text-height text-primary mr-2"></i> Header Content
                            </h3>
                            <div>
                                <label class="block text-xs font-black text-dark uppercase tracking-widest mb-2">Search Placeholder <span class="text-red-500">*</span></label>
                                <input type="text" name="search_placeholder"
                                       value="{{ old('search_placeholder', $header->search_placeholder ?? 'Search for Movies, Events, Plays, Sports and Activities') }}"
                                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                            </div>
                            <div class="grid grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-xs font-black text-dark uppercase tracking-widest mb-2">Login Button Text <span class="text-red-500">*</span></label>
                                    <input type="text" name="login_text"
                                           value="{{ old('login_text', $header->login_text ?? 'Login') }}"
                                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                                </div>
                                <div>
                                    <label class="block text-xs font-black text-dark uppercase tracking-widest mb-2">Signup Button Text <span class="text-red-500">*</span></label>
                                    <input type="text" name="signup_text"
                                           value="{{ old('signup_text', $header->signup_text ?? 'Sign Up') }}"
                                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                                </div>
                            </div>
                        </div>

                        <!-- Navigation Links -->
                        <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100 space-y-6">
                            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                                <h3 class="font-outfit font-black text-dark text-lg">
                                    <i class="fas fa-link text-primary mr-2"></i> Navigation Links
                                </h3>
                                <button type="button" @click="navLinks = [...navLinks, {label:'', url:''}]"
                                        class="flex items-center gap-2 bg-primary/10 text-primary px-4 py-2 rounded-xl text-xs font-black tracking-widest hover:bg-primary/20 transition-all uppercase">
                                    <i class="fas fa-plus"></i> Add Link
                                </button>
                            </div>

                            <template x-for="(link, index) in navLinks" :key="index">
                                <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                                    <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center text-primary text-xs font-black" x-text="index + 1"></div>
                                    <div class="flex-1 grid grid-cols-2 gap-3">
                                        <div>
                                            <input type="text" :name="'nav_links[' + index + '][label]'" x-model="link.label" placeholder="Label (e.g. HOME)"
                                                   class="w-full px-3 py-2.5 bg-white border border-slate-200 rounded-xl text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-primary/30">
                                        </div>
                                        <div>
                                            <input type="text" :name="'nav_links[' + index + '][url]'" x-model="link.url" placeholder="URL (e.g. /events)"
                                                   class="w-full px-3 py-2.5 bg-white border border-slate-200 rounded-xl text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-primary/30">
                                        </div>
                                    </div>
                                    <button type="button" @click="navLinks.splice(index, 1)"
                                            class="w-9 h-9 bg-red-50 text-red-400 rounded-xl flex items-center justify-center hover:bg-red-100 hover:text-red-600 transition-all">
                                        <i class="fas fa-trash-alt text-xs"></i>
                                    </button>
                                </div>
                            </template>

                            <div x-show="navLinks.length === 0" class="text-center py-8 text-slate-400">
                                <i class="fas fa-link text-3xl mb-3 block opacity-30"></i>
                                <p class="text-sm font-semibold">No navigation links yet. Click "Add Link" to start.</p>
                            </div>
                        </div>

                        <!-- Save Button -->
                        <button type="submit" class="w-full py-4 bg-primary text-white font-black text-sm tracking-widest uppercase rounded-2xl hover:bg-secondary transition-all shadow-lg shadow-primary/20">
                            <i class="fas fa-save mr-2"></i> Save Header Settings
                        </button>
                    </div>

                    <!-- Live Preview -->
                    <div class="lg:col-span-1">
                        <div class="sticky top-28">
                            <p class="text-xs font-black text-dark uppercase tracking-widest mb-4">Live Preview</p>
                            <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-100">
                                <!-- Top Row Preview -->
                                <div class="px-4 py-3 flex items-center justify-between border-b border-slate-100">
                                    <img loading="lazy" :src="logoPreview" class="h-8 w-auto object-contain" alt="Logo">
                                    <div class="flex items-center gap-2">
                                        <span class="text-[10px] font-semibold text-slate-500">Login</span>
                                        <span class="bg-primary text-white text-[9px] font-bold px-3 py-1 rounded-lg">Sign Up</span>
                                    </div>
                                </div>
                                <!-- Nav Preview -->
                                <div class="px-4 py-2 bg-slate-50/80 flex items-center gap-4 overflow-x-auto">
                                    <template x-for="(link, idx) in navLinks" :key="idx">
                                        <span class="text-[9px] font-bold text-slate-500 uppercase tracking-wider whitespace-nowrap" x-text="link.label || 'LINK'"></span>
                                    </template>
                                </div>
                            </div>

                            <div class="mt-4 bg-white rounded-2xl p-4 shadow-sm border border-slate-100">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Total Nav Links</p>
                                <p class="text-2xl font-black text-primary" x-text="navLinks.length"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
@endsection
