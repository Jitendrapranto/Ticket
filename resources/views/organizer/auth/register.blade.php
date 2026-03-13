@extends('layouts.app')

@section('title', 'Register as Organizer - Ticket Kinun')

@section('content')
<div class="min-h-screen flex items-center justify-center py-20 px-4 bg-[#1B2B46] relative overflow-hidden" style="margin-top: -100px;">
    <!-- Decorative background elements -->
    <div class="absolute top-0 left-0 w-full h-full opacity-20 pointer-events-none">
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-primary rounded-full blur-[120px]"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-accent rounded-full blur-[120px]"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-[#4F0B67] rounded-full blur-[200px]"></div>
    </div>

    <div class="max-w-5xl w-full grid grid-cols-1 lg:grid-cols-5 bg-white rounded-[2.5rem] overflow-hidden shadow-2xl relative z-10 animate-fadeInUp">
        
        <!-- Left Side: Branding (2 columns) -->
        <div class="hidden lg:flex lg:col-span-2 flex-col justify-between p-10 bg-[#1A0222] text-white relative">
            <div class="absolute inset-0 opacity-10">
                <div class="flex flex-wrap gap-4 p-4">
                    @for($i = 0; $i < 24; $i++)
                        <i class="fas fa-ticket-alt text-3xl transform -rotate-12"></i>
                    @endfor
                </div>
            </div>
            
            <div class="relative z-10">
                <a href="/">
                    <img loading="lazy" src="{{ asset('Blue_Simple_Technology_Logo.png') }}" alt="Ticket Kinun" class="h-14 brightness-0 invert">
                </a>
                <div class="mt-12 space-y-5">
                    <h2 class="font-outfit text-3xl font-black leading-tight tracking-tight">
                        Start Your Journey as an <span class="text-[#FFE700]">Organizer</span>.
                    </h2>
                    <p class="text-slate-400 font-medium leading-relaxed text-sm">
                        Host events on our platform and reach millions of event enthusiasts. We provide you the tools to succeed.
                    </p>
                </div>

                <div class="mt-10 space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-[#FFE700]/20 flex items-center justify-center shrink-0">
                            <i class="fas fa-calendar-check text-[#FFE700] text-xs"></i>
                        </div>
                        <span class="text-slate-300 text-xs font-semibold">Create & manage unlimited events</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-[#FFE700]/20 flex items-center justify-center shrink-0">
                            <i class="fas fa-chart-line text-[#FFE700] text-xs"></i>
                        </div>
                        <span class="text-slate-300 text-xs font-semibold">Real-time sales & analytics</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-[#FFE700]/20 flex items-center justify-center shrink-0">
                            <i class="fas fa-qrcode text-[#FFE700] text-xs"></i>
                        </div>
                        <span class="text-slate-300 text-xs font-semibold">QR code scanning & check-in</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-[#FFE700]/20 flex items-center justify-center shrink-0">
                            <i class="fas fa-users text-[#FFE700] text-xs"></i>
                        </div>
                        <span class="text-slate-300 text-xs font-semibold">Customer management & segmentation</span>
                    </div>
                </div>
            </div>

            <div class="relative z-10 flex items-center gap-3 mt-8">
                <div class="w-9 h-9 rounded-xl bg-[#FFE700]/20 flex items-center justify-center">
                    <i class="fas fa-shield-alt text-[#FFE700] text-sm"></i>
                </div>
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Secure Bank-Level Encryption</span>
            </div>
        </div>

        <!-- Right Side: Form (3 columns) -->
        <div class="lg:col-span-3 p-8 md:p-10">
            <div class="lg:hidden text-center mb-8">
                <img loading="lazy" src="{{ asset('Blue_Simple_Technology_Logo.png') }}" alt="Ticket Kinun" class="mx-auto h-10">
            </div>

            <div class="mb-8">
                <h2 class="font-outfit text-2xl font-black text-[#1B2B46] tracking-tight">Organizer Registration</h2>
                <p class="text-slate-400 text-sm font-medium mt-1">Fill in your details to create your organizer account.</p>
            </div>

            @if($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-100">
                    <div class="flex items-center gap-2 mb-2">
                        <i class="fas fa-exclamation-circle text-red-500 text-sm"></i>
                        <span class="text-xs font-bold text-red-600 uppercase tracking-wider">Please fix the following errors</span>
                    </div>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li class="text-xs text-red-500 font-medium">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('organizer.register') }}" method="POST" class="space-y-5" id="organizerRegForm">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Name -->
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-wider ml-1">Full Name <span class="text-red-400">*</span></label>
                        <input name="name" type="text" required value="{{ old('name') }}"
                            class="w-full bg-slate-50 border border-slate-100 rounded-xl py-3 px-4 outline-none focus:border-[#4F0B67]/40 focus:bg-white focus:ring-2 focus:ring-[#4F0B67]/10 transition-all text-sm font-bold"
                            placeholder="John Doe">
                        @error('name') <p class="text-[10px] text-red-500 font-bold ml-1 mt-0.5">{{ $message }}</p> @enderror
                    </div>

                    <!-- Institution Name -->
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-wider ml-1">Institution Name <span class="text-red-400">*</span></label>
                        <input name="institution_name" type="text" required value="{{ old('institution_name') }}"
                            class="w-full bg-slate-50 border border-slate-100 rounded-xl py-3 px-4 outline-none focus:border-[#4F0B67]/40 focus:bg-white focus:ring-2 focus:ring-[#4F0B67]/10 transition-all text-sm font-bold"
                            placeholder="Your Company / Organization">
                        @error('institution_name') <p class="text-[10px] text-red-500 font-bold ml-1 mt-0.5">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Email -->
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-wider ml-1">Email Address <span class="text-red-400">*</span></label>
                        <input name="email" type="email" required value="{{ old('email') }}"
                            class="w-full bg-slate-50 border border-slate-100 rounded-xl py-3 px-4 outline-none focus:border-[#4F0B67]/40 focus:bg-white focus:ring-2 focus:ring-[#4F0B67]/10 transition-all text-sm font-bold"
                            placeholder="john@example.com">
                        @error('email') <p class="text-[10px] text-red-500 font-bold ml-1 mt-0.5">{{ $message }}</p> @enderror
                    </div>

                    <!-- Phone Number -->
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-wider ml-1">Phone Number <span class="text-red-400">*</span></label>
                        <input name="phone" type="tel" required value="{{ old('phone') }}"
                            class="w-full bg-slate-50 border border-slate-100 rounded-xl py-3 px-4 outline-none focus:border-[#4F0B67]/40 focus:bg-white focus:ring-2 focus:ring-[#4F0B67]/10 transition-all text-sm font-bold"
                            placeholder="+880 1234 567 890">
                        @error('phone') <p class="text-[10px] text-red-500 font-bold ml-1 mt-0.5">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Present Address -->
                <div class="space-y-1">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-wider ml-1">Present Address <span class="text-red-400">*</span></label>
                    <textarea name="present_address" required rows="2"
                        class="w-full bg-slate-50 border border-slate-100 rounded-xl py-3 px-4 outline-none focus:border-[#4F0B67]/40 focus:bg-white focus:ring-2 focus:ring-[#4F0B67]/10 transition-all text-sm font-bold resize-none"
                        placeholder="Your present address">{{ old('present_address') }}</textarea>
                    @error('present_address') <p class="text-[10px] text-red-500 font-bold ml-1 mt-0.5">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Password -->
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-wider ml-1">Password <span class="text-red-400">*</span></label>
                        <div class="relative">
                            <input name="password" type="password" required id="reg-password"
                                class="w-full bg-slate-50 border border-slate-100 rounded-xl py-3 px-4 pr-10 outline-none focus:border-[#4F0B67]/40 focus:bg-white focus:ring-2 focus:ring-[#4F0B67]/10 transition-all text-sm font-bold"
                                placeholder="Min 8 characters">
                            <button type="button" onclick="togglePassword('reg-password', 'eye-icon-1')" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-[#4F0B67] transition-colors">
                                <i id="eye-icon-1" class="fas fa-eye text-sm"></i>
                            </button>
                        </div>
                        @error('password') <p class="text-[10px] text-red-500 font-bold ml-1 mt-0.5">{{ $message }}</p> @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-wider ml-1">Confirm Password <span class="text-red-400">*</span></label>
                        <div class="relative">
                            <input name="password_confirmation" type="password" required id="reg-password-confirm"
                                class="w-full bg-slate-50 border border-slate-100 rounded-xl py-3 px-4 pr-10 outline-none focus:border-[#4F0B67]/40 focus:bg-white focus:ring-2 focus:ring-[#4F0B67]/10 transition-all text-sm font-bold"
                                placeholder="Re-enter password">
                            <button type="button" onclick="togglePassword('reg-password-confirm', 'eye-icon-2')" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-[#4F0B67] transition-colors">
                                <i id="eye-icon-2" class="fas fa-eye text-sm"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Password Strength Indicator -->
                <div class="space-y-1.5">
                    <div class="flex gap-1.5">
                        <div id="str-1" class="h-1 flex-1 rounded-full bg-slate-100 transition-all duration-300"></div>
                        <div id="str-2" class="h-1 flex-1 rounded-full bg-slate-100 transition-all duration-300"></div>
                        <div id="str-3" class="h-1 flex-1 rounded-full bg-slate-100 transition-all duration-300"></div>
                        <div id="str-4" class="h-1 flex-1 rounded-full bg-slate-100 transition-all duration-300"></div>
                    </div>
                    <p id="str-text" class="text-[10px] font-bold text-slate-400 ml-1"></p>
                </div>

                <!-- Terms and Conditions Checkbox -->
                <div class="flex items-start gap-3 mt-2">
                    <div class="relative mt-0.5">
                        <input type="checkbox" name="terms" id="terms" required
                            class="peer w-5 h-5 rounded-md border-2 border-slate-200 appearance-none cursor-pointer checked:bg-[#4F0B67] checked:border-[#4F0B67] transition-all">
                        <i class="fas fa-check absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-white text-[9px] pointer-events-none opacity-0 peer-checked:opacity-100 transition-opacity"></i>
                    </div>
                    <label for="terms" class="text-xs text-slate-500 font-medium leading-relaxed cursor-pointer">
                        I agree to the <a href="#" class="text-[#4F0B67] font-bold hover:underline">Terms and Conditions</a> 
                        and <a href="#" class="text-[#4F0B67] font-bold hover:underline">Privacy Policy</a> of Ticket Kinun.
                    </label>
                </div>
                @error('terms') <p class="text-[10px] text-red-500 font-bold ml-1 -mt-2">{{ $message }}</p> @enderror

                <!-- Submit Button -->
                <button type="submit" id="submitBtn"
                    class="w-full bg-[#4F0B67] hover:bg-[#3D0851] text-white py-4 rounded-xl font-black text-xs tracking-widest transition-all shadow-xl shadow-[#4F0B67]/20 active:scale-[0.98] uppercase flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed"
                    disabled>
                    <i class="fas fa-user-plus text-sm"></i>
                    Create Organizer Account
                </button>

                <div class="relative my-4">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-slate-100"></div>
                    </div>
                    <div class="relative flex justify-center text-xs">
                        <span class="px-4 bg-white text-slate-400 font-bold uppercase tracking-widest text-[10px]">Already registered?</span>
                    </div>
                </div>

                <a href="{{ route('organizer.login') }}" class="block w-full text-center border-2 border-slate-100 hover:border-[#4F0B67]/30 text-[#4F0B67] py-3.5 rounded-xl font-black text-xs tracking-widest transition-all uppercase">
                    <i class="fas fa-sign-in-alt mr-1"></i> Login to Your Account
                </a>
            </form>
        </div>
    </div>
</div>

<style>
    body { background-color: #1B2B46 !important; }
    header, footer { display: none !important; }
</style>

<script>
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

    // Password strength indicator
    const passwordInput = document.getElementById('reg-password');
    passwordInput.addEventListener('input', function () {
        const val = this.value;
        let strength = 0;
        if (val.length >= 8) strength++;
        if (/[A-Z]/.test(val)) strength++;
        if (/[0-9]/.test(val)) strength++;
        if (/[^A-Za-z0-9]/.test(val)) strength++;

        const colors = ['bg-red-400', 'bg-orange-400', 'bg-yellow-400', 'bg-green-500'];
        const texts = ['Weak', 'Fair', 'Good', 'Strong'];

        for (let i = 1; i <= 4; i++) {
            const bar = document.getElementById('str-' + i);
            bar.className = 'h-1 flex-1 rounded-full transition-all duration-300';
            if (i <= strength) {
                bar.classList.add(colors[strength - 1]);
            } else {
                bar.classList.add('bg-slate-100');
            }
        }

        const textEl = document.getElementById('str-text');
        if (val.length === 0) {
            textEl.textContent = '';
        } else {
            textEl.textContent = 'Password Strength: ' + (texts[strength - 1] || 'Too Short');
            textEl.className = 'text-[10px] font-bold ml-1';
            if (strength <= 1) textEl.classList.add('text-red-400');
            else if (strength === 2) textEl.classList.add('text-orange-400');
            else if (strength === 3) textEl.classList.add('text-yellow-500');
            else textEl.classList.add('text-green-500');
        }
    });

    // Enable submit only when terms is checked
    const termsCheckbox = document.getElementById('terms');
    const submitBtn = document.getElementById('submitBtn');
    termsCheckbox.addEventListener('change', function () {
        submitBtn.disabled = !this.checked;
    });
</script>
@endsection
