<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner10000 extends Model
{
    use HasFactory;

    protected $table = 'banner_10000';
    protected $fillable = ['id','image_path','url'];
}

