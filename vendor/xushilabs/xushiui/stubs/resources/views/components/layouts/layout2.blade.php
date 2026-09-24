<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name') }}</title>
    @xushiAppearance
    @xushiStyles
</head>
<body class="xushimainlayout">

    @include('components.layouts.partials.sidebar')

    <xushi:layout.main>
        {{ $slot }}
    </xushi:layout.main>

    @xushiScripts
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
