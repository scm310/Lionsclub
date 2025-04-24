<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactSetting extends Model
{
    // Specify the database table used by the model
    protected $table = 'contact_settings'; // Optional if the model name matches the table name

    // Define which attributes can be mass-assigned
    protected $fillable = [
        'address', // The address field from the contact_settings table
    ];

    // Indicates if the model should be timestamped (created_at, updated_at)
    public $timestamps = true;
}
