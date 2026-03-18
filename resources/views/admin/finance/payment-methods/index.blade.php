@extends('admin.dashboard')

@section('admin_content')
<div class="px-8 py-8 animate-fadeIn">
    <!-- Header -->
    <div class="flex items-center justify-between mb-12">
        <div>
            <h1 class="text-3xl font-black text-dark italic tracking-tighter">Checkout <span class="text-primary underline decoration-primary/10 decoration-8 underline-offset-8">Configuration</span></h1>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-[0.3em] mt-3">Configure manual payment gateways and instructions</p>
        </div>
        <a href="{{ route('admin.finance.payment-methods.create') }}" class="group bg-primary hover:bg-dark text-white px-8 py-4 rounded-3xl font-black text-[10px] tracking-widest uppercase transition-all shadow-premium hover:-translate-y-1 flex items-center gap-3 italic">
            <i class="fas fa-plus group-hover:rotate-90 transition-transform"></i> Add New Gateway
        </a>
    </div>

    <!-- Methods Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($methods as $method)
        <div class="bg-white border border-white rounded-[3rem] p-10 relative overflow-hidden group hover:border-primary/30 transition-all duration-500 shadow-premium">
            <!-- Decorative Background -->
            <div class="absolute -right-12 -top-12 w-48 h-48 bg-primary/5 rounded-full blur-3xl group-hover:bg-primary/10 transition-colors"></div>
            
            <div class="relative z-10">
                <div class="flex items-start justify-between mb-8">
                    <div class="w-20 h-20 rounded-[1.5rem] bg-slate-50 border border-slate-100 flex items-center justify-center p-4 shadow-sm group-hover:scale-110 transition-transform">
                        @if($method->icon)
                            <img loading="lazy" src="{{ asset('storage/' . $method->icon) }}" class="w-full h-full object-contain">
                        @else
                            <i class="fas fa-wallet text-slate-300 text-3xl"></i>
                        @endif
                    </div>
                    @if($method->is_active)
                    <span class="px-5 py-2 bg-emerald-50 text-emerald-600 border border-emerald-100 rounded-full text-[8px] font-black uppercase tracking-widest flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span> Active
                    </span>
                    @else
                    <span class="px-5 py-2 bg-slate-50 text-slate-400 border border-slate-100 rounded-full text-[8px] font-black uppercase tracking-widest">Inactive</span>
                    @endif
                </div>

                <h3 class="text-xl font-black text-dark mb-2 italic tracking-tight">{{ $method->name }}</h3>
                <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest mb-8 line-clamp-1 italic">{{ $method->account_number ?? 'No ID set' }}</p>

                <div class="flex items-center gap-3 pt-6 border-t border-slate-50">
                    <a href="{{ route('admin.finance.payment-methods.edit', $method->id) }}" class="flex-1 bg-slate-50 hover:bg-primary hover:text-white text-dark py-4 rounded-2xl font-black text-[9px] tracking-widest uppercase transition-all text-center italic shadow-sm">
                        Edit Settings
                    </a>
                    <button type="button" onclick="confirmDelete('delete-form-{{ $method->id }}', 'Users won\'t be able to pay using this method anymore.')" class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-500 flex items-center justify-center hover:bg-rose-500 hover:text-white transition-all border border-rose-100 shadow-sm">
                        <i class="fas fa-trash-alt text-[10px]"></i>
                    </button>
                    <form id="delete-form-{{ $method->id }}" action="{{ route('admin.finance.payment-methods.destroy', $method->id) }}" method="POST" class="hidden">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
        @endforeach

        @if($methods->isEmpty())
        <div class="col-span-full py-24 text-center">
            <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 border border-slate-100">
                <i class="fas fa-wallet text-slate-200 text-3xl"></i>
            </div>
            <h3 class="text-dark font-black text-xl mb-2 italic">No Gateways Configured</h3>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">Add your first manual payment gateway to start accepting bookings.</p>
        </div>
        @endif
    </div>
</div>

<script>

    @if(session('success'))
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 3000,
            background: '#10B981',
            color: '#ffffff'
        });
    @endif
</script>
@endsection
