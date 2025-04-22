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
        // Fetch all updates
        $allUpdates = PendingMemberUpdate::with('member')->get(); // eager load related member
    
        // No need to separate, but you can log if desired
        foreach ($allUpdates as $update) {
            $status = $update->status ?? 'unknown';
            Log::info("🔄 Update for Member ID: {$update->member_id}, Status: {$status}");
        }
    
        return view('admin.approvemember.approve', [
            'allUpdates' => $allUpdates,
        ]);
    }
    
    
    
    
    public function approve($id)
    {
        Log::info("🚀 Approve called with ID: $id");
    
        $pending = PendingMemberUpdate::find($id);
        if (!$pending) {
            Log::error("❌ No pending update found for ID $id");
            return redirect()->back()->with('error', 'Update not found.');
        }
    
        $member = Member::where('id', $pending->member_id)->first();
        if (!$member) {
            Log::error("❌ Member not found for Member ID: {$pending->member_id}");
            return redirect()->back()->with('error', 'Member not found.');
        }
    
        Log::info("📦 Raw JSON for Member ID {$member->member_id}: " . $pending->data);
    
        $updates = json_decode($pending->data, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error("❌ JSON Decode Error: " . json_last_error_msg());
            return redirect()->back()->with('error', 'Failed to decode update data.');
        }
    
        Log::info("🔧 Decoded data:", $updates);
    
        try {
            $fillable = collect($member->getFillable());
            $validUpdates = collect($updates)->only($fillable)->toArray();
    
            if (empty($validUpdates)) {
                Log::warning("⚠️ No valid fillable fields in updates.");
                return redirect()->back()->with('error', 'No valid changes to apply.');
            }
    
            $member->update($validUpdates);
            Log::info("✅ Member updated: ", $member->fresh()->toArray());
    
            $pending->status = 'approved';
            $pending->save();
            
    
            return redirect()->back()->with('success', 'Member profile approved and updated.');

        } catch (\Exception $e) {
            Log::error("❌ Exception during update: " . $e->getMessage());
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

