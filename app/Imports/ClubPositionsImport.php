<?php

namespace App\Imports;

use App\Models\ClubPosition;
use App\Models\AddMember;
use App\Models\Member;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ClubPositionsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Find member ID based on first and last name
        $member = Member::where('first_name', $row['first_name'])
            ->where('last_name', $row['last_name'])
            ->first();

        if ($member) {
            return new ClubPosition([
                'member_id' => $member->id,
                'position'  => $row['position'],
            ]);
        }

        return null; // Skip if member not found
    }
}

