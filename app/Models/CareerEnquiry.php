<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareerEnquiry extends Model
{
    use HasFactory;

    protected $table = 'career_enquiries'; 
    protected $fillable = [
        'job_posted',
        'openings',
        'job_title',
        'company_name',
        'experience',
        'salary',
        'job_location',
        'job_description',
        'education',
        'employment_type',
        'key_skills',
        'about_company',
        'contact_person',
        'contact_details',
        'contact_email',
        'image',
    ];
    
}

