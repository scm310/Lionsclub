<?php

namespace App\Http\Controllers;
use App\Models\Member;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log; // Import Log for debugging
use Illuminate\Support\Facades\DB;



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

public function getFutureWeekBirthdayCount()
{
    $start = Carbon::today()->addDays(7); // Start from 8th day
    $end = Carbon::today()->addDays(14);  // Up to 14th day

    $startDayOfYear = $start->dayOfYear;
    $endDayOfYear = $end->dayOfYear;

    if ($endDayOfYear < $startDayOfYear) {
        // Year wrap-around (e.g., Dec 28 to Jan 4)
        $birthdays = Member::whereRaw("DAYOFYEAR(dob) >= ? OR DAYOFYEAR(dob) <= ?", [
            $startDayOfYear, $endDayOfYear
        ])->count();
    } else {
        $birthdays = Member::whereRaw("DAYOFYEAR(dob) BETWEEN ? AND ?", [
            $startDayOfYear, $endDayOfYear
        ])->count();
    }

    return $birthdays;
}
public function showFutureWeekBirthdays()
{
    $start = Carbon::today()->addDays(7);
    $end = Carbon::today()->addDays(14);

    $startDayOfYear = $start->dayOfYear;
    $endDayOfYear = $end->dayOfYear;

    // Join add_members with chapters and select required fields
    $membersQuery = DB::table('add_members as m')
        ->leftJoin('chapters as c', 'm.account_name', '=', 'c.id')
        ->select('m.*', 'c.chapter_name');

    // Apply birthday filter based on whether date range crosses year-end
    if ($endDayOfYear < $startDayOfYear) {
        $membersQuery->where(function ($query) use ($startDayOfYear, $endDayOfYear) {
            $query->whereRaw("DAYOFYEAR(m.dob) >= ?", [$startDayOfYear])
                  ->orWhereRaw("DAYOFYEAR(m.dob) <= ?", [$endDayOfYear]);
        });
    } else {
        $membersQuery->whereRaw("DAYOFYEAR(m.dob) BETWEEN ? AND ?", [$startDayOfYear, $endDayOfYear]);
    }

    $members = $membersQuery->get();

    // Sort the result by closest upcoming birthday (ignoring year)
    $members = $members->sortBy(function ($member) {
        $nextBirthday = Carbon::parse($member->dob)->setYear(now()->year);
        if ($nextBirthday->lt(now())) {
            $nextBirthday->addYear();
        }
        return $nextBirthday->dayOfYear;
    });

    return view('admin.future_birthdays', ['members' => $members]);
}

}
