<?php

namespace AmirSasani\GemSystem\Facades;


use Illuminate\Support\Facades\Facade;

class GemService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'gemService';
    }
}
