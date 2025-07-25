<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'event_date',
        'end_date',
        'location',
        'image_url',
        'prodi_id',
        'status',
        'organizer',
        'requirements',
        'registration_url',
        'is_featured'
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'end_date' => 'datetime',
        'is_featured' => 'boolean'
    ];

    // Relationships
    public function programStudi(): BelongsTo
    {
        return $this->belongsTo(ProgramStudi::class, 'prodi_id');
    }

    // Scopes
    public function scopeUpcoming($query)
    {
        return $query->where('status', 'upcoming')
            ->where('event_date', '>=', now());
    }

    public function scopeOngoing($query)
    {
        return $query->where('status', 'ongoing');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeRecent($query, $limit = 5)
    {
        return $query->orderBy('event_date', 'desc')->limit($limit);
    }

    // Helper methods
    public function isUpcoming()
    {
        return $this->event_date > now() && $this->status === 'upcoming';
    }

    public function isOngoing()
    {
        return $this->status === 'ongoing' ||
            (now() >= $this->event_date &&
                ($this->end_date ? now() <= $this->end_date : now()->isSameDay($this->event_date)));
    }

    public function isCompleted()
    {
        return $this->status === 'completed' ||
            ($this->end_date ? now() > $this->end_date : now() > $this->event_date->endOfDay());
    }

    // Automatically update status based on dates
    public function updateStatus()
    {
        if ($this->isCompleted()) {
            $this->update(['status' => 'completed']);
        } elseif ($this->isOngoing()) {
            $this->update(['status' => 'ongoing']);
        } elseif ($this->isUpcoming()) {
            $this->update(['status' => 'upcoming']);
        }
    }

    // Accessors
    public function getImageUrlAttribute($value)
    {
        return $value ? asset('storage/' . $value) : asset('images/default-event.jpg');
    }

    public function getFormattedEventDateAttribute()
    {
        return $this->event_date->format('d M Y, H:i');
    }

    public function getDurationAttribute()
    {
        if (!$this->end_date) {
            return null;
        }

        return $this->event_date->diffForHumans($this->end_date, true);
    }
}
