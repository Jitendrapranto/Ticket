<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Organizer Requests | Ticket Kinun Admin</title>
    <style>html{visibility:hidden;opacity:0}html.ready{visibility:visible;opacity:1;transition:opacity .15s ease-in}</style>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config={theme:{extend:{colors:{primary:'#520C6B',secondary:'#21032B',accent:'#FFE700',dark:'#0F172A'},fontFamily:{sans:['Arial','Helvetica','sans-serif'],outfit:['Arial','Helvetica','sans-serif'],plus:['Arial','Helvetica','sans-serif']},boxShadow:{'premium':'0 20px 50px -12px rgba(82,12,107,0.25)'}}}}
    </script>
    <style>
        body{font-family:Arial,Helvetica,sans-serif}*{font-style:normal!important}
        .no-scrollbar::-webkit-scrollbar{display:none}.no-scrollbar{-ms-overflow-style:none;scrollbar-width:none}
        @keyframes fadeInUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}
        .animate-fadeInUp{animation:fadeInUp 0.35s ease forwards}
    </style>
    <script>document.addEventListener('DOMContentLoaded',function(){document.documentElement.classList.add('ready')});setTimeout(function(){document.documentElement.classList.add('ready')},100)</script>
</head>
<body class="bg-[#F1F5F9] text-slate-800">

@include('admin.sidebar')

<div class="lg:ml-72 min-h-screen flex flex-col">

    <!-- Topbar -->
    <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-100 flex items-center justify-between px-8 sticky top-0 z-40 shadow-sm">
        <div class="flex items-center gap-4">
            <button id="toggle-sidebar" class="lg:hidden w-10 h-10 flex items-center justify-center rounded-xl bg-slate-50 text-dark">
                <i class="fas fa-bars"></i>
            </button>
            <div>
                <h2 class="font-outfit text-xl font-black text-dark tracking-tight">Organizer Requests</h2>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Review & Approve Applications</p>
            </div>
        </div>
        <div class="flex items-center gap-4" x-data="{ open: false }">
            <div class="relative">
                <button @click="open = !open" @click.away="open = false" class="flex items-center gap-3 focus:outline-none">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-[#520C6B] to-[#21032B] p-0.5 shadow-premium">
                        <div class="w-full h-full rounded-[14px] bg-white flex items-center justify-center">
                            <i class="fas fa-crown text-[#520C6B] text-xs"></i>
                        </div>
                    </div>
                </button>
                <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95 translate-y-2" x-transition:enter-end="opacity-100 scale-100 translate-y-0" class="absolute right-0 mt-3 w-52 bg-white rounded-3xl shadow-2xl border border-slate-100 py-3 z-50" style="display:none">
                    <div class="px-5 py-3 border-b border-slate-50 mb-1">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Authenticated As</p>
                        <p class="text-xs font-bold text-dark truncate">{{ Auth::user()->email ?? 'Admin' }}</p>
                    </div>
                    <a href="/" target="_blank" class="flex items-center gap-3 px-5 py-2.5 text-slate-600 hover:text-[#520C6B] hover:bg-[#520C6B]/5 transition-all text-xs font-black"><i class="fas fa-external-link-alt"></i> Live Site</a>
                    <form action="{{ route('admin.logout') }}" method="POST" class="mt-1 pt-1 border-t border-slate-50">@csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-5 py-2.5 text-red-500 hover:bg-red-50 transition-all text-xs font-black"><i class="fas fa-power-off"></i> Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Content -->
    <main class="p-6 lg:p-10 flex-1 space-y-8">

        <!-- Toast Container -->
        <div id="toast-container" class="fixed top-6 right-6 z-[9999] flex flex-col gap-3 pointer-events-none"></div>

        <!-- Approve Modal -->
        <div id="approveModal" class="fixed inset-0 z-[9998] flex items-center justify-center hidden">
            <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeApproveModal()"></div>
            <div class="relative bg-white rounded-3xl shadow-2xl max-w-md w-full mx-4 overflow-hidden animate-fadeInUp">
                <div class="bg-gradient-to-br from-[#21032B] to-[#520C6B] p-8 text-center">
                    <div class="w-20 h-20 rounded-full bg-[#FFE700]/20 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-user-check text-[#FFE700] text-3xl"></i>
                    </div>
                    <h3 class="text-white text-xl font-black tracking-tight">Approve Organizer?</h3>
                    <p class="text-white/60 text-sm font-medium mt-2">This organizer will gain full access to the organizer dashboard immediately.</p>
                </div>
                <div class="p-6 space-y-4">
                    <div class="bg-slate-50 rounded-2xl p-4 space-y-1">
                        <p class="font-black text-[#21032B] text-sm" id="modal-org-name">—</p>
                        <p class="text-slate-500 font-medium text-xs" id="modal-org-institution">—</p>
                        <p class="text-slate-400 text-xs font-medium" id="modal-org-email">—</p>
                    </div>
                    <div class="flex gap-3">
                        <button onclick="closeApproveModal()" class="flex-1 py-3 rounded-xl border-2 border-slate-100 text-slate-500 font-black text-xs uppercase tracking-widest hover:bg-slate-50 transition-all">Cancel</button>
                        <button id="confirmApproveBtn" onclick="confirmApprove()" class="flex-1 py-3 rounded-xl bg-[#21032B] text-[#FFE700] font-black text-xs uppercase tracking-widest hover:bg-[#520C6B] transition-all flex items-center justify-center gap-2">
                            <i class="fas fa-check"></i> Approve Now
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reject Modal -->
        <div id="rejectModal" class="fixed inset-0 z-[9998] flex items-center justify-center hidden">
            <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeRejectModal()"></div>
            <div class="relative bg-white rounded-3xl shadow-2xl max-w-sm w-full mx-4 overflow-hidden animate-fadeInUp">
                <div class="bg-gradient-to-br from-red-800 to-red-500 p-8 text-center">
                    <div class="w-20 h-20 rounded-full bg-white/20 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-user-times text-white text-3xl"></i>
                    </div>
                    <h3 class="text-white text-xl font-black tracking-tight">Reject Request?</h3>
                    <p class="text-white/70 text-sm font-medium mt-2">This will reject the organizer application. You can re-approve anytime.</p>
                </div>
                <div class="p-6 flex gap-3">
                    <button onclick="closeRejectModal()" class="flex-1 py-3 rounded-xl border-2 border-slate-100 text-slate-500 font-black text-xs uppercase tracking-widest hover:bg-slate-50 transition-all">Cancel</button>
                    <button id="confirmRejectBtn" onclick="confirmReject()" class="flex-1 py-3 rounded-xl bg-red-600 text-white font-black text-xs uppercase tracking-widest hover:bg-red-700 transition-all flex items-center justify-center gap-2">
                        <i class="fas fa-times"></i> Reject
                    </button>
                </div>
            </div>
        </div>

        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-black text-[#21032B] tracking-tight">Organizer Requests</h1>
                <p class="text-slate-400 text-sm font-medium mt-1">Review and manage organizer account applications</p>
            </div>
            @if($pendingCount > 0)
            <div class="inline-flex items-center gap-2 bg-[#FFE700]/10 border border-[#FFE700]/30 rounded-2xl px-5 py-3">
                <span class="w-2.5 h-2.5 rounded-full bg-[#FFE700] animate-pulse"></span>
                <span class="text-[#21032B] font-black text-sm">{{ $pendingCount }} Pending Review</span>
            </div>
            @endif
        </div>

        <!-- Status Tabs -->
        <div class="flex flex-wrap gap-2">
            @foreach(['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected', 'all' => 'All Requests'] as $tab => $label)
            <a href="{{ route('admin.organizer-requests.index', ['status' => $tab]) }}"
               class="px-5 py-2.5 rounded-xl font-black text-xs uppercase tracking-widest transition-all border
               @if($status === $tab)
                   @if($tab === 'pending') bg-[#21032B] text-[#FFE700] border-transparent shadow-lg
                   @elseif($tab === 'approved') bg-green-600 text-white border-transparent shadow-lg
                   @elseif($tab === 'rejected') bg-red-500 text-white border-transparent shadow-lg
                   @else bg-slate-600 text-white border-transparent shadow-lg
                   @endif
               @else text-slate-500 bg-white border-slate-200 hover:border-[#520C6B]/30 hover:text-[#520C6B]
               @endif">
                {{ $label }}
                @if($tab === 'pending' && $pendingCount > 0)
                    <span class="ml-1.5 bg-[#FFE700] text-[#21032B] text-[9px] font-black px-1.5 py-0.5 rounded-full">{{ $pendingCount }}</span>
                @endif
            </a>
            @endforeach
        </div>

        <!-- Table -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            @if($requests->isEmpty())
            <div class="py-24 text-center">
                <div class="w-20 h-20 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-5">
                    <i class="fas fa-user-tie text-slate-300 text-3xl"></i>
                </div>
                <p class="text-slate-400 font-black text-sm uppercase tracking-widest">No {{ $status }} requests found</p>
                <p class="text-slate-300 text-xs font-medium mt-1">Organizer applications will appear here</p>
            </div>
            @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-slate-100 bg-slate-50/60">
                            <th class="text-left px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">#</th>
                            <th class="text-left px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Applicant</th>
                            <th class="text-left px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Contact</th>
                            <th class="text-left px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Address</th>
                            <th class="text-left px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Applied</th>
                            <th class="text-left px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                            <th class="text-left px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($requests as $i => $req)
                        <tr class="hover:bg-slate-50/50 transition-colors" id="row-{{ $req->id }}">
                            <td class="px-6 py-5 text-slate-400 text-sm font-bold">{{ $requests->firstItem() + $i }}</td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-[#21032B] to-[#520C6B] flex items-center justify-center shrink-0 shadow">
                                        @if($req->avatar)
                                            <img src="{{ asset('storage/'.$req->avatar) }}" class="w-11 h-11 rounded-xl object-cover">
                                        @else
                                            <span class="text-[#FFE700] font-black text-base">{{ strtoupper(substr($req->name,0,1)) }}</span>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-[#21032B] font-black text-sm">{{ $req->name }}</p>
                                        <p class="text-slate-400 text-xs font-medium">{{ $req->institution_name ?? '—' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <p class="text-slate-700 text-sm font-bold">{{ $req->email }}</p>
                                <p class="text-slate-400 text-xs font-medium mt-0.5">{{ $req->phone ?? '—' }}</p>
                            </td>
                            <td class="px-6 py-5">
                                <p class="text-slate-500 text-xs font-medium max-w-[180px] leading-relaxed">{{ $req->present_address ?? '—' }}</p>
                            </td>
                            <td class="px-6 py-5">
                                <p class="text-slate-600 text-sm font-bold">{{ $req->created_at->format('d M, Y') }}</p>
                                <p class="text-slate-400 text-[10px] font-medium mt-0.5">{{ $req->created_at->diffForHumans() }}</p>
                            </td>
                            <td class="px-6 py-5">
                                @if($req->organizer_status === 'pending')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-[#FFE700]/10 text-yellow-700 text-[10px] font-black uppercase tracking-widest border border-[#FFE700]/30">
                                        <span class="w-1.5 h-1.5 rounded-full bg-[#FFE700] animate-pulse"></span> Pending
                                    </span>
                                @elseif($req->organizer_status === 'approved')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-green-50 text-green-700 text-[10px] font-black uppercase tracking-widest border border-green-200">
                                        <i class="fas fa-check text-[8px]"></i> Approved
                                    </span>
                                @elseif($req->organizer_status === 'rejected')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-red-50 text-red-600 text-[10px] font-black uppercase tracking-widest border border-red-200">
                                        <i class="fas fa-times text-[8px]"></i> Rejected
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-2">
                                    @if($req->organizer_status === 'pending')
                                    <button onclick="openApproveModal({{ $req->id }},'{{ addslashes($req->name) }}','{{ addslashes($req->institution_name ?? '') }}','{{ $req->email }}')"
                                        class="w-9 h-9 flex items-center justify-center rounded-xl bg-[#21032B] text-[#FFE700] hover:bg-[#520C6B] transition-all text-xs" title="Approve">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button onclick="openRejectModal({{ $req->id }})"
                                        class="w-9 h-9 flex items-center justify-center rounded-xl bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-all text-xs" title="Reject">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    @elseif($req->organizer_status === 'rejected')
                                    <button onclick="openApproveModal({{ $req->id }},'{{ addslashes($req->name) }}','{{ addslashes($req->institution_name ?? '') }}','{{ $req->email }}')"
                                        class="w-9 h-9 flex items-center justify-center rounded-xl bg-[#21032B] text-[#FFE700] hover:bg-[#520C6B] transition-all text-xs" title="Re-approve">
                                        <i class="fas fa-redo"></i>
                                    </button>
                                    @else
                                    <span class="text-slate-300 text-xs font-bold">—</span>
                                    @endif
                                    <button onclick="deleteRequest({{ $req->id }})"
                                        class="w-9 h-9 flex items-center justify-center rounded-xl bg-slate-100 text-slate-400 hover:bg-red-50 hover:text-red-500 transition-all text-xs" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($requests->hasPages())
            <div class="px-6 py-5 border-t border-slate-100">{{ $requests->appends(['status'=>$status])->links() }}</div>
            @endif
            @endif
        </div>

    </main>
</div>

<script>
    // Sidebar toggle
    const sidebarToggle = document.getElementById('toggle-sidebar');
    const sidebar = document.getElementById('admin-sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            overlay?.classList.toggle('hidden');
            overlay?.classList.toggle('opacity-0');
        });
        overlay?.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden', 'opacity-0');
        });
    }

    let currentApproveId = null;
    let currentRejectId = null;

    function openApproveModal(id, name, institution, email) {
        currentApproveId = id;
        document.getElementById('modal-org-name').textContent = name;
        document.getElementById('modal-org-institution').textContent = institution || '—';
        document.getElementById('modal-org-email').textContent = email;
        document.getElementById('approveModal').classList.remove('hidden');
    }
    function closeApproveModal() {
        document.getElementById('approveModal').classList.add('hidden');
        currentApproveId = null;
    }
    function openRejectModal(id) {
        currentRejectId = id;
        document.getElementById('rejectModal').classList.remove('hidden');
    }
    function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
        currentRejectId = null;
    }

    function confirmApprove() {
        if (!currentApproveId) return;
        const id = currentApproveId;
        const btn = document.getElementById('confirmApproveBtn');
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Approving...';
        btn.disabled = true;
        fetch(`/admin/organizer-requests/${id}/approve`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(data => {
            closeApproveModal();
            btn.innerHTML = '<i class="fas fa-check"></i> Approve Now';
            btn.disabled = false;
            if (data.success) {
                showToast('success', `<strong>${data.user.name}</strong> has been approved as an Organizer!`);
                setTimeout(() => location.reload(), 2200);
            }
        })
        .catch(() => { btn.innerHTML = '<i class="fas fa-check"></i> Approve Now'; btn.disabled = false; showToast('error', 'Something went wrong.'); });
    }

    function confirmReject() {
        if (!currentRejectId) return;
        const id = currentRejectId;
        const btn = document.getElementById('confirmRejectBtn');
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Rejecting...';
        btn.disabled = true;
        fetch(`/admin/organizer-requests/${id}/reject`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(data => {
            closeRejectModal();
            btn.innerHTML = '<i class="fas fa-times"></i> Reject';
            btn.disabled = false;
            if (data.success) {
                showToast('warning', 'Organizer request has been rejected.');
                setTimeout(() => location.reload(), 2200);
            }
        })
        .catch(() => { btn.innerHTML = '<i class="fas fa-times"></i> Reject'; btn.disabled = false; showToast('error', 'Something went wrong.'); });
    }

    function deleteRequest(id) {
        if (!confirm('Permanently delete this organizer request?')) return;
        fetch(`/admin/organizer-requests/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                const row = document.getElementById(`row-${id}`);
                if (row) { row.style.opacity = '0'; row.style.transition = 'opacity 0.3s'; setTimeout(() => row.remove(), 300); }
                showToast('success', 'Request deleted.');
            }
        });
    }

    function showToast(type, message) {
        const container = document.getElementById('toast-container');
        const styles = { success: 'bg-green-600 text-white', error: 'bg-red-600 text-white', warning: 'bg-[#FFE700] text-[#21032B]' };
        const icons  = { success: 'fa-check-circle', error: 'fa-exclamation-circle', warning: 'fa-exclamation-triangle' };
        const toast = document.createElement('div');
        toast.className = `pointer-events-auto flex items-center gap-3 px-5 py-4 rounded-2xl shadow-2xl text-sm font-black transform transition-all duration-300 translate-x-20 opacity-0 ${styles[type]}`;
        toast.innerHTML = `<i class="fas ${icons[type]}"></i><span>${message}</span>`;
        container.appendChild(toast);
        requestAnimationFrame(() => { toast.classList.remove('translate-x-20','opacity-0'); });
        setTimeout(() => { toast.classList.add('translate-x-20','opacity-0'); setTimeout(() => toast.remove(), 400); }, 4500);
    }
</script>
</body>
</html>
