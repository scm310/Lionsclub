<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    // Specify the fillable attributes
    protected $fillable = ['service_name', 'image', 'member_id'];
}
