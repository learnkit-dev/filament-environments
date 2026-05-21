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

    public static function color(?string $environment = null): string
    {
        $environment ??= \Illuminate\Support\Facades\App::environment();

        $mapping = config('filament-environment.mapping', []);

        return $mapping[$environment] ?? \Illuminate\Support\Arr::first($mapping) ?? '#000000';
    }
}