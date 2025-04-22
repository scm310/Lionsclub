<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChapterMember extends Model
{
    use HasFactory;

    protected $table = 'chaptermember'; // Table name

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'role',
        'chapter_id',
        'profile_image'
    ];

    // Relationship with the Chapter model
    public function chapter()
    {
        return $this->belongsTo(Chapter::class, 'chapter_id');
    }
}

