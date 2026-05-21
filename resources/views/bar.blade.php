@php
    $environment = \Illuminate\Support\Facades\App::environment();

    $mapping = config('filament-environment.mapping');

    $bgColor = $mapping[$environment] ?? \Illuminate\Support\Arr::first($mapping);
@endphp

<div class="fi-environment-bar fixed top-0 left-0 h-screen font-bold text-xl" style="width: 30px;background-color: {{ $bgColor }};z-index: 40;">
    <span class="text">{{ $environment }}</span>
</div>

<style>
    .fi-body {
        padding-left: 30px;
    }

    .fi-environment-bar {
        padding-top: 15px;
    }

    .fi-environment-bar .text {
        writing-mode: vertical-rl;
        text-orientation: mixed;
        transform: rotate(180deg);
    }
</style>
