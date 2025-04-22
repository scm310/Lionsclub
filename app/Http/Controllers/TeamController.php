<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;

class TeamController extends Controller
{


    public function index()
    {
        $teams = Team::all(); // Fetch all teams from the database
        return view('admin.addteam', compact('teams'));
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'team_name' => 'required|string|max:255',
            'team_code' => 'required|string|max:50|unique:teams,team_code',
            'location' => 'required|string|max:255',
        ]);

        Team::create([
            'team_name' => $request->team_name,
            'team_code' => $request->team_code,
            'location' => $request->location,
        ]);

        return redirect()->back()->with('success', 'Team added successfully!');
    }
}

