<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    // Store or update company (insert if no record, update if exists)
    public function companyStore(Request $request)
    {
        // Get the authenticated member
        $member = Auth::guard('member')->user();

        // Validate the request data
        $request->validate([
            'company_name' => 'required|string|max:255',
            'industry'     => 'nullable|string|max:255',
            'website'      => 'nullable|string|max:255',
            'designation'  => 'nullable|string|max:255',
        ]);

        // Use updateOrCreate to check for existing company by member_id, and update or insert
        Company::updateOrCreate(
            ['member_id' => $member->id], // Condition to find an existing record
            [
                'company_name' => $request->company_name,
                'industry'     => $request->industry,
                'website'      => $request->website,
                'designation'  => $request->designation,
                'member_id'    => $member->id, // Store or update the member_id
            ]
        );

        return back()->with('success', 'Company saved successfully.');
    }

    // Update an existing company (only if exists)
    public function companyUpdate(Request $request, $id)
    {
        // Get the authenticated member
        $member = Auth::guard('member')->user();

        // Find the company by its ID
        $company = Company::findOrFail($id);

        // Validate the request data
        $request->validate([
            'company_name' => 'required|string|max:255',
            'industry'     => 'nullable|string|max:255',
            'website'      => 'nullable|string|max:255',
            'designation'  => 'nullable|string|max:255',
        ]);

        // Update the company data
        $company->update([
            'company_name' => $request->company_name,
            'industry'     => $request->industry,
            'website'      => $request->website,
            'designation'  => $request->designation,
            'member_id'    => $member->id, // Update member_id if necessary
        ]);

        return back()->with('success', 'Company updated successfully.');
    }

    // Delete a company
    public function companyDelete($id)
    {
        // Find the company by its ID
        $company = Company::findOrFail($id);

        // Delete the company record
        $company->delete();

        return back()->with('success', 'Company deleted successfully.');
    }
}
