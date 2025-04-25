<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'chapter_name',
        'location',
    ];

    public function regionMembers()
    {
        return $this->hasMany(RegionMember::class, 'chapter_id');
    }
}
