<?php

namespace App\Imports;

use App\Models\PastGovernor;
use App\Models\Member;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;

class PastGovernorsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Fetch member_id using first_name and last_name
        $member = Member::where('first_name', $row['first_name'])
                        ->where('last_name', $row['last_name'])
                        ->first();

        if (!$member) {
            Log::warning('Member not found: ' . $row['first_name'] . ' ' . $row['last_name']);
            return null; // Skip if no matching member is found
        }

        return new PastGovernor([
            'member_id' => $member->id,
            'position'  => $row['position'],
            'year'      => $row['year'],
        ]);
    }
}
