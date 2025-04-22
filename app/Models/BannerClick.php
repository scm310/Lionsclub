<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BannerClick extends Model
{
    protected $fillable = ['banner_type', 'image_path', 'redirect_url', 'click_count'];
}
