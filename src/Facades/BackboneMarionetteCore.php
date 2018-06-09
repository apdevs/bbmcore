<?php

namespace APDevs\BackboneMarionetteCore\Facades;

use Illuminate\Support\Facades\Facade;

class BackboneMarionetteCore extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'bbmcore';
    }
}
