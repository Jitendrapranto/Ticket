@extends('layouts.organizer')

@section('title', 'Create New Event')
@section('header_title', 'Create New Event')

@section('content')
<div class="p-8 animate-fadeInUp">
    <form action="{{ route('organizer.events.store') }}" method="POST" enctype="multipart/form-data" x-data="{
        tickets: [{ name: 'General Admission', price: '25', quantity: '100' }],
        artists: [],
        formFields: [],
        addTicket() { this.tickets.push({ name: '', price: '', quantity: '' }) },
        removeTicket(index) { this.tickets.splice(index, 1) },
        addArtist() { this.artists.push({ name: '', role: '', image: '', preview: null, imageName: '' }) },
        removeArtist(index) { this.artists.splice(index, 1) },
        addFormField() { this.formFields.push({ label: '', type: 'text', options: [], is_required: false }) },
        removeFormField(index) { this.formFields.splice(index, 1) },
        addOption(fieldIndex) { this.formFields[fieldIndex].options.push('') },
        removeOption(fieldIndex, optIndex) { this.formFields[fieldIndex].options.splice(optIndex, 1) }
    }">
        @csrf

        <!-- Stats Overview Placeholder / Action Bar -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
            <div>
                <h3 class="font-outfit text-xl font-black text-dark tracking-tight">Experience Configuration</h3>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">Launch a new experience or save it for later review.</p>
            </div>
            <div class="flex items-center gap-4">
                <button type="submit" name="status" value="Draft" class="px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-primary transition-all">Save as Draft</button>
                <button type="submit" name="status" value="Live" class="bg-primary text-white px-8 py-3.5 rounded-xl text-[10px] font-black tracking-widest hover:bg-secondary transition-all uppercase shadow-xl shadow-primary/20 flex items-center gap-3">
                    <i class="fas fa-rocket text-[10px]"></i> Launch Event
                </button>
            </div>
        </div>

        @if(session('error') || $errors->any())
            <div class="mb-10 bg-red-50 border border-red-100 rounded-2xl p-6 text-red-600">
                <div class="flex items-center gap-4 mb-3">
                    <i class="fas fa-exclamation-triangle"></i>
                    <h4 class="text-sm font-black uppercase tracking-tight">Action Required</h4>
                </div>
                <ul class="space-y-1">
                    @foreach ($errors->all() as $error)
                        <li class="text-[11px] font-medium">• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="space-y-8 max-w-5xl">
            <!-- Basic Information -->
            <div class="bg-white rounded-[2.5rem] p-10 shadow-premium border border-slate-50">
                <div class="flex items-center gap-4 mb-10">
                    <div class="w-12 h-12 rounded-2xl bg-primary/5 text-primary flex items-center justify-center text-xl">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <h3 class="font-outfit text-xl font-black text-dark tracking-tight">Basic Information</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Event Code</label>
                        <input type="text" name="event_code" value="Auto-generated on save" readonly class="w-full bg-slate-50/50 border border-slate-100 rounded-2xl py-4 px-6 outline-none text-primary font-black text-sm cursor-not-allowed tracking-widest shadow-inner">
                    </div>
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Event Name</label>
                        <input type="text" name="title" required class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-4 px-6 outline-none focus:border-primary/30 focus:bg-white transition-all text-dark font-bold text-sm" placeholder="e.g. Summer Music Festival">
                    </div>
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Organizer Name</label>
                        <input type="text" name="organizer" value="{{ Auth::user()->name }}" readonly class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-4 px-6 outline-none text-slate-400 font-bold text-sm cursor-not-allowed shadow-inner">
                    </div>
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Category</label>
                        <select name="category_id" required class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-4 px-6 outline-none focus:border-primary/30 focus:bg-white transition-all text-dark font-bold text-sm appearance-none cursor-pointer">
                            <option value="" disabled selected>Select event category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Venue Name</label>
                        <input type="text" name="venue_name" class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-4 px-6 outline-none focus:border-primary/30 focus:bg-white transition-all text-dark font-bold text-sm" placeholder="e.g. Grand Ballroom">
                    </div>
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">City / Area</label>
                        <input type="text" name="location" required class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-4 px-6 outline-none focus:border-primary/30 focus:bg-white transition-all text-dark font-bold text-sm" placeholder="e.g. Dhaka, Bangladesh">
                    </div>

                    <div class="md:col-span-2 space-y-3">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Event Description</label>
                        <textarea name="description" rows="5" class="w-full bg-slate-50 border border-slate-100 rounded-[2rem] p-8 outline-none focus:border-primary/30 focus:bg-white transition-all text-dark font-medium text-sm leading-relaxed" placeholder="Provide a detailed overview..."></textarea>
                    </div>
                </div>
            </div>

            <!-- Media Section -->
            <div class="bg-white rounded-[2.5rem] p-10 shadow-premium border border-slate-50" x-data="{ preview: null }">
                <div class="flex items-center gap-4 mb-10">
                    <div class="w-12 h-12 rounded-2xl bg-primary/5 text-primary flex items-center justify-center text-xl">
                        <i class="fas fa-image"></i>
                    </div>
                    <h3 class="font-outfit text-xl font-black text-dark tracking-tight">Gallery & Media</h3>
                </div>

                <div class="space-y-6">
                    <div class="relative w-full aspect-video bg-slate-50 rounded-[2.5rem] border-2 border-dashed border-slate-200 flex items-center justify-center overflow-hidden transition-all group hover:border-primary/30">
                        <template x-if="preview">
                            <img loading="lazy" :src="preview" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!preview">
                            <div class="text-center">
                                <i class="fas fa-image text-4xl text-slate-200 mb-4 transition-transform group-hover:scale-110"></i>
                                <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Select Banner Photo</p>
                            </div>
                        </template>
                        <input type="file" name="image" class="absolute inset-0 opacity-0 cursor-pointer" 
                            @change="
                                const file = $event.target.files[0]; 
                                if(file) { 
                                    if (file.size > 150 * 1024) {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Banner Too Large',
                                            text: 'File size (' + (file.size / 1024).toFixed(2) + 'KB) exceeds the 150KB limit.',
                                            confirmButtonColor: '#ff0000'
                                        });
                                        $event.target.value = '';
                                        preview = null;
                                        return;
                                    }
                                    const reader = new FileReader(); 
                                    reader.onload = (e) => preview = e.target.result; 
                                    reader.readAsDataURL(file); 
                                }
                            ">
                    </div>
                </div>
            </div>

            <!-- Ticketing & Scheduling Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Scheduling -->
                <div class="bg-white rounded-[2.5rem] p-10 shadow-premium border border-slate-50">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-10 h-10 rounded-xl bg-orange-50 text-orange-500 flex items-center justify-center">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <h3 class="font-outfit text-lg font-black text-dark tracking-tight">Scheduling</h3>
                    </div>
                    <div class="space-y-6">
                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Event Date & Time</label>
                            <input type="datetime-local" name="date" required class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-4 px-6 text-sm font-bold focus:border-primary/30 transition-all">
                        </div>
                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Registration Last Date</label>
                            <input type="datetime-local" name="registration_deadline" required class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-4 px-6 text-sm font-bold focus:border-primary/30 transition-all">
                        </div>
                    </div>
                </div>

                <!-- Ticketing -->
                <div class="bg-white rounded-[2.5rem] p-10 shadow-premium border border-slate-50">
                    <div class="flex items-center justify-between mb-8">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-violet-50 text-violet-500 flex items-center justify-center">
                                <i class="fas fa-ticket-alt"></i>
                            </div>
                            <h3 class="font-outfit text-lg font-black text-dark tracking-tight">Ticket Types</h3>
                        </div>
                        <button type="button" @click="addTicket()" class="text-[10px] font-black uppercase text-primary tracking-widest">+ Add</button>
                    </div>
                    <div class="space-y-4">
                        <template x-for="(ticket, index) in tickets" :key="index">
                            <div class="grid grid-cols-12 gap-3 items-end p-2 bg-slate-50/50 rounded-2xl border border-slate-100 animate-fadeInUp">
                                <div class="col-span-12">
                                    <input type="text" :name="'tickets['+index+'][name]'" x-model="ticket.name" placeholder="Name" class="w-full bg-white px-4 py-3 rounded-xl border border-slate-100 text-xs font-bold">
                                </div>
                                <div class="col-span-5">
                                    <input type="number" :name="'tickets['+index+'][price]'" x-model="ticket.price" placeholder="Price" class="w-full bg-white px-4 py-3 rounded-xl border border-slate-100 text-xs font-black">
                                </div>
                                <div class="col-span-5">
                                    <input type="number" :name="'tickets['+index+'][quantity]'" x-model="ticket.quantity" placeholder="Qty" class="w-full bg-white px-4 py-3 rounded-xl border border-slate-100 text-xs font-bold">
                                </div>
                                <div class="col-span-2">
                                    <button type="button" @click="removeTicket(index)" class="w-full h-10 bg-red-50 text-red-400 rounded-xl hover:bg-red-500 hover:text-white transition-all"><i class="fas fa-trash text-[10px]"></i></button>
                                </div>
                            </div>
                        </template>
                    </div>
                    <input type="hidden" name="price" :value="tickets[0] ? tickets[0].price : 0">
                </div>
            </div>

            <!-- Artists Section -->
            <div class="bg-white rounded-[2.5rem] p-10 shadow-premium border border-slate-50">
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-orange-50 text-orange-500 flex items-center justify-center">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3 class="font-outfit text-lg font-black text-dark tracking-tight">Artist Lineup</h3>
                    </div>
                    <button type="button" @click="addArtist()" class="text-[10px] font-black uppercase text-primary tracking-widest">+ Add Artist</button>
                </div>
            <div class="space-y-4">
                <template x-for="(artist, index) in artists" :key="index">
                    <div class="grid grid-cols-12 gap-6 p-4 bg-slate-50/50 rounded-2xl border border-slate-100 animate-fadeInUp relative group">
                        <button type="button" @click="removeArtist(index)" class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white rounded-full text-[8px] flex items-center justify-center shadow-lg"><i class="fas fa-times"></i></button>
                        
                        <div class="col-span-12 md:col-span-4 space-y-2">
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Artist Name</label>
                            <input type="text" :name="'artists['+index+'][name]'" x-model="artist.name" placeholder="Name" class="w-full bg-white px-4 py-3 rounded-xl border border-slate-100 text-xs font-bold">
                        </div>
                        
                        <div class="col-span-12 md:col-span-3 space-y-2">
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Role / Talent</label>
                            <input type="text" :name="'artists['+index+'][role]'" x-model="artist.role" placeholder="Role (e.g. Lead Singer)" class="w-full bg-white px-4 py-3 rounded-xl border border-slate-100 text-xs font-bold">
                        </div>
                        
                        <div class="col-span-12 md:col-span-5 space-y-2">
                            <div class="flex items-center justify-between mb-1">
                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Artist Photo</label>
                                <div x-show="artist.preview" class="w-6 h-6 rounded-lg overflow-hidden border border-slate-100 shadow-sm">
                                    <img loading="lazy" :src="artist.preview" class="w-full h-full object-cover">
                                </div>
                            </div>
                            <label class="w-full h-[46px] bg-white border border-slate-100 rounded-xl flex items-center px-4 cursor-pointer hover:bg-slate-50 transition-all overflow-hidden relative group/file">
                                <i class="fas fa-camera text-slate-300 mr-2 group-hover/file:text-primary transition-colors"></i>
                                <span class="text-[10px] font-bold text-slate-400 truncate" x-text="artist.imageName || 'Select Artist Photo'"></span>
                                <input type="file" :name="'artists['+index+'][image]'" class="absolute inset-0 opacity-0 cursor-pointer" accept="image/*" 
                                    @change="
                                        const file = $event.target.files[0]; 
                                        if(file) { 
                                            if (file.size > 150 * 1024) {
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Photo Too Large',
                                                    text: 'Artist photo (' + (file.size / 1024).toFixed(2) + 'KB) exceeds the 150KB limit.',
                                                    confirmButtonColor: '#ff0000'
                                                });
                                                $event.target.value = '';
                                                return;
                                            }
                                            artist.imageName = file.name; 
                                            const reader = new FileReader(); 
                                            reader.onload = (e) => artist.preview = e.target.result; 
                                            reader.readAsDataURL(file); 
                                        }
                                    ">
                            </label>
                        </div>
                    </div>
                </template>
            </div>
            </div>

            <!-- Registration Form Builder -->
            <div class="bg-white rounded-[2.5rem] p-10 shadow-premium border border-slate-50">
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-primary/5 text-primary flex items-center justify-center">
                            <i class="fas fa-list-check"></i>
                        </div>
                        <div>
                            <h3 class="font-outfit text-lg font-black text-dark tracking-tight">Registration Form Builder</h3>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">Configure dynamic fields for the booking form.</p>
                        </div>
                    </div>
                    <button type="button" @click="addFormField()" class="bg-secondary text-white px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-black transition-all flex items-center gap-3 shadow-lg shadow-black/10">
                        <i class="fas fa-plus"></i> Add Field
                    </button>
                </div>

                <div class="space-y-6">
                    <!-- Default Fields (Static) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 pb-6 border-b border-dashed border-slate-100">
                        <div class="bg-slate-50/50 p-4 rounded-xl border border-slate-100 opacity-60">
                            <span class="text-[10px] font-black text-primary uppercase tracking-tighter block mb-1">Required</span>
                            <p class="text-[13px] font-bold text-dark">Name</p>
                        </div>
                        <div class="bg-slate-50/50 p-4 rounded-xl border border-slate-100 opacity-60">
                            <span class="text-[10px] font-black text-primary uppercase tracking-tighter block mb-1">Required</span>
                            <p class="text-[13px] font-bold text-dark">Email</p>
                        </div>
                        <div class="bg-slate-50/50 p-4 rounded-xl border border-slate-100 opacity-60">
                            <span class="text-[10px] font-black text-primary uppercase tracking-tighter block mb-1">Required</span>
                            <p class="text-[13px] font-bold text-dark">Phone</p>
                        </div>
                        <div class="bg-slate-50/50 p-4 rounded-xl border border-slate-100 opacity-60">
                            <span class="text-[10px] font-black text-primary uppercase tracking-tighter block mb-1">Required</span>
                            <p class="text-[13px] font-bold text-dark">Address</p>
                        </div>
                    </div>

                    <!-- Custom Dynamic Fields -->
                    <div class="space-y-4">
                        <template x-for="(field, index) in formFields" :key="index">
                            <div class="bg-slate-50/30 border border-slate-100 rounded-2xl p-6 group animate-fadeInUp relative">
                                <button type="button" @click="removeFormField(index)" class="absolute -top-3 -right-3 w-8 h-8 rounded-full bg-white border border-red-100 text-red-400 flex items-center justify-center hover:bg-red-500 hover:text-white transition-all shadow-sm">
                                    <i class="fas fa-times text-[10px]"></i>
                                </button>

                                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6 items-start">
                                    <div class="space-y-2">
                                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Field Name</label>
                                        <input type="text" x-model="field.label" placeholder="e.g. Identity Card Number" class="w-full bg-white border border-slate-200 rounded-xl py-3 px-4 outline-none text-[13px] font-bold focus:border-primary/30 transition-all">
                                    </div>

                                    <div class="space-y-2">
                                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Field Type</label>
                                        <select x-model="field.type" class="w-full bg-white border border-slate-200 rounded-xl py-3 px-4 outline-none text-[13px] font-bold focus:border-primary/30 transition-all cursor-pointer">
                                            <option value="text">Text Input</option>
                                            <option value="email">Email Input</option>
                                            <option value="number">Number Input</option>
                                            <option value="select">Dropdown Menu</option>
                                            <option value="textarea">Long Text / Textarea</option>
                                            <option value="date">Date Picker</option>
                                            <option value="checkbox">Single Checkbox</option>
                                            <option value="file">File Upload</option>
                                        </select>
                                    </div>

                                    <div class="space-y-2">
                                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Required?</label>
                                        <div class="flex items-center h-[46px]">
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" x-model="field.is_required" class="sr-only peer">
                                                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[4px] after:start-[4px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary"></div>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Options for Dropdown -->
                                    <div class="md:col-span-3 lg:col-span-1 space-y-2" x-show="field.type === 'select'">
                                        <div class="flex items-center justify-between">
                                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Options</label>
                                            <button type="button" @click="addOption(index)" class="text-[9px] font-black text-primary uppercase">+ Add</button>
                                        </div>
                                        <div class="space-y-2">
                                            <template x-for="(opt, optIndex) in field.options" :key="optIndex">
                                                <div class="flex gap-2">
                                                    <input type="text" x-model="field.options[optIndex]" placeholder="Option val" class="flex-1 bg-white border border-slate-100 rounded-lg py-1.5 px-3 outline-none text-[11px] font-bold">
                                                    <button type="button" @click="removeOption(index, optIndex)" class="text-red-400"><i class="fas fa-trash-alt text-[9px]"></i></button>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <div x-show="formFields.length === 0" class="text-center py-12 bg-slate-50/50 rounded-[2.5rem] border-2 border-dashed border-slate-100">
                        <i class="fas fa-wand-magic-sparkles text-2xl text-slate-200 mb-3 block"></i>
                        <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.2em]">Add custom fields to build your form</p>
                    </div>
                </div>
                <input type="hidden" name="form_fields_raw" :value="JSON.stringify(formFields)">
            </div>

            <!-- Action Bar -->
            <div class="pt-10 flex items-center justify-end gap-6">
                <a href="{{ route('organizer.events.index') }}" class="text-[10px] font-black uppercase tracking-widest text-slate-400">Cancel</a>
                <button type="submit" name="status" value="Live" class="bg-secondary text-white px-12 py-5 rounded-3xl font-black text-xs tracking-[0.3em] uppercase hover:bg-primary transition-all shadow-2xl active:scale-95">Launch Project</button>
            </div>
        </div>
    </form>
</div>
@endsection
