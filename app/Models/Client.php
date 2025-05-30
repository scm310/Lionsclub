<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'client_name',
        'company_name',
        'comapny_fullform', // Typo, see note below
        'designation',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}
