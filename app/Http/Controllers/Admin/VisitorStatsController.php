<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Visitor;
use App\Helpers\PageMap;

class VisitorStatsController extends Controller
{


public function index(Request $request)
{
    $query = Visitor::query();

    if ($request->filled('from_date') && $request->filled('to_date')) {
        // Convert dates to proper format and include time for accurate comparison
        $fromDate = $request->from_date . ' 00:00:00';
        $toDate = $request->to_date . ' 23:59:59';
        $query->whereBetween('created_at', [$fromDate, $toDate]);
    }

    // Only non-admin URLs
    $query->whereNotLike('url', '%/admin%');

    // Clone for pageStats before pagination
    $statsQuery = clone $query;

    $visits = $query->orderBy('created_at', 'desc')->get();

    $pageStats = $statsQuery->get()
        ->groupBy(function ($v) {
            return \App\Helpers\PageMap::getPageName($v->url);
        })
        ->reject(function ($_, $key) {
            return $key === 'Unknown';
        })
        ->map(function ($group) {
            return count($group);
        });

    return view('admin.visitors', compact('visits', 'pageStats'));
}


}
