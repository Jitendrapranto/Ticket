@extends('admin.dashboard')

@section('admin_content')
<div x-data="{
    deleteModal: false,
    deleteUrl: '',
    categoryName: '',
    confirmDelete(url, name) {
        this.deleteUrl = url;
        this.categoryName = name;
        this.deleteModal = true;
    }
}">
    <div class="animate-fadeIn">


        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8 shrink-0">
            <div>
                <h1 class="font-outfit text-4xl font-black text-dark tracking-tighter mb-1">System <span class="bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent">Categories.</span></h1>
                <p class="text-slate-400 font-bold uppercase text-[9px] tracking-[0.4em]">Operations Hub • Data Classification</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.categories.create') }}" class="bg-primary text-white px-8 py-3 rounded-2xl text-[10px] font-black tracking-widest hover:bg-dark transition-all uppercase shadow-lg shadow-primary/20">
                    <i class="fas fa-plus mr-2"></i> Add Category
                </a>
            </div>
        </div>

        <!-- Categories Table -->
        <div class="bg-white rounded-[2.5rem] shadow-premium border border-slate-50 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50/50 text-[10px] font-black tracking-widest text-slate-400 uppercase border-b border-slate-100">
                            <th class="px-8 py-6">Identity</th>
                            <th class="px-8 py-6">Associated Slug</th>
                            <th class="px-8 py-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($categories as $category)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-2xl bg-primary/5 text-primary flex items-center justify-center text-lg group-hover:bg-primary group-hover:text-white transition-all shadow-sm">
                                        <i class="{{ $category->icon ?? 'fas fa-tags' }}"></i>
                                    </div>
                                    <div>
                                        <p class="font-black text-dark tracking-tight">{{ $category->name }}</p>
                                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">Event Category</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <span class="px-4 py-1.5 bg-slate-100 rounded-xl text-[10px] font-black text-dark tracking-widest uppercase">/{{ $category->slug }}</span>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <div class="flex justify-end gap-3 items-center">
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-all shadow-sm">
                                        <i class="fas fa-edit text-xs"></i>
                                    </a>
                                    <button @click="confirmDelete('{{ route('admin.categories.destroy', $category) }}', '{{ $category->name }}')"
                                            class="w-10 h-10 flex items-center justify-center rounded-xl bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-all shadow-sm">
                                        <i class="fas fa-trash-alt text-xs"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($categories->hasPages())
            <div class="px-8 py-6 bg-slate-50/30 border-t border-slate-100">
                {{ $categories->links() }}
            </div>
            @endif
        </div>
    </div>

    <!-- Delete Modal -->
    <div x-show="deleteModal" x-cloak class="fixed inset-0 z-[150] flex items-center justify-center px-4">
        <div class="absolute inset-0 bg-dark/60 backdrop-blur-sm" @click="deleteModal = false"></div>
        <div class="bg-white w-full max-w-sm rounded-[2.5rem] shadow-2xl relative z-10 p-10 text-center animate-fadeInUp">
            <div class="w-20 h-20 bg-red-50 text-red-500 rounded-3xl flex items-center justify-center text-3xl mx-auto mb-8 animate-bounce">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h3 class="font-outfit text-2xl font-black text-dark mb-4">Confirm Deletion</h3>
            <p class="text-slate-400 text-sm mb-8">Are you sure you want to remove <span class="font-bold text-dark" x-text="categoryName"></span>?</p>
            <div class="flex gap-4">
                <button @click="deleteModal = false" class="flex-1 py-4 rounded-2xl bg-slate-50 text-slate-500 font-black uppercase tracking-widest text-[10px]">Cancel</button>
                <form :action="deleteUrl" method="POST" class="flex-1">
                    @csrf @method('DELETE')
                    <button type="submit" class="w-full py-4 rounded-2xl bg-red-500 text-white font-black uppercase tracking-widest text-[10px]">Yes, Remove</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
