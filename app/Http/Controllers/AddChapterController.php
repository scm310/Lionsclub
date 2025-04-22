<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chapter;

class AddChapterController extends Controller
{
    public function index()
    {
        $chapters = Chapter::all();
        return view('admin.addchapter', compact('chapters'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'chapter_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        Chapter::create([
            'chapter_name' => $request->chapter_name,
            'location' => $request->location,
        ]);

        return redirect()->back()->with('success', 'Chapter added successfully.');
    }
}
