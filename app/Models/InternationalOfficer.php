<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternationalOfficer extends Model
{
    use HasFactory;

    protected $table = 'internationalofficers';

    protected $fillable = [
        'member_id',
        'position',
        'year',
    ];

    // Relationship with User model
    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }
}
