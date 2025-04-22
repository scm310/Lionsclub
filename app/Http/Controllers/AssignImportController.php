<?php

namespace App\Http\Controllers;

use App\Imports\assignimport;
use App\Imports\ClubPositionsImport;
use App\Imports\DGTeamImport;
use App\Imports\DistrictChairpersonsImport;
use App\Imports\DistrictGovernorsImport;
use App\Imports\PastGovernorsImport;
use App\Imports\RegionMembersImport;
use Illuminate\Http\Request;
use App\Imports\InternationalOfficersImport;
use Maatwebsite\Excel\Facades\Excel;

class AssignImportController extends Controller
{
    /**
     * Display the import form.
     */
    public function showImportForm()
    {
        return view('admin.addmembers.import');
    }

    /**
     * Handle the Excel import.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',    
        ]);

        Excel::import(new assignimport, $request->file('file'));

        return redirect()->back()->with('success', 'International Officers Imported Successfully!');
    }

    public function importDGTeam(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);

        Excel::import(new DGTeamImport, $request->file('file'));

        return redirect()->back()->with('success', 'DG Team Imported Successfully!');
    }

    public function importPastGovernors(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);

        Excel::import(new PastGovernorsImport, $request->file('file'));

        return redirect()->back()->with('success', 'Past Governors Imported Successfully!');
    }


    public function importDistrictChairpersons(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);

        Excel::import(new DistrictChairpersonsImport, $request->file('file'));

        return redirect()->back()->with('success', 'District Chairpersons Imported Successfully!');
    }

    public function importDistrictGovernors(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,csv',
    ]);

    Excel::import(new DistrictGovernorsImport, $request->file('file'));

    return redirect()->back()->with('success', 'District Governors Imported Successfully!');
}

public function importRegionMembers(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,csv',
    ]);

    Excel::import(new RegionMembersImport, $request->file('file'));

    return redirect()->back()->with('success', 'Region Members imported successfully!');
}

public function importClubPositions(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,csv',
    ]);

    Excel::import(new ClubPositionsImport, $request->file('file'));

    return back()->with('success', 'Club Positions imported successfully!');
}


}
