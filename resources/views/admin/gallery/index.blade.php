@extends('admin.dashboard')

@section('admin_content')
<div x-data="{
    deleteModal: false,
    deleteUrl: '',
    imageTitle: '',
    confirmDelete(url, title) {
        this.deleteUrl = url;
        this.imageTitle = title;
        this.deleteModal = true;
    },
    homepageModal: false,
    homepageUrl: '',
    homepageTitle: '',
    homepageAction: '',
    confirmHomepage(url, title, currentlyOnHomepage) {
        this.homepageUrl = url;
        this.homepageTitle = title;
        this.homepageAction = currentlyOnHomepage ? 'remove from' : 'add to';
        this.homepageModal = true;
    }
}">

    

    <div class="animate-fadeIn">


        <header class="mb-8 flex items-center justify-between shrink-0">
            <div>
                <h2 class="font-outfit text-xl font-black text-dark tracking-tight">Gallery Hub</h2>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Manage Visual Assets</p>
            </div>
            <div class="flex items-center gap-4">
                <span class="px-4 py-1.5 bg-primary/5 rounded-lg text-[10px] font-black text-primary tracking-widest uppercase">
                    {{ $images->total() }} Dynamic Assets
                </span>
                <a href="{{ route('admin.gallery.images.create') }}" class="bg-primary text-white px-6 py-2.5 rounded-xl text-xs font-black tracking-widest hover:bg-dark transition-all uppercase shadow-lg shadow-primary/20">
                    <i class="fas fa-upload mr-2"></i> Upload Image
                </a>
            </div>
        </header>

        <main class="p-8 flex-1">
            @if(false)
                <!-- Success Toast -->
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
                     x-transition:enter="transition ease-out duration-500"
                     x-transition:enter-start="translate-x-full opacity-0"
                     x-transition:enter-end="translate-x-0 opacity-100"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-end="translate-x-full opacity-0"
                     class="fixed top-8 right-8 z-[100] max-w-sm w-full font-plus">
                    <div class="bg-secondary rounded-[2rem] shadow-2xl p-6 flex items-center gap-6 relative overflow-hidden text-white border border-white/5">
                        <div class="absolute left-0 top-0 bottom-0 w-2 bg-primary"></div>
                        <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center text-xl shadow-inner"><i class="fas fa-check-circle"></i></div>
                        <div class="flex-1 text-left">
                            <h4 class="text-sm font-black tracking-tight uppercase">Registry Updated</h4>
                            <p class="text-[11px] text-white/60 mt-0.5 leading-tight">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @forelse($images as $image)
                    <div class="bg-white rounded-[2.5rem] shadow-premium border border-slate-50 overflow-hidden group hover:-translate-y-2 transition-all duration-500">
                        <div class="aspect-square relative overflow-hidden bg-slate-100">
                            <img loading="lazy" src="{{ str_starts_with($image->image_path, 'http') ? $image->image_path : asset('storage/' . $image->image_path) }}" alt="{{ $image->title }}" class="w-full h-full object-cover transition-transform duration-[1.5s] group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-dark/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end p-8">
                                <span class="bg-primary/90 backdrop-blur-md px-4 py-1.5 rounded-lg text-white font-black text-[9px] tracking-widest uppercase">
                                    {{ $image->category->name }}
                                </span>
                            </div>
                            @if($image->show_on_homepage)
                            <div class="absolute top-4 left-4">
                                <span class="bg-green-500 text-white px-3 py-1.5 rounded-xl text-[9px] font-black tracking-widest uppercase shadow-lg shadow-green-500/30 flex items-center gap-1.5">
                                    <i class="fas fa-home text-[8px]"></i> ON HOMEPAGE
                                </span>
                            </div>
                            @endif
                        </div>
                        <div class="p-8 flex items-center justify-between">
                            <div class="flex-1 min-w-0 mr-4">
                                <h3 class="font-outfit text-lg font-black text-dark tracking-tight truncate">{{ $image->title }}</h3>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">Uploaded {{ $image->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <button @click="confirmHomepage('{{ route('admin.gallery.images.toggle-homepage', $image) }}', '{{ $image->title }}', {{ $image->show_on_homepage ? 'true' : 'false' }})"
                                        class="w-12 h-12 flex items-center justify-center rounded-2xl {{ $image->show_on_homepage ? 'bg-green-50 text-green-500 hover:bg-green-500' : 'bg-blue-50 text-blue-500 hover:bg-blue-500' }} hover:text-white transition-all shadow-sm"
                                        title="{{ $image->show_on_homepage ? 'Remove from Homepage' : 'Add to Homepage' }}">
                                    <i class="fas {{ $image->show_on_homepage ? 'fa-home' : 'fa-plus-circle' }} text-sm"></i>
                                </button>
                                <a href="{{ route('admin.gallery.images.edit', $image) }}"
                                   class="w-12 h-12 flex items-center justify-center rounded-2xl bg-amber-50 text-amber-500 hover:bg-amber-500 hover:text-white transition-all shadow-sm"
                                   title="Edit Asset">
                                    <i class="fas fa-edit text-sm"></i>
                                </a>
                                <button @click="confirmDelete('{{ route('admin.gallery.images.destroy', $image) }}', '{{ $image->title }}')"
                                    class="w-12 h-12 flex items-center justify-center rounded-2xl bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-all shadow-sm">
                                    <i class="fas fa-trash-alt text-sm"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-32 text-center bg-white rounded-[3rem] shadow-premium border border-slate-50">
                        <div class="w-24 h-24 bg-slate-50 rounded-[2rem] flex items-center justify-center text-slate-200 mx-auto mb-8 animate-pulse">
                            <i class="fas fa-images text-4xl"></i>
                        </div>
                        <h3 class="font-outfit text-2xl font-black text-dark tracking-tight">The Gallery is Quiet</h3>
                        <p class="text-slate-400 text-sm font-medium mt-3">Start by uploading some moments to showcase to the world.</p>
                        <a href="{{ route('admin.gallery.images.create') }}" class="mt-10 inline-flex items-center gap-3 bg-primary text-white px-10 py-4 rounded-2xl font-black text-xs tracking-widest uppercase hover:bg-dark transition-all shadow-xl shadow-primary/20">
                            <i class="fas fa-plus"></i> Begin Exhibition
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-16">
                {{ $images->links() }}
            </div>
        </main>

        <!-- Delete Confirmation Modal -->
        <div x-show="deleteModal"
             x-cloak
             class="fixed inset-0 z-[150] flex items-center justify-center px-4 overflow-hidden"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">

            <div class="absolute inset-0 bg-dark/60 backdrop-blur-sm" @click="deleteModal = false"></div>

            <div class="bg-white w-full max-w-md rounded-[2.5rem] shadow-2xl relative z-10 overflow-hidden">
                <div class="p-10 text-center">
                    <div class="w-20 h-20 bg-red-50 text-red-500 rounded-3xl flex items-center justify-center text-3xl mx-auto mb-8 shadow-inner animate-bounce">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>

                    <h3 class="font-outfit text-2xl font-black text-dark tracking-tight mb-4">De-register Asset?</h3>
                    <p class="text-slate-400 text-sm font-medium leading-relaxed mb-8">
                        You are about to remove <span class="text-dark font-bold" x-text="imageTitle"></span> from the visual exhibition. This cannot be undone.
                    </p>

                    <div class="flex items-center gap-4">
                        <button @click="deleteModal = false" class="flex-1 py-4 rounded-2xl bg-slate-50 text-slate-500 font-black text-xs tracking-widest hover:bg-slate-100 transition-all uppercase">
                            Cancel
                        </button>
                        <form :action="deleteUrl" method="POST" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full py-4 rounded-2xl bg-red-500 text-white font-black text-xs tracking-widest hover:bg-red-600 transition-all uppercase shadow-lg shadow-red-500/20">
                                Yes, Remove
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Homepage Toggle Confirmation Modal -->
        <div x-show="homepageModal"
             x-cloak
             class="fixed inset-0 z-[150] flex items-center justify-center px-4 overflow-hidden"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">

            <div class="absolute inset-0 bg-dark/60 backdrop-blur-sm" @click="homepageModal = false"></div>

            <div class="bg-white w-full max-w-md rounded-[2.5rem] shadow-2xl relative z-10 overflow-hidden"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-90"
                 x-transition:enter-end="opacity-100 scale-100">
                <div class="p-10 text-center">
                    <div class="w-20 h-20 rounded-3xl flex items-center justify-center text-3xl mx-auto mb-8"
                         :class="homepageAction === 'add to' ? 'bg-blue-50 text-blue-500' : 'bg-amber-50 text-amber-500'">
                        <i class="fas" :class="homepageAction === 'add to' ? 'fa-home' : 'fa-eye-slash'"></i>
                    </div>

                    <h3 class="font-outfit text-2xl font-black text-dark tracking-tight mb-4">
                        <span x-text="homepageAction === 'add to' ? 'Add to Homepage?' : 'Remove from Homepage?'"></span>
                    </h3>
                    <p class="text-slate-400 text-sm font-medium leading-relaxed mb-8">
                        You are about to <span class="text-dark font-bold" x-text="homepageAction"></span> the homepage gallery:
                        <span class="text-primary font-bold" x-text="homepageTitle"></span>
                    </p>

                    <div class="flex items-center gap-4">
                        <button @click="homepageModal = false" class="flex-1 py-4 rounded-2xl bg-slate-50 text-slate-500 font-black text-xs tracking-widest hover:bg-slate-100 transition-all uppercase">
                            Cancel
                        </button>
                        <form :action="homepageUrl" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full py-4 rounded-2xl font-black text-xs tracking-widest transition-all uppercase shadow-lg"
                                    :class="homepageAction === 'add to' ? 'bg-primary text-white hover:bg-secondary shadow-primary/20' : 'bg-amber-500 text-white hover:bg-amber-600 shadow-amber-500/20'">
                                <span x-text="homepageAction === 'add to' ? 'Yes, Add' : 'Yes, Remove'"></span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
        .pagination { display: flex; justify-content: center; gap: 0.5rem; }
        .page-item .page-link { width: 3rem; height: 3rem; display: flex; align-items: center; justify-content: center; border-radius: 1rem; background: white; color: #64748b; font-weight: 700; font-size: 0.75rem; border: 1px solid #f1f5f9; transition: all 0.3s; }
        .page-item.active .page-link { background: #520C6B; color: white; border-color: #520C6B; box-shadow: 0 10px 20px -5px rgba(82, 12, 107, 0.3); }
        .page-item:hover .page-link { background: #520C6B; color: white; border-color: #520C6B; }
    </style>

</div>
@endsection
