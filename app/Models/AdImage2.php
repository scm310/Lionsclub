<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdImage2 extends Model
{
    use HasFactory;

    protected $table = 'ad_images_2';

    protected $fillable = ['id','image_path', 'website_link'];
}

