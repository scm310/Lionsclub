<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MembershipEnquiry;
use App\Models\Donation;


class EnquiryController extends Controller
{
    public function index()
    {
        $enquiries = MembershipEnquiry::latest()->get();
        return view('admin.enquiries.index', compact('enquiries'));
    }

    public function donateIndex()
{
    $donations = Donation::all(); // Fetch all donation records
    return view('admin.enquiries.donateEnquiry', compact('donations'));
}

public function donateCareer()
{
    return view('admin.enquiries.Career');
}


public function destroy($id)
{
    Donation::findOrFail($id)->delete();
    return redirect()->back()->with('success', 'Donation enquiry deleted successfully.');
}

public function destroyEnquiry($id)
{
    MembershipEnquiry::findOrFail($id)->delete();


    return redirect()->back()->with('success', 'Enquiry deleted successfully.');
}
}
