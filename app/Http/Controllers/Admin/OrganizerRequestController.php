<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class OrganizerRequestController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'pending');

        $requests = User::whereIn('role', ['pending_organizer', 'organizer'])
            ->when($status === 'pending', fn($q) => $q->where('organizer_status', 'pending'))
            ->when($status === 'approved', fn($q) => $q->where('organizer_status', 'approved'))
            ->when($status === 'rejected', fn($q) => $q->where('organizer_status', 'rejected'))
            ->when($status === 'all', fn($q) => $q)
            ->latest()
            ->paginate(15);

        $pendingCount = User::whereIn('role', ['pending_organizer'])->where('organizer_status', 'pending')->count();

        return view('admin.organizer-requests.index', compact('requests', 'status', 'pendingCount'));
    }

    public function approve($id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'role' => 'organizer',
            'organizer_status' => 'approved',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Organizer request approved successfully.',
            'user' => [
                'name' => $user->name,
                'institution_name' => $user->institution_name,
                'email' => $user->email,
            ],
        ]);
    }

    public function reject(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'role' => 'pending_organizer',
            'organizer_status' => 'rejected',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Organizer request rejected.',
        ]);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Organizer request deleted.',
        ]);
    }
}
