<?php

namespace App\Http\Controllers;

use App\Models\Popup;
use Illuminate\Http\Request;
use Storage;
use Str;

class PopupController extends Controller
{

 // 🟢 Store a new banner
 public function store(Request $request)
 {
     $request->validate([
         'title'   => 'nullable|string|max:255',
         'content' => 'nullable|string',
         'link'    => 'nullable|string',
         'image'   => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
     ]);

     // Upload Image
     $imagePath = $request->file('image')->store('uploads', 'public');

     $websiteLink = trim($request->link);
     if (!Str::startsWith($websiteLink, ['http://', 'https://'])) {
         $websiteLink = 'https://' . $websiteLink;
     }
     // Store in Database
     Popup::create([
         'title'   => $request->title,
         'content' => $request->content,
         'link'    => $websiteLink,
         'image'   => $imagePath,
     ]);

         return back()
         ->with('sweetalert', 'Popup banner added successfully!')
         ->with('tab_id', 'tab6');
 }


public function destroy($id)
{
    $banner = Popup::findOrFail($id);

    // Delete the image from storage
    Storage::delete('public/' . $banner->image);

    // Delete the record from the database
    $banner->delete();


        return back()
        ->with('sweetalert', 'Banner deleted successfully!')
        ->with('tab_id', 'tab6');
}


}
