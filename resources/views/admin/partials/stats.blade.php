<!-- Dynamic Statistics Command Center (Re-engineered Large Layout) -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
    <!-- Total Sales -->
    <div class="group relative bg-gradient-to-br from-primary to-[#3a084c] py-10 px-8 rounded-xl shadow-premium transition-all duration-500 overflow-hidden h-44">
        <div class="relative z-10 text-white h-full flex flex-col justify-center">
            <p class="text-[10px] font-black tracking-[0.2em] text-white/60 uppercase mb-3">Total Sales</p>
            <h3 class="text-4xl font-black tracking-tighter">৳{{ number_format($totalSales ?? 0, 0) }}</h3>
        </div>
        <div class="absolute -right-4 -bottom-4 opacity-10 text-white group-hover:scale-110 group-hover:-rotate-12 transition-all duration-700">
            <i class="fa-solid fa-coins text-7xl"></i>
        </div>
        <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full blur-3xl -mr-16 -mt-16"></div>
    </div>

    <!-- Today's Sale -->
    <div class="group relative bg-gradient-to-br from-[#10B981] to-emerald-700 py-10 px-8 rounded-xl shadow-premium transition-all duration-500 overflow-hidden h-44">
        <div class="relative z-10 text-white h-full flex flex-col justify-center">
            <p class="text-[10px] font-black tracking-[0.2em] text-white/60 uppercase mb-3">Today's Sale</p>
            <h3 class="text-4xl font-black tracking-tighter">৳{{ number_format($todaySales ?? 0, 0) }}</h3>
        </div>
        <div class="absolute -right-4 -bottom-4 opacity-10 text-white group-hover:scale-110 group-hover:-rotate-12 transition-all duration-700">
            <i class="fa-solid fa-bolt-lightning text-7xl"></i>
        </div>
        <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full blur-3xl -mr-16 -mt-16"></div>
    </div>

    <!-- Total Events -->
    <div class="group relative bg-gradient-to-br from-accent to-blue-700 py-10 px-8 rounded-xl shadow-premium transition-all duration-500 overflow-hidden h-44">
        <div class="relative z-10 text-white h-full flex flex-col justify-center">
            <p class="text-[10px] font-black tracking-[0.2em] text-white/60 uppercase mb-3">Total Events</p>
            <h3 class="text-4xl font-black tracking-tighter">{{ number_format($totalEvents ?? 0) }}</h3>
        </div>
        <div class="absolute -right-4 -bottom-4 opacity-10 text-white group-hover:scale-110 group-hover:-rotate-12 transition-all duration-700">
            <i class="fa-solid fa-masks-theater text-7xl"></i>
        </div>
        <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full blur-3xl -mr-16 -mt-16"></div>
    </div>

    <!-- Organizer Request -->
    <a href="{{ route('admin.organizer-requests.index') }}" class="group relative bg-gradient-to-br from-[#FF3366] to-[#C2185B] py-10 px-8 rounded-xl shadow-premium hover:-translate-y-2 transition-all duration-500 overflow-hidden h-44 border border-white/10">
        <div class="relative z-10 text-white h-full flex flex-col justify-center">
            <p class="text-[10px] font-black tracking-[0.2em] text-white/80 uppercase mb-3 text-shadow-sm">Organizer Request</p>
            <h3 class="text-4xl font-black tracking-tighter text-shadow-md">{{ number_format($organizerRequests ?? 0) }}</h3>
        </div>
        <div class="absolute -right-4 -bottom-4 opacity-20 text-white group-hover:scale-110 group-hover:-rotate-12 transition-all duration-700">
            <i class="fa-solid fa-user-tie text-7xl"></i>
        </div>
        <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full blur-2xl -mr-12 -mt-12"></div>
    </a>

    <!-- Event Approval -->
    <a href="{{ route('admin.events.index') }}" class="group relative bg-gradient-to-br from-teal-400 to-teal-800 py-10 px-8 rounded-xl shadow-premium hover:-translate-y-2 transition-all duration-500 overflow-hidden h-44 border border-white/10">
        <div class="relative z-10 text-white h-full flex flex-col justify-center">
            <p class="text-[10px] font-black tracking-[0.2em] text-white/60 uppercase mb-3">Event Approval</p>
            <h3 class="text-4xl font-black tracking-tighter">{{ number_format($eventApprovalRequests ?? 0) }}</h3>
        </div>
        <div class="absolute -right-4 -bottom-4 opacity-10 text-white group-hover:scale-110 group-hover:-rotate-12 transition-all duration-700">
            <i class="fa-solid fa-circle-check text-7xl"></i>
        </div>
        <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full blur-3xl -mr-16 -mt-16"></div>
    </a>

    <!-- Payment Approval -->
    <a href="{{ route('admin.finance.bookings.index', ['status' => 'pending']) }}" class="group relative bg-gradient-to-br from-amber-500 to-orange-700 py-10 px-8 rounded-xl shadow-premium hover:-translate-y-2 transition-all duration-500 overflow-hidden h-44 border border-white/10">
        <div class="relative z-10 text-white h-full flex flex-col justify-center">
            <p class="text-[10px] font-black tracking-[0.2em] text-white/60 uppercase mb-3">Payment Approval</p>
            <h3 class="text-4xl font-black tracking-tighter">{{ number_format($paymentApprovalRequests ?? 0) }}</h3>
        </div>
        <div class="absolute -right-4 -bottom-4 opacity-10 text-white group-hover:scale-110 group-hover:-rotate-12 transition-all duration-700">
            <i class="fa-solid fa-money-bill-transfer text-7xl"></i>
        </div>
        <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full blur-3xl -mr-16 -mt-16"></div>
    </a>
</div>
