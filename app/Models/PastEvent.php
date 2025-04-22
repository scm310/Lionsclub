<?php
 namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class PastEvent extends Model
    {
        use HasFactory;

        protected $table = 'past_events';
        protected $fillable = ['event_id', 'venue', 'details', 'images'];

        protected $casts = [
            'images' => 'array',
        ];

        public function event()
        {
            return $this->belongsTo(Event::class);
        }
    }
