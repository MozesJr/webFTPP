<?php
// app/Models/SiteSetting.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key_name',
        'value',
        'type',
        'description',
        'group'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Cache settings for performance
    protected static $settingsCache = null;

    // Boot method to clear cache when settings change
    protected static function booted()
    {
        static::saved(function () {
            Cache::forget('site_settings');
            static::$settingsCache = null;
        });

        static::deleted(function () {
            Cache::forget('site_settings');
            static::$settingsCache = null;
        });
    }

    /**
     * Get setting value by key
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get($key, $default = null)
    {
        // Load all settings into cache
        if (static::$settingsCache === null) {
            static::$settingsCache = Cache::remember('site_settings', 3600, function () {
                return static::all()->pluck('value', 'key_name')->toArray();
            });
        }

        $value = static::$settingsCache[$key] ?? null;

        if ($value === null) {
            return $default;
        }

        // Get the setting record to determine type
        $setting = static::where('key_name', $key)->first();

        if (!$setting) {
            return $default;
        }

        return static::castValue($value, $setting->type);
    }

    /**
     * Set setting value
     *
     * @param string $key
     * @param mixed $value
     * @param string $type
     * @param string|null $description
     * @param string $group
     * @return SiteSetting
     */
    public static function set($key, $value, $type = 'text', $description = null, $group = 'general')
    {
        $processedValue = static::processValue($value, $type);

        return static::updateOrCreate(
            ['key_name' => $key],
            [
                'value' => $processedValue,
                'type' => $type,
                'description' => $description,
                'group' => $group
            ]
        );
    }

    /**
     * Get multiple settings by group
     *
     * @param string $group
     * @return array
     */
    public static function getGroup($group)
    {
        $settings = static::where('group', $group)->get();
        $result = [];

        foreach ($settings as $setting) {
            $result[$setting->key_name] = static::castValue($setting->value, $setting->type);
        }

        return $result;
    }

    /**
     * Get all settings grouped by group
     *
     * @return array
     */
    public static function getAllGrouped()
    {
        $settings = static::all();
        $grouped = [];

        foreach ($settings as $setting) {
            $grouped[$setting->group][$setting->key_name] = static::castValue($setting->value, $setting->type);
        }

        return $grouped;
    }

    /**
     * Process value based on type before saving
     *
     * @param mixed $value
     * @param string $type
     * @return string
     */
    protected static function processValue($value, $type)
    {
        return match ($type) {
            'boolean' => $value ? '1' : '0',
            'number' => (string) $value,
            'json' => json_encode($value),
            'array' => json_encode($value),
            default => (string) $value
        };
    }

    /**
     * Cast value to appropriate type
     *
     * @param string $value
     * @param string $type
     * @return mixed
     */
    protected static function castValue($value, $type)
    {
        return match ($type) {
            'boolean' => (bool) $value,
            'number' => is_numeric($value) ? (float) $value : 0,
            'integer' => (int) $value,
            'json' => json_decode($value, true) ?? [],
            'array' => json_decode($value, true) ?? [],
            default => $value
        };
    }

    /**
     * Check if setting exists
     *
     * @param string $key
     * @return bool
     */
    public static function has($key)
    {
        return static::where('key_name', $key)->exists();
    }

    /**
     * Remove setting
     *
     * @param string $key
     * @return bool
     */
    public static function remove($key)
    {
        return static::where('key_name', $key)->delete();
    }

    /**
     * Get setting with type information
     *
     * @param string $key
     * @return array|null
     */
    public static function getWithType($key)
    {
        $setting = static::where('key_name', $key)->first();

        if (!$setting) {
            return null;
        }

        return [
            'key' => $setting->key_name,
            'value' => static::castValue($setting->value, $setting->type),
            'type' => $setting->type,
            'description' => $setting->description,
            'group' => $setting->group
        ];
    }

    /**
     * Bulk set settings
     *
     * @param array $settings
     * @return bool
     */
    public static function setBulk(array $settings)
    {
        foreach ($settings as $key => $data) {
            if (is_array($data)) {
                static::set(
                    $key,
                    $data['value'],
                    $data['type'] ?? 'text',
                    $data['description'] ?? null,
                    $data['group'] ?? 'general'
                );
            } else {
                static::set($key, $data);
            }
        }

        return true;
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

    // Accessors
    public function getValueAttribute($value)
    {
        return static::castValue($value, $this->type);
    }

    public function getRawValueAttribute()
    {
        return $this->attributes['value'];
    }

    // Mutators
    public function setValueAttribute($value)
    {
        $this->attributes['value'] = static::processValue($value, $this->type);
    }

    /**
     * Common website settings structure
     */
    public static function getDefaultSettings()
    {
        return [
            // General Settings
            'site_title' => [
                'value' => 'Fakultas Website',
                'type' => 'text',
                'description' => 'Website title displayed in browser tab',
                'group' => 'general'
            ],
            'site_description' => [
                'value' => 'Official website of our faculty',
                'type' => 'text',
                'description' => 'Website description for SEO',
                'group' => 'general'
            ],
            'site_logo' => [
                'value' => '',
                'type' => 'file',
                'description' => 'Main website logo',
                'group' => 'general'
            ],
            'contact_email' => [
                'value' => 'info@fakultas.ac.id',
                'type' => 'email',
                'description' => 'Main contact email',
                'group' => 'contact'
            ],
            'contact_phone' => [
                'value' => '+62 21 1234567',
                'type' => 'text',
                'description' => 'Main contact phone',
                'group' => 'contact'
            ],
            'address' => [
                'value' => 'Jl. Contoh No. 123, Jakarta',
                'type' => 'textarea',
                'description' => 'Faculty address',
                'group' => 'contact'
            ],

            // SEO Settings
            'meta_keywords' => [
                'value' => 'fakultas, universitas, pendidikan',
                'type' => 'text',
                'description' => 'Default meta keywords',
                'group' => 'seo'
            ],
            'google_analytics_id' => [
                'value' => '',
                'type' => 'text',
                'description' => 'Google Analytics tracking ID',
                'group' => 'seo'
            ],

            // Social Media
            'facebook_url' => [
                'value' => '',
                'type' => 'url',
                'description' => 'Facebook page URL',
                'group' => 'social'
            ],
            'instagram_url' => [
                'value' => '',
                'type' => 'url',
                'description' => 'Instagram profile URL',
                'group' => 'social'
            ],
            'youtube_url' => [
                'value' => '',
                'type' => 'url',
                'description' => 'YouTube channel URL',
                'group' => 'social'
            ],

            // Appearance
            'theme_color' => [
                'value' => '#3B82F6',
                'type' => 'color',
                'description' => 'Primary theme color',
                'group' => 'appearance'
            ],
            'items_per_page' => [
                'value' => 10,
                'type' => 'number',
                'description' => 'Number of items per page in listings',
                'group' => 'general'
            ],

            // Features
            'enable_news' => [
                'value' => true,
                'type' => 'boolean',
                'description' => 'Enable news section',
                'group' => 'features'
            ],
            'enable_events' => [
                'value' => true,
                'type' => 'boolean',
                'description' => 'Enable events section',
                'group' => 'features'
            ],
            'enable_gallery' => [
                'value' => true,
                'type' => 'boolean',
                'description' => 'Enable photo gallery',
                'group' => 'features'
            ]
        ];
    }

    /**
     * Initialize default settings
     */
    public static function initializeDefaults()
    {
        $defaults = static::getDefaultSettings();

        foreach ($defaults as $key => $data) {
            if (!static::has($key)) {
                static::set(
                    $key,
                    $data['value'],
                    $data['type'],
                    $data['description'],
                    $data['group']
                );
            }
        }
    }
}
