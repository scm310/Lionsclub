<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\ClubPosition;
use App\Models\DGTeam;
use App\Models\DistrictChairperson;
use App\Models\DistrictGovernor;
use App\Models\InternationalOfficer;
use App\Models\PastGovernor;
use App\Models\RegionMember;
use Illuminate\Http\Request;

use App\Models\Member;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AssignMemberController extends Controller
{
    // Display the page

    public function index()
    {
        $members = Member::selectRaw("id, CONCAT(first_name, ' ', last_name) as full_name")->get();
        $chapters = Chapter::all(); // Fetch all chapters

        return view('admin.memberdirectory.assignmember', compact('members', 'chapters'));
    }


    public function clubindex(Request $request)
    {
        $chapters = Chapter::all();
        $members = [];

        if ($request->has('chapter_id') && $request->chapter_id != '') {
            $members = Member::where('account_name', $request->chapter_id)->get();
        }

        return view('admin.memberdirectory.assignclub', compact('chapters', 'members'));
    }




    public function searchMember(Request $request)
    {
        $query = $request->input('query');    // Search term entered by the user
        $clubId = $request->input('club_id'); // Club ID (if available)
        
        // Query the Member model to search by full name (first_name + last_name) and also include member_id
        $members = Member::select('id', 'first_name', 'last_name', 'member_id')  // Include member_id here
            ->when($clubId, function ($q) use ($clubId) {
                $q->where('club_id', $clubId);  // If club_id is provided, filter by club_id
            })
            ->where(function ($q) use ($query) {
                $q->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$query}%"])  // Search by full name
                  ->orWhere('member_id', 'LIKE', "%{$query}%");  // Also search by member_id
            })
            ->get()
            ->map(function ($member) {
                return [
                    'id' => $member->id,
                    'full_name' => $member->first_name . ' ' . $member->last_name,
                    'member_id' => $member->member_id,  // Ensure member_id is included
                ];
            });
    
        return response()->json($members); // Return the results as JSON
    }
    


    public function storeInternationalOfficer(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:add_members,id',
            'position' => 'required|string|max:255',
            'year' => 'required|string|max:50',
        ]);

        InternationalOfficer::create([
            'member_id' => $request->member_id,
            'position' => $request->position,
            'year' => $request->year,
        ]);

        return redirect()->back()->with('success', 'International Officer Assigned Successfully');
    }


    public function storedg(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:add_members,id',
            'position' => 'required|string|max:255',
            'year' => 'required|in:CurrentYear,UpCommingYear',
        ]);

        // Check if the same position is already assigned for the same year
        $exists = DGTeam::where('position', $request->position)
            ->where('year', $request->year)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'This position is already assigned for the selected year.');
        }

        // Store new position
        DGTeam::create([
            'member_id' => $request->member_id,
            'position' => $request->position,
            'year' => $request->year,
        ]);

        return redirect()->back()->with('success', 'DG Team position assigned successfully.');
    }



    public function storeDistrictGovernor(Request $request)
    {
        // Debugging: Check the received data
        Log::info('Received Data:', $request->all());

        // Validate the incoming request
        $validated = $request->validate([
            'member_id' => 'required|exists:add_members,id',
            'position' => 'required|string',
            'year' => 'required|string',
        ]);

        // Try to store data in the database
        try {
            $districtGovernor = new DistrictGovernor();
            $districtGovernor->member_id = $request->member_id;
            $districtGovernor->position = $request->position;
            $districtGovernor->year = $request->year;
            $districtGovernor->save();

            Log::info('District Governor Stored Successfully', ['id' => $districtGovernor->id]);

            return redirect()->back()->with('success', 'District Governor saved successfully!');
        } catch (\Exception $e) {
            Log::error('Error storing District Governor:', ['message' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to save District Governor!');
        }
    }

    public function storeClubPosition(Request $request)
    {
        $request->validate([
            'member_ids' => 'required|array|min:1',
            'member_ids.*' => 'exists:add_members,id',
            'position' => 'required|in:President,Secretary,Treasurer,Member'
        ]);

        try {
            foreach ($request->member_ids as $memberId) {
                ClubPosition::create([
                    'member_id' => $memberId,
                    'position' => $request->position
                ]);
            }

            return redirect()->back()->with('success', 'Members assigned to position successfully.');
        } catch (\Exception $e) {
            Log::error("Error assigning Club Positions: " . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to assign positions.');
        }
    }



    public function storeRegionMember(Request $request)
    {
        $request->validate([
            'region_member_id' => 'required|exists:add_members,id',
            'position' => 'required|in:Region Chairperson,Zone Chairperson',
            'region' => 'required|in:Region 1,Region 2,Region 3,Region 4',
            'zone' => 'nullable|required_if:position,Zone Chairperson|in:Zone 1,Zone 2,Zone 3',
            'chapter_id' => 'nullable|array', // Always required as array
            'chapter_id.*' => 'exists:chapters,id', // Every chapter must exist
        ]);

        RegionMember::create([
            'member_id' => $request->region_member_id,
            'position' => $request->position,
            'year' => $request->year,
            'region' => $request->region,
            'zone' => $request->position === 'Zone Chairperson' ? $request->zone : null,
            'chapter_id' => json_encode($request->chapter_id), // Store array as JSON string
        ]);

        return redirect()->back()->with('success', 'Region Member assigned successfully.');
    }



    public function storePastGovernor(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:add_members,id',
            'position' => 'required|string|max:255',
        ]);

        PastGovernor::create([
            'member_id' => $request->member_id,
            'position' => $request->position,
            'year' => $request->year, // Year is optional now
        ]);

        return redirect()->back()->with('success', 'Past Governor details assigned successfully!');
    }

    public function storeDistrictChairperson(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'member_id' => 'required|exists:add_members,id',
            'position' => 'required|string|max:255',
            'year' => 'required|string|max:9',
        ]);

        // Create District Chairperson record
        DistrictChairperson::create([
            'member_id' => $request->member_id,
            'position' => $request->position,
            'year' => $request->year,
        ]);

        // Return a success response with a message
        return response()->json([
            'status' => 'success',
            'message' => 'District Chairperson assigned successfully!'
        ]);
    }


    public function remove(Request $request)
    {
        $role = $request->input('role', 'internationalofficers'); // 👈 default here

        $modelMap = [
            'internationalofficers' => \App\Models\InternationalOfficer::class,
            'dg_team' => \App\Models\DGTeam::class,
            'district_governors' => \App\Models\DistrictGovernor::class,
            'club_positions' => \App\Models\ClubPosition::class,
            'region_members' => \App\Models\RegionMember::class,
            'past_governors' => \App\Models\PastGovernor::class,
            'district_chairpersons' => \App\Models\DistrictChairperson::class,
        ];

        $members = collect();

        if (array_key_exists($role, $modelMap)) {
            $model = $modelMap[$role];
            $table = (new $model)->getTable();

            $members = $model::leftJoin('add_members as am', "$table.member_id", '=', 'am.id')
                ->select(
                    "$table.*",
                    'am.first_name',
                    'am.last_name'
                )
                ->get();
        }

        return view('admin.memberdirectory.removemember', compact('members', 'role'));
    }









    public function destroy($role, $id)
    {
        $modelMap = [
            'internationalofficers' => InternationalOfficer::class,
            'dg_team' => DgTeam::class,
            'district_governors' => DistrictGovernor::class,
            'club_positions' => ClubPosition::class,
            'region_members' => RegionMember::class,
            'past_governors' => PastGovernor::class,
            'district_chairpersons' => DistrictChairperson::class,
        ];

        if (!array_key_exists($role, $modelMap)) {
            return redirect()->back()->with('error', 'Invalid role');
        }

        $model = $modelMap[$role];
        $model::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Member role removed successfully');
    }
}
