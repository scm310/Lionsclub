<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events'; // Table name

    protected $fillable = ['event_name', 'event_date', 'event_invitation'];

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
}
