<?php
namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminMemberLoungeController extends Controller



{


    public function index(Request $request)
    {
        $memberId = session('member_id');

        // Start building the query
        $members = Member::with([
            'account',
            'client',
            'testimonial',
            'project',
            'service'
        ])
        ->orderBy('first_name', 'asc');

        // If a member is logged in, filter by their account_name
        if (!is_null($memberId)) {
            $targetAccountName = DB::table('add_members')
                ->where('member_id', $memberId)
                ->value('account_name');

            // Add filter for account_name via account relationship
            $members->whereHas('account', function ($query) use ($targetAccountName) {
                $query->where('account_name', $targetAccountName);
            });
        }

        // Apply search filter if present
        if ($request->has('search')) {
            $search = $request->input('search');

            $members->where(function ($query) use ($search) {
                $query->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere(DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', "%{$search}%")
                    ->orWhere('member_id', 'like', "%{$search}%")
                    ->orWhere('phone_number', 'like', "%{$search}%")
                    ->orWhereHas('account', function ($q) use ($search) {
                        $q->where('chapter_name', 'like', "%{$search}%");
                    });
            });
        }

        $members = $members->paginate(30);

        return view('admin.adminmemberlounge.index', compact('members'));
    }



    public function show($id)
    {
        $member = Member::with('account')->findOrFail($id);
        return view('admin.adminmemberlounge.member_details', compact('member'));
    }
}
