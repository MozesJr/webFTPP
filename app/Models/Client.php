<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'logo_url',
        'website_url',
        'partnership_type',
        'description',
        'is_active',
        'order_index'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order_index' => 'integer'
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order_index');
    }

    // Accessors
    public function getLogoUrlAttribute($value)
    {
        return $value ? asset('storage/' . $value) : asset('images/default-client.png');
    }
}
