<?php

namespace App\Http\Controllers;
use App\Models\Member;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log; // Import Log for debugging


class BirthdayController extends Controller
{


    public function index()
    {
        $currentMonth = Carbon::now()->month; // Get current month number (1-12)

        // Fetch members with birthdays this month
        $birthdays = Member::whereMonth('dob', $currentMonth)
                           ->select('first_name','last_name', 'dob')
                           ->get();

        // Fetch members with anniversaries this month
        $anniversaries = Member::whereMonth('anniversary_date', $currentMonth)
                               ->select('first_name','last_name', 'anniversary_date')
                               ->get();

        return view('admin.birthday', compact('birthdays', 'anniversaries'));
    }


public function getCelebrations(Request $request)
{
    $today = Carbon::today()->format('m-d'); // Get today's month and day

    // Fetch members with birthdays today
    $birthdays = Member::whereRaw("DATE_FORMAT(dob, '%m-%d') = ?", [$today])
                       ->select('first_name', 'last_name', 'dob')
                       ->get();

    // Fetch members with anniversaries today
    $anniversaries = Member::whereRaw("DATE_FORMAT(anniversary_date, '%m-%d') = ?", [$today])
                           ->select('first_name', 'last_name', 'anniversary_date')
                           ->get();

    // Return as JSON response
    return response()->json([
        'birthdays' => $birthdays,
        'anniversaries' => $anniversaries
    ]);
}

}
