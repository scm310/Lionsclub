<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PastDistrictGovernor extends Model
{
    use HasFactory;

    protected $table = 'past_district_governors';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'blood_group',
        'm_no',
        'chapter_id',
        'spouse_name',
        'year_of_joining',
        'profile_photo',
        'pdg'
    ];

    public function chapter()
    {
        return $this->belongsTo(Chapter::class, 'chapter_id');
    }
}

