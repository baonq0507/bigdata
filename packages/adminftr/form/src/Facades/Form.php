<?php

namespace Adminftr\Form\Facades;

use Illuminate\Support\Facades\Facade;

class Form extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'form';
    }
}
