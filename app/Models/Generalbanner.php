<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Generalbanner extends Model
{
    use HasFactory;

    protected $table = 'generalbanner';
    protected $fillable = ['id','10000','5000','1000'];
}

