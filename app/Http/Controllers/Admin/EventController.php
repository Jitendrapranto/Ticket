<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('category')->whereIn('status', ['Live', 'Expired'])->latest()->paginate(10);
        return view('admin.events.index', compact('events'));
    }

    public function drafts()
    {
        $events = Event::with('category')->where('status', 'Draft')->latest()->paginate(10);
        return view('admin.events.drafts', compact('events'));
    }

    public function publish(Event $event)
    {
        $event->update(['status' => 'Live']);
        return redirect()->route('admin.events.index')->with('success', 'Event published and is now live!');
    }

    public function create()
    {
        $categories = EventCategory::all();
        return view('admin.events.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:event_categories,id',
            'organizer' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'registration_deadline' => 'required|date',
            'location' => 'required|string',
            'price' => 'required|numeric',
            'status' => 'required|in:Live,Expired,Draft',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'sort_order' => 'required|integer|min:0',
            'is_featured' => 'nullable|boolean',
            'tickets' => 'nullable|array',
            'tickets.*.name' => 'required|string|max:255',
            'tickets.*.price' => 'required|numeric',
            'tickets.*.quantity' => 'required|integer',
        ]);

        \DB::transaction(function () use ($request) {
            $data = $request->except('tickets');
            $data['slug'] = Str::slug($request->title);

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('events', 'public');
            }

            $data['is_featured'] = $request->has('is_featured');

            $event = Event::create($data);

            if ($request->has('tickets')) {
                foreach ($request->tickets as $ticket) {
                    $event->ticketTypes()->create($ticket);
                }
            }
        });

        if ($request->status === 'Draft') {
            return redirect()->route('admin.events.drafts')->with('success', 'Event saved to Draft Queue.');
        }

        return redirect()->route('admin.events.index')->with('success', 'Event created and launched successfully!');
    }

    public function edit(Event $event)
    {
        $categories = EventCategory::all();
        return view('admin.events.edit', compact('event', 'categories'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'category_id' => 'required|exists:event_categories,id',
            'organizer' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'registration_deadline' => 'required|date',
            'location' => 'required|string',
            'price' => 'required|numeric',
            'status' => 'required|in:Live,Expired,Draft',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'sort_order' => 'required|integer|min:0',
            'is_featured' => 'nullable|boolean',
            'tickets' => 'nullable|array',
            'tickets.*.name' => 'required|string|max:255',
            'tickets.*.price' => 'required|numeric',
            'tickets.*.quantity' => 'required|integer',
        ]);

        \DB::transaction(function () use ($request, $event) {
            $data = $request->except('tickets');
            $data['slug'] = Str::slug($request->title);

            if ($request->hasFile('image')) {
                if ($event->image) {
                    Storage::disk('public')->delete($event->image);
                }
                $data['image'] = $request->file('image')->store('events', 'public');
            }

            $data['is_featured'] = $request->has('is_featured');

            $event->update($data);

            if ($request->has('tickets')) {
                $event->ticketTypes()->delete();
                foreach ($request->tickets as $ticket) {
                    $event->ticketTypes()->create($ticket);
                }
            }
        });

        if ($request->status === 'Draft') {
            return redirect()->route('admin.events.drafts')->with('success', 'Draft updated successfully.');
        }

        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully!');
    }

    public function destroy(Event $event)
    {
        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }
        $event->delete();
        return redirect()->back()->with('success', 'Event removed successfully!');
    }
}
