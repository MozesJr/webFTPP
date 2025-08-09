<?php

namespace App\Helpers;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;

class SiteSettingsHelper
{
    /**
     * Cache duration in minutes
     */
    const CACHE_DURATION = 60;

    /**
     * Get a setting value by key with caching
     */
    public static function get($key, $default = null)
    {
        $cacheKey = "site_setting_{$key}";

        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($key, $default) {
            $setting = SiteSetting::where('key_name', $key)->first();

            if (!$setting) {
                return $default;
            }

            // Return formatted value based on type
            switch ($setting->type) {
                case 'boolean':
                    return (bool) $setting->getRawValueAttribute();
                case 'number':
                    return is_numeric($setting->getRawValueAttribute())
                        ? (float) $setting->getRawValueAttribute()
                        : $default;
                case 'file':
                    return $setting->getRawValueAttribute()
                        ? asset('storage/' . $setting->getRawValueAttribute())
                        : $default;
                default:
                    return $setting->getRawValueAttribute() ?: $default;
            }
        });
    }

    /**
     * Get multiple settings by group
     */
    public static function getGroup($group)
    {
        $cacheKey = "site_settings_group_{$group}";

        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($group) {
            $settings = SiteSetting::where('group', $group)->get();

            $result = [];
            foreach ($settings as $setting) {
                $result[$setting->key_name] = self::get($setting->key_name);
            }

            return $result;
        });
    }

    /**
     * Get all settings grouped by category
     */
    public static function getAllGrouped()
    {
        $cacheKey = "site_settings_all_grouped";

        return Cache::remember($cacheKey, self::CACHE_DURATION, function () {
            $settings = SiteSetting::orderBy('group')->orderBy('key_name')->get();

            $grouped = [];
            foreach ($settings as $setting) {
                $grouped[$setting->group][$setting->key_name] = self::get($setting->key_name);
            }

            return $grouped;
        });
    }

    /**
     * Set a setting value
     */
    public static function set($key, $value, $type = 'text', $group = 'general', $description = null)
    {
        $setting = SiteSetting::updateOrCreate(
            ['key_name' => $key],
            [
                'value' => $value,
                'type' => $type,
                'group' => $group,
                'description' => $description
            ]
        );

        // Clear cache
        self::clearCache($key, $group);

        return $setting;
    }

    /**
     * Clear cache for specific setting or group
     */
    public static function clearCache($key = null, $group = null)
    {
        if ($key) {
            Cache::forget("site_setting_{$key}");
        }

        if ($group) {
            Cache::forget("site_settings_group_{$group}");
        }

        // Clear all grouped cache
        Cache::forget("site_settings_all_grouped");
    }

    /**
     * Clear all settings cache
     */
    public static function clearAllCache()
    {
        $settings = SiteSetting::all();

        foreach ($settings as $setting) {
            Cache::forget("site_setting_{$setting->key_name}");
            Cache::forget("site_settings_group_{$setting->group}");
        }

        Cache::forget("site_settings_all_grouped");
    }

    /**
     * Share common settings with all views
     */
    public static function shareWithViews()
    {
        $commonSettings = [
            'site_title' => self::get('site_title', 'My Website'),
            'site_description' => self::get('site_description', ''),
            'site_logo' => self::get('site_logo'),
            'contact_email' => self::get('contact_email'),
            'contact_phone' => self::get('contact_phone'),
            'facebook_url' => self::get('facebook_url'),
            'instagram_url' => self::get('instagram_url'),
            'twitter_url' => self::get('twitter_url'),
            'theme_color' => self::get('theme_color', '#3B82F6'),
        ];

        View::share('siteSettings', $commonSettings);
    }

    /**
     * Get SEO meta tags
     */
    public static function getSeoMeta($pageTitle = null, $pageDescription = null)
    {
        $siteTitle = self::get('site_title', 'My Website');
        $siteDescription = self::get('site_description', '');
        $siteLogo = self::get('site_logo');

        $title = $pageTitle ? "{$pageTitle} - {$siteTitle}" : $siteTitle;
        $description = $pageDescription ?: $siteDescription;

        return [
            'title' => $title,
            'description' => $description,
            'og_title' => $title,
            'og_description' => $description,
            'og_image' => $siteLogo,
            'twitter_title' => $title,
            'twitter_description' => $description,
            'twitter_image' => $siteLogo,
        ];
    }

    /**
     * Export settings to array (for backup)
     */
    public static function exportSettings()
    {
        $settings = SiteSetting::all();

        $export = [];
        foreach ($settings as $setting) {
            $export[] = [
                'key_name' => $setting->key_name,
                'value' => $setting->getRawValueAttribute(),
                'type' => $setting->type,
                'group' => $setting->group,
                'description' => $setting->description,
            ];
        }

        return $export;
    }

    /**
     * Import settings from array
     */
    public static function importSettings($settingsArray)
    {
        foreach ($settingsArray as $settingData) {
            SiteSetting::updateOrCreate(
                ['key_name' => $settingData['key_name']],
                [
                    'value' => $settingData['value'],
                    'type' => $settingData['type'],
                    'group' => $settingData['group'],
                    'description' => $settingData['description'] ?? null,
                ]
            );
        }

        // Clear all cache after import
        self::clearAllCache();
    }

    /**
     * Get settings for frontend API
     */
    public static function getPublicSettings()
    {
        $publicKeys = [
            'site_title',
            'site_description',
            'site_logo',
            'theme_color',
            'contact_email',
            'contact_phone',
            'facebook_url',
            'instagram_url',
            'twitter_url',
            'address'
        ];

        $settings = [];
        foreach ($publicKeys as $key) {
            $settings[$key] = self::get($key);
        }

        return $settings;
    }
}
