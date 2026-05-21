# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Package overview

`learnkit/filament-environment` is a small Laravel package that adds a vertical colored bar to the left edge of every Filament v3 panel page, displaying the current `App::environment()` value. It is intended to be installed into a host Laravel + Filament app via Composer path/VCS repository.

There is no test suite, build step, or lint config in this repo — it is a pure PHP library consumed by other apps. Verification happens in the consuming application.

## Architecture

Three pieces wired together by `FilamentEnvironmentServiceProvider`:

- **`FilamentEnvironment` (src/FilamentEnvironment.php)** — static gate. Host apps call `FilamentEnvironment::gate(fn() => ...)` to control whether the bar renders. `allows()` returns `true` when no gate is set, otherwise the closure's return value (coerced via `?? false`).
- **`FilamentEnvironmentServiceProvider`** — auto-registered via `extra.laravel.providers` in `composer.json`. On `boot()` it hooks into `Filament::serving()` and, if `FilamentEnvironment::allows()` passes, registers `PanelsRenderHook::BODY_START` to render the `filament-environment::bar` view. The gate check runs per-request inside `serving()`, so toggling at runtime works.
- **`resources/views/bar.blade.php`** — the bar markup + inline CSS. It pulls the color for the current environment out of `config('filament-environment.mapping')`, falling back to `Arr::first($mapping)` when the env name isn't mapped. It also injects `padding-left: 30px` on `.fi-layout` to make room for the fixed bar.

The `mapping` config key drives env → hex color. The `production` config key lists env names considered production (currently unused by the package itself — it's there for consumers to read via `config()`).

## Conventions specific to this repo

- Requires `php ^8.2`, `filament/filament ^3.2`, `illuminate/support ^10.0|^11.0`. Keep these constraints in sync when upgrading — Filament v3 render hooks (`PanelsRenderHook`) are not API-compatible with v2 or v4.
- The render hook is `BODY_START`, not a panel-scoped hook, so the bar appears on every panel automatically without per-panel `->plugin()` registration. Don't refactor this into a `Filament\Contracts\Plugin` unless you're intentionally changing the install UX.
- Color values live in `config/filament-environment.php` and are merged (not published) via `mergeConfigFrom`. Consumers override by publishing or by defining the same keys in their own config.
