@extends('layouts.organizer')

@section('title', 'Edit Scanner')

@section('content')
<div class="p-10 max-w-[1000px] mx-auto w-full">
    <div class="mb-12">
        <a href="{{ route('organizer.scanners.index') }}" class="inline-flex items-center gap-2 text-xs font-black text-slate-400 uppercase tracking-widest hover:text-primary transition-colors mb-6">
            <i class="fas fa-arrow-left"></i>
            Back to Team
        </a>
        <h1 class="font-outfit text-5xl font-black text-dark tracking-tighter">Edit Scanner</h1>
    </div>

    <form action="{{ route('organizer.scanners.update', $scanner->id) }}" method="POST" class="space-y-8 animate-fadeInUp">
        @csrf
        @method('PUT')
        
        <div class="bg-white rounded-[3rem] p-12 shadow-premium border border-white">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Name -->
                <div class="space-y-3">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Full Name</label>
                    <div class="relative group">
                        <i class="fas fa-user absolute left-6 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-primary transition-colors"></i>
                        <input type="text" name="name" value="{{ old('name', $scanner->name) }}" required
                            class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-14 pr-8 py-5 text-sm font-bold text-dark focus:ring-4 focus:ring-primary/5 focus:bg-white outline-none transition-all placeholder:text-slate-300">
                    </div>
                </div>

                <!-- Email -->
                <div class="space-y-3">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Email Address</label>
                    <div class="relative group">
                        <i class="fas fa-envelope absolute left-6 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-primary transition-colors"></i>
                        <input type="email" name="email" value="{{ old('email', $scanner->email) }}" required
                            class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-14 pr-8 py-5 text-sm font-bold text-dark focus:ring-4 focus:ring-primary/5 focus:bg-white outline-none transition-all placeholder:text-slate-300">
                    </div>
                </div>

                <!-- Password -->
                <div class="space-y-3">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">New Password (Leave blank to keep current)</label>
                    <div class="relative group">
                        <i class="fas fa-lock absolute left-6 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-primary transition-colors"></i>
                        <input type="password" name="password"
                            class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-14 pr-8 py-5 text-sm font-bold text-dark focus:ring-4 focus:ring-primary/5 focus:bg-white outline-none transition-all placeholder:text-slate-300">
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="space-y-3">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Confirm New Password</label>
                    <div class="relative group">
                        <i class="fas fa-shield-alt absolute left-6 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-primary transition-colors"></i>
                        <input type="password" name="password_confirmation"
                            class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-14 pr-8 py-5 text-sm font-bold text-dark focus:ring-4 focus:ring-primary/5 focus:bg-white outline-none transition-all placeholder:text-slate-300">
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-6 pt-4">
            <a href="{{ route('organizer.scanners.index') }}" class="text-xs font-black text-slate-400 uppercase tracking-widest hover:text-dark transition-colors">Cancel</a>
            <button type="submit" class="bg-primary text-white px-12 py-5 rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-secondary transition-all shadow-2xl shadow-primary/20 flex items-center gap-4">
                <i class="fas fa-save"></i>
                <span>Update Scanner</span>
            </button>
        </div>
    </form>
</div>
@endsection
