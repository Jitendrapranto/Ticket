@extends('admin.dashboard')

@section('admin_content')
<div class="px-8 py-8 animate-fadeIn">
    <!-- Header -->
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-12 gap-6">
        <div>
            <div class="flex items-center gap-4 mb-3">
                <a href="{{ route('admin.finance.payment-methods.index') }}" class="w-10 h-10 rounded-2xl bg-white flex items-center justify-center text-slate-400 hover:text-primary transition-colors border border-slate-100 shadow-sm">
                    <i class="fas fa-arrow-left text-[10px]"></i>
                </a>
                <span class="text-slate-400 text-[9px] font-black uppercase tracking-[0.3em]">Finance / Checkout</span>
            </div>
            <h1 class="text-3xl font-black text-dark italic tracking-tighter">Edit <span class="text-primary underline decoration-primary/10 decoration-8 underline-offset-8">Gateway</span></h1>
        </div>
    </div>

    <!-- Form -->
    <form id="payment-form" action="{{ route('admin.finance.payment-methods.update', $paymentMethod->id) }}" method="POST" enctype="multipart/form-data" class="max-w-4xl">
        @csrf
        @method('PUT')
        <div class="bg-white border border-white rounded-[3rem] p-12 space-y-10 shadow-premium">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <!-- Name -->
                <div class="space-y-4">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4">Gateway Name</label>
                    <input type="text" name="name" value="{{ old('name', $paymentMethod->name) }}" required placeholder="e.g. bKash"
                           class="w-full bg-slate-50 border border-slate-100 rounded-3xl px-8 py-5 text-dark font-bold text-sm focus:border-primary focus:bg-white transition-all outline-none italic">
                </div>

                <!-- Account Number -->
                <div class="space-y-4">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4">Account/Reference ID</label>
                    <input type="text" name="account_number" value="{{ old('account_number', $paymentMethod->account_number) }}" placeholder="e.g. 017XX-XXXXXX"
                           class="w-full bg-slate-50 border border-slate-100 rounded-3xl px-8 py-5 text-dark font-bold text-sm focus:border-primary focus:bg-white transition-all outline-none italic text-primary font-black">
                </div>
            </div>

            <!-- Instructions -->
            <div class="space-y-4">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4">Payment Instructions (Dynamic)</label>
                <textarea name="instructions" rows="6" required placeholder="Step by step instructions..."
                          class="w-full bg-slate-50 border border-slate-100 rounded-[2rem] px-8 py-6 text-dark font-medium text-sm focus:border-primary focus:bg-white transition-all outline-none leading-relaxed">{{ old('instructions', $paymentMethod->instructions) }}</textarea>
                <p class="text-[9px] text-slate-300 italic px-4 uppercase tracking-widest">Available Variable: <span class="text-primary font-black">[amount]</span> for dynamic pricing.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <!-- Icon Upload -->
                <div class="space-y-4">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4">Gateway Logo</label>
                    @if($paymentMethod->icon)
                    <div class="mb-4 flex items-center gap-4 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <img src="{{ asset('storage/' . $paymentMethod->icon) }}" class="w-12 h-12 object-contain">
                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Current Icon</span>
                    </div>
                    @endif
                    <div class="relative group border-2 border-dashed border-slate-100 rounded-[2.5rem] p-10 flex flex-col items-center justify-center hover:bg-slate-50 transition-all cursor-pointer">
                        <input type="file" name="icon" class="absolute inset-0 opacity-0 cursor-pointer" accept="image/*">
                        <i class="fas fa-cloud-upload-alt text-slate-200 text-3xl mb-4 group-hover:scale-110 transition-transform"></i>
                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Replace Logo</span>
                    </div>
                </div>

                <!-- QR Code Upload -->
                <div class="space-y-4">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4">Payment QR Code</label>
                    @if($paymentMethod->qr_code)
                    <div class="mb-4 flex items-center gap-4 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <img src="{{ asset('storage/' . $paymentMethod->qr_code) }}" class="w-12 h-12 object-contain">
                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Current QR</span>
                    </div>
                    @endif
                    <div class="relative group border-2 border-dashed border-slate-100 rounded-[2.5rem] p-10 flex flex-col items-center justify-center hover:bg-slate-50 transition-all cursor-pointer">
                        <input type="file" name="qr_code" class="absolute inset-0 opacity-0 cursor-pointer" accept="image/*">
                        <i class="fas fa-qrcode text-slate-200 text-3xl mb-4 group-hover:scale-110 transition-transform"></i>
                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Replace QR</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 pt-6 border-t border-slate-50">
                <!-- Status -->
                <div class="space-y-4">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4">Visibility Status</label>
                    <select name="is_active" class="w-full bg-slate-50 border border-slate-100 rounded-3xl px-8 py-5 text-dark font-bold text-sm focus:border-primary focus:bg-white transition-all outline-none italic appearance-none cursor-pointer shadow-sm">
                        <option value="1" {{ $paymentMethod->is_active ? 'selected' : '' }}>Active (Published Online)</option>
                        <option value="0" {{ !$paymentMethod->is_active ? 'selected' : '' }}>Draft (Hidden from Checkout)</option>
                    </select>
                </div>

                <!-- Sort Order -->
                <div class="space-y-4">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4">Dashboard Priority (Sort)</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $paymentMethod->sort_order) }}" required
                           class="w-full bg-slate-50 border border-slate-100 rounded-3xl px-8 py-5 text-dark font-bold text-sm focus:border-primary focus:bg-white transition-all outline-none italic">
                </div>
            </div>

            <div class="pt-10 flex gap-4">
                <button type="button" onclick="confirmUpdate()" class="flex-1 bg-primary hover:bg-dark text-white py-6 rounded-[2rem] font-black text-xs tracking-[0.3em] uppercase transition-all shadow-premium active:scale-95 italic">
                    Sync Changes
                </button>
                <a href="{{ route('admin.finance.payment-methods.index') }}" class="px-10 flex items-center justify-center bg-slate-50 text-slate-400 border border-slate-100 rounded-[2.5rem] font-black text-[9px] tracking-widest uppercase hover:bg-slate-100 transition-colors">
                    Cancel
                </a>
            </div>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmUpdate() {
        Swal.fire({
            title: 'Update Gateway?',
            text: "All live users will see the updated instructions immediately.",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#7C3AED',
            confirmButtonText: 'Yes, Sync Now',
            background: '#ffffff',
            color: '#1e293b',
            customClass: {
                popup: 'rounded-[2rem] border border-slate-100 shadow-2xl',
                confirmButton: 'rounded-2xl px-10 py-5 font-black uppercase tracking-widest text-[10px]',
                cancelButton: 'rounded-2xl px-10 py-5 font-black uppercase tracking-widest text-[10px]'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('payment-form').submit();
            }
        })
    }
</script>
@endsection
