<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id', // Corrected field name
        'client_name',
        'company_name',
        'comapny_fullform',
        'designation',
    ];

    // Optional: Define relationship with the add_members table if needed
    public function addMember()
    {
        return $this->belongsTo(Member::class, 'member_id');  // Assuming AddMember model exists
    }
}
