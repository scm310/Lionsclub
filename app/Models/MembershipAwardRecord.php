<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipAwardRecord extends Model
{
    use HasFactory;

    // Define the table name (optional, as it will automatically be inferred as plural form of the model)
    protected $table = 'membership_awards_records';

    // Define the primary key (optional, as it defaults to 'id')
    protected $primaryKey = 'id';

    // Disable auto-increment if you're using a different key type or logic
    public $incrementing = true;

    // Define the fillable fields for mass assignment (these are the columns that you want to allow for mass assignment)
    protected $fillable = [
        'name', 
        'awards_id', 
        'chapter_id',
    ];

    // Define the timestamps fields (optional if you are not using 'created_at' and 'updated_at' columns)
    public $timestamps = true;

    // Optionally, define custom date formats for the timestamp fields
    protected $dateFormat = 'Y-m-d H:i:s';

    // Define relationships, if necessary. Example (assuming you may have models for 'Award' and 'Chapter' tables):
    public function award()
    {
        return $this->belongsTo(Award::class, 'awards_id');
    }

    public function chapter()
    {
        return $this->belongsTo(Chapter::class, 'chapter_id');
    }
}
