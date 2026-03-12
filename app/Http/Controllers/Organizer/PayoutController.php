<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\WithdrawRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PayoutController extends Controller
{
    public function requests()
    {
        $organizer_id = Auth::id();
        $events = \App\Models\Event::where('user_id', $organizer_id)->get();
        $eventIds = $events->pluck('id')->toArray();

        // Financial Stats
        $grossRevenue = \App\Models\Booking::whereIn('event_id', $eventIds)->where('status', 'confirmed')->sum('total_amount');
        $commissionAmount = \App\Models\Booking::whereIn('event_id', $eventIds)->where('status', 'confirmed')->sum('commission_amount');
        $totalNetEarnings = $grossRevenue - $commissionAmount;

        $totalApprovedWithdrawals = WithdrawRequest::where('user_id', $organizer_id)
            ->where('status', 'approved')
            ->sum('amount');

        $availableBalance = $totalNetEarnings - $totalApprovedWithdrawals;

        $requests = WithdrawRequest::where('user_id', $organizer_id)
            ->where('status', 'pending')
            ->latest()
            ->paginate(20);

        return view('organizer.payout.requests', compact('requests', 'availableBalance', 'totalNetEarnings'));
    }

    public function history()
    {
        $requests = WithdrawRequest::where('user_id', Auth::id())
            ->whereIn('status', ['approved', 'rejected'])
            ->latest()
            ->paginate(20);

        return view('organizer.payout.history', compact('requests'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'method' => 'required|string',
            'account_details' => 'required|string',
        ]);

        // Check if organizer has enough balance? 
        // For now, let's assume they can request and admin will verify.
        // Usually, we would check against (Total Sales - Commission - Total Paid).

        WithdrawRequest::create([
            'user_id' => Auth::id(),
            'amount' => $request->amount,
            'method' => $request->method,
            'account_details' => $request->account_details,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Withdraw request submitted successfully!');
    }
}
