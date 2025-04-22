<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MembershipEnquiry;

class EnquiryController extends Controller
{
    public function index()
    {
        $enquiries = MembershipEnquiry::latest()->get();
        return view('admin.enquiries.index', compact('enquiries'));
    }


    public function destroyEnquiry($id)
{
    $enquiry = MembershipEnquiry::findOrFail($id);
    $enquiry->delete();

    return redirect()->route('enquiry.index')->with('success', 'Enquiry deleted successfully.');
}

}
