<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PastEvent;
use Carbon\Carbon;

class GalleryController extends Controller
{
    public function showGallery()
    {
        // Fetch completed events along with event date from related `events` table
        $events = PastEvent::with('event') // Load related event details
            ->whereNotNull('images')
            ->get()
            ->groupBy(function ($event) {
                // Get event date from the related `event` model
                return optional($event->event)->event_date
                    ? Carbon::parse($event->event->event_date)->format('F Y')
                    : 'Unknown Date';
            });

        return view('member.gallery', compact('events'));
    }
}
