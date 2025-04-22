<?php

namespace App\Http\Controllers;

use App\Models\PendingMemberUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\AddMember; // Ensure you have this model
use App\Models\Member;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


class MemberLoginController extends Controller
{
    public function membershowLoginForm()
    {
        return view('member.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'member_id' => 'required',
            'password' => 'required',
        ]);

        Log::info('Login attempt with member_id: ' . $request->member_id);

        $member = Member::where('member_id', $request->member_id)->first();

        if (!$member || !Hash::check($request->password, $member->password)) {
            Log::warning('Login failed for member_id: ' . $request->member_id);
            return back()->with('error', 'Invalid login credentials.');
        }

        Auth::guard('member')->login($member);
        $request->session()->regenerate();

        Log::info('Login successful for member_id: ' . $member->member_id);

        return redirect()->route('member.dashboard');
    }


    public function logout()
    {
        session()->forget('member_id');
        return redirect()->route('member.login');
    }


    public function edit()
    {
        // ✅ Get authenticated member using the 'member' guard
        $member = Auth::guard('member')->user();

        // ❌ Redirect if not logged in
        if (!$member) {
            Log::error('❌ Member not found in edit() - Not authenticated.');
            return redirect()->route('member.login')->with('error', 'Please log in again.');
        }

        // ✅ Get related data from other tables
        $parentMultipleDistrict = DB::table('parents_multiple_district')
            ->where('id', $member->parent_multiple_district)
            ->value('name');

        $parentDistrict = DB::table('district')
            ->where('id', $member->parent_district)
            ->value('name');

        $accountName = DB::table('chapters')
            ->where('id', $member->account_name)
            ->value('chapter_name');

        $membershipFullType = DB::table('membership_type')
            ->where('id', $member->membership_full_type)
            ->value('name');

        return view('member.profileedit', compact(
            'member',
            'parentMultipleDistrict',
            'parentDistrict',
            'accountName',
            'membershipFullType'
        ));
    }





    public function update(Request $request)
    {
        Log::info('Update Request Data:', $request->all());

        $request->validate([
            'salutation' => 'nullable|string',
            'first_name' => 'sometimes|required|string',
            'last_name' => 'sometimes|required|string',
            'suffix' => 'nullable|string',
            'spouse_name' => 'nullable|string',
            'dob' => 'nullable|date',
            'anniversary_date' => 'nullable|date',
            'membership_type' => 'nullable|string',
            'profile_photo' => 'nullable|image|max:2048',

            // ✅ Mailing address fields
            'mailing_address_line_1' => 'nullable|string',
            'mailing_address_line_2' => 'nullable|string',
            'mailing_address_line_3' => 'nullable|string',
            'mailing_city'          => 'nullable|string',
            'mailing_state'         => 'nullable|string',
            'mailing_country'       => 'nullable|string',
            'mailing_zip'           => 'nullable|string',

            // ✅ Contact and email fields
            'preferred_email'       => 'nullable|string',
            'email_address'         => 'nullable|email',
            'work_email'            => 'nullable|email',
            'alternate_email'       => 'nullable|email',
            'preferred_phone'       => 'nullable|string',
            'phone_number'          => 'nullable|string', // Mobile Number
            'work_number'           => 'nullable|string',
            'home_number'           => 'nullable|string',
            'fax'                   => 'nullable|string',
        ]);

        $member = Auth::guard('member')->user();

        if (!$member) {
            Log::error("❌ Authenticated member not found.");
            return redirect()->back()->with('error', 'Member not found or not logged in.');
        }

        $original = $member->toArray();
        $input = $request->except(['member_id', 'profile_photo', '_token']);
        $changes = [];

        // Compare changes (excluding profile photo)
        foreach ($input as $key => $newValue) {
            if (!is_null($newValue) && $newValue !== '' && ($original[$key] ?? null) != $newValue) {
                $changes[$key] = $newValue;
            }
        }

        // ✅ Handle Profile Photo - save directly to members table
        if ($request->hasFile('profile_photo')) {
            Log::info('📸 Profile Photo Uploaded');

            if (!Storage::exists('public/profile_photos')) {
                Storage::makeDirectory('public/profile_photos');
            }

            if ($member->profile_photo) {
                Storage::delete('public/' . $member->profile_photo);
            }

            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $member->profile_photo = $path; // Save directly to DB
            $member->save();
        }

        // Handle changes that require approval
        if (!empty($changes)) {
            Log::info('🔄 Saving to PendingMemberUpdate:', $changes);

            PendingMemberUpdate::updateOrCreate(
                ['member_id' => $member->id, 'status' => 'pending'],
                ['data' => json_encode($changes)]
            );
        }

        return redirect()->route('member.edit')->with('success', 'Your profile update has been submitted for approval.');
    }






}
