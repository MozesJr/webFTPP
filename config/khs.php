<?php
return [
    /*
    |--------------------------------------------------------------------------
    | KHS File Upload Settings
    |--------------------------------------------------------------------------
    */

    'max_file_size' => env('KHS_UPLOAD_MAX_SIZE', 10240), // KB
    'allowed_mime_types' => ['application/pdf'],
    'allowed_extensions' => ['pdf'],

    /*
    |--------------------------------------------------------------------------
    | Google Drive Settings
    |--------------------------------------------------------------------------
    */

    'gdrive' => [
        'root_folder_name' => 'KHS_Portal_Orang_Tua',
        'folder_permissions' => 'reader', // anyone with link
        'auto_create_folders' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Access Logging
    |--------------------------------------------------------------------------
    */

    'logging' => [
        'enabled' => true,
        'log_views' => true,
        'log_downloads' => true,
        'retention_days' => 365, // Keep logs for 1 year
    ],

    /*
    |--------------------------------------------------------------------------
    | Academic Settings
    |--------------------------------------------------------------------------
    */

    'academic' => [
        'auto_activate_period' => false,
        'allow_multiple_active_periods' => false,
    ]
];
