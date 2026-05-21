# Filament Environment

A small Laravel package that adds a vertical colored bar to the left edge of every [Filament](https://filamentphp.com) panel page, showing the current `App::environment()` value. Useful for instantly knowing whether you are looking at `local`, `staging`, or `production` when juggling multiple tabs.

Supports Filament **v3, v4 and v5**.

## Installation

```bash
composer require learnkit/filament-environment
```

The service provider is auto-discovered via `extra.laravel.providers`, so no further wiring is required.

## Configuration

Publish the config file if you want to customise the colors:

```bash
php artisan vendor:publish --tag=config --provider="LearnKit\FilamentEnvironment\FilamentEnvironmentServiceProvider"
```

Or simply create `config/filament-environment.php` with the keys you want to override — the package uses `mergeConfigFrom`, so partial overrides work.

```php
return [
    'mapping' => [
        'local'      => '#FFDB58',
        'dev'        => '#FFDB58',
        'staging'    => '#D2042D',
        'prod'       => '#4169E1',
        'production' => '#4169E1',
    ],

    'production' => [
        'prod', 'production',
    ],
];
```

- **`mapping`** — maps the value returned by `App::environment()` to a hex color. If the current environment is not in the map, the first entry is used as fallback.
- **`production`** — a list of environment names you consider "production". The package itself does not act on this; it is exposed so consumers can read it via `config('filament-environment.production')`.

## Conditionally hiding the bar

Use the static `gate()` method (e.g. from `AppServiceProvider::boot()`) to control when the bar should render. The gate runs on every request inside `Filament::serving()`, so you can rely on runtime state like the authenticated user:

```php
use LearnKit\FilamentEnvironment\FilamentEnvironment;

FilamentEnvironment::gate(fn () => auth()->user()?->isAdmin() ?? false);
```

When no gate is set, the bar is always shown.

## How it works

On `Filament::serving()` the service provider registers a `PanelsRenderHook::BODY_START` hook that renders `resources/views/bar.blade.php`. Because `BODY_START` is panel-agnostic, the bar appears in every Filament panel without per-panel plugin registration. The view also injects a small amount of inline CSS to give `.fi-layout` a `padding-left` so the panel content does not sit underneath the bar.

## License

Proprietary — © LearnKit.
