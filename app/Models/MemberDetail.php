<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberDetail extends Model
{
    use HasFactory;

    protected $table = 'members'; // Set correct table name

    protected $fillable = ['name', 'role', 'image']; // Allow mass assignment
}


