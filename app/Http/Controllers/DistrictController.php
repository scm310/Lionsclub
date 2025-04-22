<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\District;

class DistrictController extends Controller
{
    public function index()
    {
        $districts = District::all();
        return view('admin.adddistrict', compact('districts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'district_name' => 'required|string|max:255',
            'district_code' => 'required|string|max:50|unique:districts,district_code',
        ]);

        District::create([
            'district_name' => $request->district_name,
            'district_code' => $request->district_code,
        ]);

        return redirect()->route('districts.index')->with('success', 'District added successfully!');
    }

    public function destroy($id)
    {
        District::findOrFail($id)->delete();
        return redirect()->route('districts.index')->with('success', 'District deleted successfully!');
    }
}

