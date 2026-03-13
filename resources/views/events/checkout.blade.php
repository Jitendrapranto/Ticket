@extends('layouts.app')

@section('title', 'Secure Checkout - ' . $booking->event->title)

@section('content')
<div class="container mx-auto px-4 max-w-6xl mb-24 py-12">
    <!-- Header -->
    <div class="flex flex-col items-center justify-center mb-16 animate-fadeInUp">
        <div class="w-20 h-20 rounded-[2rem] bg-primary/10 flex items-center justify-center text-primary text-3xl mb-6 shadow-sm border border-primary/5">
            <i class="fas fa-lock"></i>
        </div>
        <h1 class="font-outfit text-4xl font-black text-dark tracking-tight mb-2">Finalize Booking</h1>
        <p class="text-slate-500 font-medium">Complete your payment using your preferred mobile banking method.</p>
    </div>

    <!-- Checkout Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12" x-data="{ 
        selectedMethod: '{{ $paymentMethods->first()->slug ?? '' }}',
        methods: {{ json_encode($paymentMethods) }},
        get selectedData() {
            return this.methods.find(m => m.slug === this.selectedMethod) || {}
        }
    }">
        <!-- Left: Payment Form (8 cols) -->
        <div class="lg:col-span-7 space-y-10 animate-fadeInUp" style="animation-delay: 0.1s">
            
            <form action="{{ route('events.checkout.complete', $booking->booking_id) }}" method="POST" enctype="multipart/form-data" class="space-y-10">
                @csrf
                <input type="hidden" name="payment_method" :value="selectedMethod">

                <!-- Payment Method Selector -->
                <div class="bg-white rounded-[2.5rem] p-10 border border-slate-100 shadow-premium">
                    <h2 class="text-xl font-outfit font-black text-dark mb-10 flex items-center gap-4">
                        <span class="w-10 h-10 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-500 text-sm">
                            <i class="fas fa-wallet"></i>
                        </span>
                        Select Payment Method
                    </h2>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($paymentMethods as $method)
                        <button type="button" 
                                @click="selectedMethod = '{{ $method->slug }}'"
                                :class="selectedMethod === '{{ $method->slug }}' ? 'border-primary bg-primary/5 shadow-lg shadow-primary/10 scale-[1.02]' : 'border-slate-100 bg-white hover:border-slate-300'"
                                class="flex flex-col items-center gap-4 p-6 rounded-3xl border-2 transition-all duration-300 relative group">
                            <div class="w-16 h-16 rounded-2xl bg-slate-50 flex items-center justify-center overflow-hidden border border-slate-100 group-hover:scale-110 transition-transform">
                                @if($method->icon)
                                    <img loading="lazy" src="{{ asset('storage/' . $method->icon) }}" class="w-12 h-12 object-contain">
                                @else
                                    <span class="font-black text-xs text-slate-400">{{ strtoupper($method->name) }}</span>
                                @endif
                            </div>
                            <span class="text-[10px] font-black uppercase tracking-widest" :class="selectedMethod === '{{ $method->slug }}' ? 'text-primary' : 'text-slate-500'">{{ $method->name }}</span>
                            
                            <template x-if="selectedMethod === '{{ $method->slug }}'">
                                <div class="absolute -top-2 -right-2 w-6 h-6 bg-primary text-white rounded-full flex items-center justify-center text-[10px] shadow-lg">
                                    <i class="fas fa-check"></i>
                                </div>
                            </template>
                        </button>
                        @endforeach
                    </div>
                </div>

                <!-- Payment Instructions -->
                <div class="bg-indigo-50/50 rounded-[2.5rem] p-10 border border-indigo-100/50 relative overflow-hidden group">
                    <div class="absolute -right-20 -top-20 w-64 h-64 bg-indigo-500/5 rounded-full blur-3xl group-hover:bg-indigo-500/10 transition-colors"></div>
                    
                    <div class="flex flex-col md:flex-row gap-10 relative z-10">
                        <!-- Instructions Text -->
                        <div class="flex-1">
                            <h3 class="text-indigo-600 font-bold flex items-center gap-3 mb-6">
                                <i class="fas fa-info-circle text-lg"></i>
                                <span class="text-xs uppercase tracking-widest font-black">Payment Instructions</span>
                            </h3>

                            <div class="prose prose-sm max-w-none text-slate-600 font-medium">
                                <div x-html="selectedData.instructions ? selectedData.instructions.replace('[amount]', '{{ number_format($booking->total_amount) }}').replace(/\n/g, '<br>') : ''"></div>
                            </div>
                        </div>

                        <!-- QR Code -->
                        <div class="shrink-0 flex flex-col items-center md:items-end justify-start gap-4" x-show="selectedData.qr_code">
                            <div class="p-4 bg-white rounded-3xl shadow-sm border border-indigo-100">
                                <img loading="lazy" :src="'{{ asset('storage') }}/' + selectedData.qr_code" class="w-32 h-32 object-contain" alt="QR Code">
                            </div>
                            <span class="text-[9px] font-black text-indigo-400 uppercase tracking-widest">Scan to Pay</span>
                        </div>
                    </div>
                </div>

                <!-- Transaction Inputs -->
                <div class="bg-white rounded-[2.5rem] p-10 border border-slate-100 shadow-premium">
                    <h2 class="text-xl font-outfit font-black text-dark mb-10 flex items-center gap-4">
                        <span class="w-10 h-10 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-500 text-sm">
                            <i class="fas fa-file-invoice-dollar"></i>
                        </span>
                        Transaction Details
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Transaction ID</label>
                            <div class="relative group">
                                <i class="fas fa-hashtag absolute left-6 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-primary transition-colors"></i>
                                <input type="text" name="transaction_id" required placeholder="e.g. 8N7A6D5C4B" 
                                       class="w-full pl-14 pr-6 py-5 bg-slate-50 border border-slate-100 rounded-2xl text-dark font-bold text-sm focus:bg-white focus:border-primary focus:ring-4 focus:ring-primary/5 transition-all outline-none">
                            </div>
                        </div>
                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Your Mobile Number</label>
                            <div class="relative group">
                                <i class="fas fa-phone absolute left-6 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-primary transition-colors"></i>
                                <input type="text" name="payment_number" required placeholder="01XXX-XXXXXX" 
                                       class="w-full pl-14 pr-6 py-5 bg-slate-50 border border-slate-100 rounded-2xl text-dark font-bold text-sm focus:bg-white focus:border-primary focus:ring-4 focus:ring-primary/5 transition-all outline-none">
                            </div>
                        </div>
                    </div>

                    <!-- Screenshot Upload -->
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Payment Screenshot (Optional)</label>
                        <div class="relative group border-2 border-dashed border-slate-200 rounded-[2.5rem] p-12 flex flex-col items-center justify-center hover:border-primary/30 transition-all cursor-pointer bg-slate-50/30">
                            <input type="file" name="payment_screenshot" id="screenshot-upload" class="absolute inset-0 opacity-0 cursor-pointer" accept="image/*"
                                   @change="const file = $event.target.files[0]; if(file) { document.getElementById('preview-box').classList.remove('hidden'); document.getElementById('upload-icon').classList.add('hidden'); }">
                            
                            <div id="upload-icon" class="flex flex-col items-center text-center">
                                <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center text-primary mb-4 group-hover:scale-110 transition-transform">
                                    <i class="fas fa-cloud-upload-alt text-2xl"></i>
                                </div>
                                <h4 class="text-sm font-black text-dark mb-1">Click to upload screenshot</h4>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">PNG, JPG up to 2MB</p>
                            </div>

                            <div id="preview-box" class="hidden flex flex-col items-center">
                                <div class="px-6 py-3 bg-emerald-500 rounded-2xl text-[10px] font-black text-white tracking-widest uppercase flex items-center gap-2">
                                    <i class="fas fa-check-circle"></i> Screenshot Selected
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="hidden lg:block">
                    <button type="submit" class="w-full bg-[#1B2B46] text-white py-6 rounded-3xl font-black text-sm tracking-[0.3em] transition-all shadow-2xl active:scale-[0.98] uppercase flex items-center justify-center gap-4 hover:bg-primary group overflow-hidden relative">
                        <span class="relative z-10">Complete Booking</span>
                        <i class="fas fa-arrow-right text-xs group-hover:translate-x-2 transition-transform relative z-10"></i>
                        <div class="absolute inset-0 bg-gradient-to-r from-primary to-indigo-600 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    </button>
                    <p class="text-center mt-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Secure 256-bit SSL Encrypted Transaction</p>
                </div>
            </form>
        </div>

        <!-- Right: Summary (4 cols) -->
        <div class="lg:col-span-5 space-y-8 animate-fadeInUp" style="animation-delay: 0.2s">
            <div class="lg:sticky lg:top-40 space-y-8">
                <!-- Order Summary Card -->
                <div class="bg-white rounded-[3rem] border border-slate-100 shadow-premium overflow-hidden">
                    <div class="bg-dark p-8 text-white relative h-40">
                        <div class="absolute inset-0 opacity-40">
                            @if($booking->event->image)
                                <img loading="lazy" src="{{ asset('storage/' . $booking->event->image) }}" class="w-full h-full object-cover grayscale">
                            @endif
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-dark to-dark/20"></div>
                        <div class="relative z-10 flex flex-col h-full justify-end">
                            <span class="text-[9px] font-black uppercase tracking-[0.3em] text-primary mb-2">Order Summary</span>
                            <h3 class="font-outfit text-2xl font-black tracking-tight line-clamp-1">{{ $booking->event->title }}</h3>
                        </div>
                    </div>

                    <div class="p-10 space-y-8">
                        <!-- Items -->
                        <div class="space-y-4">
                            @foreach($booking->attendees->groupBy('ticket_type_id') as $tierId => $attendees)
                            <div class="flex items-center justify-between py-4 border-b border-slate-50 last:border-0">
                                <div class="flex items-center gap-5">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center text-dark font-black text-sm shadow-sm">
                                        {{ $attendees->count() }}
                                    </div>
                                    <div>
                                        <h4 class="text-xs font-black text-dark uppercase tracking-wider">{{ $attendees->first()->ticketType->name }}</h4>
                                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">৳ {{ number_format($attendees->first()->ticketType->price) }} / ticket</p>
                                    </div>
                                </div>
                                <span class="text-xs font-black text-dark">৳ {{ number_format($attendees->first()->ticketType->price * $attendees->count()) }}</span>
                            </div>
                            @endforeach
                        </div>

                        <!-- Calculations -->
                        <div class="bg-slate-50 rounded- [2rem] p-8 space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Subtotal</span>
                                <span class="text-xs font-black text-dark">৳ {{ number_format($booking->subtotal_amount) }}</span>
                            </div>
                            <div class="flex justify-between items-center text-primary">
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-black uppercase tracking-widest">Processing Fee</span>
                                    <span class="text-[8px] font-bold opacity-50 uppercase tracking-tighter">Secure processing & platform maintenance</span>
                                </div>
                                <span class="text-xs font-black">+ ৳ {{ number_format($booking->commission_amount) }}</span>
                            </div>
                            <div class="pt-6 border-t border-slate-200 flex justify-between items-end">
                                <div>
                                    <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-1">Total Payable</h4>
                                    <p class="text-[8px] text-slate-400 font-bold uppercase tracking-widest">Includes all taxes and fees</p>
                                </div>
                                <div class="text-right">
                                    <span class="text-4xl font-outfit font-black text-dark tracking-tighter leading-none">৳{{ number_format($booking->total_amount) }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="lg:hidden">
                            <button type="submit" class="w-full bg-[#1B2B46] text-white py-6 rounded-3xl font-black text-sm tracking-[0.3em] transition-all shadow-2xl active:scale-[0.98] uppercase flex items-center justify-center gap-4 hover:bg-primary group overflow-hidden relative">
                                <span class="relative z-10">Complete Booking</span>
                                <i class="fas fa-arrow-right text-xs group-hover:translate-x-2 transition-transform relative z-10"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Support Card -->
                <div class="bg-indigo-600 rounded-[3rem] p-10 text-white shadow-2xl relative overflow-hidden group">
                    <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/5 rounded-full blur-2xl group-hover:bg-white/10 transition-colors"></div>
                    <div class="relative z-10">
                        <h4 class="font-outfit text-xl font-black mb-4">Need Assistance?</h4>
                        <p class="text-indigo-100/70 text-xs font-medium leading-relaxed mb-8">Our VIP support team is available 24/7 to help with your payment verification or any technical queries.</p>
                        <a href="{{ route('contact') }}" class="inline-flex items-center gap-3 bg-white text-indigo-600 px-8 py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-50 transition-colors active:scale-95 shadow-xl">
                            Contact Support
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('error'))
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
                background: '#F43F5E',
                color: '#ffffff',
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            Toast.fire({
                icon: 'error',
                title: "{{ session('error') }}"
            });
        @endif
    });
</script>

<style>
    body { background-color: #F9FBFE !important; }
    header { background-color: white !important; }
    [x-cloak] { display: none !important; }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fadeInUp { animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    .shadow-premium { box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.03), 0 0 1px rgba(0,0,0,0.1); }
</style>
@endsection
