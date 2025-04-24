<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'project_name',
        'project_image',
        'location',
        'client_name',
        'company_name',
    ];
}

