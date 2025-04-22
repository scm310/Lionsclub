<?php

namespace App\Imports;

use App\Models\Member;
use App\Models\Chapter;
use App\Models\District;
use App\Models\MembershipType;
use App\Models\ParentsMultipleDistrict;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;


class MembersImport implements ToCollection, WithHeadingRow, WithChunkReading
{
    public function collection(Collection $rows)
    {
        $imported = 0;

        foreach ($rows as $index => $row) {
            try {
                $firstName = isset($row['first_name']) ? trim($row['first_name']) : null;
                if (!$firstName || $firstName === '') {
                    Log::warning("Skipped Row #{$index} - Missing first_name: " . json_encode($row));
                    continue;
                }

                $member = Member::updateOrCreate(
                    ['member_id' => $row['member_id']],
                    [
                        'parent_multiple_district' => ParentsMultipleDistrict::firstOrCreate([
                            'name' => trim($row['parent_multiple_district'] ?? '')
                        ])->id,

                        'parent_district' => District::firstOrCreate([
                            'name' => trim($row['parent_district'] ?? '')
                        ])->id,

                        'account_name' => Chapter::firstOrCreate([
                            'chapter_name' => trim($row['account_name'] ?? '')
                        ])->id,

                        'membership_full_type' => MembershipType::firstOrCreate([
                            'name' => trim($row['membership_full_type'] ?? '')
                        ])->id,

                        'dob' => $this->formatDate($row['dob'] ?? null),
                        'anniversary_date' => $this->formatDate($row['anniversary_date'] ?? null),
                        'salutation' => $row['salutation'] ?? null,
                        'first_name' => $firstName,
                        'last_name' => $row['last_name'] ?? null,
                        'suffix' => $row['suffix'] ?? null,
                        'spouse_name' => $row['spouse_name'] ?? null,
                        'mailing_address_line_1' => $row['mailing_address_line_1'] ?? null,
                        'mailing_address_line_2' => $row['mailing_address_line_2'] ?? null,
                        'mailing_address_line_3' => $row['mailing_address_line_3'] ?? null,
                        'mailing_city' => $row['mailing_city'] ?? null,
                        'mailing_state' => $row['mailing_state'] ?? null,
                        'mailing_country' => $row['mailing_country'] ?? null,
                        'mailing_zip' => $row['mailing_zip'] ?? null,
                        'preferred_email' => $row['preferred_email'] ?? null,
                        'email_address' => $row['email_address'] ?? null,
                        'work_email' => $row['work_email'] ?? null,
                        'alternate_email' => $row['alternate_email'] ?? null,
                        'preferred_phone' => $row['preferred_phone'] ?? 'mobile',
                        'phone_number' => $row['phone_number'] ?? null,
                        'work_number' => $this->sanitizeWorkNumber($row['work_number'] ?? null),
                        'home_number' => $row['home_number'] ?? null,
                        'fax' => $row['fax'] ?? null,
                        'profile_photo' => $row['profile_photo'] ?? null,
                        'password' => Hash::make('1234', ['rounds' => 4]),

                    ]
                );

                $imported++;
            } catch (\Exception $e) {
                Log::error("Failed to import row #{$index}: " . $e->getMessage());
                Log::error(json_encode($row));
            }
        }

        Log::info("Successfully imported {$imported} members.");
    }

    public function chunkSize(): int
    {
        return 500;
    }

    private function formatDate($date)
    {
        if (!empty($date)) {
            try {
                return Carbon::createFromFormat('d/m/Y', trim($date))->format('Y-m-d');
            } catch (\Exception $e) {
                Log::warning("Invalid date format: {$date}");
                return null;
            }
        }
        return null;
    }

    private function sanitizeWorkNumber($workNumber)
    {
        if ($workNumber && strlen($workNumber) > 50) {
            Log::warning("Trimming work_number: " . $workNumber);
            return substr($workNumber, 0, 50);
        }
        return $workNumber;
    }
}