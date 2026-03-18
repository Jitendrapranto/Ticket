@extends('admin.dashboard')

@section('admin_content')
<div x-data="{ 
    addModal: false, 
    editModal: false,
    editData: { id: '', type: '', target_name: '', revenue_model: 'percentage', percentage: 0, fixed_amount: 0 },
    openEdit(override) {
        this.editData = {
            id: override.id,
            target_name: override.overridable ? (override.overridable_type.includes('EventCategory') ? override.overridable.name : override.overridable.title) : 'Unknown',
            revenue_model: override.revenue_model,
            percentage: override.percentage,
            fixed_amount: override.fixed_amount
        };
        this.editModal = true;
    }
}">

    <div class="animate-fadeIn">
        <main class="p-10 flex-1 max-w-7xl mx-auto w-full">
                <!-- Header -->
                <div class="flex items-center justify-between mb-10">
                    <div>
                        <h1 class="font-outfit text-3xl font-black text-dark tracking-tight mb-2">Commission Strategy</h1>
                        <p class="text-slate-400 font-medium text-sm">Define platform earning models and specific event-level overrides.</p>
                    </div>
                    <button type="submit" form="commissionSettingsForm" class="bg-secondary text-white px-8 py-4 rounded-2xl text-[11px] font-black uppercase tracking-widest hover:bg-dark transition-all flex items-center gap-3 shadow-xl shadow-secondary/20">
                        <i class="fas fa-save text-[13px]"></i> Save Configuration
                    </button>
                </div>

                <!-- Summary Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                    <div class="bg-white p-8 rounded-[2rem] border border-slate-50 shadow-premium flex items-start justify-between group hover:border-primary/20 transition-all">
                        <div>
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 block">Revenue Model</span>
                            <h3 class="font-outfit text-2xl font-black text-dark tracking-tight mb-1">
                                {{ ucfirst($setting->revenue_model) }}
                            </h3>
                            <p class="text-[10px] font-bold text-slate-400">Default active strategy</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center text-sm group-hover:bg-blue-500 group-hover:text-white transition-all">
                            <i class="fas fa-hand-holding-usd"></i>
                        </div>
                    </div>

                    <div class="bg-white p-8 rounded-[2rem] border border-slate-50 shadow-premium flex items-start justify-between group hover:border-brand-green/20 transition-all">
                        <div>
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 block">Default Percentage</span>
                            <h3 class="font-outfit text-2xl font-black text-dark tracking-tight mb-1">
                                {{ $setting->default_percentage }}%
                            </h3>
                            <p class="text-[10px] font-bold text-brand-green tracking-tight">Active platform fee</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-brand-green/5 text-brand-green flex items-center justify-center text-sm group-hover:bg-brand-green group-hover:text-white transition-all">
                            <i class="fas fa-percent"></i>
                        </div>
                    </div>

                    <div class="bg-white p-8 rounded-[2rem] border border-slate-50 shadow-premium flex items-start justify-between group hover:border-accent/20 transition-all">
                        <div>
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 block">Active Overrides</span>
                            <h3 class="font-outfit text-2xl font-black text-dark tracking-tight mb-1">{{ $overrides->count() }} Rules</h3>
                            <p class="text-[10px] font-bold text-slate-400">Specific event/category settings</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-accent/5 text-accent flex items-center justify-center text-sm group-hover:bg-accent group-hover:text-white transition-all">
                            <i class="fas fa-bolt"></i>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                    <!-- Set Default Fees -->
                    <div class="lg:col-span-12 xl:col-span-4 space-y-8">
                        <form id="commissionSettingsForm" action="{{ route('admin.finance.commission.update') }}" method="POST" class="bg-white rounded-[2.5rem] border border-slate-50 shadow-premium overflow-hidden text-left">
                            @csrf
                            <div class="p-10 pb-0">
                                <h3 class="font-outfit text-xl font-black text-dark mb-2 tracking-tight">Global Default Fees</h3>
                                <p class="text-[11px] font-medium text-slate-400 leading-relaxed">Primary rates applied when no specific override exists across the board.</p>
                            </div>

                            <div class="p-10 space-y-8">
                                <div class="space-y-4">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Revenue Collection Model</label>
                                    <select name="revenue_model" class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-6 py-4 text-xs font-bold text-dark focus:ring-4 focus:ring-primary/5 focus:bg-white outline-none transition-all cursor-pointer text-left">
                                        <option value="percentage" {{ $setting->revenue_model == 'percentage' ? 'selected' : '' }}>Percentage-based (%)</option>
                                        <option value="fixed" {{ $setting->revenue_model == 'fixed' ? 'selected' : '' }}>Fixed Amount (৳)</option>
                                    </select>
                                </div>

                                <div class="space-y-4">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 text-left">% Default Value</label>
                                    <div class="relative">
                                        <input type="number" step="0.01" name="default_percentage" value="{{ $setting->default_percentage }}"
                                            class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-6 py-4 text-xs font-bold text-dark focus:ring-4 focus:ring-primary/5 focus:bg-white transition-all outline-none">
                                        <div class="absolute right-6 top-1/2 -translate-y-1/2 text-[10px] font-black text-slate-300 uppercase tracking-widest">Amount</div>
                                    </div>
                                </div>

                                <div class="pt-6 border-t border-slate-50 flex items-center justify-between">
                                    <div class="text-left">
                                        <p class="text-xs font-black text-dark mb-1">Active Platform Fee</p>
                                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Toggle earning system globally.</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="is_active" value="1" {{ $setting->is_active ? 'checked' : '' }} class="sr-only peer">
                                        <div class="w-12 h-6 bg-slate-100 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-secondary border border-slate-200"></div>
                                    </label>
                                </div>
                            </div>
                        </form>

                        <!-- Pro Tip Card -->
                        <div class="bg-gradient-to-br from-primary/95 to-secondary rounded-[2.5rem] p-10 text-white relative overflow-hidden group shadow-2xl shadow-primary/20 text-left">
                            <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700"></div>
                            <div class="relative z-10">
                                <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-sm mb-6">
                                    <i class="fas fa-bolt"></i>
                                </div>
                                <h4 class="font-outfit text-lg font-black mb-3 tracking-tight">Pro-Tip: Flex Pricing</h4>
                                <p class="text-[11px] font-medium leading-[1.8] opacity-70">You can set different commission models for specific events. Free events are great for community growth and attracting new organizers!</p>
                            </div>
                        </div>
                    </div>

                    <!-- Overrides List -->
                    <div class="lg:col-span-12 xl:col-span-8 flex flex-col">
                        <div class="bg-white rounded-[2.5rem] border border-slate-50 shadow-premium overflow-hidden flex-1 h-fit">
                            <div class="p-10 flex items-center justify-between border-b border-slate-50 text-left">
                                <div>
                                    <h3 class="font-outfit text-xl font-black text-dark mb-1 tracking-tight">Event & Category Overrides</h3>
                                    <p class="text-[11px] font-medium text-slate-400">Custom rules for specific platform entities that override global settings.</p>
                                </div>
                                <button type="button" @click="addModal = true" class="bg-slate-50 border border-slate-100 text-dark px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-100 transition-all flex items-center gap-3">
                                    <i class="fas fa-plus text-[9px]"></i> Add Override
                                </button>
                            </div>

                            <div class="p-0 overflow-x-auto no-scrollbar">
                                <table class="w-full text-left">
                                    <thead>
                                        <tr class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] bg-slate-50/30">
                                            <th class="px-10 py-6">Target Entity</th>
                                            <th class="px-8 py-6 text-center">Level</th>
                                            <th class="px-8 py-6 text-center">Custom Rule</th>
                                            <th class="px-10 py-6 text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-50">
                                        @forelse($overrides as $override)
                                        <tr class="group hover:bg-slate-50/50 transition-all text-left">
                                            <td class="px-10 py-8">
                                                <div class="flex items-center gap-4">
                                                    <div class="w-10 h-10 rounded-xl bg-primary/5 text-primary flex items-center justify-center text-xs">
                                                        <i class="fas {{ str_contains($override->overridable_type, 'EventCategory') ? 'fa-university' : 'fa-calendar-star' }}"></i>
                                                    </div>
                                                    <span class="text-xs font-black text-dark">
                                                        {{ $override->overridable ? (str_contains($override->overridable_type, 'EventCategory') ? $override->overridable->name : $override->overridable->title) : 'Unknown' }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="px-8 py-8 text-center text-left">
                                                <span class="px-3 py-1 rounded-lg bg-slate-100 text-[9px] font-black text-slate-400 uppercase tracking-widest leading-none">
                                                    {{ str_contains($override->overridable_type, 'EventCategory') ? 'Category' : 'Event' }}
                                                </span>
                                            </td>
                                            <td class="px-8 py-8 text-center text-left">
                                                <span class="px-4 py-1.5 rounded-full {{ $override->revenue_model === 'percentage' ? ($override->percentage == 0 ? 'bg-brand-green/10 text-brand-green' : 'bg-primary/10 text-primary') : 'bg-accent/10 text-accent' }} text-[9px] font-black uppercase tracking-wider">
                                                    @if($override->revenue_model === 'percentage')
                                                        {{ $override->percentage == 0 ? 'Free (0%)' : 'Custom ('.$override->percentage.'%)' }}
                                                    @else
                                                        Custom (৳{{ $override->fixed_amount }})
                                                    @endif
                                                </span>
                                            </td>
                                            <td class="px-10 py-8 text-right">
                                                <div x-data="{ openMenu: false }" class="relative flex justify-end">
                                                    <button type="button" @click="openMenu = !openMenu" @click.away="openMenu = false"
                                                        class="w-8 h-8 rounded-lg bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-400 hover:bg-primary hover:text-white transition-all duration-300 shadow-sm"
                                                        :class="openMenu ? 'bg-primary text-white ring-4 ring-primary/10' : ''">
                                                        <i class="fas fa-ellipsis-v text-[10px]"></i>
                                                    </button>
                                                    <div x-show="openMenu"
                                                         x-transition:enter="transition ease-out duration-200"
                                                         x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                                                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                                         x-transition:leave="transition ease-in duration-150"
                                                         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                                         x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                                                         class="absolute right-0 mt-3 w-48 bg-white rounded-2xl shadow-premium border border-slate-100 z-50 overflow-hidden" 
                                                         x-cloak>
                                                        <div class="p-2 space-y-1">
                                                            <button type="button" @click="openEdit({{ json_encode($override) }})" class="w-full text-left flex items-center gap-3 px-4 py-2.5 text-[10px] font-black uppercase tracking-widest text-slate-600 hover:bg-primary/5 hover:text-primary rounded-xl transition-all group/item">
                                                                <div class="w-6 h-6 rounded-lg bg-slate-50 flex items-center justify-center group-hover/item:bg-white transition-all"><i class="fas fa-edit text-[9px]"></i></div>
                                                                Edit Rule
                                                            </button>
                                                            <form action="{{ route('admin.finance.commission.overrides.destroy', $override) }}" method="POST" class="w-full">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="w-full text-left flex items-center gap-3 px-4 py-2.5 text-[10px] font-black uppercase tracking-widest text-red-500 hover:bg-red-50 rounded-xl transition-all group/item">
                                                                    <div class="w-6 h-6 rounded-lg bg-red-50/50 flex items-center justify-center group-hover/item:bg-white transition-all"><i class="fas fa-trash-alt text-[9px]"></i></div>
                                                                    Remove
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="px-10 py-12 text-center text-slate-400 font-bold text-xs uppercase tracking-widest">No overrides defined.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="p-10 bg-slate-50/30 flex items-center justify-center gap-3 text-left">
                                <i class="fas fa-info-circle text-[10px] text-slate-300"></i>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Event-level overrides always take precedence over global settings.</p>
                            </div>
                        </div>
                    </div>
                </div>
        </main>
    </div>

    <!-- Modals -->
    <!-- Add Modal -->
    <div x-show="addModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-dark/60 backdrop-blur-sm" @click="addModal = false"></div>
        <div class="bg-white rounded-[2.5rem] w-full max-w-lg relative z-10 shadow-2xl overflow-hidden text-left"
             x-transition:enter="transition ease-out duration-300 translate-y-4"
             x-transition:enter-start="translate-y-8 scale-95 opacity-0"
             x-transition:enter-end="translate-y-0 scale-100 opacity-100">
            <div class="p-10 border-b border-slate-50 flex items-center justify-between">
                <h3 class="font-outfit text-xl font-black text-dark tracking-tight">New Commission Override</h3>
                <button @click="addModal = false" class="text-slate-300 hover:text-dark transition-colors"><i class="fas fa-times"></i></button>
            </div>
            <form action="{{ route('admin.finance.commission.overrides.store') }}" method="POST" x-data="{ type: 'event', model: 'percentage' }">
                @csrf
                <div class="p-10 space-y-6">
                    <div class="space-y-3">
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Target Type</label>
                        <select name="type" x-model="type" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-5 py-3 text-xs font-bold text-dark focus:ring-4 focus:ring-primary/5 outline-none transition-all">
                            <option value="event">Specific Event</option>
                            <option value="category">Category-wide</option>
                        </select>
                    </div>

                    <div class="space-y-3" x-show="type === 'event'">
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Select Event</label>
                        <select x-bind:name="type === 'event' ? 'target_id' : ''" x-bind:required="type === 'event'" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-5 py-3 text-xs font-bold text-dark focus:ring-4 focus:ring-primary/5 outline-none transition-all">
                            @foreach($events as $event)
                                <option value="{{ $event->id }}">{{ $event->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-3" x-show="type === 'category'" style="display: none;">
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Select Category</label>
                        <select x-bind:name="type === 'category' ? 'target_id' : ''" x-bind:required="type === 'category'" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-5 py-3 text-xs font-bold text-dark focus:ring-4 focus:ring-primary/5 outline-none transition-all">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-3">
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Override Model</label>
                        <select name="revenue_model" x-model="model" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-5 py-3 text-xs font-bold text-dark focus:ring-4 focus:ring-primary/5 outline-none transition-all">
                            <option value="percentage">Percentage (%)</option>
                            <option value="fixed">Fixed Amount (৳)</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-3" x-show="model === 'percentage'">
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Percentage (%)</label>
                            <input type="number" step="0.01" name="percentage" value="0" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-5 py-3 text-xs font-bold text-dark">
                        </div>
                        <div class="space-y-3" x-show="model === 'fixed'">
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Fixed Fee (৳)</label>
                            <input type="number" step="0.01" name="fixed_amount" value="0" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-5 py-3 text-xs font-bold text-dark">
                        </div>
                    </div>
                </div>
                <div class="p-10 bg-slate-50 flex items-center justify-end gap-4">
                    <button type="button" @click="addModal = false" class="text-xs font-black text-slate-400 uppercase tracking-widest hover:text-dark transition-colors">Cancel</button>
                    <button type="submit" class="bg-primary text-white px-8 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-dark transition-all shadow-lg shadow-primary/20">Create Rule</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div x-show="editModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-dark/60 backdrop-blur-sm" @click="editModal = false"></div>
        <div class="bg-white rounded-[2.5rem] w-full max-w-lg relative z-10 shadow-2xl overflow-hidden text-left"
             x-transition:enter="transition ease-out duration-300 translate-y-4">
            <div class="p-10 border-b border-slate-50 flex items-center justify-between">
                <div>
                    <h3 class="font-outfit text-xl font-black text-dark tracking-tight">Edit Override Rule</h3>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1" x-text="'Target: ' + editData.target_name"></p>
                </div>
                <button @click="editModal = false" class="text-slate-300 hover:text-dark transition-colors"><i class="fas fa-times"></i></button>
            </div>
            <form :action="'{{ route('admin.finance.commission.overrides.update', '___ID___') }}'.replace('___ID___', editData.id)" method="POST">
                @csrf
                @method('PUT')
                <div class="p-10 space-y-6">
                    <div class="space-y-3">
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Override Model</label>
                        <select name="revenue_model" x-model="editData.revenue_model" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-5 py-3 text-xs font-bold text-dark outline-none">
                            <option value="percentage">Percentage (%)</option>
                            <option value="fixed">Fixed Amount (৳)</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-3" x-show="editData.revenue_model === 'percentage'">
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Percentage (%)</label>
                            <input type="number" step="0.01" name="percentage" x-model="editData.percentage" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-5 py-3 text-xs font-bold text-dark">
                        </div>
                        <div class="space-y-3" x-show="editData.revenue_model === 'fixed'">
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Fixed Fee (৳)</label>
                            <input type="number" step="0.01" name="fixed_amount" x-model="editData.fixed_amount" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-5 py-3 text-xs font-bold text-dark">
                        </div>
                    </div>
                </div>
                <div class="p-10 bg-slate-50 flex items-center justify-end gap-4">
                    <button type="button" @click="editModal = false" class="text-xs font-black text-slate-400 uppercase tracking-widest hover:text-dark transition-colors">Cancel</button>
                    <button type="submit" class="bg-secondary text-white px-8 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-dark transition-all shadow-lg shadow-secondary/20">Update Rule</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Feedback Toasts -->
    <script>
        @if(session('success'))
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                customClass: {
                    popup: 'rounded-2xl shadow-premium'
                }
            });
        @endif
    </script>
</div>
@endsection
