<?php

// app/Models/Testimonial.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'client_name',
        'company_name',
        'image',
        'designation',
        'testimonial_content',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}


