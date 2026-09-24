<!DOCTYPE html>
<html data-xushi-theme="xushitheme-neutral-neutral-dark-sharp"
      lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name') }}</title>
    @xushiAppearance
    @xushiStyles
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.9/dist/cdn.min.js"></script>
    @vite('resources/css/app.css')
</head>
<body style="display:flex; justify-content:center; background:var(--xushi-color-base-background);">
    <div class="xushimainlayout">
        @include('components.layouts.partials.header')
        @include('components.layouts.partials.sidebar')

        <xushi:main width="clamp(320px, 100%, 1280px)" padding="20px">
        
            {{ $slot }}
            
        </xushi:main>        
        @xushiScripts
    </div>
</body>
</html>