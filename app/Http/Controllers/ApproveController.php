<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\PendingMemberUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApproveController extends Controller
{
   
    
    public function index()
    {
        // Fetch all updates with member, ordered by status: pending first
        $allUpdates = PendingMemberUpdate::with('member')
            ->orderByRaw("FIELD(status, 'pending', 'rejected', 'approved')")
            ->get();
    
        return view('admin.approvemember.approve', [
            'allUpdates' => $allUpdates,
        ]);
    }
    
    
    
    
    
    
    public function approve($id)
    {
        $pending = PendingMemberUpdate::find($id);
        if (!$pending) {
            return redirect()->back()->with('error', 'Update not found.');
        }
    
        $member = Member::where('id', $pending->member_id)->first();
        if (!$member) {
            return redirect()->back()->with('error', 'Member not found.');
        }
    
        $updates = json_decode($pending->data, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return redirect()->back()->with('error', 'Failed to decode update data.');
        }
    
        try {
            $fillable = collect($member->getFillable());
            $validUpdates = collect($updates)->only($fillable)->toArray();
    
            if (empty($validUpdates)) {
                return redirect()->back()->with('error', 'No valid changes to apply.');
            }
    
            $member->update($validUpdates);
    
            $pending->status = 'approved';
            $pending->save();
    
            return redirect()->back()->with('success', 'Member profile approved and updated.');
    
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Update failed.');
        }
    }
    
    

    
    
    public function reject($id)
    {
        $pending = PendingMemberUpdate::findOrFail($id);
        $pending->status = 'rejected';
        $pending->save();
    
        return redirect()->back()->with('success', 'Member profile update rejected.');
    }
    
    
}

