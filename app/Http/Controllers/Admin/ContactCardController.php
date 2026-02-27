<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactCard;
use Illuminate\Http\Request;

class ContactCardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cards = ContactCard::orderBy('sort_order', 'asc')->get();
        return view('admin.contact.cards.index', compact('cards'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.contact.cards.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'icon' => 'required|string|max:100',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'action_text' => 'nullable|string|max:255',
            'action_url' => 'nullable|string|max:255',
            'bg_color' => 'required|string|max:20',
            'theme_color' => 'required|string|max:20',
            'title_color' => 'required|string|max:20',
            'desc_color' => 'required|string|max:20',
            'sort_order' => 'nullable|integer',
        ]);

        ContactCard::create($request->all());

        return redirect()->route('admin.contact.cards.index')->with('success', 'Contact Card created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContactCard $card)
    {
        return view('admin.contact.cards.edit', compact('card'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContactCard $card)
    {
        $request->validate([
            'icon' => 'required|string|max:100',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'action_text' => 'nullable|string|max:255',
            'action_url' => 'nullable|string|max:255',
            'bg_color' => 'required|string|max:20',
            'theme_color' => 'required|string|max:20',
            'title_color' => 'required|string|max:20',
            'desc_color' => 'required|string|max:20',
            'sort_order' => 'nullable|integer',
        ]);

        $card->update($request->all());

        return redirect()->route('admin.contact.cards.index')->with('success', 'Contact Card updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContactCard $card)
    {
        $card->delete();
        return redirect()->route('admin.contact.cards.index')->with('success', 'Contact Card deleted successfully!');
    }
}
