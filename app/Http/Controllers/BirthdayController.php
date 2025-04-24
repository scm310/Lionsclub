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
        $memberId = session('member_id');
        $currentMonth = Carbon::now()->month; // Get current month number (1-12)
    
        if ($memberId !== null) {
            // Fetch account name of the logged-in member
            $accountName = DB::table('add_members')
                             ->where('member_id', $memberId)
                             ->value('account_name');
    
            // Fetch birthdays for same account
            $birthdays = DB::table('add_members')
                           ->whereMonth('dob', $currentMonth)
                           ->where('account_name', $accountName)
                           ->select('first_name', 'last_name', 'dob')
                           ->get();
    
            // Fetch anniversaries for same account
            $anniversaries = DB::table('add_members')
                               ->whereMonth('anniversary_date', $currentMonth)
                               ->where('account_name', $accountName)
                               ->select('first_name', 'last_name', 'anniversary_date')
                               ->get();
    
        } else {
            // Fetch all birthdays
            $birthdays = DB::table('add_members')
                           ->whereMonth('dob', $currentMonth)
                           ->select('first_name', 'last_name', 'dob')
                           ->get();
    
            // Fetch all anniversaries
            $anniversaries = DB::table('add_members')
                               ->whereMonth('anniversary_date', $currentMonth)
                               ->select('first_name', 'last_name', 'anniversary_date')
                               ->get();
        }
    
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
    $memberId = session('member_id');

    $start = Carbon::today()->addDays(7);
    $end = Carbon::today()->addDays(14);

    $startDayOfYear = $start->dayOfYear;
    $endDayOfYear = $end->dayOfYear;

    // Get the logged-in member's account name
    $memberWithChapter = DB::table('add_members as m')
        ->leftJoin('chapters as c', 'm.account_name', '=', 'c.id')
        ->select('m.*', 'c.chapter_name')
        ->where('m.member_id', $memberId)
        ->first();

    if (!$memberWithChapter) {
        return redirect()->back()->with('error', 'Member not found.');
    }

    $accountName = $memberWithChapter->account_name;

    // Get all members in the same account with upcoming birthdays
    $membersQuery = DB::table('add_members as m')
        ->leftJoin('chapters as c', 'm.account_name', '=', 'c.id')
        ->select('m.*', 'c.chapter_name')
        ->where('m.account_name', $accountName);

    if ($endDayOfYear < $startDayOfYear) {
        $membersQuery->where(function ($query) use ($startDayOfYear, $endDayOfYear) {
            $query->whereRaw("DAYOFYEAR(m.dob) >= ?", [$startDayOfYear])
                  ->orWhereRaw("DAYOFYEAR(m.dob) <= ?", [$endDayOfYear]);
        });
    } else {
        $membersQuery->whereRaw("DAYOFYEAR(m.dob) BETWEEN ? AND ?", [$startDayOfYear, $endDayOfYear]);
    }

    $members = $membersQuery->get();

    // Sort the result by closest upcoming birthday
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
