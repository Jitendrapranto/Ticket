<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commission Settings | Ticket Kinun Admin</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#520C6B',
                        'primary-dark': '#21032B',
                        secondary: '#21032B',
                        accent: '#FF7D52',
                        dark: '#0F172A',
                    },
                    fontFamily: {
                        outfit: ['Outfit', 'sans-serif'],
                        plus: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    boxShadow: {
                        'premium': '0 20px 50px -12px rgba(82, 12, 107, 0.15)',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-[#F8FAFC] text-slate-800 font-plus overflow-x-hidden">

    @include('admin.sidebar')

    <!-- Main Content wrapper -->
    <div class="lg:ml-72 min-h-screen flex flex-col transition-all duration-300">
        
        <!-- Topbar -->
        <header class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-10 sticky top-0 z-40">
            <div class="flex items-center gap-6">
                <!-- Mobile Menu Button -->
                <button id="toggle-sidebar" class="lg:hidden w-10 h-10 flex items-center justify-center rounded-xl bg-slate-50 text-dark hover:bg-slate-100 transition-colors">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            
            <div class="flex items-center gap-6">
                <div class="text-right">
                    <p class="text-xs font-black text-dark">{{ Auth::user()->name }}</p>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Administrator</p>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="p-10 flex-1 max-w-7xl mx-auto w-full">
            
            <!-- Page Header -->
            <div class="mb-10 flex justify-between items-end">
                <div>
                    <h1 class="font-outfit text-3xl font-black text-dark tracking-tight mb-2">Commission Settings</h1>
                    <p class="text-slate-400 font-medium text-sm">Configure how much commission you earn per ticket sale.</p>
                </div>
            </div>

            @if(session('success'))
            <div class="mb-8 p-6 bg-green-50 border border-green-100 rounded-[1.5rem] flex items-center gap-4 text-green-700">
                <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center text-lg">
                    <i class="fas fa-check"></i>
                </div>
                <div>
                    <h4 class="font-black text-sm">Success</h4>
                    <p class="text-xs font-medium">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            <form action="{{ route('admin.finance.commission.update') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    
                    <div class="space-y-8">
                        <div class="bg-white rounded-[2rem] p-8 shadow-premium border border-slate-50">
                            <h3 class="font-outfit text-xl font-black text-dark tracking-tight mb-6 flex items-center gap-3">
                                <span class="w-8 h-8 rounded-lg bg-primary/10 text-primary flex items-center justify-center text-sm"><i class="fas fa-percentage"></i></span>
                                Commission Model
                            </h3>

                            <div class="space-y-6">
                                <div>
                                    <label class="text-xs font-bold text-slate-500 mb-2 block">Revenue Model</label>
                                    <select name="revenue_model" class="w-full bg-slate-50 border border-slate-100 rounded-xl py-4 px-6 outline-none focus:border-primary/30 focus:bg-white transition-all text-dark font-bold text-sm">
                                        <option value="percentage" {{ ($setting->revenue_model ?? 'percentage') == 'percentage' ? 'selected' : '' }}>Percentage of Ticket Price (%)</option>
                                        <option value="fixed" {{ ($setting->revenue_model ?? 'percentage') == 'fixed' ? 'selected' : '' }}>Fixed Amount per Ticket (৳)</option>
                                    </select>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-xs font-bold text-slate-500 mb-2 block">Percentage (%)</label>
                                        <input type="number" step="0.01" name="default_percentage" value="{{ $setting->default_percentage ?? '10.00' }}" class="w-full bg-slate-50 border border-slate-100 rounded-xl py-4 px-6 outline-none focus:border-primary/30 focus:bg-white transition-all text-dark font-black text-xl text-center placeholder:text-slate-300">
                                    </div>
                                    <div>
                                        <label class="text-xs font-bold text-slate-500 mb-2 block">Fixed Amount (৳)</label>
                                        <input type="number" step="0.01" name="fixed_amount" value="{{ $setting->fixed_amount ?? '0.00' }}" class="w-full bg-slate-50 border border-slate-100 rounded-xl py-4 px-6 outline-none focus:border-primary/30 focus:bg-white transition-all text-dark font-black text-xl text-center placeholder:text-slate-300">
                                    </div>
                                </div>
                                <div class="pt-4 border-t border-slate-100">
                                    <label class="flex items-center gap-4 cursor-pointer group">
                                        <div class="relative">
                                            <input type="checkbox" name="is_active" class="sr-only peer" {{ ($setting->is_active ?? true) ? 'checked' : '' }}>
                                            <div class="w-14 h-8 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:start-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-primary"></div>
                                        </div>
                                        <div>
                                            <p class="text-sm font-black text-dark group-hover:text-primary transition-colors">Apply Commission</p>
                                            <p class="text-[10px] font-bold text-slate-400 mt-0.5">If disabled, the platform will earn 0% from organizers.</p>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-50 flex flex-col justify-center">
                            <button type="submit" class="w-full bg-primary text-white py-4 rounded-xl text-xs font-black tracking-widest hover:bg-primary-dark hover:-translate-y-1 transition-all uppercase shadow-xl shadow-primary/20 flex justify-center items-center gap-2">
                                Save Settings <i class="fas fa-save"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>
</body>
</html>
