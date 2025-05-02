<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegionMember extends Model
{
    use HasFactory;

    protected $table = 'region_members';


    protected $fillable = [
        'member_id',
        'position',
        'year',
        'region',
        'zone',
        'chapter_id'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function chapter()
    {
        return $this->belongsTo(Chapter::class, 'chapter_id');
    }



    public function user()
    {
        return $this->belongsTo(User::class, 'member_id');
    }
}
