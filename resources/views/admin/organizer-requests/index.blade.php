@extends('admin.dashboard')

@section('admin_content')
    <!-- Content -->
    <div class="space-y-8 animate-fadeIn">

        <!-- Toast Container -->
        <div id="toast-container" class="fixed top-6 right-6 z-[9999] flex flex-col gap-3 pointer-events-none"></div>

        <!-- Approve Modal -->
        <div id="approveModal" class="fixed inset-0 z-[9998] flex items-center justify-center hidden">
            <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeApproveModal()"></div>
            <div class="relative bg-white rounded-3xl shadow-2xl max-w-md w-full mx-4 overflow-hidden animate-fadeInUp">
                <div class="bg-gradient-to-br from-[#1B2B46] to-[#520C6B] p-8 text-center">
                    <div class="w-20 h-20 rounded-full bg-[#FFE700]/20 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-user-check text-[#FFE700] text-3xl"></i>
                    </div>
                    <h3 class="text-white text-xl font-black tracking-tight">Approve Organizer?</h3>
                    <p class="text-white/60 text-sm font-medium mt-2">This organizer will gain full access to the organizer dashboard immediately.</p>
                </div>
                <div class="p-6 space-y-4">
                    <div class="bg-slate-50 rounded-2xl p-4 space-y-1">
                        <p class="font-black text-[#1B2B46] text-sm" id="modal-org-name">â€”</p>
                        <p class="text-slate-500 font-medium text-xs" id="modal-org-institution">â€”</p>
                        <p class="text-slate-400 text-xs font-medium" id="modal-org-email">â€”</p>
                    </div>
                    <div class="flex gap-3">
                        <button onclick="closeApproveModal()" class="flex-1 py-3 rounded-xl border-2 border-slate-100 text-slate-500 font-black text-xs uppercase tracking-widest hover:bg-slate-50 transition-all">Cancel</button>
                        <button id="confirmApproveBtn" onclick="confirmApprove()" class="flex-1 py-3 rounded-xl bg-[#1B2B46] text-[#FFE700] font-black text-xs uppercase tracking-widest hover:bg-[#520C6B] transition-all flex items-center justify-center gap-2">
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
                <h1 class="text-3xl font-black text-[#1B2B46] tracking-tight">Organizer Requests</h1>
                <p class="text-slate-400 text-sm font-medium mt-1">Review and manage organizer account applications</p>
            </div>
            @if($pendingCount > 0)
            <div class="inline-flex items-center gap-2 bg-[#FFE700]/10 border border-[#FFE700]/30 rounded-2xl px-5 py-3">
                <span class="w-2.5 h-2.5 rounded-full bg-[#FFE700] animate-pulse"></span>
                <span class="text-[#1B2B46] font-black text-sm">{{ $pendingCount }} Pending Review</span>
            </div>
            @endif
        </div>

        <!-- Status Tabs -->
        <div class="flex flex-wrap gap-2">
            @foreach(['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected', 'all' => 'All Requests'] as $tab => $label)
            <a href="{{ route('admin.organizer-requests.index', ['status' => $tab]) }}"
               class="px-5 py-2.5 rounded-xl font-black text-xs uppercase tracking-widest transition-all border
               @if($status === $tab)
                   @if($tab === 'pending') bg-[#1B2B46] text-[#FFE700] border-transparent shadow-lg
                   @elseif($tab === 'approved') bg-green-600 text-white border-transparent shadow-lg
                   @elseif($tab === 'rejected') bg-red-500 text-white border-transparent shadow-lg
                   @else bg-slate-600 text-white border-transparent shadow-lg
                   @endif
               @else text-slate-500 bg-white border-slate-200 hover:border-[#520C6B]/30 hover:text-[#520C6B]
               @endif">
                {{ $label }}
                @if($tab === 'pending' && $pendingCount > 0)
                    <span class="ml-1.5 bg-[#FFE700] text-[#1B2B46] text-[9px] font-black px-1.5 py-0.5 rounded-full">{{ $pendingCount }}</span>
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
                                    <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-[#1B2B46] to-[#520C6B] flex items-center justify-center shrink-0 shadow">
                                        @if($req->avatar)
                                            <img loading="lazy" src="{{ asset('storage/'.$req->avatar) }}" class="w-11 h-11 rounded-xl object-cover">
                                        @else
                                            <span class="text-[#FFE700] font-black text-base">{{ strtoupper(substr($req->name,0,1)) }}</span>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-[#1B2B46] font-black text-sm">{{ $req->name }}</p>
                                        <p class="text-slate-400 text-xs font-medium">{{ $req->institution_name ?? 'â€”' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <p class="text-slate-700 text-sm font-bold">{{ $req->email }}</p>
                                <p class="text-slate-400 text-xs font-medium mt-0.5">{{ $req->phone ?? 'â€”' }}</p>
                            </td>
                            <td class="px-6 py-5">
                                <p class="text-slate-500 text-xs font-medium max-w-[180px] leading-relaxed">{{ $req->present_address ?? 'â€”' }}</p>
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
                                        class="w-9 h-9 flex items-center justify-center rounded-xl bg-[#1B2B46] text-[#FFE700] hover:bg-[#520C6B] transition-all text-xs" title="Approve">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button onclick="openRejectModal({{ $req->id }})"
                                        class="w-9 h-9 flex items-center justify-center rounded-xl bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-all text-xs" title="Reject">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    @elseif($req->organizer_status === 'rejected')
                                    <button onclick="openApproveModal({{ $req->id }},'{{ addslashes($req->name) }}','{{ addslashes($req->institution_name ?? '') }}','{{ $req->email }}')"
                                        class="w-9 h-9 flex items-center justify-center rounded-xl bg-[#1B2B46] text-[#FFE700] hover:bg-[#520C6B] transition-all text-xs" title="Re-approve">
                                        <i class="fas fa-redo"></i>
                                    </button>
                                    @else
                                    <span class="text-slate-300 text-xs font-bold">-</span>
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
            @endif
        </div>
    </div>

    <!-- Page Scripts -->
    <script>
        (function() {
            // Re-attached every time the page loads via Swup
            console.log("Setting up Organizer action functions...");
            
            window.openApproveModal = function(id, name, institution, email) {
                console.log("Opening approve modal for:", name);
                window.currentApproveId = id;
                const nameEl = document.getElementById('modal-org-name');
                const instEl = document.getElementById('modal-org-institution');
                const emailEl = document.getElementById('modal-org-email');
                if (nameEl) nameEl.textContent = name;
                if (instEl) instEl.textContent = institution || '-';
                if (emailEl) emailEl.textContent = email;
                document.getElementById('approveModal')?.classList.remove('hidden');
            };

            window.closeApproveModal = function() {
                document.getElementById('approveModal')?.classList.add('hidden');
                window.currentApproveId = null;
            };

            window.openRejectModal = function(id) {
                console.log("Opening reject modal for ID:", id);
                window.currentRejectId = id;
                document.getElementById('rejectModal')?.classList.remove('hidden');
            };

            window.closeRejectModal = function() {
                document.getElementById('rejectModal')?.classList.add('hidden');
                window.currentRejectId = null;
            };

            window.confirmApprove = function() {
                if (!window.currentApproveId) return;
                const id = window.currentApproveId;
                const btn = document.getElementById('confirmApproveBtn');
                btn.disabled = true;
                btn.innerHTML = 'Wait...';

                fetch(`/admin/organizer-requests/${id}/approve`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
                })
                .then(r => r.json())
                .then(data => {
                    closeApproveModal();
                    if (data.success) {
                        Swal.fire({ icon: 'success', title: 'Done', showConfirmButton: false, timer: 1000 });
                        setTimeout(() => location.reload(), 1000);
                    }
                })
                .catch(() => {
                    btn.disabled = false;
                    btn.innerHTML = 'Try Again';
                });
            };

            window.deleteRequest = function(id) {
                console.log("Confirming delete for ID:", id);
                Swal.fire({
                    title: 'Delete this?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Delete'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/admin/organizer-requests/${id}`, {
                            method: 'DELETE',
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
                        })
                        .then(r => r.json())
                        .then(data => {
                            if (data.success) {
                                document.getElementById(`row-${id}`)?.remove();
                                Swal.fire({ icon: 'success', title: 'Deleted', timer: 1000, showConfirmButton: false });
                            }
                        })
                        .catch(() => Swal.fire({ icon: 'error', title: 'Failed' }));
                    }
                });
            };
        })();
    </script>
@endsection
