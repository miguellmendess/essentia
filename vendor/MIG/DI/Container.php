<?php

namespace MIG\DI;


use App\Conn;

class Container
{
    public static function getModel($modelName)
    {
        $class = "\\App\\Models\\".ucfirst($modelName);
        return new $class(Conn::getDb());
    }
}