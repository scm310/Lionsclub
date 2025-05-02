<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CareerEnquiry;

class CareerEnquiryController extends Controller
{
    public function create()
    {
        $enquiries = CareerEnquiry::orderBy('id', 'desc')->get();
        $jobs = CareerEnquiry::orderBy('id', 'desc')->get();
        return view('admin.enquiries.Career', compact('enquiries', 'jobs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'job_posted' => 'required|date',
            'openings' => 'required|integer',
            'job_title' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'experience' => 'required|string|max:100',
            'salary' => 'required|string|max:100',
            'job_location' => 'required|string|max:255',
            'job_description' => 'required|string',
            'education' => 'required|string|max:255',
            'employment_type' => 'required|in:permanent,contract',
            'key_skills' => 'required|string|max:255',
            'about_company' => 'required|string',
            'contact_person' => 'required|string|max:255',
            'contact_details' => 'required|string|max:10',
            'contact_email' => 'required|email|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Format salary to "2 - 3 Lacs PA" style
        $validated['salary'] = $this->formatSalary($validated['salary']);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('career_images', $imageName, 'public');
            $validated['image'] = $imageName;
        }

        CareerEnquiry::create($validated);

        return redirect()->back()->with('success', 'Career Enquiry submitted successfully!');
    }
    

    private function formatSalary($input)
    {
        $input = preg_replace('/\s+/', '', $input); // remove all spaces
    
        if (preg_match('/^(\d+)-(\d+)$/', $input, $matches)) {
            $min = (int) $matches[1];
            $max = (int) $matches[2];
    
            if ($min >= 10000000 && $max >= 10000000) {
                return round($min / 10000000) . ' - ' . round($max / 10000000) . ' Crore PA';
            } elseif ($min >= 100000 && $max >= 100000) {
                return round($min / 100000) . ' - ' . round($max / 100000) . ' Lacs PA';
            } else {
                return $min . ' - ' . $max . ' PA';
            }
        } elseif (preg_match('/^\d+$/', $input)) {
            $value = (int) $input;
    
            if ($value >= 10000000) {
                return round($value / 10000000) . ' Crore PA';
            } elseif ($value >= 100000) {
                return round($value / 100000) . ' Lacs PA';
            } else {
                return $value . ' PA';
            }
        }
    
        // Leave non-numeric or textual values like "Negotiable" as is
        return $input;
    }
    





    public function update(Request $request, $id)
    {
        $request->validate([
            'job_posted' => 'required|date',
            'openings' => 'required|numeric',
            'job_title' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'experience' => 'nullable|string|max:255',
            'salary' => 'nullable|string|max:255',
            'job_description' => 'required|string',
            'job_location' => 'required|string|max:255',
            'employment_type' => 'required|in:Permanent,Contract',
            'education' => 'nullable|string|max:255',
            'key_skills' => 'nullable|string',
            'about_company' => 'nullable|string',
            'contact_person' => 'nullable|string|max:255',
            'contact_details' => 'nullable|string|max:20',
            'contact_email' => 'nullable|email',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $career = CareerEnquiry::findOrFail($id);
    
        // Handle image upload if new file is uploaded
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('career_images', $imageName, 'public');
            $career->image = $imageName;
        }
    
        $career->job_posted = $request->job_posted;
        $career->openings = $request->openings;
        $career->job_title = $request->job_title;
        $career->company_name = $request->company_name;
        $career->experience = $request->experience;
    
        // Format salary
        $career->salary = $this->formatSalary($request->salary);
    
        $career->job_description = $request->job_description;
        $career->job_location = $request->job_location;
        $career->employment_type = $request->employment_type;
        $career->education = $request->education;
        $career->key_skills = $request->key_skills;
        $career->about_company = $request->about_company;
        $career->contact_person = $request->contact_person;
        $career->contact_details = $request->contact_details;
        $career->contact_email = $request->contact_email;
    
        $career->save();
    
        return redirect()->route('career.enquiry.page')->with('success', 'Job Post updated successfully!');
    }
    

    public function edit($id)
    {
        $career = CareerEnquiry::findOrFail($id);



        return view('admin.enquiries.editcareer', compact('career'));
    }


    public function destroy($id)
    {
        $enquiry = CareerEnquiry::findOrFail($id);
        $enquiry->delete();

        return redirect()->route('career.enquiry.page')->with('success', 'Post Job deleted successfully');
    }
}
