<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events'; // Table name

    protected $fillable = [
        'event_name', 
        'event_date', 
        'event_invitation', 
        'activity_level', 
        'multiple_district_id',
        'district_id',
        'club_id',
        'creator',
        'activity_duration',
        'start_date',
        'end_date',
        'activity_type',
        'cause',
        'total_volunteers',
        'description'
    ];
    

    /**
     * Relationship: One event can have multiple past events.
     */
    public function pastEvents()
    {
        return $this->hasMany(PastEvent::class, 'event_id');
    }

    /**
     * Scope to get events that have already occurred (past events)
     */
    public function scopePastEvents($query)
    {
        return $query->where('event_date', '<', Carbon::now());
    }

    public function parentDistrict()
{
    return $this->belongsTo(ParentsMultipleDistrict::class, 'multiple_district_id');
}

public function district()
{
    return $this->belongsTo(District::class, 'district_id');
}

public function club()
{
    return $this->belongsTo(Chapter::class, 'club_id'); // Use 'club_id' if that's the correct foreign key
}


}
