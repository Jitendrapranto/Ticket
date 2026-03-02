<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ScannerController extends Controller
{
    public function index()
    {
        $scanners = Auth::user()->scanners()->latest()->paginate(10);
        return view('organizer.scanners.index', compact('scanners'));
    }

    public function create()
    {
        return view('organizer.scanners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'scanner',
            'organizer_id' => Auth::id(),
        ]);

        return redirect()->route('organizer.scanners.index')->with('success', 'Scanner created successfully.');
    }

    public function edit(User $scanner)
    {
        if ($scanner->organizer_id !== Auth::id()) {
            abort(403);
        }
        return view('organizer.scanners.edit', compact('scanner'));
    }

    public function update(Request $request, User $scanner)
    {
        if ($scanner->organizer_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $scanner->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $scanner->update($data);

        return redirect()->route('organizer.scanners.index')->with('success', 'Scanner updated successfully.');
    }

    public function destroy(User $scanner)
    {
        if ($scanner->organizer_id !== Auth::id()) {
            abort(403);
        }
        $scanner->delete();
        return redirect()->route('organizer.scanners.index')->with('success', 'Scanner deleted successfully.');
    }
}
