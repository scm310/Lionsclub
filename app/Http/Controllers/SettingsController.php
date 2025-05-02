<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParentsMultipleDistrict;
use App\Models\District;
use App\Models\Chapter;
use App\Models\MembershipType;
use App\Models\Region;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;


class SettingsController extends Controller
{
    // Display the settings page with districts
    public function add()
    {
        // Fetch all districts for the parent district dropdown
        $ParentsMultipleDistrict = ParentsMultipleDistrict::all(); // This gets all districts from the database

        // Pass the districts to the view
        return view('admin.Setting.add', compact('ParentsMultipleDistrict')); // Passing 'districts' variable
    }




    // Store a new district
    public function store(Request $request)
    {
        // Validate the input
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Create a new record in the database
        ParentsMultipleDistrict::create([
            'name' => $request->name,
        ]);

        // Redirect back to the 'admin.settings.add' route
        return redirect()->route('admin.settings.add')->with('success', 'District added successfully!');
    }


    // Store a new district with a parent district
    public function storedistrict(Request $request)
    {
        // Validate the input
        $request->validate([
            'name' => 'required|array',  // Ensure that names are an array
            'name.*' => 'required|string|max:255', // Validate each name individually
            'parent_district_id' => 'required|exists:parents_multiple_district,id', // Validate parent district ID
        ]);

        // Loop through each district name and insert it into the database
        foreach ($request->name as $districtName) {
            DB::table('district')->insert([
                'name' => $districtName,
                'parent_district_id' => $request->parent_district_id,
            ]);
        }

        // Redirect back to the settings page with a success message
        return redirect()->route('admin.settings')->with('success', 'District with parent added successfully!');
    }



    public function storeAccountNames(Request $request)
    {
        $request->validate([
            'account_names' => 'required|array',
            'account_names.*' => 'required|string|max:255',
        ]);

        foreach ($request->account_names as $name) {
            // Assuming you have a 'Chapter' model to store account names
            Chapter::create(['chapter_name' => $name]);
        }

        return redirect()->route('admin.settings')->with('success', 'Account names added successfully!');
    }

    public function storeMembershipTypes(Request $request)
    {
        $request->validate([
            'membership_types' => 'required|array',
            'membership_types.*' => 'required|string|max:255',
        ]);

        foreach ($request->membership_types as $type) {
            // Assuming you have a 'MembershipType' model to store membership types
            MembershipType::create(['name' => $type]);
        }

        return redirect()->route('admin.settings')->with('success', 'Membership types added successfully!');
    }


    public function view()
    {
        // Fetch data from the four tables
        $parentsMultipleDistricts = DB::table('parents_multiple_district')->get(); // Table 1
        $districts = DB::table('district')->get(); // Table 2
        $chapters = DB::table('chapters')->get(); // Table 3
        $membershipTypes = DB::table('membership_type')->get(); // Table 4
        $regions = Region::all();
        // Pass the data to the view
        return view('admin.Setting.view', compact('parentsMultipleDistricts', 'districts', 'chapters', 'membershipTypes', 'regions'));
    }



    public function deleteDistrict($id)
    {
        try {
            // Check if there are any child records in the district table
            $childRecordsExist = DB::table('district')->where('parent_district_id', $id)->exists();

            if ($childRecordsExist) {
                // If child records exist, show a warning message to delete child data first
                return redirect()->back()->with('error', 'This district has child data. Please delete the child data first before deleting the parent.');
            }

            // If no child records exist, proceed to delete the parent record
            DB::table('parents_multiple_district')->where('id', $id)->delete();

            return redirect()->back()->with('success', 'District deleted successfully.');
        } catch (QueryException $e) {
            // If there's any error, handle the exception (such as a foreign key constraint violation)
            return redirect()->back()->with('error', 'Error: Unable to delete the district. Ensure no child data exists.');
        }
    }


    public function deleteChapter($id)
    {
        // Attempt to delete the chapter by id
        Chapter::where('id', $id)->delete();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Chapter deleted successfully!');
    }


    public function deleteMembership($id)
    {
        // Find the membership type by id and delete it
        MembershipType::where('id', $id)->delete();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Membership type deleted successfully!');
    }


    public function destroyDistrict($id)
    {
        // Delete the district from the database
        DB::table('district')->where('id', $id)->delete();

        return redirect()->back()->with('success', 'District deleted successfully.');
    }



    public function updateMembership(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $membership = MembershipType::findOrFail($id);
        $membership->name = $request->name;
        $membership->save();

        return redirect()->back()->with('success', 'Membership updated successfully!');
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $district = District::findOrFail($id);
        $district->name = $request->name;
        $district->save();

        return redirect()->back()->with('success', 'District updated successfully!');
    }


    public function updateChapter(Request $request, $id)
    {
        $request->validate([
            'chapter_name' => 'required|string|max:255',
        ]);

        $chapter = Chapter::findOrFail($id);
        $chapter->chapter_name = $request->chapter_name;
        $chapter->save();

        return redirect()->back()->with('success', 'Chapter updated successfully!');
    }


    public function updateDistrict(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $district = District::findOrFail($id);
        $district->name = $request->name;
        $district->save();

        return redirect()->back()->with('success', 'District updated successfully!');
    }


    public function editParentDistrict(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $district = ParentsMultipleDistrict::findOrFail($id);
        $district->name = $request->name;
        $district->save();

        return redirect()->back()->with('success', 'District updated successfully.');
    }


    public function storeRegion(Request $request)
    {
        $request->validate([
            'name' => 'required|array',
            'name.*' => 'required|string|max:100|distinct|unique:regions,name',
        ]);

        try {
            foreach ($request->name as $regionName) {
                Region::create(['name' => $regionName]);
            }
            return redirect()->back()->with('success', 'Regions added successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error adding regions: ' . $e->getMessage());
        }
    }


    public function updateregion(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $region = Region::findOrFail($id);
        $region->name = $request->name;
        $region->save();

        return redirect()->back()->with('success', 'Region updated successfully.');
    }

    public function destroy($id)
    {
        $region = Region::findOrFail($id);
        $region->delete();

        return redirect()->back()->with('success', 'Region deleted successfully.');
    }
}
