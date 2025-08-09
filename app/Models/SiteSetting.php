<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key_name',
        'value',
        'type',
        'description',
        'group',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Accessors
    public function getValueAttribute($value)
    {
        // Handle different types
        switch ($this->type) {
            case 'boolean':
                return (bool) $value;
            case 'number':
                return is_numeric($value) ? (float) $value : $value;
            case 'file':
                return $value ? asset('storage/' . $value) : null;
            default:
                return $value;
        }
    }

    public function getRawValueAttribute()
    {
        return $this->attributes['value'] ?? null;
    }

    // Scopes
    public function scopeByGroup($query, $group)
    {
        return $query->where('group', $group);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByKey($query, $key)
    {
        return $query->where('key_name', $key);
    }

    // Static methods for easy access
    public static function getValue($key, $default = null)
    {
        $setting = static::where('key_name', $key)->first();
        return $setting ? $setting->getRawValueAttribute() : $default;
    }

    public static function getFormattedValue($key, $default = null)
    {
        $setting = static::where('key_name', $key)->first();
        return $setting ? $setting->value : $default;
    }

    public static function setValue($key, $value)
    {
        return static::updateOrCreate(
            ['key_name' => $key],
            ['value' => $value]
        );
    }

    public static function getGroupSettings($group)
    {
        return static::where('group', $group)
            ->orderBy('key_name')
            ->get()
            ->pluck('value', 'key_name');
    }

    // Helper methods
    public function getDisplayValueAttribute()
    {
        switch ($this->type) {
            case 'boolean':
                return $this->getRawValueAttribute() ? 'Yes' : 'No';
            case 'file':
                if ($this->getRawValueAttribute()) {
                    return basename($this->getRawValueAttribute());
                }
                return 'No file';
            case 'textarea':
                return strlen($this->getRawValueAttribute()) > 50
                    ? substr($this->getRawValueAttribute(), 0, 50) . '...'
                    : $this->getRawValueAttribute();
            default:
                return $this->getRawValueAttribute();
        }
    }

    public function getTypeIconAttribute()
    {
        $icons = [
            'text' => 'document-text',
            'textarea' => 'document-text',
            'email' => 'at-symbol',
            'url' => 'link',
            'file' => 'document',
            'number' => 'hashtag',
            'boolean' => 'check-circle',
            'color' => 'color-swatch',
        ];

        return $icons[$this->type] ?? 'cog';
    }
}
