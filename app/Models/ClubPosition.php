<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClubPosition extends Model
{
    use HasFactory;

    protected $table = 'club_positions';

    protected $fillable = ['member_id', 'position'];
}

