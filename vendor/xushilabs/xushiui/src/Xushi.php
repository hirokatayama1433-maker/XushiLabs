<?php

namespace Xushi\UI;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Xushi\UI\XushiManager
 */
class Xushi extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return 'xushi';
    }
}
