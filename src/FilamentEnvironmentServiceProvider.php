<?php

namespace LearnKit\FilamentEnvironment;

use Filament\Facades\Filament;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\ServiceProvider;

class FilamentEnvironmentServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/filament-environment.php', 'filament-environment');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'filament-environment');
    }

    public function boot()
    {
        Filament::serving(function () {
            if (! FilamentEnvironment::allows()) {
                return;
            }

            $display = config('filament-environment.display', 'bar');

            if (in_array($display, ['bar', 'both'], true)) {
                Filament::registerRenderHook(PanelsRenderHook::BODY_START, fn() => view('filament-environment::bar'));
            }

            if (in_array($display, ['badge', 'both'], true)) {
                Filament::registerRenderHook(PanelsRenderHook::GLOBAL_SEARCH_BEFORE, fn() => view('filament-environment::badge'));
            }
        });
    }
}
