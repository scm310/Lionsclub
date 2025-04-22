<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PastGovernor extends Model
{
    use HasFactory;

    protected $table = 'past_governors';

    protected $fillable = [
        'member_id',
        'position',
        'year',
    ];

    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }
}
