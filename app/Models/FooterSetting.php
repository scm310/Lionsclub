<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FooterSetting extends Model
{
    protected $fillable = [
        'copyright_text',
        'facebook_link',
        'twitter_link',
        'instagram_link',
    ];
}

