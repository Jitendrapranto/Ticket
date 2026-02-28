<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommissionSetting;
use Illuminate\Http\Request;

class CommissionSettingController extends Controller
{
    public function index()
    {
        $setting = CommissionSetting::first() ?? new CommissionSetting();
        return view('admin.finance.commission.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'revenue_model' => 'required|in:percentage,fixed',
            'default_percentage' => 'required|numeric|min:0|max:100',
            'fixed_amount' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        $setting = CommissionSetting::first() ?? new CommissionSetting();
        $setting->revenue_model = $request->revenue_model;
        $setting->default_percentage = $request->default_percentage;
        $setting->fixed_amount = $request->fixed_amount;
        $setting->is_active = $request->has('is_active');
        $setting->save();

        return redirect()->route('admin.finance.commission.index')->with('success', 'Commission settings updated successfully.');
    }
}
