<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentsMultipleDistrict extends Model
{
    use HasFactory;

    // Specify the table name (optional, as it's inferred from the model name in plural form)
    protected $table = 'parents_multiple_district';

    // By default, Eloquent expects the `id` field to be auto-incrementing and the table
    // to have 'created_at' and 'updated_at' fields, so we don't need to explicitly
    // declare them unless we want to change their behavior.

    // Specify the fields that are mass assignable (optional)
    protected $fillable = ['name'];

    // If you want to disable timestamps (not recommended in most cases), you can do:
    // public $timestamps = false;
}
