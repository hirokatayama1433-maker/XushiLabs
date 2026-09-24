<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name') }}</title>
    @xushiAppearance
    @xushiStyles
</head>
<body>
    <div style="display:grid; grid-template-columns:1fr 1fr; min-height:100vh;">

        {{-- Branding panel — hidden on mobile, visible on desktop via .xushi-auth-split-panel in xushi.css --}}
        <div
            class="xushi-auth-split-panel"
            style="display:flex; flex-direction:column; align-items:center; justify-content:center; padding:3rem; background:var(--xushi-color-primary); color:var(--xushi-color-primary-content);"
        >
            @isset($branding)
                {{ $branding }}
            @else
                <span style="font-size:1.5rem; font-weight:700;">{{ config('app.name') }}</span>
            @endisset
        </div>

        {{-- Form content --}}
        <main style="display:flex; align-items:center; justify-content:center; padding:3rem;">
            {{ $slot }}
        </main>

    </div>

    @xushiScripts
</body>
</html>
