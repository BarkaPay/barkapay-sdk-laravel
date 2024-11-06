<?php

namespace BarkapayLaravel\Facades;

use Illuminate\Support\Facades\Facade;

class BarkaPay extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'barkapay';
    }
}
