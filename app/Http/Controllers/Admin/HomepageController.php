<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PinImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\FooterSetting;
use App\Models\ContactSetting;


class HomepageController extends Controller
{
    // Display the page and images
    public function index()
    {
        $images = PinImage::orderBy('created_at', 'desc')->get();
        return view('admin.homepagesettings.pinimage', compact('images'));
    }

    public function pinimagestore(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);
    
        // Check if there's already an image and delete it
        $existingImage = PinImage::first();
    
        if ($existingImage) {
            // Delete image file
            if (Storage::disk('public')->exists($existingImage->image_path)) {
                Storage::disk('public')->delete($existingImage->image_path);
            }
    
            // Delete DB record
            $existingImage->delete();
        }
    
        // Store new image
        $imagePath = $request->file('image')->store('pin_images', 'public');
    
        PinImage::create([
            'image_path' => $imagePath,
        ]);
    
        return redirect()->route('admin.homepage.pinimage')->with('success', 'Image updated successfully.');
    }


public function pinimagedestroy($id)
{
    $image = PinImage::findOrFail($id);

    // Delete image file from storage
    if (Storage::disk('public')->exists($image->image_path)) {
        Storage::disk('public')->delete($image->image_path);
    }

    // Delete database record
    $image->delete();

    return redirect()->back()->with('success', 'Image deleted successfully.');
}


public function footerSettings()
    {
        $footers = FooterSetting::orderBy('created_at', 'desc')->get();
        return view('admin.homepagesettings.footersettings', compact('footers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'copyright' => 'required|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
        ]);

        $footer = FooterSetting::first();

        if ($footer) {
            $footer->update([
                'copyright_text' => $request->copyright,
                'facebook_link' => $request->facebook,
                'twitter_link' => $request->twitter,
                'instagram_link' => $request->instagram,
            ]);
        } else {
            FooterSetting::create([
                'copyright_text' => $request->copyright,
                'facebook_link' => $request->facebook,
                'twitter_link' => $request->twitter,
                'instagram_link' => $request->instagram,
            ]);
        }

        return redirect()->back()->with('success', 'Footer settings updated successfully!');
    }


    public function destroy($id)
    {
        $footer = FooterSetting::findOrFail($id);  // Find footer by ID
        $footer->delete();  // Delete the footer item
    
        return redirect()->back()->with('success', 'Footer deleted successfully!');
    }


    public function contactSettings()
    {
        $contacts = ContactSetting::all();
        return view('admin.homepagesettings.contactsettings', compact('contacts'));
    }
    

public function storeContactSettings(Request $request)
{
    $request->validate([
        'address' => 'nullable|string',
    ]);

    $contact = ContactSetting::first();

    if ($contact) {
        $contact->update(['address' => $request->address]);
    } else {
        ContactSetting::create(['address' => $request->address]);
    }

    return redirect()->back()->with('success', 'Contact address updated successfully!');
}

public function editContactSettings($id)
{
    $contact = ContactSetting::findOrFail($id);
    return view('admin.homepagesettings.contactsettings', compact('contact'));
}

public function deleteContactSettings($id)
{
    $contact = ContactSetting::findOrFail($id);
    $contact->delete();

    return redirect()->route('contact.index')->with('success', 'Contact setting deleted successfully!');
}




}

