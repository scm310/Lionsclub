<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\PastEvent;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        // Include events with today's date and future
        $events = Event::whereDate('event_date', '>=', Carbon::today())
            ->orderBy('event_date', 'asc')
            ->get();

        $completedEvents = PastEvent::with('event')->latest()->get();

        return view('admin.Event.index', compact('events', 'completedEvents'));
    }



// Store a new event
public function store(Request $request)
{
    $request->validate([
        'event_name' => 'required|string|max:255',
        'event_date' => 'required|date',
        'event_invitation' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $eventData = [
        'event_name' => $request->event_name,
        'event_date' => $request->event_date,
    ];

    if ($request->hasFile('event_invitation')) {
        $file = $request->file('event_invitation');
        $filename = time() . '_' . $file->getClientOriginalName();

        // Store the file in storage/app/public/event_invitations
        $file->storeAs('event_invitations', $filename, 'public');

        // Store ONLY the filename in the database (without path)
        $eventData['event_invitation'] = $filename;
    }

    Event::create($eventData);

    return back()->with('success', 'Event added successfully!');
}

public function edit($id)
{
    $event = Event::findOrFail($id);
    return view('admin.Event.edit', compact('event'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'event_name' => 'required|string|max:255',
        'event_date' => 'required|date',
        'event_invitation' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $event = Event::findOrFail($id);
    $event->event_name = $request->event_name;
    $event->event_date = $request->event_date;

    if ($request->hasFile('event_invitation')) {
        // Delete old file
        if ($event->event_invitation && file_exists(public_path('storage/event_invitations/' . $event->event_invitation))) {
            unlink(public_path('storage/event_invitations/' . $event->event_invitation));
        }

        $file = $request->file('event_invitation');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('event_invitations', $filename, 'public');
        $event->event_invitation = $filename;
    }

    $event->save();

    return redirect()->route('event_index')->with('success', 'Event updated successfully!');
}


public function storeCompletedEvent(Request $request)
{
    $request->validate([
        'event_id' => 'required|exists:events,id',
        'venue' => 'required|string|max:255',
        'details' => 'required|string',
        'images.*' => 'image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $imagePaths = [];
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $imagePaths[] = $image->store('past_event_images', 'public');
        }
    }

    PastEvent::create([
        'event_id' => $request->event_id,
        'venue' => $request->venue,
        'details' => $request->details,
        'images' => $imagePaths,
    ]);

    return back()->with('success', 'Past event added successfully!');
}


public function deleteCompletedEvent($id)
{
    $event = PastEvent::find($id);

    if (!$event) {
        return back()->with('error', 'Event not found.');
    }

    // Delete images from storage
    if (is_string($event->images)) {
        $images = json_decode($event->images, true);
    } else {
        $images = $event->images;
    }

    if (is_array($images)) {
        foreach ($images as $image) {
            Storage::disk('public')->delete($image);
        }
    }

    // Delete the event record
    $event->delete();

    return back()->with('success', 'Event deleted successfully!');
}

public function destroy($id)
{
    $event = Event::findOrFail($id);

    if ($event->event_invitation) {
        $path = storage_path('app/public/event_invitations/' . basename($event->event_invitation));
        if (file_exists($path)) {
            unlink($path);
        }
    }

    $event->delete();

    return back()->with('success', 'Event deleted successfully!');
}


}
