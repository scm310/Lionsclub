<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\ChapterMember;
use App\Models\DistrictGovernor;
use App\Models\PastDistrictGovernor;
use App\Models\RegionMember;
use Illuminate\Http\Request;
use App\Models\InternationalOfficer;
use App\Models\District;
use App\Models\Team;
use Illuminate\Support\Facades\DB;

class InternationalOfficerController extends Controller
{
    // Display form & list
    public function index()
    {
        $districts = District::all();
        $officers = InternationalOfficer::with('district')->get();
        $chapters = DB::table('chapters')->get(); // Fetch chapters
        $teams = Team::all(); // Fetch teams
    
        return view('admin.members.intlofficers', compact('districts', 'officers', 'chapters', 'teams'));
    }

    // Store International Officer
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:international_officers,email',
            'address' => 'required|string|max:500',
            'position' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'district_id' => 'required|exists:districts,id',
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image
        ]);
    
        // Handle file upload
        $imagePath = null;
        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
        }
    
        // Store data in the database
        InternationalOfficer::create([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'position' => $request->position,
            'company_name' => $request->company_name,
            'district_id' => $request->district_id,
            'profile_image' => $imagePath,
        ]);
    
        return redirect()->route('international.officers.index')->with('success', 'Officer added successfully.');
    }
    

    // Delete Officer
    public function destroy($id)
    {
        $officer = InternationalOfficer::findOrFail($id);
        $officer->delete();

        return redirect()->route('international.officers.index')->with('success', 'Officer deleted successfully.');
    }



    public function storeGovernor(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:district_governors,email',
            'phone' => 'required|string|max:20',
            'position' => 'required|string|max:255',
            'district_id' => 'required|exists:districts,id',
            'address' => 'required|string|max:500',
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Handle file upload
        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
        }
    
        DistrictGovernor::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'position' => $request->position,
            'district_id' => $request->district_id,
            'address' => $request->address,
            'profile_image' => $imagePath ?? null,
        ]);
    
        return redirect()->back()->with('success', 'District Governor added successfully.');
    }
    


    public function storeDgTeam(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'position' => 'required|string|max:255',
        'mobile_no' => 'required|string|max:20',
        'address' => 'required|string|max:500',
        'email' => 'required|email|unique:dg_teams,email',
        'phone' => 'required|string|max:20',
        'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Handle File Upload
    $photoPath = null;
    if ($request->hasFile('profile_photo')) {
        $photoPath = $request->file('profile_photo')->store('dg_team_photos', 'public');
    }

    // Store in Database
    DB::table('dg_teams')->insert([
        'name' => $request->name,
        'position' => $request->position,
        'mobile_no' => $request->mobile_no,
        'address' => $request->address,
        'email' => $request->email,
        'phone' => $request->phone,
        'profile_photo' => $photoPath,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->back()->with('success', 'DG Team Member added successfully.');
}



public function addChapterMember(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:chaptermember,email',
        'phone' => 'required|string|max:15',
        'address' => 'required|string',
        'role' => 'required|integer',
        'chapter_id' => 'required|exists:chapters,id',
        'profile_image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
    ]);

    $imagePath = null;
    if ($request->hasFile('profile_image')) {
        $imagePath = $request->file('profile_image')->store('profile_images', 'public');
    }

    ChapterMember::create([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'address' => $request->address,
        'role' => $request->role,
        'chapter_id' => $request->chapter_id,
        'profile_image' => $imagePath,
    ]);

    return redirect()->back()->with('success', 'Chapter Member Added Successfully!');
}


public function showAddChapterMemberForm()
{
    $chapters = DB::table('chapters')->get();
    return view('admin.members.addchaptermember', compact('chapters'));
}


public function addDistrictChairperson(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:district_chairpersons,email',
        'phone' => 'required|string|max:20',
        'm_no' => 'required|string|max:20',
        'address' => 'required|string',
        'position' => 'required|string',
        'team_id' => 'required|exists:teams,id',
        'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    // Handle profile image upload
    $imagePath = $request->file('profile_image')->store('profile_images', 'public');

    DistrictChairperson::create([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'm_no' => $request->m_no,
        'address' => $request->address,
        'position' => $request->position,
        'team_id' => $request->team_id,
        'profile_image' => $imagePath,
    ]);

    return back()->with('success', 'District Chairperson added successfully.');
}


public function showDistrictChairpersonForm()
{
    $teams = Team::all();
    return view('admin.district_chairperson_form', compact('teams'));
}


public function addRegionMember()
{
    $chapters = DB::table('chapters')->get();
    return view('admin.region_members.create', compact('chapters'));
}


public function storeRegionMember(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:region_members,email',
        'phone' => 'required|string|max:20',
        'address' => 'required|string',
        'm_no' => 'required|string|max:50',
        'chapter_id' => 'required|exists:chapters,id',
        'region' => 'required|string',
        'position' => 'required|string',
        'profile_image' => 'required|image|mimes:jpg,jpeg,png|max:2048', // Image validation
    ]);

    // Handle Image Upload
    $imagePath = null;
    if ($request->hasFile('profile_image')) {
        $imagePath = $request->file('profile_image')->store('profile_images', 'public');
    }

    // Store data in database
    RegionMember::create([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'address' => $request->address,
        'm_no' => $request->m_no,
        'chapter_id' => $request->chapter_id,
        'region' => $request->region,
        'position' => $request->position,
        'profile_image' => $imagePath, // Save image path
    ]);

    return redirect()->back()->with('success', 'Region Member Added Successfully');
}

public function createPastDistrictGovernor()
{
    $chapters = Chapter::all();
    return view('pastdistrictgovernors.create', compact('chapters'));
}

public function storePastDistrictGovernor(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:past_district_governors,email',
        'phone' => 'required|string|max:20',
        'address' => 'required|string',
        'blood_group' => 'required|string|max:10',
        'm_no' => 'required|string|max:50',
        'chapter_id' => 'required|exists:chapters,id',
        'spouse_name' => 'nullable|string|max:255',
        'year_of_joining' => 'required|date',
        'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'pdg' => 'required|string|in:Club Constitution & Trust,Service Activities,Eye Care,Leadership,Foundation Coordinator,Membership,Hunger Relief'
    ]);

    // Handle image upload
    $profilePhoto = null;
    if ($request->hasFile('profile_photo')) {
        $profilePhoto = $request->file('profile_photo')->store('profile_photos', 'public');
    }

    PastDistrictGovernor::create([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'address' => $request->address,
        'blood_group' => $request->blood_group,
        'm_no' => $request->m_no,
        'chapter_id' => $request->chapter_id,
        'spouse_name' => $request->spouse_name,
        'year_of_joining' => $request->year_of_joining,
        'profile_photo' => $profilePhoto,
        'pdg' => $request->pdg
    ]);

    return redirect()->back()->with('success', 'Past District Governor Added Successfully');
}

   

}
