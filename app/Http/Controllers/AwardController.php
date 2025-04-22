<?php

namespace App\Http\Controllers;
use App\Models\MembershipAwardRecord;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class AwardController extends Controller
{
    public function index()
    {
        $members = MembershipAwardRecord::with(['award', 'chapter'])->paginate(10); // Fetch members with award and chapter details

        return view('website.keyawards', compact('members'));
    }

    // Function to paginate an array
    private function paginate($items, $perPage)
    {
        $page = request()->input('page', 1);
        $collection = collect($items);
        $currentPageItems = $collection->slice(($page - 1) * $perPage, $perPage)->all();
        return new LengthAwarePaginator($currentPageItems, count($collection), $perPage, $page, [
            'path' => request()->url(),
            'query' => request()->query(),
        ]);
    }
}
