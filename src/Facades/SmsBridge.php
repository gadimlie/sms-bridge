<?php

namespace Gadimlie\SmsBridge\Facades;

use Illuminate\Support\Facades\Facade;

class SmsBridge extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Gadimlie\SmsBridge\SmsBridgeManager::class;
    }
}
