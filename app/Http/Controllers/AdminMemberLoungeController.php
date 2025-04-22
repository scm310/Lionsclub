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
        $members = Member::with('account')->orderBy('first_name', 'asc');
    
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