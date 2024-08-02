<?php

namespace LearnKit\FilamentEnvironment;

class FilamentEnvironment
{
    public static $closure = null;

    public static function gate($closure): void
    {
        static::$closure = $closure;
    }

    public static function allows(): bool
    {
        if (static::$closure === null) {
            return true;
        }

        $method = static::$closure;

        return $method() ?? false;
    }
}