<?php

namespace App\Imports;

use App\Models\RegionMember;
use App\Models\Member;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RegionMembersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Fetch member_id using first_name and last_name
        $member = Member::where('first_name', $row['first_name'])
                        ->where('last_name', $row['last_name'])
                        ->first();

        // Ensure member exists before inserting
        if (!$member) {
            return null; // Skip entry if no matching member is found
        }

        return new RegionMember([
            'member_id' => $member->id, // Assign fetched member_id
            'position'  => $row['position'],
            'year'      => $row['year'],
            'zone'      => $row['zone'],
            'region'    => $row['region'],
        ]);
    }
}
