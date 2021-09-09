<?php

namespace ModStart\Core\Facades;

use Illuminate\Support\Facades\Facade;


class ModStart extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \ModStart\ModStart::class;
    }
}
