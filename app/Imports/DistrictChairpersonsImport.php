<?php

namespace App\Imports;

use App\Models\DistrictChairperson;
use App\Models\Member;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DistrictChairpersonsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Fetch member_id using first_name and last_name
        $member = Member::where('first_name', $row['first_name'])
                        ->where('last_name', $row['last_name'])
                        ->first();

        // Ensure member exists
        if (!$member) {
            return null; // Skip if no matching member is found
        }

        return new DistrictChairperson([
            'member_id' => $member->id, // Assign found member_id
            'position'  => $row['position'],
            'year'      => $row['year'],
        ]);
    }
}
