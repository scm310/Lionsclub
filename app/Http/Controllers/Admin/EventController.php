<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\District;
use App\Models\Event;
use App\Models\ParentsMultipleDistrict;
use Illuminate\Http\Request;
use App\Models\PastEvent;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::whereDate('start_date', '>=', Carbon::today())
            ->orderBy('start_date', 'asc')
            ->get();
    
        $completedEvents = PastEvent::with('event')->latest()->get();
    
        $multipleDistricts = DB::table('parents_multiple_district')->get();
        $districts = DB::table('district')->get();
        $clubs = DB::table('chapters')->get();
    
        return view('admin.Event.index', compact('events', 'completedEvents', 'multipleDistricts', 'districts', 'clubs'));
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'event_name' => 'required|string|max:255',
           
            'activity_level' => 'required|string|max:255',
            'multiple_district_id' => 'required',
            'district_id' => 'required',
            'club_id' => 'required',
            'creator' => 'required|string|max:255',
            'activity_duration' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'activity_type' => 'required|string',
            'cause' => 'required|string',
            'total_volunteers' => 'required|integer',
            'description' => 'required|string',
            'event_invitation' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $eventData = $request->only([
            'event_name',
          
            'activity_level',
            'multiple_district_id',
            'district_id',
            'club_id',
            'creator',
            'activity_duration',
            'start_date',
            'end_date',
            'activity_type',
            'cause',
            'total_volunteers',
            'description'
        ]);
    
        if ($request->hasFile('event_invitation')) {
            $file = $request->file('event_invitation');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('event_invitations', $filename, 'public');
            $eventData['event_invitation'] = $filename;
        }
    
        Event::create($eventData);
    
        return back()->with('success', 'Event added successfully!');
    }
    



    public function edit($id)
    {
        $event = Event::findOrFail($id);
        $multipleDistricts = ParentsMultipleDistrict::all(); // adjust model name if needed
        $districts = District::all(); // adjust model name if needed
        $clubs = Chapter::all(); // adjust model name if needed
    
        return view('admin.Event.edit', compact('event', 'multipleDistricts', 'districts', 'clubs'));
    }
    

    public function update(Request $request, $id)
    {
        $request->validate([
            'event_name' => 'required|string|max:255',
            'activity_level' => 'required|string|max:255',
            'multiple_district_id' => 'required',
            'district_id' => 'required',
            'club_id' => 'required',
            'creator' => 'required|string|max:255',
            'activity_duration' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'activity_type' => 'required',
            'cause' => 'required',
            'total_volunteers' => 'required|integer',
            'description' => 'required|string',
            'event_invitation' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $event = Event::findOrFail($id);
    
        $event->update([
            'event_name' => $request->event_name,
            'activity_level' => $request->activity_level,
            'multiple_district_id' => $request->multiple_district_id,
            'district_id' => $request->district_id,
            'club_id' => $request->club_id,
            'creator' => $request->creator,
            'activity_duration' => $request->activity_duration,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'activity_type' => $request->activity_type,
            'cause' => $request->cause,
            'total_volunteers' => $request->total_volunteers,
            'description' => $request->description,
        ]);
    
        if ($request->hasFile('event_invitation')) {
            if ($event->event_invitation && file_exists(public_path('storage/event_invitations/' . $event->event_invitation))) {
                unlink(public_path('storage/event_invitations/' . $event->event_invitation));
            }
    
            $file = $request->file('event_invitation');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('event_invitations', $filename, 'public');
            $event->event_invitation = $filename;
            $event->save();
        }
    
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
