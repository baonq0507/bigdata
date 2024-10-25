<?php

namespace Adminftr\Table\Facades;

use Illuminate\Support\Facades\Facade;

class Table extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'table';
    }
}
