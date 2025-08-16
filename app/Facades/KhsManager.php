<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class KhsManager extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Services\KhsManagementService::class;
    }
}
