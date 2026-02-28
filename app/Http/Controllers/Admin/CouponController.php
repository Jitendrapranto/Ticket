<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        return view('admin.coupons.index');
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(Request $request)
    {
        // Placeholder
        return redirect()->route('admin.coupons.index');
    }

    public function edit($id)
    {
        return view('admin.coupons.edit');
    }

    public function update(Request $request, $id)
    {
        // Placeholder
        return redirect()->route('admin.coupons.index');
    }

    public function destroy($id)
    {
        // Placeholder
        return redirect()->route('admin.coupons.index');
    }
}
