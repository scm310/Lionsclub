<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PendingMemberUpdate extends Model
{
    use HasFactory;

    protected $table = 'pending_member_updates';

    protected $fillable = [
        'member_id',
        'data',
        'status',
    ];

    protected $casts = [
        'data' => 'array', // Automatically converts JSON to array and vice versa
    ];

    // Relation to Member model (assuming it's named `Member`)
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }


}
