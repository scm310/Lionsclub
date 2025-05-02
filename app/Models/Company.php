<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    // Explicitly set the table name to 'company'
    protected $table = 'company';  // Table name is 'company' (singular)

    // Define the fields that can be mass assigned
    protected $fillable = [
        'member_id',
        'company_name',
        'industry',
        'website',
        'designation',
    ];
}
