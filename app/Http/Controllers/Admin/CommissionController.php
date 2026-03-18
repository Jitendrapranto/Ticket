<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommissionSetting;
use App\Models\CommissionOverride;
use App\Models\Event;
use App\Models\EventCategory;
use Illuminate\Http\Request;

class CommissionController extends Controller
{
    public function index()
    {
        $setting = CommissionSetting::first();
        if (!$setting) {
             $setting = CommissionSetting::create([
                'revenue_model' => 'percentage',
                'default_percentage' => 10,
                'fixed_amount' => 0,
                'is_active' => true
             ]);
        }

        $overrides = CommissionOverride::with(['overridable'])->get();
        $events = Event::select('id', 'title')->get();
        $categories = EventCategory::select('id', 'name')->get();

        return view('admin.finance.commission', compact('setting', 'overrides', 'events', 'categories'));
    }

    public function update(Request $request)
    {
        $setting = CommissionSetting::first();
        
        $request->validate([
            'revenue_model' => 'required',
            'default_percentage' => 'nullable|numeric|min:0',
            'fixed_amount' => 'nullable|numeric|min:0',
        ]);

        $setting->update([
            'revenue_model' => $request->revenue_model,
            'default_percentage' => $request->default_percentage ?? 0,
            'fixed_amount' => $request->fixed_amount ?? 0,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return redirect()->back()->with('success', 'Commission strategy updated successfully!');
    }

    public function storeOverride(Request $request)
    {
        $request->validate([
            'type' => 'required|in:event,category',
            'target_id' => 'required',
            'revenue_model' => 'required|in:percentage,fixed',
            'percentage' => 'nullable|numeric|min:0',
            'fixed_amount' => 'nullable|numeric|min:0',
        ]);

        $overridable_type = $request->type === 'event' ? Event::class : EventCategory::class;

        CommissionOverride::create([
            'overridable_type' => $overridable_type,
            'overridable_id' => $request->target_id,
            'revenue_model' => $request->revenue_model,
            'percentage' => $request->percentage ?? 0,
            'fixed_amount' => $request->fixed_amount ?? 0,
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', 'Override rule added successfully!');
    }

    public function updateOverride(Request $request, CommissionOverride $override)
    {
        $request->validate([
            'revenue_model' => 'required|in:percentage,fixed',
            'percentage' => 'nullable|numeric|min:0',
            'fixed_amount' => 'nullable|numeric|min:0',
        ]);

        $override->update([
            'revenue_model' => $request->revenue_model,
            'percentage' => $request->percentage ?? 0,
            'fixed_amount' => $request->fixed_amount ?? 0,
        ]);

        return redirect()->back()->with('success', 'Override rule updated successfully!');
    }

    public function destroyOverride(CommissionOverride $override)
    {
        $override->delete();
        return redirect()->back()->with('success', 'Override rule removed successfully!');
    }
}
