@extends('layouts.app')

@section('title', 'My Profile - Ticket Kinun')

@section('content')
<div class="container mx-auto px-4 max-w-4xl mb-24 animate-fadeInUp">
    <div class="mb-12">
        <h1 class="font-outfit text-4xl font-black text-dark tracking-tight mb-2">My Profile</h1>
        <p class="text-slate-500 font-medium">Manage your personal information and security settings.</p>

        @if($errors->any())
            <div class="mt-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-xl">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-500"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700 font-bold uppercase tracking-widest text-[10px]">Validation Errors</p>
                        <ul class="mt-1 list-disc list-inside text-xs text-red-600 font-medium">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        @csrf
        
        <!-- Left: Photo Upload -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-[2.5rem] p-10 border border-slate-100 shadow-premium text-center">
                <div class="relative inline-block mb-6 group">
                    <div class="w-32 h-32 rounded-[2rem] bg-slate-100 border-4 border-white shadow-xl overflow-hidden relative transition-all group-hover:shadow-primary/20">
                        @if($user->avatar)
                            <img loading="lazy" id="avatar-preview" src="{{ asset('storage/' . $user->avatar) }}" class="w-full h-full object-cover">
                        @else
                            <div id="avatar-placeholder" class="w-full h-full flex items-center justify-center bg-primary/5 text-primary text-4xl font-black">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <img loading="lazy" id="avatar-preview" src="#" class="w-full h-full object-cover hidden">
                        @endif
                    </div>
                    <label for="avatar-upload" class="absolute -bottom-2 -right-2 w-10 h-10 rounded-2xl bg-primary text-white flex items-center justify-center shadow-lg cursor-pointer hover:bg-secondary transition-all active:scale-90">
                        <i class="fas fa-camera text-sm"></i>
                        <input type="file" id="avatar-upload" name="avatar" class="hidden" onchange="previewImage(this)">
                    </label>
                </div>
                @error('avatar') <p class="text-[10px] text-red-500 font-bold mb-4">{{ $message }}</p> @enderror
                <h3 class="font-black text-dark uppercase tracking-widest text-xs mb-1">{{ $user->name }}</h3>
                <p class="text-[10px] font-black text-primary uppercase tracking-tighter">
                    @if($user->role === 'admin')
                        System Administrator
                    @elseif($user->role === 'organizer')
                        Official Organizer
                    @else
                        Verified Fan
                    @endif
                </p>
                
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
                                class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-4 px-6 outline-none @error('name') border-red-500 @else focus:border-primary/30 @enderror focus:bg-white transition-all text-sm font-bold shadow-inner">
                            @error('name') <p class="text-[10px] text-red-500 font-bold ml-1 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-400 uppercase tracking-wider block ml-1">Email Address</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="email"
                                class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-4 px-6 outline-none @error('email') border-red-500 @else focus:border-primary/30 @enderror focus:bg-white transition-all text-sm font-bold shadow-inner"
                                pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" title="Please enter a valid email address (e.g. shakib@gmail.com)">
                            @error('email') <p class="text-[10px] text-red-500 font-bold ml-1 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-400 uppercase tracking-wider block ml-1">Mobile Number</label>
                            <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}"
                                class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-4 px-6 outline-none @error('phone') border-red-500 @else focus:border-primary/30 @enderror focus:bg-white transition-all text-sm font-bold shadow-inner"
                                placeholder="Enter mobile number">
                            @error('phone') <p class="text-[10px] text-red-500 font-bold ml-1 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-400 uppercase tracking-wider block ml-1">Present Address</label>
                            <input type="text" name="present_address" value="{{ old('present_address', $user->present_address) }}"
                                class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-4 px-6 outline-none @error('present_address') border-red-500 @else focus:border-primary/30 @enderror focus:bg-white transition-all text-sm font-bold shadow-inner"
                                placeholder="Enter your address">
                            @error('present_address') <p class="text-[10px] text-red-500 font-bold ml-1 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-[#1B2B46] rounded-[2.5rem] p-10 text-white shadow-2xl relative overflow-hidden">
                <div class="absolute -top-24 -right-24 w-64 h-64 bg-primary/20 rounded-full blur-3xl"></div>
                
                <h2 class="text-lg font-outfit font-black mb-8 relative z-10 flex items-center gap-3">
                    <i class="fas fa-lock text-white/30 text-sm"></i>
                    Security
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 relative z-10">
                    <div class="space-y-3">
                        <div class="flex justify-between items-center ml-1">
                            <label class="text-[11px] font-black text-white/50 uppercase tracking-wider block">New Password</label>
                            <span class="text-[9px] font-bold text-white/20 uppercase tracking-widest">(Optional)</span>
                        </div>
                        <div class="relative group">
                            <i class="fas fa-key absolute left-6 top-1/2 -translate-y-1/2 text-white/20 group-focus-within:text-primary transition-colors"></i>
                            <input type="password" id="password" name="password"
                                class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 pl-14 pr-12 outline-none focus:border-primary/50 focus:bg-white/10 transition-all text-sm font-bold text-white"
                                placeholder="Leave blank to keep current" autocomplete="new-password">
                            <button type="button" onclick="togglePassword('password', 'toggle-icon-1')" class="absolute right-6 top-1/2 -translate-y-1/2 text-white/20 hover:text-white transition-all">
                                <i id="toggle-icon-1" class="fas fa-eye text-xs"></i>
                            </button>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center ml-1">
                            <label class="text-[11px] font-black text-white/50 uppercase tracking-wider block">Confirm New Password</label>
                        </div>
                        <div class="relative group">
                            <i class="fas fa-shield-alt absolute left-6 top-1/2 -translate-y-1/2 text-white/20 group-focus-within:text-primary transition-colors"></i>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 pl-14 pr-12 outline-none focus:border-primary/50 focus:bg-white/10 transition-all text-sm font-bold text-white"
                                placeholder="Confirm new password" autocomplete="new-password">
                            <button type="button" onclick="togglePassword('password_confirmation', 'toggle-icon-2')" class="absolute right-6 top-1/2 -translate-y-1/2 text-white/20 hover:text-white transition-all">
                                <i id="toggle-icon-2" class="fas fa-eye text-xs"></i>
                            </button>
                        </div>
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

function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>
@endsection
