<?php

namespace App\Http\Controllers;

use App\Imports\MembersImport;
use App\Models\Chapter;
use App\Models\District;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\MembershipType;
use App\Models\ParentsMultipleDistrict;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class MemberController extends Controller
{

    public function index()
    {
        // Get session values
        $adminId = session('admin_id');
        $adminRole = session('admin_role');
        $memberId = session('member_id');
       
        
        // If a specific member is logged in
        if (!is_null($memberId)) {
            // Step 1: Get the account_name of the logged-in user from add_members
            $targetAccountName = DB::table('add_members')
                ->where('member_id', $memberId)
                ->value('account_name');
    
            // Step 2: Fetch all members with the same account_name via the account relationship
            $members = Member::with(['membershipType', 'parentMultipleDistrict', 'parentDistrict', 'account'])
                ->whereHas('account', function ($query) use ($targetAccountName) {
                    $query->where('account_name', $targetAccountName);
                })
                ->orderBy('created_at', 'desc')
                ->get();
    
            return view('admin.addmembers.list', compact('members'));
        }
    
        // Otherwise, fetch all members
        $members = Member::with(['membershipType', 'parentMultipleDistrict', 'parentDistrict', 'account'])
            ->orderBy('created_at', 'desc')
            ->get();
    
        return view('admin.addmembers.list', compact('members'));
    }
    
    

    

  
  
  public function create()
    {
        $parentMultipleDistricts = ParentsMultipleDistrict::all(); // Fetch all multiple districts
        $districts = District::all(); // Fetch all districts
        $chapters = Chapter::all(); // Fetch all chapters
        $membershipTypes = MembershipType::all(); // Fetch all membership types

        return view('admin.addmembers.create', compact('parentMultipleDistricts', 'districts', 'chapters', 'membershipTypes'));
    }
 
    
    
    
    public function checkMemberId(Request $request)
    {
        $exists = Member::where('member_id', $request->member_id)->exists();
        return response()->json(['exists' => $exists]);
    }
    

    public function getDistricts(Request $request)
    {
        // Ensure 'parent_multiple_district_id' is being passed correctly
        $districts = District::where('parent_district_id', $request->parent_multiple_district_id)->get();
    
        return response()->json($districts);
    }



    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'member_id' => 'required|unique:add_members',
            'dob' => 'required|date_format:Y-m-d',
            'anniversary_date' => 'nullable|date_format:Y-m-d',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'phone_number' => 'nullable|string|max:20',
            'work_number' => 'nullable|string|max:20',
            'home_number' => 'nullable|string|max:20',
            'email_address' => 'nullable|email|max:255',
            'membership_type' => 'required|in:Leo Club,Lions Club',
        ]);
    
        $dob = $request->dob ? date('Y-m-d', strtotime($request->dob)) : null;
        $anniversary_date = $request->anniversary_date ? date('Y-m-d', strtotime($request->anniversary_date)) : null;
    
        $imagePath = $request->hasFile('profile_photo') 
            ? $request->file('profile_photo')->store('members', 'public') 
            : null;
    
        Member::create([
            'parent_multiple_district' => $request->parent_multiple_district,
            'parent_district' => $request->parent_district,
            'account_name' => $request->account_name,
            'member_id' => $request->member_id,
            'salutation' => $request->salutation,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'suffix' => $request->suffix,
            'spouse_name' => $request->spouse_name,
            'dob' => $dob,
            'anniversary_date' => $anniversary_date,
            'mailing_address_line_1' => $request->mailing_address_line_1,
            'mailing_address_line_2' => $request->mailing_address_line_2,
            'mailing_address_line_3' => $request->mailing_address_line_3,
            'mailing_city' => $request->mailing_city,
            'mailing_state' => $request->mailing_state,
            'mailing_country' => $request->mailing_country,
            'mailing_zip' => $request->mailing_zip,
            'preferred_email' => $request->preferred_email,
            'email_address' => $request->email_address,
            'work_email' => $request->work_email,
            'alternate_email' => $request->alternate_email,
            'preferred_phone' => $request->preferred_phone,
            'phone_number' => $request->phone_number,
            'work_number' => $request->work_number,
            'home_number' => $request->home_number,
            'fax' => $request->fax,
            'membership_full_type' => $request->membership_full_type,
            'membership_type' => $request->membership_type,
            'profile_photo' => $imagePath,
            'password' => Hash::make('1234'), // Storing default password securely
        ]);
    
        return redirect()->route('members.add')->with('success', 'Member added successfully!');
    }



    public function edit($id)
    {
        $member = Member::findOrFail($id);
        $parentMultipleDistricts = ParentsMultipleDistrict::all();
        $chapters = Chapter::all();
        $membershipTypes = MembershipType::all();
        $districts = District::all(); // Fetch all districts
    
        return view('admin.addmembers.edit', compact('member', 'parentMultipleDistricts', 'chapters', 'membershipTypes', 'districts'));
    }
    
    
    public function update(Request $request, $id)
    {


  
        $member = Member::findOrFail($id);
    
        // Validation
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'member_id' => 'required|unique:add_members,member_id,' . $id,
            'dob' => 'nullable|date_format:Y-m-d',
            'anniversary_date' => 'nullable|date_format:Y-m-d',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'phone_number' => 'nullable|string|max:20',
            'work_number' => 'nullable|string|max:20',
            'home_number' => 'nullable|string|max:20',
            'email_address' => 'nullable|email|max:255',
            'mailing_address_line_1' => 'nullable|string|max:255',
            'mailing_address_line_2' => 'nullable|string|max:255',
            'mailing_address_line_3' => 'nullable|string|max:255',
            'mailing_city' => 'nullable|string|max:255',
            'mailing_state' => 'nullable|string|max:255',
            'mailing_country' => 'nullable|string|max:255',
            'mailing_zip' => 'nullable|string|max:10',
            'preferred_email' => 'nullable|string|max:20',
            'preferred_phone' => 'nullable|string|max:20',
            'fax' => 'nullable|string|max:20',
            'membership_full_type' => 'nullable|string|max:255',
            'membership_type' => 'nullable|string|max:255',
            
            'parent_multiple_district' => 'required',
            'parent_district' => 'required',
            'account_name' => 'required',
        ]);
    
   
    
        // Handle file upload
        if ($request->hasFile('profile_photo')) {
            $imagePath = $request->file('profile_photo')->store('profile_photos', 'public');
            $member->profile_photo = $imagePath;
        }
    
        // Update the member fields
        $member->fill($request->except(['profile_photo']));
    
        // Save the changes
        $member->save();
    
        return redirect()->route('members.list')->with('success', 'Member updated successfully!');
    }
    
    
    
    
// Delete Member
public function destroy($id)
{
    $member = Member::findOrFail($id);
    $member->delete();

    return redirect()->route('members.list')->with('success', 'Member deleted successfully!');
}

    


    public function view($id)
{
    $member = Member::findOrFail($id);

    return response()->json(view('addmembers.partials.details', compact('member'))->render());
}

public function getMemberDetails($id)
{
    $member = Member::with(['membershipType', 'parentMultipleDistrict', 'parentDistrict', 'account'])->find($id);


    if (!$member) {
        return response()->json(['error' => 'Member not found'], 404);
    }

    return response()->json(['member' => $member]);
}





public function showImportForm()
{
    return view('members.import');
}

public function import(Request $request)
{
    Log::info('🔁 Import request received.');

    $request->validate([
        'import_file' => 'required|file|mimes:csv,txt,xlsx'
    ]);

    try {
        // REMOVE toCollection line — it corrupts the file
        Excel::import(new MembersImport, $request->file('import_file'));

        return redirect()->back()->with('success', 'Members imported successfully.');
    } catch (\Throwable $e) {
        Log::error('❌ Excel import failed: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Import failed. Check logs.');
    }
}

    
}



