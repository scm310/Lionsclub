<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistrictChairperson extends Model
{
    use HasFactory;

    protected $table = 'district_chairpersons';

    protected $fillable = [
        'member_id',
        'position',
        'year',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}


