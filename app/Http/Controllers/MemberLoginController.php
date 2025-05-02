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
use App\Models\Product;
use App\Models\Company;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\Service; // Import the Service model



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

        // Fetch additional information as you have in your original code
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
        $clients = Client::where('member_id', $member->id)->get();
        $company = DB::table('company')->where('member_id', $member->id)->first();

        // Fetch member's products
        $products = DB::table('products')
            ->where('member_id', $member->id)  // Assuming there's a 'member_id' column in the products table
            ->select('id', 'product_name', 'product_image', 'created_at', 'updated_at')
            ->get();

            $services = DB::table('services')->where('member_id', $member->id)->get();

        // Return the view with all the data
        return view('member.profileedit', compact(
            'member',
            'parentMultipleDistrict',
            'parentDistrict',
            'accountName',
            'membershipFullType',
            'testimonials',
            'projects',
            'clients',
            'services',
            'products',
            'company' // Pass the products data to the view
        ));
    }



    public function update(Request $request)
    {
        // dd($request);
        // Log the entire request for debugging
        Log::info('📝 Update Request Data:', $request->all());

        // Validate the request data
        $request->validate([
            'salutation' => 'nullable|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'suffix' => 'nullable|string',
            'spouse_name' => 'nullable|string',
            'dob' => 'nullable|date',
            'anniversary_date' => 'nullable|date',
            'membership_full_type' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'password' => 'nullable|string|min:6',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

            // Address
            'mailing_address_line_1' => 'nullable|string',
            'mailing_address_line_2' => 'nullable|string',
            'mailing_address_line_3' => 'nullable|string',
            'mailing_city' => 'nullable|string',
            'mailing_state' => 'nullable|string',
            'mailing_country' => 'nullable|string',
            'mailing_zip' => 'nullable|string',

            // Contact
            'preferred_email'       => 'nullable|string',
            'email_address'         => 'nullable|email',
            'work_email'            => 'nullable|email',
            'alternate_email'       => 'nullable|email',
            'preferred_phone'       => 'nullable|string',
            'phone_number'          => 'nullable|string',
            'work_number'           => 'nullable|string',
            'home_number'           => 'nullable|string',
            'fax'                   => 'nullable|string',
        ]);

        // Get the authenticated member
        $member = Auth::guard('member')->user();

        // Log if member is authenticated
        Log::info('Authenticated Member:', [$member]);

        // Check if member is found
        if (!$member) {
            Log::error("❌ Authenticated member not found.");
            return redirect()->back()->with('error', 'Member not found or not logged in.');
        }

        // Prepare input data excluding certain fields
        $input = $request->except(['_token', 'profile_photo', 'created_at', 'updated_at']);

        // Update password if provided
        if (!empty($input['password'])) {
            $input['password'] = bcrypt($input['password']);
        } else {
            unset($input['password']); // Don't overwrite if empty
        }

        // Handle profile photo if uploaded
        if ($request->hasFile('profile_photo')) {
            Log::info('📸 Profile Photo Uploaded');

            // Check if directory exists, if not create it
            if (!Storage::exists('public/profile_photos')) {
                Storage::makeDirectory('public/profile_photos');
            }

            // Delete old profile photo if it exists
            if ($member->profile_photo) {
                Storage::delete('public/' . $member->profile_photo);
            }

            // Store the new photo and update the input array
            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $input['profile_photo'] = $path;
        }

        // Begin database transaction to ensure atomic updates
        DB::beginTransaction();
        try {
            // Update the member record
            $member->update($input);

            // Commit the transaction
            DB::commit();

            // Log success
            Log::info('✅ Member record updated successfully', $input);

            // Return success response
            return redirect()->route('member.edit')->with('success', 'Your profile has been updated successfully.');
        } catch (\Exception $e) {
            // Rollback the transaction in case of error
            DB::rollBack();

            // Log the error
            Log::error('❌ Error updating member:', [$e->getMessage()]);

            // Return error response
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
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
                    $testimonial->testimonial_content = $request->testimonial[$index]; // ✅ fixed here
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
                    'testimonial_content' => $request->testimonial[$index], // ✅ fixed here
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
        if (isset($request->file('project_image')[$index])) {
            $image = $request->file('project_image')[$index]->store('project_images', 'public');

            Project::create([
                'member_id'     => $member->id,
                'project_name'  => $name,
                'project_image' => $image,
                'location'      => $request->location[$index],
                'client_name'   => $request->client_name[$index],
                'company_name'  => $request->company_name[$index],
            ]);
        }
    }

    return back()->with('success', 'Project(s) added successfully.');
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


public function productTab()
{
    $member = Auth::guard('member')->user();

    // Safety check
    if (!$member) {
        return redirect()->route('member.login')->with('error', 'Please log in to view your products.');
    }

    // ✅ Fetch products belonging to logged-in member
    $products = Product::where('member_id', $member->id)->get();

    return view('member.partial.products', compact('products')); // <-- this is critical
}

public function storeProduct(Request $request)
{
    $member = Auth::guard('member')->user();

    foreach ($request->product_name as $index => $name) {
        // Skip existing products by ignoring product_id
        $productImage = $request->file('product_image')[$index] ?? null;

        $imageName = null;
        if ($productImage) {
            $imageName = time() . '_' . $index . '.' . $productImage->getClientOriginalExtension();
            $productImage->storeAs('product_images', $imageName, 'public');
        }

        // Always create new product
        Product::create([
            'member_id' => $member->id,
            'product_name' => $name,
            'product_image' => $imageName ? 'product_images/' . $imageName : null,
        ]);
    }

    return redirect()->back()->with('success', 'New products saved successfully.');
}

public function editProfile()
{
    $member = Auth::guard('member')->user();
    $products = Product::where('member_id', $member->id)->get();

    return view('member.profileedit', compact('products'));
}



public function deleteProduct($id)
{
    $member = Auth::guard('member')->user();

    Product::where('id', $id)->where('member_id', $member->id)->delete();

    return back()->with('success', 'Product deleted.');
}

public function updateProduct(Request $request, $id)
{
    $member = Auth::guard('member')->user();

    $product = Product::where('id', $id)->where('member_id', $member->id)->firstOrFail();

    $product->product_name = $request->product_name;

    if ($request->hasFile('product_image')) {
        // Delete old image if exists
        if ($product->product_image && Storage::exists('public/' . $product->product_image)) {
            Storage::delete('public/' . $product->product_image);
        }

        // Upload new image
        $image = $request->file('product_image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->storeAs('product_images', $imageName, 'public');

        $product->product_image = 'product_images/' . $imageName;

    }

    $product->save();

    return back()->with('success', 'Product updated successfully.');
}


public function store(Request $request)
{
    $request->validate([
        'service_name' => 'required|array',
        'service_name.*' => 'required|string|max:255',
        'image' => 'nullable|array',
        'image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $member = Auth::guard('member')->user();

    foreach ($request->service_name as $index => $name) {
        $service = new Service();
        $service->member_id = $member->id;
        $service->service_name = $name;

        if ($request->hasFile("image.$index")) {
            $service->image = $request->file("image.$index")->store('services', 'public');
        }

        $service->save();
    }

    return back()->with('success', 'Services added successfully.');
}

public function updateservice(Request $request, $id)
{
    $request->validate([
        'service_name' => 'required|string|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $service = Service::findOrFail($id);
    $service->service_name = $request->service_name;

    if ($request->hasFile('image')) {
        if ($service->image_path) {
            Storage::delete('public/' . $service->image_path);
        }
        $service->image  = $request->file('image')->store('services', 'public');
    }

    $service->save();

    return back()->with('success', 'Service updated successfully.');
}

public function delete($id)
{
    $service = Service::findOrFail($id);

    // Delete image if it exists
    if ($service->image_path) {
        Storage::delete('public/' . $service->image_path);
    }

    $service->delete();

    return back()->with('success', 'Service deleted successfully.');
}





}
