<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Member;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'product_name',
        'product_image',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}
