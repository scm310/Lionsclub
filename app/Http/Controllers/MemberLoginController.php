<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\PendingMemberUpdate;
use App\Models\Project;
use App\Models\Testimonial;
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
        $images = DB::table('pin_images')->select('image_path')->get();

        return view('member.login',compact('images'));
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
        $member = Auth::guard('member')->user();
    
        if (!$member) {
            Log::error('❌ Member not found in edit() - Not authenticated.');
            return redirect()->route('member.login')->with('error', 'Please log in again.');
        }
    
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
    
        // Fetch member's testimonials
        $testimonials = Testimonial::where('member_id', $member->id)->get();
    
        // Fetch member's projects
        $projects = Project::where('member_id', $member->id)->get();
    
        // Fetch member's clients
        $clients = Client::where('member_id', $member->id)->get(); // Assuming you have a Client model that stores the clients
    
        return view('member.profileedit', compact(
            'member',
            'parentMultipleDistrict',
            'parentDistrict',
            'accountName',
            'membershipFullType',
            'testimonials',
            'projects',
            'clients' // Pass the clients data to the view
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


    
    public function storeTestimonials(Request $request)
    {
        $member = Auth::guard('member')->user();
    
        foreach ($request->client_name as $index => $name) {
            $testimonialId = $request->testimonial_id[$index];
            $imagePath = null;
    
            // Handle image upload if a new image is uploaded
            if ($request->hasFile("image.$index")) {
                $imagePath = $request->file("image.$index")->store('testimonials', 'public');
            }
    
            if ($testimonialId) {
                // Update existing testimonial
                $testimonial = Testimonial::find($testimonialId);
                if ($testimonial) {
                    $testimonial->client_name = $name;
                    $testimonial->company_name = $request->company_name[$index];
                    $testimonial->designation = $request->designation[$index];
                    $testimonial->testimonial = $request->testimonial[$index];
                    if ($imagePath) {
                        $testimonial->image = $imagePath;
                    }
                    $testimonial->save();
                }
            } else {
                // Create new testimonial
                Testimonial::create([
                    'member_id' => $member->id,
                    'client_name' => $name,
                    'company_name' => $request->company_name[$index],
                    'designation' => $request->designation[$index],
                    'testimonial' => $request->testimonial[$index],
                    'image' => $imagePath,
                ]);
            }
        }
    
        return redirect()->back()->with('success', 'Testimonials saved successfully!');
    }

    public function destroy($id)
    {
        $testimonial = Testimonial::findOrFail($id);
    
        // Optionally delete the image
        if ($testimonial->image && \Storage::exists('public/' . $testimonial->image)) {
            \Storage::delete('public/' . $testimonial->image);
        }
    
        $testimonial->delete();
    
        return redirect()->back()->with('success', 'Testimonial deleted successfully.');
    }




    public function storeTestimonial(Request $request)
    {
        $member = Auth::guard('member')->user();

        foreach ($request->client_name as $index => $name) {
            $imageName = null;
        
            if ($request->hasFile('image') && isset($request->file('image')[$index])) {
                $image = $request->file('image')[$index];
                $imageName = time() . $index . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/testimonial_images', $imageName);
            }
        
            Testimonial::create([
                'member_id' => $member->id,
                'client_name' => $name,
                'company_name' => $request->company_name[$index],
                'image' => $imageName ? 'testimonial_images/' . $imageName : null,
                'designation' => $request->designation[$index],
                'testimonial_content' => $request->testimonial_content[$index],
            ]);
        }
        

        return back()->with('success', 'Testimonial(s) added successfully.');
    }

    public function updateTestimonial(Request $request, $id)
    {
        $testimonial = Testimonial::findOrFail($id);

        if ($request->hasFile('image')) {
            Storage::delete('public/' . $testimonial->image);
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/testimonial_images', $imageName);
            $testimonial->image = 'testimonial_images/' . $imageName;
        }

        $testimonial->update([
            'client_name' => $request->client_name,
            'company_name' => $request->company_name,
            'designation' => $request->designation,
            'testimonial_content' => $request->testimonial_content,
        ]);

        return back()->with('success', 'Testimonial updated successfully.');
    }

    public function deleteTestimonial($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        Storage::delete('public/' . $testimonial->image);
        $testimonial->delete();

        return back()->with('success', 'Testimonial deleted successfully.');
    }
    

    public function projectTab()
{
    $member = Auth::guard('member')->user();
    $projects = Project::where('user_id', $member->id)->get();
    return view('member.partial.project', compact('projects'));
}

public function storeProject(Request $request)
{
    $member = Auth::guard('member')->user();

    foreach ($request->project_name as $index => $name) {
        $projectImage = $request->file('project_image')[$index];
        
        // Generate a unique file name using time() and index to avoid conflicts
        $imageName = time() . $index . '.' . $projectImage->getClientOriginalExtension();

        // Store the file in the correct folder with the generated file name
        $projectImage->storeAs('public/project_images', $imageName);
    
        // Create a new project entry with the correct image path
        Project::create([
            'member_id'     => $member->id,
            'project_name'  => $name,
            'project_image' => 'project_images/' . $imageName, // Ensure the path is consistent
            'location'      => $request->location[$index],
            'client_name'   => $request->client_name[$index],
            'company_name'  => $request->company_name[$index],
        ]);
    }
    
    return back()->with('success', 'Project added successfully.');
}



public function updateProject(Request $request, $id)
{
    $member = Auth::guard('member')->user();

    $project = Project::where('id', $id)->where('member_id', $member->id)->firstOrFail();

    $project->project_name = $request->project_name;
    $project->location = $request->location;
    $project->client_name = $request->client_name;
    $project->company_name = $request->company_name;

    if ($request->hasFile('project_image')) {
        $image = $request->file('project_image')->store('project_images', 'public');
        $project->project_image = $image;
    }

    $project->save();

    return back()->with('success', 'Project updated successfully.');
}

public function deleteProject($id)
{
    $member = Auth::guard('member')->user();

    Project::where('id', $id)->where('member_id', $member->id)->delete();

    return back()->with('success', 'Project deleted.');
}
    

public function storeClient(Request $request)
{
    $member = Auth::guard('member')->user();

    foreach ($request->client_name as $index => $name) {
        Client::create([
            'member_id' => $member->id,
            'client_name' => $name,
            'company_name' => $request->company_name[$index],
            'comapny_fullform' => $request->comapny_fullform[$index],
            'designation' => $request->designation[$index],
        ]);
    }

    return back()->with('success', 'Clients added successfully.');
}

public function updateClient(Request $request, $id)
{
    $client = Client::findOrFail($id);
    $client->update($request->only('client_name', 'company_name', 'comapny_fullform', 'designation'));

    return back()->with('success', 'Client updated successfully.');
}

public function deleteClient($id)
{
    Client::findOrFail($id)->delete();
    return back()->with('success', 'Client deleted successfully.');
}





}
