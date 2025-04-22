<?php

namespace App\Http\Controllers;

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
        return view('admin.memberdirectory.assignmember', compact('members'));
    }

    // Handle search request
    public function searchMember(Request $request)
    {
        $query = $request->input('query');

        $members = Member::selectRaw("id, CONCAT(first_name, ' ', last_name) as full_name")
            ->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$query}%"])
            ->get();

        return response()->json($members);
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
        ]);

        DGTeam::create([
            'member_id' => $request->member_id,
            'position' => $request->position,
        ]);

        return redirect()->back()->with('success', 'DG Team position assigned successfully.');
    }

    public function storeDistrictGovernor(Request $request) {
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
        'member_id' => 'required|exists:add_members,id',
        'position' => 'required|in:President,Secretary,Treasurer,Member'
    ]);

    try {
        ClubPosition::create([
            'member_id' => $request->member_id,
            'position' => $request->position
        ]);

        return redirect()->back()->with('success', 'Club Position assigned successfully.');
    } catch (\Exception $e) {
        Log::error("Error assigning Club Position: " . $e->getMessage());
        return redirect()->back()->with('error', 'Failed to assign Club Position.');
    }
}
    

public function storeRegionMember(Request $request)
{
    $request->validate([
        'region_member_id' => 'required|exists:add_members,id',
        'position' => 'required|in:Region Chairperson,Zone Chairperson',
        'region' => 'required|in:Region 1,Region 2,Region 3,Region 4',
        'zone' => 'nullable|required_if:position,Zone Chairperson|in:Zone 1,Zone 2,Zone 3',
    ]);

    RegionMember::create([
        'member_id' => $request->region_member_id,
        'position' => $request->position,
        'year' => $request->year,
        'region' => $request->region,
        'zone' => $request->position === 'Zone Chairperson' ? $request->zone : null,
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
    $request->validate([
        'member_id' => 'required|exists:add_members,id',
        'position' => 'required|string|max:255',
        'year' => 'required|string|max:9',
    ]);

    DistrictChairperson::create([
        'member_id' => $request->member_id,
        'position' => $request->position,
        'year' => $request->year,
    ]);

    return response()->json(['message' => 'District Chairperson assigned successfully!']);
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
