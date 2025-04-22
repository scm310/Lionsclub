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
    return view('admin.auth.login', compact('members'));
}







    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $admin = DB::table('admin')->where('email', $request->email)->first();

        if ($admin && $admin->password === $request->password) {

            // Restrict access to only the allowed roles
            $allowed_roles = ['club_president', 'club_secretary', 'club_administrator'];

            if (!in_array($admin->role, $allowed_roles)) {
                return back()->withErrors(['email' => '']);
            }

            session([
                'admin_logged_in' => true,
                'admin_id' => $admin->id,
                'admin_role' => $admin->role
            ]);

            return redirect()->route('admin.dashboard')->with('success', 'Login Successful');
        }


        return back()->withErrors(['email' => 'Invalid email or password'])->withInput();
        }


    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login')->with('success', 'Logged out successfully');
    }
}

