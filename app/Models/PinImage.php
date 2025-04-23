<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PinImage extends Model
{
    use HasFactory;

    protected $table = 'pin_images';

    protected $fillable = [
        'image_path',
    ];
}
