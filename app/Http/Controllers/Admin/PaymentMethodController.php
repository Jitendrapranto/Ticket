<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $methods = PaymentMethod::orderBy('sort_order')->get();
        return view('admin.finance.payment-methods.index', compact('methods'));
    }

    public function create()
    {
        return view('admin.finance.payment-methods.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|image|max:1024',
            'qr_code' => 'nullable|image|max:2048',
            'instructions' => 'required|string',
            'account_number' => 'nullable|string',
            'is_active' => 'required|boolean',
            'sort_order' => 'required|integer'
        ]);

        $data = $request->except(['icon', 'qr_code']);
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('icon')) {
            $data['icon'] = $request->file('icon')->store('payment_icons', 'public');
        }

        if ($request->hasFile('qr_code')) {
            $data['qr_code'] = $request->file('qr_code')->store('payment_qrs', 'public');
        }

        PaymentMethod::create($data);

        return redirect()->route('admin.finance.payment-methods.index')->with('success', 'Payment method created successfully.');
    }

    public function edit(PaymentMethod $paymentMethod)
    {
        return view('admin.finance.payment-methods.edit', compact('paymentMethod'));
    }

    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|image|max:1024',
            'qr_code' => 'nullable|image|max:2048',
            'instructions' => 'required|string',
            'account_number' => 'nullable|string',
            'is_active' => 'required|boolean',
            'sort_order' => 'required|integer'
        ]);

        $data = $request->except(['icon', 'qr_code']);
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('icon')) {
            if ($paymentMethod->icon) Storage::disk('public')->delete($paymentMethod->icon);
            $data['icon'] = $request->file('icon')->store('payment_icons', 'public');
        }

        if ($request->hasFile('qr_code')) {
            if ($paymentMethod->qr_code) Storage::disk('public')->delete($paymentMethod->qr_code);
            $data['qr_code'] = $request->file('qr_code')->store('payment_qrs', 'public');
        }

        $paymentMethod->update($data);

        return redirect()->route('admin.finance.payment-methods.index')->with('success', 'Payment method updated successfully.');
    }

    public function destroy(PaymentMethod $paymentMethod)
    {
        if ($paymentMethod->icon) Storage::disk('public')->delete($paymentMethod->icon);
        if ($paymentMethod->qr_code) Storage::disk('public')->delete($paymentMethod->qr_code);
        
        $paymentMethod->delete();

        return redirect()->route('admin.finance.payment-methods.index')->with('success', 'Payment method deleted successfully.');
    }
}
