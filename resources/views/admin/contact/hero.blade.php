@extends('admin.dashboard')

@section('admin_content')
<div>

    

    <div class="animate-fadeIn">
        <header class="mb-8 flex items-center justify-between shrink-0">
            <div>
                <h2 class="font-outfit text-xl font-black text-dark tracking-tight">Contact Hero Section</h2>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest"><a href="#" class="hover:text-primary">Contact Page</a> / Edit Hero</p>
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

            <form action="{{ route('admin.contact.hero.update') }}" method="POST" class="max-w-3xl mx-auto bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
                @csrf
                @method('PUT')

                <div class="p-10 space-y-8">

                    <div>
                        <h3 class="font-outfit text-lg font-black text-[#1e293b] mb-6 border-b border-slate-100 pb-2"><i class="fas fa-image mr-2 text-primary"></i> Hero Content</h3>

                        <div class="space-y-6">
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Badge Text</label>
                                <input type="text" name="badge_text" value="{{ old('badge_text', $hero->badge_text) }}" class="w-full bg-slate-50 border border-slate-200 text-dark rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all font-bold">
                                @error('badge_text') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Title (White Part)</label>
                                    <input type="text" name="title_main" value="{{ old('title_main', $hero->title_main) }}" class="w-full bg-slate-50 border border-slate-200 text-dark rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all font-bold">
                                    @error('title_main') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Title (Highlighted Part)</label>
                                    <input type="text" name="title_accent" value="{{ old('title_accent', $hero->title_accent) }}" class="w-full bg-slate-50 border border-slate-200 text-primary rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all font-black">
                                    @error('title_accent') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Subtitle / Description</label>
                                <textarea name="subtitle" rows="4" class="w-full bg-slate-50 border border-slate-200 text-dark rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all font-medium text-sm">{{ old('subtitle', $hero->subtitle) }}</textarea>
                                @error('subtitle') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                </div>

                <div class="bg-slate-50 p-8 border-t border-slate-100 flex justify-end">
                    <button type="submit" class="bg-primary text-white px-8 py-4 rounded-xl font-black tracking-widest uppercase hover:bg-primary-dark transition-all shadow-lg hover:shadow-primary/20">
                        Update Hero Section
                    </button>
                </div>
            </form>
        </main>
    </div>

</div>
@endsection
