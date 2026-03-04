<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery Mosaic | Ticket Kinun Admin</title>
    <style>html { visibility: hidden; opacity: 0; } html.ready { visibility: visible; opacity: 1; transition: opacity 0.15s ease-in; }</style>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { primary: '#520C6B', secondary: '#21032B', accent: '#FF7D52', dark: '#0F172A' },
                    fontFamily: { outfit: ['Outfit', 'sans-serif'], plus: ['"Plus Jakarta Sans"', 'sans-serif'] },
                }
            }
        }
    </script>
    <script>document.addEventListener('DOMContentLoaded', () => document.documentElement.classList.add('ready')); setTimeout(() => document.documentElement.classList.add('ready'), 100);</script>
</head>
<body class="bg-[#F1F5F9] font-plus"
      x-data="{
          deleteModal: false,
          deleteUrl: '',
          itemName: '',
          confirmDelete(url, name) {
              this.deleteUrl = url;
              this.itemName = name;
              this.deleteModal = true;
          }
      }">
    @include('admin.sidebar')

    <div class="lg:ml-72 min-h-screen flex flex-col">
        <!-- Header -->
        <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-100 flex items-center justify-between px-8 sticky top-0 z-40">
            <div>
                <h2 class="font-outfit text-xl font-black text-dark tracking-tight">Gallery Mosaic</h2>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Homepage Gallery Section</p>
            </div>
            <a href="{{ route('admin.gallery.images.index') }}" class="flex items-center gap-2 bg-slate-100 text-slate-600 px-5 py-2.5 rounded-xl text-xs font-black tracking-widest hover:bg-slate-200 transition-all uppercase">
                <i class="fas fa-images"></i> Full Gallery
            </a>
        </header>

        <!-- Toast -->
        @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-[-10px]"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-end="opacity-0 translate-y-[-10px]"
             class="fixed top-6 right-6 z-[9999] flex items-center gap-4 bg-white border border-green-100 shadow-2xl shadow-green-500/10 rounded-2xl px-6 py-4 max-w-sm">
            <div class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center shrink-0">
                <i class="fas fa-check-circle text-green-500 text-lg"></i>
            </div>
            <div>
                <p class="font-black text-dark text-sm">Success!</p>
                <p class="text-slate-500 text-xs font-medium mt-0.5">{{ session('success') }}</p>
            </div>
            <button @click="show = false" class="ml-2 text-slate-300 hover:text-slate-500"><i class="fas fa-times text-xs"></i></button>
        </div>
        @endif

        <main class="p-8 flex-1 space-y-8">
            @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-2xl p-5 flex items-start gap-4">
                <i class="fas fa-exclamation-circle text-red-500 mt-0.5"></i>
                <ul class="text-sm text-red-600 font-semibold space-y-1">
                    @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
                </ul>
            </div>
            @endif

            <!-- Section Settings -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 flex items-center gap-4">
                    <div class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center">
                        <i class="fas fa-edit text-primary text-sm"></i>
                    </div>
                    <div>
                        <h3 class="font-outfit font-black text-dark text-base">Section Content</h3>
                        <p class="text-[11px] text-slate-400 font-medium mt-0.5">Edit the heading, description and button that appear above the mosaic</p>
                    </div>
                </div>
                <form action="{{ route('admin.home.mosaic.update-section') }}" method="POST" class="p-8">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-black text-dark uppercase tracking-widest mb-2">Section Title <span class="text-red-500">*</span></label>
                            <input type="text" name="title" value="{{ old('title', $section->title ?? 'Moments That Stick Forever') }}"
                                   class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-black text-dark uppercase tracking-widest mb-2">Description</label>
                            <textarea name="description" rows="2"
                                      class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary resize-none">{{ old('description', $section->description ?? '') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-black text-dark uppercase tracking-widest mb-2">Button Label <span class="text-red-500">*</span></label>
                            <input type="text" name="button_text" value="{{ old('button_text', $section->button_text ?? 'OPEN GALLERY') }}"
                                   class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-dark uppercase tracking-widest mb-2">Button URL <span class="text-red-500">*</span></label>
                            <input type="text" name="button_url" value="{{ old('button_url', $section->button_url ?? '/gallery') }}"
                                   class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="px-8 py-3 bg-primary text-white font-black text-xs tracking-widest uppercase rounded-xl hover:bg-secondary transition-all shadow-lg shadow-primary/20">
                            <i class="fas fa-save mr-2"></i> Save Section
                        </button>
                    </div>
                </form>
            </div>

            <!-- Add New Image -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 flex items-center gap-4">
                    <div class="w-10 h-10 bg-accent/10 rounded-xl flex items-center justify-center">
                        <i class="fas fa-plus text-accent text-sm"></i>
                    </div>
                    <div>
                        <h3 class="font-outfit font-black text-dark text-base">Add Mosaic Image</h3>
                        <p class="text-[11px] text-slate-400 font-medium mt-0.5">Upload a new photo to appear in the homepage mosaic grid</p>
                    </div>
                </div>
                <form action="{{ route('admin.home.mosaic.store-image') }}" method="POST" enctype="multipart/form-data" class="p-8"
                      x-data="{ preview: null, fileName: '' }">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Upload Area -->
                        <div class="md:col-span-1">
                            <label class="block text-xs font-black text-dark uppercase tracking-widest mb-2">Photo <span class="text-red-500">*</span></label>
                            <label class="relative block border-2 border-dashed border-slate-200 rounded-2xl overflow-hidden cursor-pointer hover:border-primary/40 transition-all" style="height: 180px;">
                                <input type="file" name="image" accept="image/*" class="sr-only"
                                       @change="
                                           let f = $event.target.files[0];
                                           if(f) {
                                               fileName = f.name;
                                               let r = new FileReader();
                                               r.onload = e => preview = e.target.result;
                                               r.readAsDataURL(f);
                                           }">
                                <template x-if="preview">
                                    <img :src="preview" class="w-full h-full object-cover absolute inset-0">
                                </template>
                                <div x-show="!preview" class="absolute inset-0 flex flex-col items-center justify-center gap-2 p-4">
                                    <div class="w-12 h-12 bg-primary/5 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-cloud-upload-alt text-primary text-xl"></i>
                                    </div>
                                    <p class="text-xs font-bold text-slate-500 text-center">Click to upload</p>
                                    <p class="text-[10px] text-slate-400">Max 5MB · JPG, PNG, WEBP</p>
                                </div>
                                <div x-show="preview" class="absolute bottom-2 left-2 right-2 bg-black/50 rounded-lg px-3 py-1.5">
                                    <p class="text-[10px] text-white font-medium truncate" x-text="fileName"></p>
                                </div>
                            </label>
                        </div>

                        <!-- Fields -->
                        <div class="md:col-span-2 space-y-5">
                            <div>
                                <label class="block text-xs font-black text-dark uppercase tracking-widest mb-2">Caption</label>
                                <input type="text" name="caption" placeholder="e.g. Neon World Tour Final"
                                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-black text-dark uppercase tracking-widest mb-2">Grid Span</label>
                                    <select name="span" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-primary/30">
                                        <option value="1x1">1×1 — Standard</option>
                                        <option value="2x1">2×1 — Wide</option>
                                        <option value="1x2">1×2 — Tall</option>
                                        <option value="2x2">2×2 — Large</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-black text-dark uppercase tracking-widest mb-2">Sort Order</label>
                                    <input type="number" name="sort_order" value="0" min="0"
                                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-primary/30">
                                </div>
                            </div>
                            <button type="submit" class="px-8 py-3 bg-accent text-white font-black text-xs tracking-widest uppercase rounded-xl hover:bg-dark transition-all shadow-lg shadow-accent/20">
                                <i class="fas fa-plus mr-2"></i> Add to Mosaic
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Mosaic Images Grid -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-slate-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-th text-slate-500 text-sm"></i>
                        </div>
                        <div>
                            <h3 class="font-outfit font-black text-dark text-base">Mosaic Images</h3>
                            <p class="text-[11px] text-slate-400 font-medium mt-0.5">{{ $images->count() }} image{{ $images->count() !== 1 ? 's' : '' }} in the homepage mosaic</p>
                        </div>
                    </div>
                </div>

                @if($images->count())
                <div class="p-8 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
                    @foreach($images as $image)
                    <div class="group relative rounded-2xl overflow-hidden bg-slate-100 aspect-video">
                        <img src="{{ $image->image_url }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy">

                        <!-- Overlay -->
                        <div class="absolute inset-0 bg-dark/50 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center gap-3 p-4">
                            @if($image->caption)
                            <p class="text-white font-black text-xs text-center line-clamp-2">{{ $image->caption }}</p>
                            @endif
                            <button @click="confirmDelete('{{ route('admin.home.mosaic.destroy-image', $image) }}', '{{ addslashes($image->caption ?? 'this image') }}')"
                                    class="px-4 py-2 bg-red-500 text-white rounded-xl text-[10px] font-black tracking-widest hover:bg-red-600 transition-all">
                                <i class="fas fa-trash-alt mr-1"></i> Delete
                            </button>
                        </div>

                        <!-- Span badge -->
                        <div class="absolute top-2 left-2 bg-black/60 text-white text-[9px] font-black px-2 py-1 rounded-lg tracking-wider">
                            {{ $image->span }}
                        </div>

                        <!-- Sort order badge -->
                        <div class="absolute top-2 right-2 bg-primary/80 text-white text-[9px] font-black w-6 h-6 rounded-lg flex items-center justify-center">
                            {{ $image->sort_order }}
                        </div>

                        <!-- Active badge -->
                        @if(!$image->is_active)
                        <div class="absolute bottom-2 right-2 bg-slate-500/80 text-white text-[9px] font-black px-2 py-1 rounded-lg">Hidden</div>
                        @endif
                    </div>
                    @endforeach
                </div>
                @else
                <div class="py-20 flex flex-col items-center gap-4 text-center">
                    <div class="w-20 h-20 bg-slate-50 rounded-3xl flex items-center justify-center">
                        <i class="fas fa-image text-slate-300 text-3xl"></i>
                    </div>
                    <p class="font-black text-dark text-lg">No Images Yet</p>
                    <p class="text-slate-400 text-sm font-medium max-w-xs">Add your first mosaic image using the form above.</p>
                </div>
                @endif
            </div>
        </main>
    </div>

    <!-- Delete Confirmation Modal -->
    <div x-show="deleteModal" x-cloak
         class="fixed inset-0 z-[999] flex items-center justify-center p-4"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-dark/60 backdrop-blur-sm" @click="deleteModal = false"></div>
        <div class="relative bg-white rounded-3xl p-8 max-w-md w-full shadow-2xl"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-90"
             x-transition:enter-end="opacity-100 scale-100">
            <div class="flex justify-center mb-6">
                <div class="w-16 h-16 bg-red-50 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-trash-alt text-red-500 text-2xl"></i>
                </div>
            </div>
            <h3 class="font-outfit font-black text-dark text-xl text-center mb-2">Delete Image?</h3>
            <p class="text-slate-500 text-sm text-center mb-8">
                You are about to permanently remove <span class="font-black text-dark" x-text="'&quot;' + itemName + '&quot;'"></span> from the homepage mosaic. This cannot be undone.
            </p>
            <div class="flex gap-3">
                <button @click="deleteModal = false" class="flex-1 py-3.5 bg-slate-100 text-slate-600 font-black text-xs tracking-widest uppercase rounded-2xl hover:bg-slate-200 transition-all">
                    Cancel
                </button>
                <form :action="deleteUrl" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full py-3.5 bg-red-500 text-white font-black text-xs tracking-widest uppercase rounded-2xl hover:bg-red-600 transition-all shadow-lg shadow-red-500/20">
                        <i class="fas fa-trash-alt mr-2"></i> Yes, Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
