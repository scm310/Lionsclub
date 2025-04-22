<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner1000 extends Model
{
    use HasFactory;

    protected $table = 'banner_1000';
    protected $fillable = ['id','image_path','url'];
}

