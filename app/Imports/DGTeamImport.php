<?php

namespace App\Imports;

use App\Models\DGTeam;
use App\Models\Member;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DGTeamImport implements ToModel, WithHeadingRow
{
    

    public function model(array $row)
    {
      
    
        $member = Member::where('first_name', $row['first_name'])
                        ->where('last_name', $row['last_name'])
                        ->first();
    
        if (!$member) {
            Log::warning('Member not found for: ' . $row['first_name'] . ' ' . $row['last_name']);
            return null;
        }
    
      
    
        return new DGTeam([
            'member_id' => $member->id,
            'position'  => $row['position'],
        ]);
    }
    
}
