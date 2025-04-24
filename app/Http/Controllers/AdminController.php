<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\BannerClick;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
class AdminController extends Controller
{
    public function dashboard()
    {
        $memberId = session('member_id');
    
        $start = Carbon::today()->addDays(7);
        $end = Carbon::today()->addDays(14);
        $startDayOfYear = $start->dayOfYear;
        $endDayOfYear = $end->dayOfYear;
    
        // Initialize all variables
        $memberCount = null;
        $chapterCount = null;
        $districtCount = null;
        $visitorCount = null;
        $birthdayCount = 0;
        $upcomingBirthdays = collect();
        $accountName = null;
    
        if ($memberId !== null) {
            // For logged-in member
            $member = DB::table('add_members')
                ->where('member_id', $memberId)
                ->select('account_name')
                ->first();
    
            if ($member) {
                $accountName = $member->account_name;
    
                $upcomingBirthdays = DB::table('add_members')
                    ->where('account_name', $accountName)
                    ->whereRaw(
                        $endDayOfYear < $startDayOfYear
                            ? "(DAYOFYEAR(dob) >= ? OR DAYOFYEAR(dob) <= ?)"
                            : "DAYOFYEAR(dob) BETWEEN ? AND ?",
                        [$startDayOfYear, $endDayOfYear]
                    )
                    ->select('first_name', 'last_name', 'dob')
                    ->get();
    
                $birthdayCount = $upcomingBirthdays->count();
            }
        } else {
            // For admin dashboard
            $memberCount = DB::table('add_members')->count();
            $chapterCount = DB::table('chapters')->count();
            $districtCount = DB::table('district')->count();
            $visitorCount = DB::table('visitors')->select('ip_address')->distinct()->count('ip_address');
    
            $upcomingBirthdays = DB::table('add_members')
                ->whereRaw(
                    $endDayOfYear < $startDayOfYear
                        ? "(DAYOFYEAR(dob) >= ? OR DAYOFYEAR(dob) <= ?)"
                        : "DAYOFYEAR(dob) BETWEEN ? AND ?",
                    [$startDayOfYear, $endDayOfYear]
                )
                ->select('first_name', 'last_name', 'dob')
                ->get();
    
            $birthdayCount = $upcomingBirthdays->count();
        }
    
        return view('admin.dashboard', compact(
            'memberCount',
            'chapterCount',
            'districtCount',
            'visitorCount',
            'birthdayCount',
            'upcomingBirthdays',
            'accountName'
        ));
    }
    
    
    





    public function logout(Request $request)
{
    Auth::logout(); // Logout the user
    $request->session()->invalidate(); // Invalidate the session
    $request->session()->regenerateToken(); // Regenerate CSRF token

    return redirect()->route('admin.login')->with('success', 'Logged out successfully!');
}

public function viewBannerClicks(Request $request)
{
    $query = BannerClick::query();

    if ($request->filled('type')) {
        $query->where('banner_type', $request->type);
    }

    if ($request->filled('start_date')) {
        $query->whereDate('created_at', '>=', $request->start_date);
    }

    if ($request->filled('end_date')) {
        $query->whereDate('created_at', '<=', $request->end_date);
    }

    $clicks = $query->orderByDesc('click_count')->get();
    $topClicks = BannerClick::where('banner_type', 'top')->sum('click_count');

    $bottomClicks = BannerClick::where('banner_type', 'bottom')->sum('click_count');
    $leftClicks = BannerClick::where('banner_type', 'left')->sum('click_count');

    $rightClicks = BannerClick::where('banner_type', 'right')->sum('click_count');
    $popupClicks = BannerClick::where('banner_type', 'popup')->sum('click_count');

    // Apply same filters for charts
    $chartQuery = BannerClick::query();

    if ($request->filled('type')) {
        $chartQuery->where('banner_type', $request->type);
    }

    if ($request->filled('start_date')) {
        $chartQuery->whereDate('created_at', '>=', $request->start_date);
    }

    if ($request->filled('end_date')) {
        $chartQuery->whereDate('created_at', '<=', $request->end_date);
    }

    $clicksPerDay = $chartQuery->clone()->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(click_count) as total'))
        ->groupBy(DB::raw('DATE(created_at)'))
        ->orderBy('date')
        ->get();

    $newUsers = $chartQuery->clone()->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(DISTINCT redirect_url) as new_user_count'))
        ->groupBy(DB::raw('DATE(created_at)'))
        ->orderBy('date')
        ->get();


        $newUsersPerMonth = $chartQuery->clone()
    ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('COUNT(DISTINCT redirect_url) as new_user_count'))
    ->groupBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'))
    ->orderBy('month')
    ->get();

    $clicksPerMonth = $chartQuery->clone()
    ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('SUM(click_count) as total_clicks'))
    ->groupBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'))
    ->orderBy('month')
    ->get();



    return view('admin.banner_clicks', compact(
        'clicks', 'topClicks', 'bottomClicks', 'leftClicks', 'rightClicks', 'popupClicks',
        'clicksPerDay', 'newUsers' ,'newUsersPerMonth','clicksPerMonth'
    ));
}



    public function exportBannerClicks(): StreamedResponse
    {
        $fileName = 'banner_clicks_' . now()->format('Ymd_His') . '.csv';
        $clicks = BannerClick::all();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        $callback = function () use ($clicks) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Banner Type', 'Image Path', 'Redirect URL', 'Click Count', 'Created At']);

            foreach ($clicks as $click) {
                fputcsv($handle, [
                    $click->id,
                    $click->banner_type,
                    $click->image_path,
                    $click->redirect_url,
                    $click->click_count,
                    $click->created_at,
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }


}
