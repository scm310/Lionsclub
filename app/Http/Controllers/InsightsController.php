<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\Member;

class InsightsController extends Controller
{
    
    public function index()
    {
        $member = Auth::guard('member')->user();
    
        $accountName = Member::where('id', $member->id)->value('account_name');
    
        $events = Event::where('club_id', $accountName)->get();
   
    
        return view('member.partials.insights', compact('events', 'member'));
    }
}
