<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class PasswordController extends Controller
{
    // Show the password update form
    public function showUpdatePasswordForm()
    {
        return view('member.updatePassword');  // Blade view for update password
    }

    // Handle the password update form submission
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);
    
        $userId = auth('member')->id();
    
        if (!$userId) {
            return redirect()->route('member.login')->with('error', 'Please login first.');
        }
    
        $currentPasswordHash = DB::table('add_members')->where('member_id', $userId)->value('password');
    
        if (!Hash::check($request->current_password, $currentPasswordHash)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect']);
        }
    
        // ✅ New check: Prevent setting the same password
        if (Hash::check($request->new_password, $currentPasswordHash)) {
            return back()->with('error', 'The new password cannot be the same as the current password.');
        }
    
        $newPasswordHash = Hash::make($request->new_password);
    
        DB::update('UPDATE add_members SET password = ? WHERE member_id = ?', [$newPasswordHash, $userId]);
    
        return redirect()->route('member.updatePassword')->with('success', 'Password updated successfully');
    }
    
    
}

