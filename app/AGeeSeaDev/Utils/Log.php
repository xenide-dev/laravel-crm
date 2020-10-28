<?php

namespace App\AGeeSeaDev\Utils;

use Illuminate\Support\Facades\Log as ILog;

class Log
{

    public static function __callStatic($name, $arguments)
    {
        try {
            ILog::$name(...$arguments);
        }catch (\Exception $exception) {

        }
    }
}
