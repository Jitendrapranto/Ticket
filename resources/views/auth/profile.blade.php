@extends('layouts.app')

@section('title', 'My Profile - Ticket Kinun')

@section('content')
<div class="container mx-auto px-4 max-w-4xl mb-24 animate-fadeInUp">
    <div class="mb-12">
        <h1 class="font-outfit text-4xl font-black text-dark tracking-tight mb-2">My Profile</h1>
        <p class="text-slate-500 font-medium">Manage your personal information and security settings.</p>
    </div>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        @csrf
        
        <!-- Left: Photo Upload -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-[2.5rem] p-10 border border-slate-100 shadow-premium text-center">
                <div class="relative inline-block mb-6 group">
                    <div class="w-32 h-32 rounded-[2rem] bg-slate-100 border-4 border-white shadow-xl overflow-hidden relative transition-all group-hover:shadow-primary/20">
                        @if($user->avatar)
                            <img id="avatar-preview" src="{{ asset('storage/' . $user->avatar) }}" class="w-full h-full object-cover">
                        @else
                            <div id="avatar-placeholder" class="w-full h-full flex items-center justify-center bg-primary/5 text-primary text-4xl font-black">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <img id="avatar-preview" src="#" class="w-full h-full object-cover hidden">
                        @endif
                    </div>
                    <label for="avatar-upload" class="absolute -bottom-2 -right-2 w-10 h-10 rounded-2xl bg-primary text-white flex items-center justify-center shadow-lg cursor-pointer hover:bg-secondary transition-all active:scale-90">
                        <i class="fas fa-camera text-sm"></i>
                        <input type="file" id="avatar-upload" name="avatar" class="hidden" onchange="previewImage(this)">
                    </label>
                </div>
                <h3 class="font-black text-dark uppercase tracking-widest text-xs mb-1">{{ $user->name }}</h3>
                <p class="text-[10px] font-black text-primary uppercase tracking-tighter">Verified Fan</p>
                
                <div class="mt-8 pt-8 border-t border-slate-50 text-left space-y-4">
                    <div class="flex items-center gap-4 text-slate-400">
                        <i class="fas fa-calendar-check text-[10px]"></i>
                        <span class="text-[10px] font-bold uppercase">Member since {{ $user->created_at->format('M Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Detail Fields -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white rounded-[2.5rem] p-10 border border-slate-100 shadow-premium">
                <h2 class="text-lg font-outfit font-black text-dark mb-8 flex items-center gap-3">
                    <i class="fas fa-id-card text-primary/30 text-sm"></i>
                    Personal Details
                </h2>
                
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-400 uppercase tracking-wider block ml-1">Full Name</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-4 px-6 outline-none focus:border-primary/30 focus:bg-white transition-all text-sm font-bold shadow-inner">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-400 uppercase tracking-wider block ml-1">Email Address</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-4 px-6 outline-none focus:border-primary/30 focus:bg-white transition-all text-sm font-bold shadow-inner">
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-[#21032B] rounded-[2.5rem] p-10 text-white shadow-2xl relative overflow-hidden">
                <div class="absolute -top-24 -right-24 w-64 h-64 bg-primary/20 rounded-full blur-3xl"></div>
                
                <h2 class="text-lg font-outfit font-black mb-8 relative z-10 flex items-center gap-3">
                    <i class="fas fa-lock text-white/30 text-sm"></i>
                    Security
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 relative z-10">
                    <div class="space-y-2">
                        <label class="text-[11px] font-black text-white/50 uppercase tracking-wider block ml-1">New Password</label>
                        <input type="password" name="password"
                            class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 px-6 outline-none focus:border-primary/50 focus:bg-white/10 transition-all text-sm font-bold"
                            placeholder="Leave blank to keep same">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[11px] font-black text-white/50 uppercase tracking-wider block ml-1">Confirm New Password</label>
                        <input type="password" name="password_confirmation"
                            class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 px-6 outline-none focus:border-primary/50 focus:bg-white/10 transition-all text-sm font-bold"
                            placeholder="Confirm password">
                    </div>
                </div>
            </div>

            <div class="pt-4 flex items-center justify-between">
                <div>
                    @if(session('success'))
                        <div class="flex items-center gap-2 text-green-500 font-bold text-xs uppercase tracking-widest animate-bounce">
                            <i class="fas fa-check-circle"></i>
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
                <button type="submit" class="bg-primary hover:bg-secondary text-white px-10 py-5 rounded-2xl font-black text-xs tracking-[0.2em] transition-all shadow-xl shadow-primary/20 active:scale-95 uppercase flex items-center gap-3">
                    Save Changes
                </button>
            </div>
        </div>
    </form>
</div>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('avatar-preview').src = e.target.result;
            document.getElementById('avatar-preview').classList.remove('hidden');
            if(document.getElementById('avatar-placeholder')) {
                document.getElementById('avatar-placeholder').classList.add('hidden');
            }
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
