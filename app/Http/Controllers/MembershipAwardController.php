<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Award;
use App\Models\Chapter;
use App\Models\MembershipAwardRecord;

class MembershipAwardController extends Controller
{
    public function index()
    {
        $awards = Award::all();
        $chapters = Chapter::all();
        $records = MembershipAwardRecord::all();
        return view('admin.membership_awards.index', compact('awards', 'chapters', 'records'));
    }
    

    public function storeAward(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Award::create(['name' => $request->name]);

        return redirect()->back()->with('success', 'Award added successfully.');
    }
    public function storeMembershipAward(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'awards_id' => 'required|exists:awards,id',  // Ensure that the awards_id exists in the awards table
            'chapter_id' => 'required|exists:chapters,id',  // Ensure that the chapter_id exists in the chapters table
        ]);
    
        // Create a new membership award record
        MembershipAwardRecord::create([
            'name' => $request->name,
            'awards_id' => $request->awards_id,  // Ensure the correct field name for awards_id
            'chapter_id' => $request->chapter_id,  // Ensure the correct field name for chapter_id
        ]);
    
        // Redirect back with a success message
        return redirect()->back()->with('success', 'Membership Award Record added successfully.');
    }

    public function destroy($id)
    {
        // Find the record by ID
        $record = MembershipAwardRecord::findOrFail($id);
    
        // Delete the record
        $record->delete();
    
        // Return a JSON response
        return response()->json([
            'success' => 'Record deleted successfully.'
        ]);
    }
    

    
}    
