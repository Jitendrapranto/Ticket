<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WithdrawRequest;
use Illuminate\Http\Request;

class PayoutController extends Controller
{
    public function requests()
    {
        $requests = WithdrawRequest::with('user')
            ->where('status', 'pending')
            ->latest()
            ->paginate(20);

        return view('admin.payout.requests', compact('requests'));
    }

    public function history()
    {
        $requests = WithdrawRequest::with('user')
            ->whereIn('status', ['approved', 'rejected'])
            ->latest()
            ->paginate(20);

        return view('admin.payout.history', compact('requests'));
    }

    public function approve(Request $request, $id)
    {
        $withdrawRequest = WithdrawRequest::findOrFail($id);
        
        $request->validate([
            'transaction_id' => 'required|string',
            'admin_notes' => 'nullable|string'
        ]);

        $withdrawRequest->update([
            'status' => 'approved',
            'transaction_id' => $request->transaction_id,
            'admin_notes' => $request->admin_notes,
            'processed_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Withdraw request approved successfully!');
    }

    public function reject(Request $request, $id)
    {
        $withdrawRequest = WithdrawRequest::findOrFail($id);
        
        $request->validate([
            'admin_notes' => 'required|string'
        ]);

        $withdrawRequest->update([
            'status' => 'rejected',
            'admin_notes' => $request->admin_notes,
            'processed_at' => now(),
        ]);

        return redirect()->back()->with('error', 'Withdraw request has been rejected.');
    }
}
