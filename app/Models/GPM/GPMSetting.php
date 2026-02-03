<?php

namespace App\Models\GPM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GPMSetting extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'gpm_settings';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'label',
        'description',
        'is_public',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'is_public' => 'boolean',
    ];

    /**
     * Get the value in its proper type.
     */
    public function getTypedValueAttribute()
    {
        return match($this->type) {
            'boolean' => filter_var($this->value, FILTER_VALIDATE_BOOLEAN),
            'integer' => (int) $this->value,
            'json' => json_decode($this->value, true),
            default => $this->value,
        };
    }

    /**
     * Set value and auto-detect type if not set.
     */
    public function setValueAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['value'] = json_encode($value);
            if (empty($this->type)) {
                $this->attributes['type'] = 'json';
            }
        } elseif (is_bool($value)) {
            $this->attributes['value'] = $value ? 'true' : 'false';
            if (empty($this->type)) {
                $this->attributes['type'] = 'boolean';
            }
        } elseif (is_numeric($value)) {
            $this->attributes['value'] = (string) $value;
            if (empty($this->type)) {
                $this->attributes['type'] = 'integer';
            }
        } else {
            $this->attributes['value'] = $value;
            if (empty($this->type)) {
                $this->attributes['type'] = 'string';
            }
        }
    }

    /**
     * Scope: Filter by group
     */
    public function scopeGroup($query, string $group)
    {
        return $query->where('group', $group);
    }

    /**
     * Scope: Public settings only
     */
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    /**
     * Get setting value by key.
     */
    public static function get(string $key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        
        if (!$setting) {
            return $default;
        }
        
        return $setting->typed_value;
    }

    /**
     * Set setting value by key.
     */
    public static function set(string $key, $value, ?string $group = null): self
    {
        $setting = self::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'group' => $group,
            ]
        );

        return $setting;
    }

    /**
     * Check if setting exists.
     */
    public static function has(string $key): bool
    {
        return self::where('key', $key)->exists();
    }

    /**
     * Delete setting by key.
     */
    public static function forget(string $key): bool
    {
        return self::where('key', $key)->delete();
    }

    /**
     * Get all settings as key-value pairs.
     */
    public static function all(): array
    {
        return self::query()
            ->get()
            ->mapWithKeys(function ($setting) {
                return [$setting->key => $setting->typed_value];
            })
            ->toArray();
    }

    /**
     * Get settings by group.
     */
    public static function getByGroup(string $group): array
    {
        return self::group($group)
            ->get()
            ->mapWithKeys(function ($setting) {
                return [$setting->key => $setting->typed_value];
            })
            ->toArray();
    }

    /**
     * Get public settings only.
     */
    public static function getPublicSettings(): array
    {
        return self::public()
            ->get()
            ->mapWithKeys(function ($setting) {
                return [$setting->key => $setting->typed_value];
            })
            ->toArray();
    }

    /**
     * Boot method
     */
    protected static function boot()
    {
        parent::boot();

        // Ensure unique key
        static::creating(function ($model) {
            if (self::where('key', $model->key)->exists()) {
                throw new \Exception("Setting with key '{$model->key}' already exists.");
            }
        });
    }
}
