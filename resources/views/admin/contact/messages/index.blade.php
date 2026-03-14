@extends('admin.dashboard')

@section('admin_content')
<div class="lg:ml-2 min-h-screen flex flex-col">
    <!-- Header / Topbar (Already in layout, but we can add page dynamic info) -->
    <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <h1 class="text-4xl md:text-5xl font-black text-dark tracking-tighter mb-2">Contact <span class="bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent">Messages.</span></h1>
            <p class="text-slate-400 font-bold uppercase text-xs tracking-[0.4em]">Dashboard / Communication Hub</p>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-premium border border-white overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/40 text-xs font-black tracking-widest text-slate-400 uppercase">
                        <th class="px-8 py-5 border-b border-slate-50">Status</th>
                        <th class="px-8 py-5 border-b border-slate-50">Sender</th>
                        <th class="px-8 py-5 border-b border-slate-50">Subject</th>
                        <th class="px-8 py-5 border-b border-slate-50">Date</th>
                        <th class="px-8 py-5 border-b border-slate-50 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($messages as $message)
                    <tr class="hover:bg-slate-50/50 transition-colors group {{ !$message->is_read ? 'bg-primary/5' : '' }}">
                        <td class="px-8 py-5">
                            @if(!$message->is_read)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-primary text-white text-[10px] font-black uppercase tracking-wider">New</span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100 text-slate-400 text-[10px] font-black uppercase tracking-wider">Read</span>
                            @endif
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex flex-col">
                                <span class="font-black text-dark text-sm">{{ $message->full_name }}</span>
                                <span class="text-[11px] text-slate-400 font-medium">{{ $message->email }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <span class="text-sm font-bold text-slate-600 truncate max-w-xs block">{{ $message->subject ?? 'No Subject' }}</span>
                        </td>
                        <td class="px-8 py-5">
                            <span class="text-[11px] text-slate-400 font-black uppercase tracking-wider">{{ $message->created_at->format('d M Y, h:i A') }}</span>
                        </td>
                        <td class="px-8 py-5 text-right">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('admin.contact.messages.show', $message->id) }}" class="w-11 h-11 bg-white border border-slate-100 rounded-xl flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-all shadow-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form id="delete-form-{{ $message->id }}" action="{{ route('admin.contact.messages.destroy', $message->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete('delete-form-{{ $message->id }}', 'This message will be permanently removed from the database.')" class="w-11 h-11 bg-white border border-slate-100 rounded-xl flex items-center justify-center text-vibrant hover:bg-vibrant hover:text-white transition-all shadow-sm">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-24 text-center">
                            <div class="flex flex-col items-center gap-6">
                                <div class="w-24 h-24 bg-slate-50 rounded-[2.5rem] flex items-center justify-center text-slate-200 text-4xl shadow-inner">
                                    <i class="fas fa-envelope-open"></i>
                                </div>
                                <div>
                                    <h3 class="font-outfit text-xl font-black text-slate-300 uppercase tracking-widest mb-2">Communication Idle</h3>
                                    <p class="text-sm text-slate-400 max-w-xs mx-auto font-medium">When customers send you messages through the contact portal, they will appear here for review.</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($messages->hasPages())
        <div class="p-8 border-t border-slate-50 bg-slate-50/20">
            {{ $messages->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
