@extends('layouts.organizer')

@section('title', 'Scanner Management')

@section('content')
<div class="p-10 max-w-[1600px] mx-auto w-full">
    <div class="flex items-center justify-between mb-12">
        <div class="max-w-xl">
            <h1 class="font-outfit text-5xl font-black text-dark tracking-tighter mb-4">Scanner Team</h1>
            <p class="text-slate-400 font-medium text-base leading-relaxed">Manage your on-site check-in team. Scanners can access a simplified dashboard to validate tickets and track attendance.</p>
        </div>
        <div>
            <a href="{{ route('organizer.scanners.create') }}" class="bg-primary text-white px-10 py-5 rounded-[1.5rem] text-xs font-black uppercase tracking-widest hover:bg-secondary transition-all flex items-center gap-4 shadow-2xl shadow-primary/20 group">
                <i class="fas fa-plus text-[14px] group-hover:rotate-90 transition-transform"></i>
                <span>Add New Scanner</span>
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-8 p-4 bg-emerald-50 border border-emerald-100 text-emerald-600 rounded-2xl text-sm font-bold flex items-center gap-3 animate-fadeIn">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-white rounded-[3rem] shadow-premium border border-white overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/30 text-[10px] font-black tracking-[0.2em] text-slate-400 uppercase">
                        <th class="px-12 py-6 font-black w-[40%]">Scanner Identity</th>
                        <th class="px-8 py-6 font-black w-[30%]">Registered Email</th>
                        <th class="px-12 py-6 font-black w-[30%] text-right whitespace-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100/50">
                    @forelse($scanners as $scanner)
                    <tr class="hover:bg-slate-50/50 transition-all group">
                        <td class="px-12 py-8">
                            <div class="flex items-center gap-5">
                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-primary/10 to-primary/5 text-primary flex items-center justify-center overflow-hidden transition-transform group-hover:scale-110">
                                    <span class="text-base font-black uppercase">{{ substr($scanner->name, 0, 1) }}</span>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-[17px] font-black text-dark tracking-tight leading-none group-hover:text-primary transition-colors">
                                        {{ $scanner->name }}
                                    </p>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Team Member</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-8">
                            <span class="text-xs font-bold text-slate-600">{{ $scanner->email }}</span>
                        </td>
                        <td class="px-12 py-8 text-right">
                            <div class="flex items-center justify-end gap-3 transition-all">
                                <a href="{{ route('organizer.scanners.edit', $scanner->id) }}" class="w-10 h-10 rounded-xl bg-slate-50 text-slate-400 flex items-center justify-center hover:bg-primary hover:text-white transition-all shadow-soft group/edit">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>
                                <form action="{{ route('organizer.scanners.destroy', $scanner->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this scanner?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-10 h-10 rounded-xl bg-slate-50 text-slate-400 flex items-center justify-center hover:bg-brand-red hover:text-white transition-all shadow-soft group/del">
                                        <i class="fas fa-trash-alt text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-12 py-24 text-center">
                            <div class="flex flex-col items-center gap-4 max-w-sm mx-auto">
                                <div class="w-20 h-20 rounded-[2rem] bg-slate-50 flex items-center justify-center text-3xl text-slate-200">
                                    <i class="fas fa-qrcode"></i>
                                </div>
                                <h4 class="text-xl font-outfit font-black text-slate-400">No Scanners Found</h4>
                                <p class="text-xs font-medium text-slate-300">You haven't added any scanning team members yet. Add one to start processing tickets on-site.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-12 bg-slate-50/30 border-t border-slate-50">
            {{ $scanners->links() }}
        </div>
    </div>
</div>
@endsection
