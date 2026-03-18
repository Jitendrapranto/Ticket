@extends('admin.dashboard')

@section('admin_content')
<div>


    

    <div class="animate-fadeIn">
        <header class="mb-8 flex items-center justify-between shrink-0">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.customers.index') }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-50 text-dark hover:bg-primary hover:text-white transition-all">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h2 class="font-outfit text-xl font-black text-dark tracking-tight">Add Customer</h2>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Register a new fan base member</p>
                </div>
            </div>
        </header>

        <main class="p-8 flex-1 max-w-4xl mx-auto w-full">
            <div class="bg-white rounded-[2.5rem] shadow-premium border border-slate-50 overflow-hidden">
                <form action="{{ route('admin.customers.store') }}" method="POST" class="p-10 space-y-8">
                    @csrf

                    <!-- Section Header -->
                    <div class="flex items-center gap-6 mb-10 pb-10 border-b border-slate-50">
                        <div class="w-16 h-16 rounded-2xl bg-secondary flex items-center justify-center text-white text-2xl shadow-xl">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-outfit font-black text-dark tracking-tight">Account Information</h3>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Provide the core identity details</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Name -->
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Full Name</label>
                            <div class="relative">
                                <i class="fas fa-user absolute left-5 top-1/2 -translate-y-1/2 text-slate-300"></i>
                                <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. John Doe"
                                    class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-4 pl-12 pr-6 outline-none focus:border-primary/30 focus:bg-white transition-all text-sm font-bold">
                            </div>
                            @error('name') <p class="text-red-500 text-[10px] font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Email -->
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Email Address</label>
                            <div class="relative">
                                <i class="fas fa-envelope absolute left-5 top-1/2 -translate-y-1/2 text-slate-300"></i>
                                <input type="email" name="email" value="{{ old('email') }}" required placeholder="john@example.com"
                                    class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-4 pl-12 pr-6 outline-none focus:border-primary/30 focus:bg-white transition-all text-sm font-bold">
                            </div>
                            @error('email') <p class="text-red-500 text-[10px] font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Password -->
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Initial Password</label>
                            <div class="relative">
                                <i class="fas fa-lock absolute left-5 top-1/2 -translate-y-1/2 text-slate-300"></i>
                                <input type="password" name="password" required placeholder="••••••••"
                                    class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-4 pl-12 pr-6 outline-none focus:border-primary/30 focus:bg-white transition-all text-sm font-bold">
                            </div>
                            @error('password') <p class="text-red-500 text-[10px] font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Password Confirmation -->
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Confirm Password</label>
                            <div class="relative">
                                <i class="fas fa-redo absolute left-5 top-1/2 -translate-y-1/2 text-slate-300"></i>
                                <input type="password" name="password_confirmation" required placeholder="••••••••"
                                    class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-4 pl-12 pr-6 outline-none focus:border-primary/30 focus:bg-white transition-all text-sm font-bold">
                            </div>
                        </div>
                    </div>

                    <div class="pt-10 border-t border-slate-50 flex items-center justify-end gap-6">
                        <a href="{{ route('admin.customers.index') }}" class="text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-dark transition-all">Cancel & Return</a>
                        <button type="submit" class="bg-secondary hover:bg-black text-white px-12 py-5 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] shadow-xl hover:shadow-secondary/30 transition-all flex items-center gap-3">
                            <i class="fas fa-check-circle text-[12px]"></i> Finalize Account
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

</div>
@endsection
