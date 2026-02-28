<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommissionSetting;
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
        return view('admin.finance.commission', compact('setting'));
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
}
