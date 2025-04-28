<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;
use Illuminate\Support\Facades\Auth; // make sure this is at the top
use Illuminate\Support\Facades\DB;

class AnnouncementController extends Controller
{

    public function create()
    {
        // Auto-delete announcements older than 48 hours
        Announcement::where('created_at', '<', now()->subHours(48))->delete();
    
        $memberId = session('member_id');
    
        if (!is_null($memberId)) {
            // Get account_name from add_members (maps to chapter_id in announcements)
            $accountName = DB::table('add_members')
                ->where('member_id', $memberId)
                ->value('account_name');
    
            // Fetch announcements only for this chapter
            $announcements = Announcement::where('chapter_id', $accountName)
                ->latest()
                ->get();
        } else {
            // Admin: fetch all announcements
            $announcements = Announcement::latest()->get();
        }
    
        return view('admin.announcement', compact('announcements'));
    }
    
    


    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'subject' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'message' => 'required|string',
        ]);

        $imagePath = $request->file('image')?->store('announcements', 'public');

        $chapterId = null;

        // If logged in from member table
        if (session()->has('member_id')) {
            $memberId = session('member_id');
            $chapterId = DB::table('add_members')
                ->where('member_id', $memberId)
                ->value('account_name');
        }

        // If logged in from club position table
        if (session()->has('club_id')) {
            $clubId = session('club_id');
            $chapterId = DB::table('club_positions')
                ->where('club_id', $clubId)
                ->value('club_id'); // Or use another column if needed
        }

        Announcement::create([
            'date' => $validated['date'],
            'subject' => $validated['subject'],
            'image' => $imagePath,
            'message' => $validated['message'],
            'chapter_id' => $chapterId,
        ]);

        return redirect()->back()->with('success', 'Announcement created successfully!');
    }


    public function destroy($id)
    {
        $announcement = Announcement::findOrFail($id);

        // Delete image file if exists
        if ($announcement->image && \Storage::exists('public/' . $announcement->image)) {
            \Storage::delete('public/' . $announcement->image);
        }

        $announcement->delete();

        return redirect()->back()->with('success', 'Announcement deleted successfully.');
    }
}
