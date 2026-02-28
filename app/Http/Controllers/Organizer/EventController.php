<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\EventFormField;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        $stats = [
            'total' => Event::where('user_id', Auth::id())->count(),
            'pending' => Event::where('user_id', Auth::id())->where('is_approved', false)->count(),
            'active_today' => Event::where('user_id', Auth::id())->where('status', 'Live')->whereDate('date', now())->count(),
            'reported' => 0, 
        ];

        $events = Event::with(['category', 'ticketTypes', 'bookings'])->where('user_id', Auth::id())->latest()->get();
        return view('organizer.events.index', compact('events', 'stats'));
    }

    public function create()
    {
        $categories = EventCategory::all();
        return view('organizer.events.create', compact('categories'));
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
            'venue_name' => 'nullable|string|max:255',
            'price' => 'required|numeric',
            'status' => 'required|in:Live,Expired,Draft',
            'description' => 'nullable|string',
            'language' => 'nullable|string|max:255',
            'age_limit' => 'nullable|string|max:255',
            'duration' => 'nullable|string|max:255',
            'you_should_know' => 'nullable|string',
            'terms_conditions' => 'nullable|string',
            'artists_raw' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'tickets' => 'nullable|array',
            'tickets.*.name' => 'required|string|max:255',
            'tickets.*.price' => 'required|numeric',
            'tickets.*.quantity' => 'required|integer',
        ]);

        \DB::transaction(function () use ($request) {
            $data = $request->except(['tickets', 'artists_raw', 'form_fields_raw']);
            $data['slug'] = Str::slug($request->title);
            $data['event_code'] = $request->event_code ?? 'EVP-' . strtoupper(Str::random(8));
            $data['user_id'] = Auth::id();
            $data['is_approved'] = false; // Must be approved by admin
            $data['sort_order'] = 0;
            $data['is_featured'] = false;

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('events', 'public');
            }

            if ($request->artists_raw) {
                $data['artists'] = json_decode($request->artists_raw, true);
            }

            $event = Event::create($data);

            if ($request->has('tickets')) {
                foreach ($request->tickets as $ticket) {
                    $event->ticketTypes()->create($ticket);
                }
            }

            $this->saveFormFields($event, $request->form_fields_raw);
        });

        return redirect()->route('organizer.events.index')->with('success', 'Event created! It will be visible after admin approval.');
    }

    public function getNextCode(Request $request)
    {
        $prefix = $request->prefix ?: 'EVP';
        $suffix = $request->suffix ?: 'XYZ';

        // Find the last event code with this prefix and suffix
        // Format: PREFIX-NUMBER-SUFFIX
        $lastEvent = Event::where('event_code', 'like', "$prefix-%-$suffix")
            ->orderBy('id', 'desc')
            ->first();

        $number = 1;
        if ($lastEvent) {
            $parts = explode('-', $lastEvent->event_code);
            if (count($parts) >= 2) {
                $lastNumber = (int)$parts[1];
                $number = $lastNumber + 1;
            }
        }

        $formattedNumber = str_pad($number, 2, '0', STR_PAD_LEFT);
        return response()->json([
            'number' => $formattedNumber,
            'full_code' => "$prefix-$formattedNumber-$suffix"
        ]);
    }

    public function edit(Event $event)
    {
        if ($event->user_id !== Auth::id()) abort(403);
        
        $categories = EventCategory::all();
        return view('organizer.events.edit', compact('event', 'categories'));
    }

    public function update(Request $request, Event $event)
    {
        if ($event->user_id !== Auth::id()) abort(403);

        $request->validate([
            'category_id' => 'required|exists:event_categories,id',
            'organizer' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'event_code' => 'required|string|unique:events,event_code,'.$event->id,
            'date' => 'required|date',
            'registration_deadline' => 'required|date',
            'location' => 'required|string',
            'venue_name' => 'nullable|string|max:255',
            'price' => 'required|numeric',
            'status' => 'required|in:Live,Expired,Draft',
            'description' => 'nullable|string',
            'language' => 'nullable|string|max:255',
            'age_limit' => 'nullable|string|max:255',
            'duration' => 'nullable|string|max:255',
            'you_should_know' => 'nullable|string',
            'terms_conditions' => 'nullable|string',
            'artists_raw' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'tickets' => 'nullable|array',
            'tickets.*.name' => 'required|string|max:255',
            'tickets.*.price' => 'required|numeric',
            'tickets.*.quantity' => 'required|integer',
        ]);

        \DB::transaction(function () use ($request, $event) {
            $data = $request->except(['tickets', 'artists_raw', 'form_fields_raw']);
            
            if ($request->title !== $event->title) {
                $data['slug'] = Str::slug($request->title);
            }

            if ($request->hasFile('image')) {
                if ($event->image) {
                    Storage::disk('public')->delete($event->image);
                }
                $data['image'] = $request->file('image')->store('events', 'public');
            }

            if ($request->artists_raw) {
                $data['artists'] = json_decode($request->artists_raw, true);
            }

            // On edit, maybe set is_approved false to require re-approval? User didn't specify. We'll leave it as is or reset if they want. Let's keep it approved unless super admin edits.
            
            $event->update($data);

            $event->ticketTypes()->delete();
            if ($request->has('tickets')) {
                foreach ($request->tickets as $ticket) {
                    $event->ticketTypes()->create($ticket);
                }
            }

            $this->saveFormFields($event, $request->form_fields_raw);
        });

        return redirect()->route('organizer.events.index')->with('success', 'Event updated successfully!');
    }

    public function destroy(Event $event)
    {
        if ($event->user_id !== Auth::id()) abort(403);
        
        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }
        $event->delete();

        return redirect()->route('organizer.events.index')->with('success', 'Event deleted permanently.');
    }

    public function bookings($event_id)
    {
        $event = Event::findOrFail($event_id);
        if ($event->user_id !== Auth::id()) abort(403);

        $bookings = Booking::with(['user', 'attendees'])->where('event_id', $event_id)->latest()->paginate(20);
        return view('organizer.events.bookings', compact('event', 'bookings'));
    }

    private function saveFormFields(Event $event, $rawFields)
    {
        $event->formFields()->delete();

        // Always create the 4 default fields
        $defaults = [
            ['label' => 'Name', 'type' => 'text', 'is_required' => true, 'is_default' => true, 'sort_order' => 0],
            ['label' => 'Email', 'type' => 'email', 'is_required' => true, 'is_default' => true, 'sort_order' => 1],
            ['label' => 'Phone', 'type' => 'text', 'is_required' => true, 'is_default' => true, 'sort_order' => 2],
            ['label' => 'Address', 'type' => 'textarea', 'is_required' => true, 'is_default' => true, 'sort_order' => 3],
        ];

        foreach ($defaults as $field) {
            $event->formFields()->create($field);
        }

        // Save custom fields
        if ($rawFields) {
            $customFields = json_decode($rawFields, true);
            if (is_array($customFields)) {
                foreach ($customFields as $index => $field) {
                    // Check both 'label' and 'name' for compatibility with whatever the organizer frontend sends
                    $label = $field['label'] ?? $field['name'] ?? null;
                    if ($label && !empty($field['type'])) {
                        $event->formFields()->create([
                            'label' => $label,
                            'type' => $field['type'],
                            'options' => isset($field['options']) && is_array($field['options']) ? $field['options'] : null,
                            'is_required' => $field['required'] ?? $field['is_required'] ?? false,
                            'is_default' => false,
                            'sort_order' => $index + 4,
                        ]);
                    }
                }
            }
        }
    }
}
