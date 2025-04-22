<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    use HasFactory;

    // Define the table name if it doesn't follow Laravel's convention
    protected $table = 'awards';

    // Define the fillable fields
    protected $fillable = ['name'];
}
