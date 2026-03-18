@extends('admin.dashboard')

@section('admin_content')
<div class="lg:ml-2">
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="flex items-center gap-6">
            <a href="{{ route('admin.contact.messages.index') }}" class="w-12 h-12 rounded-2xl bg-white border border-slate-100 flex items-center justify-center text-slate-400 hover:text-primary hover:border-primary/20 transition-all shadow-sm">
                @csrf
                @method('DELETE')
                <button type="button" onclick="confirmDelete('delete-form-single', 'This message Intel will be erased from the system.')" class="bg-vibrant/5 text-vibrant px-8 py-4 rounded-xl font-black text-[11px] uppercase tracking-widest hover:bg-vibrant hover:text-white transition-all flex items-center gap-3 shadow-sm">
                    <i class="fas fa-trash-alt text-xs"></i> Delete Message
                </button>
            </form>
        </div>
    </div>

    <div class="max-w-5xl mx-auto">
        <div class="bg-white rounded-[2.5rem] shadow-premium border border-white overflow-hidden">
            <div class="p-12">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-10 mb-12 pb-12 border-b border-slate-50">
                    <div class="flex items-center gap-8">
                        <div class="w-20 h-20 bg-gradient-to-br from-primary/10 to-accent/10 rounded-3xl flex items-center justify-center text-primary text-3xl font-black shadow-inner border border-white">
                            {{ strtoupper(substr($message->full_name, 0, 1)) }}
                        </div>
                        <div>
                            <h2 class="font-outfit text-3xl font-black text-dark tracking-tight mb-1">{{ $message->full_name }}</h2>
                            <div class="flex items-center gap-4">
                                <span class="text-sm font-bold text-slate-400 flex items-center gap-2">
                                    <i class="fas fa-envelope text-[10px]"></i> {{ $message->email }}
                                </span>
                                @if($message->phone)
                                <span class="w-1 h-1 rounded-full bg-slate-200"></span>
                                <span class="text-sm font-bold text-slate-400 flex items-center gap-2">
                                    <i class="fas fa-phone-alt text-[10px]"></i> {{ $message->phone }}
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="bg-slate-50/50 p-6 rounded-3xl border border-slate-100/50 text-left md:text-right">
                        <p class="text-[9px] text-slate-400 font-black uppercase tracking-[0.2em] mb-2">Signal Received</p>
                        <p class="font-black text-dark text-base mb-1">{{ $message->created_at->format('M d, Y') }}</p>
                        <p class="text-[11px] text-primary font-black uppercase tracking-widest">{{ $message->created_at->format('h:i A') }} <span class="text-slate-300 mx-2">|</span> {{ $message->created_at->diffForHumans() }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-10">
                    <div>
                        <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 pl-2">Subject Header</h4>
                        <div class="bg-slate-50/30 rounded-2xl p-6 border border-slate-100/50">
                            <p class="font-black text-dark text-lg tracking-tight">{{ $message->subject ?? 'No Subject Provided' }}</p>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 pl-2">Payload Content</h4>
                        <div class="bg-slate-50/30 rounded-[2rem] p-10 border border-slate-100/50 min-h-[300px]">
                            <p class="text-slate-600 font-medium text-lg leading-[1.8] whitespace-pre-line">{{ $message->message }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
