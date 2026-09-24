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
    <main class="xushi-auth-shell">
        {{ $slot }}
    </main>

    @xushiScripts
</body>
</html>
