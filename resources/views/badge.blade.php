@php
    use LearnKit\FilamentEnvironment\FilamentEnvironment;

    $environment = \Illuminate\Support\Facades\App::environment();
    $bgColor = FilamentEnvironment::color($environment);

    $hex = ltrim($bgColor, '#');
    if (strlen($hex) === 3) {
        $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
    }
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    $brightness = ($r * 299 + $g * 587 + $b * 114) / 1000;
    $textColor = $brightness > 140 ? '#000000' : '#ffffff';
@endphp

<div
    class="fi-environment-badge"
    style="background-color: {{ $bgColor }}; color: {{ $textColor }};"
>
    {{ $environment }}
</div>

<style>
    .fi-environment-badge {
        display: inline-flex;
        align-items: center;
        height: 1.75rem;
        padding: 0 0.625rem;
        margin-right: 0.75rem;
        border-radius: 0.5rem;
        font-size: 0.75rem;
        font-weight: 700;
        line-height: 1;
        letter-spacing: 0.025em;
        text-transform: uppercase;
        white-space: nowrap;
    }
</style>