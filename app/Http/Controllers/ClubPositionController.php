<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chapter;
use App\Models\Member;

class ClubPositionController extends Controller
{
    // Show assign page
// In your controller
public function showAssignMemberPage()
{
    // Fetch all chapters
    $chapters = Chapter::all();
    
    // Return the view with chapters
    return view('admin.memberdirectory.assignmember', compact('chapters'));
}

// Get members by chapter
public function getMembers($id)
{
    // Assuming you have a relation between Chapter and Member (e.g. chapter has many members)
    $chapter = Chapter::findOrFail($id);
    $members = $chapter->members; // Fetch members related to the chapter
    
    // Return members as JSON response
    return response()->json($members);
}

    
    
    

    // Assign role
    public function assignRole(Request $request)
    {
        $request->validate([
            'club_id' => 'required',
            'role' => 'required',
            'member_ids' => 'required|array',
        ]);

        foreach ($request->member_ids as $memberId) {
            Member::where('id', $memberId)->update([
                'position' => $request->role
            ]);
        }

        return redirect()->back()->with('success', 'Roles assigned successfully!');
    }

    // Optional: Import form (if used)
    public function showImportForm()
    {
        return view('admin.memberdirectory.importmembers'); // Create this view if needed
    }
}

    
