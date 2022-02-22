<?php

namespace App\Applozic\Facades;

use App\Applozic\ApplozicManager;
use Illuminate\Support\Facades\Facade;

class Applozic extends Facade
{
    public static function getFacadeAccessor()
    {
        return ApplozicManager::class;
    }
}
