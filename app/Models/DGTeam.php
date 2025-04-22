<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DGTeam extends Model
{
    use HasFactory;

    protected $table = 'dg_team';

    protected $fillable = ['member_id', 'position','year'];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}
