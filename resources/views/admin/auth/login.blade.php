<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Ticket Kinun Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#520C6B',
                        secondary: '#21032B',
                        dark: '#0F172A',
                    },
                    fontFamily: {
                        outfit: ['Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="font-outfit bg-[#0F172A] min-h-screen flex items-center justify-center p-6 relative overflow-hidden">
    
    <!-- Background Accents -->
    <div class="absolute top-0 left-0 w-full h-full opacity-30 pointer-events-none">
        <div class="absolute -top-48 -left-48 w-full h-full bg-primary/20 rounded-full blur-[150px]"></div>
        <div class="absolute -bottom-48 -right-48 w-full h-full bg-primary/10 rounded-full blur-[150px]"></div>
    </div>

    <div class="max-w-md w-full relative z-10">
        <div class="text-center mb-10">
            <img src="{{ asset('Blue_Simple_Technology_Logo.png') }}" alt="Logo" class="h-16 mx-auto mb-6 brightness-0 invert">
            <h1 class="text-3xl font-black text-white tracking-tight">Super Admin Portal</h1>
            <p class="text-slate-400 mt-2 font-medium">Securely access your management dashboard</p>
        </div>

        <div class="bg-white rounded-[2.5rem] p-10 shadow-2xl overflow-hidden relative group border border-white/10">
            <!-- Form Header Decor -->
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-primary to-accent"></div>

            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="space-y-2">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Admin Email</label>
                    <div class="relative">
                        <i class="fas fa-user-shield absolute left-5 top-1/2 -translate-y-1/2 text-slate-300"></i>
                        <input type="email" name="email" required autofocus
                            class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-4 pl-12 pr-6 outline-none focus:border-primary/30 focus:bg-white transition-all text-sm font-bold shadow-inner"
                            placeholder="admin@ticketkinun.com">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Security Key</label>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-5 top-1/2 -translate-y-1/2 text-slate-300"></i>
                        <input type="password" name="password" required
                            class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-4 pl-12 pr-6 outline-none focus:border-primary/30 focus:bg-white transition-all text-sm font-bold shadow-inner"
                            placeholder="••••••••">
                    </div>
                </div>

                @if($errors->any())
                    <div class="bg-red-50 p-4 rounded-xl border border-red-100 text-red-500 text-[10px] font-black uppercase tracking-widest">
                        <i class="fas fa-exclamation-triangle mr-2"></i> {{ $errors->first() }}
                    </div>
                @endif

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-200 text-primary focus:ring-primary/20">
                        <label for="remember" class="ml-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Keep Session Active</label>
                    </div>
                </div>

                <button type="submit" class="w-full bg-[#21032B] hover:bg-black text-white py-5 rounded-2xl font-black text-xs tracking-[0.2em] transition-all shadow-xl active:scale-[0.98] uppercase flex items-center justify-center gap-3">
                    <i class="fas fa-sign-in-alt"></i> Access Dashboard
                </button>
            </form>
            
            <div class="mt-8 pt-8 border-t border-slate-50 text-center">
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Authorized Personnel Only</p>
            </div>
        </div>

        <div class="mt-10 text-center">
            <a href="/" class="text-slate-500 hover:text-white transition-all text-[11px] font-black uppercase tracking-widest">
                <i class="fas fa-arrow-left mr-2"></i> Back to Live Site
            </a>
        </div>
    </div>

</body>
</html>
