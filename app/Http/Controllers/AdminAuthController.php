<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        $members = DB::table('members')->get();
        $images = DB::table('pin_images')->select('image_path')->get();
        //dd(  $images);
        
        return view('admin.auth.login', compact('members', 'images'));
    }
    


    public function login(Request $request)
    {
        $request->validate([
            'email_or_memberid' => 'required',
            'password' => 'required',
        ]);
    
        $input = $request->email_or_memberid;
        $password = $request->password;
    
        // 1. Try login as admin (by email)
        $admin = DB::table('admin')->where('email', $input)->first();
    
        if ($admin && $admin->password === $password) {
            // Allow only specific roles
            $allowed_roles = ['club_president', 'club_secretary', 'club_administrator'];
            if (!in_array($admin->role, $allowed_roles)) {
                return back()->withErrors(['email_or_memberid' => 'Access denied for this role.']);
            }
    
            session([
                'admin_logged_in' => true,
                'admin_id' => $admin->id,
                'admin_role' => $admin->role,
            ]);
    
            return redirect()->route('admin.dashboard')->with('success', 'Admin Login Successful');
        }
    
        // 2. Try login as club member (by member_id)
        $member = DB::table('add_members')
            ->join('club_positions', 'add_members.id', '=', 'club_positions.member_id')
            ->where('add_members.member_id', $input)
            ->whereIn('club_positions.position', ['Secretary', 'President', 'Treasurer'])
            ->select(
                'add_members.id as member_db_id',
                'add_members.member_id',
                'add_members.account_name',
                'club_positions.password',
                'club_positions.position'
            )
            ->first();
    
        if ($member && $member->password === $password) {
            session([
                'admin_logged_in' => true,
                'admin_id' => $member->member_db_id,
                'admin_role' => $member->position,
                'member_id' => $member->member_id, // Store member_id in session
            ]);
    
            return redirect()->route('admin.dashboard')->with('success', 'Club Member Login Successful');
        }
    
        return back()->withErrors(['email_or_memberid' => 'Invalid credentials'])->withInput();
    }
    


    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login')->with('success', 'Logged out successfully');
    }
}
