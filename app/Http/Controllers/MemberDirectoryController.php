<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberDirectoryController extends Controller
{
    public function index()
    {
        $districts = $this->getDistricts();
        $governors = $this->getDistrictGovernors(); // Fetch all governors

        return view('member.memberdirectory', compact('districts', 'governors'));
    }

    // Fetch district codes from the districts table
    private function getDistricts()
    {
        return DB::table('districts')->pluck('district_code', 'id'); // Fetch district codes with IDs
    }

    // Fetch all governors with district details
    private function getDistrictGovernors()
    {
        return DB::table('district_governors')
            ->join('districts', 'district_governors.district_id', '=', 'districts.id')
            ->select('district_governors.*', 'districts.district_code')
            ->get();
    }

    // Fetch governors based on selected district ID (for AJAX calls)
    public function getGovernorsByDistrict($districtId)
    {
        $governors = DB::table('district_governors')
            ->where('district_id', $districtId)
            ->get(); // This returns a collection of stdClass objects
    
        return response()->json($governors);
    }
    
}
