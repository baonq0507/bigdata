<?php

namespace Adminftr\Messages\Facades;

use Illuminate\Support\Facades\Facade;

class Messages extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'messages';
    }
}
