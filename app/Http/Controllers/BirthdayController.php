<?php

namespace App\Http\Controllers;
use App\Models\Member;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log; // Import Log for debugging
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class BirthdayController extends Controller
{




    public function index()
    {
        $memberId = session('member_id');
        $currentMonth = Carbon::now()->month; // Get current month number (1-12)
    
        $start = Carbon::today()->addDays(7);
        $end = Carbon::today()->addDays(14);
        $startDayOfYear = $start->dayOfYear;
        $endDayOfYear = $end->dayOfYear;
    
        $birthdays = [];
        $anniversaries = [];
        $futureWeekBirthdays = [];
    
        if ($memberId !== null) {
            $accountName = DB::table('add_members')
                             ->where('member_id', $memberId)
                             ->value('account_name');
    
            $birthdays = DB::table('add_members as m')
                           ->leftJoin('chapters as c', 'm.account_name', '=', 'c.id')
                           ->whereMonth('m.dob', $currentMonth)
                           ->where('m.account_name', $accountName)
                           ->select('m.first_name', 'm.last_name', 'm.dob', 'c.chapter_name')
                           ->get();
    
                           $anniversaries = DB::table('add_members as m')
                           ->leftJoin('chapters as c', 'm.account_name', '=', 'c.id')
                           ->whereMonth('m.anniversary_date', $currentMonth)
                           ->where('m.account_name', $accountName)
                           ->select('m.first_name', 'm.last_name', 'm.anniversary_date', 'c.chapter_name')
                           ->get();
                       
    
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
    
            $futureWeekBirthdays = $membersQuery->get();
    
        } else {
            $birthdays = DB::table('add_members as m')
                           ->leftJoin('chapters as c', 'm.account_name', '=', 'c.id')
                           ->whereMonth('m.dob', $currentMonth)
                           ->select('m.first_name', 'm.last_name', 'm.dob', 'c.chapter_name')
                           ->get();
    
                           $anniversaries = DB::table('add_members as m')
                           ->leftJoin('chapters as c', 'm.account_name', '=', 'c.id')
                           ->whereMonth('m.anniversary_date', $currentMonth)
                           ->select('m.first_name', 'm.last_name', 'm.anniversary_date', 'c.chapter_name')
                           ->get();
                       
            $futureWeekBirthdays = DB::table('add_members as m')
                                     ->leftJoin('chapters as c', 'm.account_name', '=', 'c.id')
                                     ->select('m.*', 'c.chapter_name')
                                     ->whereRaw("DAYOFYEAR(m.dob) BETWEEN ? AND ?", [$startDayOfYear, $endDayOfYear])
                                     ->get();
        }
    
        $futureWeekBirthdays = $futureWeekBirthdays->sortBy(function ($member) {
            $nextBirthday = Carbon::parse($member->dob)->setYear(now()->year);
            if ($nextBirthday->lt(now())) {
                $nextBirthday->addYear();
            }
            return $nextBirthday->dayOfYear;
        });
    
        return view('admin.birthday', compact('birthdays', 'anniversaries', 'futureWeekBirthdays'));
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

    $membersQuery = DB::table('add_members as m')
        ->leftJoin('chapters as c', 'm.account_name', '=', 'c.id')
        ->select('m.*', 'c.chapter_name');

    // If logged-in member exists, filter by their account_name
    if ($memberId !== null) {
        $member = DB::table('add_members')
            ->where('member_id', $memberId)
            ->select('account_name')
            ->first();

        if (!$member) {
            return redirect()->back()->with('error', 'Member not found.');
        }

        $accountName = $member->account_name;
        $membersQuery->where('m.account_name', $accountName);
    }

    // Apply birthday filter logic (including year-end handling)
    if ($endDayOfYear < $startDayOfYear) {
        $membersQuery->where(function ($query) use ($startDayOfYear, $endDayOfYear) {
            $query->whereRaw("DAYOFYEAR(m.dob) >= ?", [$startDayOfYear])
                  ->orWhereRaw("DAYOFYEAR(m.dob) <= ?", [$endDayOfYear]);
        });
    } else {
        $membersQuery->whereRaw("DAYOFYEAR(m.dob) BETWEEN ? AND ?", [$startDayOfYear, $endDayOfYear]);
    }

    $members = $membersQuery->get();

    // Sort by next upcoming birthday
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
