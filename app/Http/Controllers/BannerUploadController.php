<?php

namespace App\Http\Controllers;

use App\Models\AdImage1;
use App\Models\AdImage2;
use App\Models\BottomBanner;
use App\Models\Generalbanner;
use App\Models\MemberDetail;
use App\Models\Popup;
use Illuminate\Http\Request;
use App\Models\Banner10000;
use App\Models\Banner5000;
use App\Models\Banner1000;
use App\Models\Image1;
use App\Models\Image2;
use App\Models\Image3;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BannerUploadController extends Controller
{
   

    public function index()
    {
        $banner10000 = Banner10000::orderBy("created_at", "desc")->get();
        $banner5000 = Banner5000::orderBy("created_at", "desc")->get();
        $banner1000 = Banner1000::orderBy("created_at", "desc")->get();
    
        $banners = BottomBanner::all();
        $adimage = AdImage1::all();
        $adimage2 = AdImage2::all();
        $image1 = Image1::all();
        $image2 = Image2::all();
        $image3 = Image3::all();
        $members = MemberDetail::all();
        $popup = Popup::all();
    
        // Fetch general banner name (debug to confirm)
        $bannerNames = DB::table('generalbanner')->first();
       // dd($bannerNames); // Uncomment this to debug the object structure
    
        return view('admin.upload_banners', compact(
            'banner10000', 'banner5000', 'banner1000', 'banners', 'adimage',
            'adimage2', 'image1', 'image2', 'image3', 'members', 'popup', 'bannerNames'
        ));
    }
    


 public function bannerupdate(Request $request)
{
    $request->validate([
        'banner_value' => 'required|string|max:255',
        'banner_type' => 'required|in:10000,5000,1000',
    ]);

    $banner = Generalbanner::first(); // Assuming only one row

    if ($banner) {
        $banner->update([
            $request->banner_type => $request->banner_value,
        ]);
    } else {
        Generalbanner::create([
            $request->banner_type => $request->banner_value,
        ]);
    }

    return back()->with('success', 'Banner updated successfully!');
}


    // Function to handle the file upload
    public function store(Request $request)
{

    $request->validate([
        'banner_type' => 'required|in:10000,5000,1000',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'url' => 'nullable|string|max:150',
    ]);

    // Determine storage folder based on banner type
    $folders = [
        '10000' => 'banners_10000',
        '5000'  => 'banners_5000',
        '1000'  => 'banners_1000',
    ];

    $folder = $folders[$request->banner_type] ?? null;

    if (!$folder) {
        return back()->with('error', 'Invalid banner type.');
    }

    // Store the file
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store($folder, 'public');

        // Store in respective table
        $models = [
            '10000' => Banner10000::class,
            '5000'  => Banner5000::class,
            '1000'  => Banner1000::class,
        ];

        $models[$request->banner_type]::create([
            'image_path' => $imagePath,
            'url' => $request->url ?? null, // Ensures 'url' is handled properly if null
        ]);

        return back()->with('success', 'Banner uploaded successfully!');
    }

    return back()->with('error', 'Failed to upload banner. Please try again.');
}

public function uploadAd(Request $request)
{
    $request->validate([
        'ad_type' => 'required',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'website_link' => 'required|url'
    ]);

    // Determine storage folder based on ad type
    $folder = match ($request->ad_type) {
        'ad1' => 'ads/ad1',
        'ad2' => 'ads/ad2',
        default => null,
    };


    if (!$folder) {
        return back()->with('error', 'Invalid ad type');
    }

    // Store the file in the respective folder
    $imagePath = $request->file('image')->store($folder, 'public');

    // Store in the respective table
    match ($request->ad_type) {
        'ad1' => AdImage1::create(['image_path' => $imagePath, 'website_link' => $request->website_link]),
        'ad2' => AdImage2::create(['image_path' => $imagePath, 'website_link' => $request->website_link]),
    };

    return back()->with('success', 'Ad image uploaded successfully!')->with('activeTab', 'tab2');
}

public function deleteAdImage($id, $ad_type)
{
    // Determine the model based on the ad type
    $model = match ($ad_type) {

        'ad1' => AdImage1::class,
        'ad2' => AdImage2::class,
        default => null,
    };


    if (!$model) {
        return back()->with('error', 'Invalid ad type.');
    }

    // Find the image record
    $adImage = $model::find($id);

    if (!$adImage) {
        return back()->with('error', 'Ad image not found.');
    }

    // Delete the image file from storage
    $imagePath = storage_path('storage/app/public/' . $adImage->image_path);
    if (file_exists($imagePath)) {
        unlink($imagePath);
    }

    // Delete the image record from the database
    $adImage->delete();

    return back()->with('sweetalert');
}

public function storeImage1(Request $request)
{
    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'website_link' => 'required|url'
    ]);

    $imagePath = $request->file('image')->store('images/image1', 'public');

    Image1::create([
        'image_path' => $imagePath,
        'website_link' => $request->website_link
    ]);

    return redirect()->back()->with('success', 'Image 1 uploaded successfully!')->with('activeTab', 'tab3');
}

public function deleteImage1($id)
{
    // Find the image record
    $image = Image1::find($id);

    if (!$image) {
        return back()->with('error', 'Image not found.');
    }

    // Delete the image file from storage
    $imagePath = public_path('storage/app/public/' . $image->image_path);

    if (file_exists($imagePath)) {
        unlink($imagePath);
    }

    // Delete the record from the database
    $image->delete();

    return back()->with('sweetalert', 'Image deleted successfully!');
}

public function deleteImage2($id)
{
    // Find the image record
    $image = Image2::find($id);

    if (!$image) {
        return back()->with('error', 'Image not found.');
    }

    // Delete the image file from storage
    $imagePath = public_path('storage/app/public/' . $image->image_path);

    if (file_exists($imagePath)) {
        unlink($imagePath);
    }

    // Delete the record from the database
    $image->delete();

    return back()->with('sweetalert', 'Image deleted successfully!');
}
public function deleteImage3($id)
{
    // Find the image record
    $image = Image3::find($id);

    if (!$image) {
        return back()->with('error', 'Image not found.');
    }

    // Delete the image file from storage
    $imagePath = public_path('storage/app/public/' . $image->image_path);

    if (file_exists($imagePath)) {
        unlink($imagePath);
    }

    // Delete the record from the database
    $image->delete();

    // ✅ Return with SweetAlert success message
    return back()->with('sweetalert', 'Image deleted successfully!');
}





public function storeImage2(Request $request)
{
    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'website_link' => 'required|url'
    ]);

    // Debugging
    // dd($request->all());

    $imagePath = $request->file('image')->store('images/image2', 'public');

    Image2::create([
        'image_path' => $imagePath,
        'website_link' => $request->website_link
    ]);

    return redirect()->back()->with('success', 'Image 2 uploaded successfully!')->with('activeTab', 'tab3');
}


public function storeImage3(Request $request)
{
    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'website_link' => 'required|url'
    ]);

    $imagePath = $request->file('image')->store('images/image3', 'public');

    Image3::create([
        'image_path' => $imagePath,
        'website_link' => $request->website_link
    ]);

    return redirect()->back()->with('success', 'Image 3 uploaded successfully!')->with('activeTab', 'tab3');
}


public function getBannerImages()
{
    // Fetch all images from `banner_10000` table
    $banner10000 = Banner10000::pluck('image_path')->toArray();

    // Fetch all images from `banner_5000` table, ensuring at least an empty array is returned
    $banner5000 = Banner5000::pluck('image_path')->toArray();

    // Chunk `banner5000` into pairs of 2 images per slide
    $banner5000 = array_chunk($banner5000, 2);


    return view('includes.banner', compact('banner10000', 'banner5000'));
}



//banner 10000 function

// Fetch banner data for editing
public function edit(Request $request, $id)
{
    $title = $request->query('title');
    $banner = null;

    if ($title == '10000') {
        $banner = Banner10000::findOrFail($id);
    } elseif ($title == '5000') {
        $banner = Banner5000::findOrFail($id);
    } elseif ($title == '1000') {
        $banner = Banner1000::findOrFail($id);
    }

    // If no valid title is found, return an error response
    if (!$banner) {
        return response()->json(['error' => 'Invalid title provided'], 400);
    }

    return response()->json($banner);
}


// Update banner details
public function update(Request $request, $id)
{
    $request->validate([
        'url' => 'max:150',
        'image_path' => 'image|mimes:jpeg,png,jpg,gif', // Corrected field name
        'title' => 'required|in:10000,5000,1000',
    ]);

    // Define banner types and their models/folders
    $banners = [
        '10000' => ['model' => Banner10000::class, 'folder' => 'banners_10000'],
        '5000'  => ['model' => Banner5000::class, 'folder' => 'banners_5000'],
        '1000'  => ['model' => Banner1000::class, 'folder' => 'banners_1000'],
    ];

    $title = $request->title;

    // Check if the provided title is valid
    if (!isset($banners[$title])) {
        return redirect()->back()->with('error', 'Invalid banner type.');
    }

    $model = $banners[$title]['model'];
    $storageFolder = $banners[$title]['folder'];

    $banner = $model::find($id);

    if (!$banner) {
        return redirect()->back()->with('error', 'Banner not found.');
    }

    // If a new image is uploaded
    if ($request->hasFile('image_path')) {
        // Delete the old image if it exists
        $oldImagePath = $banner->image_path;

        if (!empty($oldImagePath) && Storage::disk('public')->exists($oldImagePath)) {
            Storage::disk('public')->delete($oldImagePath);
        }

        // Upload new image and get the stored path
        $imagePath = $request->file('image_path')->store($storageFolder, 'public');

        // Update the banner image path
        $banner->image_path = $imagePath;
    }

    // Update URL field
    $banner->url = $request->url;
    $banner->save();

    return redirect()->back()->with('success', 'Banner updated successfully!');
}





// Delete banner
public function destroy(Request $request, $id)
{
    $title = $request->input('title'); // Get title from request

    // Determine the correct model based on the title
    $banner = null;
    if ($title == '10000') {
        $banner = Banner10000::find($id);
    } elseif ($title == '5000') {
        $banner = Banner5000::find($id);
    } elseif ($title == '1000') {
        $banner = Banner1000::find($id);
    }

    // If banner is not found, return an error response
    if (!$banner) {
        return response()->json(['error' => 'Banner not found'], 404);
    }

    // Store the banner title before deleting it
    $bannerTitle = $title;

    // Delete the banner image from storage if it exists
    $imagePath = storage_path('app/public/' . $banner->image_path);

    if (!empty($banner->image_path) && file_exists($imagePath)) {

        unlink($imagePath);
    }

    // Delete the banner record from the database
    $banner->delete();

    return response()->json(['success' => "Banner '{$bannerTitle}' deleted successfully"]);
}


public function uploadBottomBanner(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'website_link' => 'required|string',
        ]);

        // Store image in storage/app/public/bottombanners
        $imagePath = $request->file('image')->store('bottombanners', 'public');

        // Save in the database
        $banner = BottomBanner::create([
            'image' => $imagePath,  // Store full storage path
            'website_link' => $request->website_link
        ]);

        if ($banner) {
            return back()->with('success', 'Bottom Banner uploaded successfully!');
        } else {
            return back()->with('error', 'Failed to upload banner.');
        }
    }

    public function storeBottomBanner(Request $request)
{
    Log::info('Received Request:', $request->all()); // Debugging

    // Validate input
    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048|dimensions:width=1353,height=180',
        'website_link' => 'required|string',
    ]);

    // Store image in storage/app/public/bottombanners
    $imagePath = $request->file('image')->store('bottombanners', 'public');

    // Save to the database
    $banner = BottomBanner::create([
        'image' => $imagePath,
        'website_link' => $request->website_link
    ]);

    if ($banner) {
        Log::info('Banner Stored:', $banner->toArray());
        return back()->with('success', 'Bottom Banner uploaded successfully!');
    } else {
        Log::error('Database Insert Failed');
        return back()->with('error', 'Failed to upload banner.');
    }
}



public function showBottomBanners()
{
    $banners = BottomBanner::all(); // Fetch banners
    return view('admin.upload_banners', compact('banners')); // Correct path
}



public function deleteBottomBanner($id)
{
    $banner = BottomBanner::findOrFail($id);

    // Delete image file from storage
    Storage::disk('public')->delete($banner->image);

    // Delete database record
    $banner->delete();

    return back()->with('sweetalert', 'Banner deleted successfully!');

}






public function showMembers()
{
    $members = MemberDetail::all();
    return view('admin.member', compact('members'));
}

public function addMember(Request $request)
{
    // Check if a member already exists
    if (MemberDetail::count() > 0) {
        return redirect()->back()->with('error', 'You must delete the first data before uploading a new one.');
    }

    $request->validate([
        'name' => 'required|string|max:255',
        'role' => 'required|string|max:255',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    // Upload Image
    $imagePath = $request->file('image')->store('member', 'public');

    // Save to Database
    $member = new MemberDetail();
    $member->name = $request->name;
    $member->role = $request->role;
    $member->image = $imagePath;
    $member->save();

    return redirect()->back()->with('success', 'Member added successfully!');
}


public function deleteMember($id) // Delete member
{
    $member = MemberDetail::findOrFail($id);
    Storage::disk('public')->delete($member->image);
    $member->delete();

    return redirect()->back()->with('sweetalert', 'Member deleted successfully!');

}







    }


