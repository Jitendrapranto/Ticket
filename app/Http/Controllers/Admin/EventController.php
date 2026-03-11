<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventCategory;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $stats = [
            'total' => Event::count(),
            'pending' => Event::where('is_approved', false)->count(),
            'active_today' => Event::where('status', 'Live')->whereDate('date', now())->count(),
            'reported' => 0, // Placeholder as there's no reports table yet
        ];

        $events = Event::with(['category', 'ticketTypes', 'bookings'])->latest()->get();
        
        return view('admin.events.index', compact('events', 'stats'));
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

    public function approve(Event $event)
    {
        $event->update(['is_approved' => true]);
        return redirect()->back()->with('success', 'Event approved successfully!');
    }

    public function create()
    {
        $categories = EventCategory::all();
        $organizers = User::where('role', 'organizer')->orderBy('name')->get();
        return view('admin.events.create', compact('categories', 'organizers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:event_categories,id',
            'user_id' => 'nullable|exists:users,id',
            'organizer' => 'nullable|string|max:255',
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
            'sort_order' => 'required|integer|min:0',
            'is_featured' => 'nullable|boolean',
            'tickets' => 'nullable|array',
            'tickets.*.name' => 'required|string|max:255',
            'tickets.*.price' => 'required|numeric',
            'tickets.*.quantity' => 'required|integer',
        ]);

        \DB::transaction(function () use ($request) {
            $data = $request->except(['tickets', 'artists_raw', 'form_fields_raw']);
            $data['slug'] = Str::slug($request->title);
            $data['is_approved'] = true;

            // Automatically set organizer name if user is selected and organizer name is empty
            if ($request->filled('user_id') && !$request->filled('organizer')) {
                $organizerUser = User::find($request->user_id);
                $data['organizer'] = $organizerUser->name;
            }

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('events', 'public');
            }

            $data['is_featured'] = $request->has('is_featured');
            
            if ($request->artists_raw) {
                $data['artists'] = json_decode($request->artists_raw, true);
            }

            $event = Event::create($data);

            if ($request->has('tickets')) {
                foreach ($request->tickets as $ticket) {
                    $event->ticketTypes()->create($ticket);
                }
            }

            // Save form fields
            $this->saveFormFields($event, $request->form_fields_raw);
        });

        if ($request->status === 'Draft') {
            return redirect()->route('admin.events.drafts')->with('success', 'Event saved to Draft Queue.');
        }

        return redirect()->route('admin.events.index')->with('success', 'Event created and launched successfully!');
    }

    public function edit(Event $event)
    {
        $categories = EventCategory::all();
        $organizers = User::where('role', 'organizer')->orderBy('name')->get();
        $event->load('formFields');
        return view('admin.events.edit', compact('event', 'categories', 'organizers'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'category_id' => 'required|exists:event_categories,id',
            'user_id' => 'nullable|exists:users,id',
            'organizer' => 'nullable|string|max:255',
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
            'sort_order' => 'required|integer|min:0',
            'is_featured' => 'nullable|boolean',
            'tickets' => 'nullable|array',
            'tickets.*.name' => 'required|string|max:255',
            'tickets.*.price' => 'required|numeric',
            'tickets.*.quantity' => 'required|integer',
        ]);

        \DB::transaction(function () use ($request, $event) {
            $data = $request->except(['tickets', 'artists_raw', 'form_fields_raw']);
            $data['slug'] = Str::slug($request->title);

            // Automatically set organizer name if user is selected and organizer name is empty
            if ($request->filled('user_id') && !$request->filled('organizer')) {
                $organizerUser = User::find($request->user_id);
                $data['organizer'] = $organizerUser->name;
            }

            if ($request->hasFile('image')) {
                if ($event->image) {
                    Storage::disk('public')->delete($event->image);
                }
                $data['image'] = $request->file('image')->store('events', 'public');
            }

            $data['is_featured'] = $request->has('is_featured');
            
            if ($request->artists_raw) {
                $data['artists'] = json_decode($request->artists_raw, true);
            }

            $event->update($data);

            if ($request->has('tickets')) {
                $event->ticketTypes()->delete();
                foreach ($request->tickets as $ticket) {
                    $event->ticketTypes()->create($ticket);
                }
            }

            // Save form fields
            $this->saveFormFields($event, $request->form_fields_raw);
        });

        if ($request->status === 'Draft') {
            return redirect()->route('admin.events.drafts')->with('success', 'Draft updated successfully.');
        }

        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully!');
    }

    public function export()
    {
        $events = Event::with('category')->latest()->get();

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $phpWord->getSettings()->setUpdateFields(true);

        $section = $phpWord->addSection([
            'orientation' => 'landscape',
            'pageSizeW' => \PhpOffice\PhpWord\Shared\Converter::cmToEmu(35),
            'pageSizeH' => \PhpOffice\PhpWord\Shared\Converter::cmToEmu(21),
            'marginTop'    => 800,
            'marginBottom' => 800,
            'marginLeft'   => 800,
            'marginRight'  => 800,
        ]);

        // Title
        $section->addText(
            'Platform Verified Event Master List — ' . date('Y-M-d'),
            ['bold' => true, 'size' => 16, 'color' => '1B2B46'],
            ['spaceAfter' => 400, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]
        );

        // Table style
        $styleTable = ['borderSize' => 6, 'borderColor' => 'E2E8F0', 'cellMargin' => 80];
        $styleFirstRow = ['bgColor' => '1B2B46', 'bold' => true];
        $phpWord->addTableStyle('EventTable', $styleTable, $styleFirstRow);

        $table = $section->addTable('EventTable');

        // Header row
        $headers = ['ID', 'Photo', 'Event Title', 'Category', 'Organizer', 'Date', 'Venue', 'Status', 'Sales'];
        $colWidths = [1000, 2000, 3500, 2000, 2500, 2500, 3000, 1500, 1000];
        
        $table->addRow(600);
        foreach ($headers as $i => $hdr) {
            $table->addCell($colWidths[$i])->addText($hdr, ['bold' => true, 'color' => 'FFFFFF', 'size' => 10]);
        }

        // Data rows
        foreach ($events as $event) {
            $totalTickets = $event->ticketTypes->sum('quantity');
            $soldTickets = \App\Models\BookingAttendee::whereIn('ticket_type_id', $event->ticketTypes->pluck('id'))->count();
            $salesPercent = $totalTickets > 0 ? round(($soldTickets / $totalTickets) * 100) : 0;

            $table->addRow(1200);
            $cellStyle = ['valign' => 'center', 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER];
            $textStyle = ['size' => 9];

            // ID
            $table->addCell($colWidths[0], $cellStyle)->addText((string)$event->id, $textStyle);
            
            // PHOTO
            $photoCell = $table->addCell($colWidths[1], $cellStyle);
            if ($event->image) {
                $absolutePath = \Storage::disk('public')->path($event->image);
                if (file_exists($absolutePath)) {
                    try {
                        $photoCell->addImage($absolutePath, ['width' => 60, 'height' => 45, 'wrappingStyle' => 'inline']);
                    } catch (\Exception $e) {
                        $photoCell->addText('(img err)', $textStyle);
                    }
                } else {
                    $photoCell->addText('N/A', $textStyle);
                }
            } else {
                $photoCell->addText('N/A', $textStyle);
            }

            $table->addCell($colWidths[2], $cellStyle)->addText($event->title, ['bold' => true, 'size' => 9]);
            $table->addCell($colWidths[3], $cellStyle)->addText($event->category->name ?? 'N/A', $textStyle);
            $table->addCell($colWidths[4], $cellStyle)->addText($event->organizer, $textStyle);
            $table->addCell($colWidths[5], $cellStyle)->addText($event->date->format('M d, Y'), $textStyle);
            $table->addCell($colWidths[6], $cellStyle)->addText($event->venue_name ?? $event->location, $textStyle);
            $table->addCell($colWidths[7], $cellStyle)->addText($event->is_approved ? 'APPROVED' : 'PENDING', 
                ['bold' => true, 'color' => $event->is_approved ? '10B981' : 'F59E0B', 'size' => 9]);
            $table->addCell($colWidths[8], $cellStyle)->addText($salesPercent . '%', $textStyle);
        }

        $tmpFile = tempnam(sys_get_temp_dir(), 'ev_word_') . '.docx';
        $writer = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($tmpFile);

        $fileName = 'platform_verified_events_' . date('Y_m_d_His') . '.docx';

        return response()->download($tmpFile, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ])->deleteFileAfterSend(true);
    }

    public function destroy(Event $event)
    {
        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }
        $event->delete();
        return redirect()->back()->with('success', 'Event removed successfully!');
    }

    /**
     * Save dynamic form fields for an event.
     */
    private function saveFormFields(Event $event, $formFieldsRaw)
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
        if ($formFieldsRaw) {
            $customFields = json_decode($formFieldsRaw, true);
            if (is_array($customFields)) {
                foreach ($customFields as $index => $field) {
                    if (!empty($field['label']) && !empty($field['type'])) {
                        $event->formFields()->create([
                            'label' => $field['label'],
                            'type' => $field['type'],
                            'options' => isset($field['options']) && is_array($field['options']) ? $field['options'] : null,
                            'is_required' => $field['is_required'] ?? false,
                            'is_default' => false,
                            'sort_order' => $index + 4,
                        ]);
                    }
                }
            }
        }
    }
}
