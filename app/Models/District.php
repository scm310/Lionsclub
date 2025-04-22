<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    protected $table = 'district'; // Specify the correct table name
    protected $fillable = ['name', 'parent_district_id'];

    public function parentDistrict()
    {
        return $this->belongsTo(ParentsMultipleDistrict::class, 'parent_district_id');
    }
}
