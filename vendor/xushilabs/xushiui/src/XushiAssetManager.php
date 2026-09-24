<?php

namespace Xushi\UI;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class XushiAssetManager
{
    public static function boot(): void
    {
        $instance = new static();
        $instance->registerRoutes();
    }

    protected function registerRoutes(): void
    {
        Route::get('/xushi/xushi.css', [static::class, 'css']);
        Route::get('/xushi/xushi.js', [static::class, 'js']);
    }

    public function css(): mixed
    {
        return $this->pretendResponseIsFile(__DIR__ . '/../stubs/resources/css/xushi.css', 'text/css');
    }

    public function js(): mixed
    {
        return $this->pretendResponseIsFile(__DIR__ . '/../stubs/resources/js/xushi.js', 'text/javascript');
    }

    public static function renderStyles(): string
    {
        $version = filemtime(__DIR__ . '/../stubs/resources/css/xushi.css');
        $criticalTheme = static::criticalThemeStyles();

        return $criticalTheme . "\n" . '<link rel="stylesheet" href="' . url('/xushi/xushi.css?v=' . $version) . '">';
    }

    public static function renderScripts(): string
    {
        $version = filemtime(__DIR__ . '/../stubs/resources/js/xushi.js');

        return '<script src="' . url('/xushi/xushi.js?v=' . $version) . '" defer></script>';
    }

    public static function renderAppearance(): string
    {
        return static::appearanceScript();
    }

    protected static function appearanceScript(): string
    {
        $bases   = json_encode(XushiThemes::$bases,   JSON_UNESCAPED_UNICODE);
        $accents = json_encode(XushiThemes::$accents, JSON_UNESCAPED_UNICODE);
        $layouts = json_encode(XushiThemes::$layouts, JSON_UNESCAPED_UNICODE);
        $default = XushiThemeRegistry::getDefault();

        return <<<HTML
<script data-xushi-appearance>
(function() {
    var bases   = {$bases};
    var accents = {$accents};
    var layouts = {$layouts};

    function compile(key) {
        var stripped = key.replace('xushitheme-', '');
        var parts    = stripped.split('-');
        var layout   = parts[parts.length - 1];
        var mode     = parts[parts.length - 2];
        var accent   = parts[parts.length - 3];
        var palette  = parts.slice(0, parts.length - 3).join('-');

        var tokens = Object.assign(
            {},
            bases[palette + '-' + mode]   || bases['neutral-light'],
            accents[accent]                || accents['neutral'],
            layouts[layout]                || layouts['default']
        );

        var root = document.documentElement;
        for (var k in tokens) {
            root.style.setProperty(k, tokens[k]);
        }
        root.setAttribute('data-xushi-theme', key);
    }

    var key = document.documentElement.getAttribute('data-xushi-theme') || '{$default}';
    compile(key);

    window.XushiCompileTheme = compile;

    if (localStorage.getItem('xushi-sidebar') === 'true') {
        document.documentElement.classList.add('sidebar-collapsed');
    }
})();
</script>
HTML;
    }

    protected static function criticalThemeStyles(): string
    {
        return <<<'HTML'
<style data-xushi-critical-theme>

</style>
HTML;
    }

    protected function pretendResponseIsFile(string $file, string $contentType): mixed
    {
        $lastModified = filemtime($file);

        return $this->cachedFileResponse(
            $file,
            $contentType,
            $lastModified,
            fn ($headers) => response()->file($file, $headers)
        );
    }

    protected function cachedFileResponse(string $filename, string $contentType, int $lastModified, callable $downloadCallback): mixed
    {
        $expires = strtotime('+1 year');
        $cacheControl = 'public, max-age=31536000';

        if ($this->matchesCache($lastModified)) {
            return response('', 304, [
                'Expires' => $this->httpDate($expires),
                'Cache-Control' => $cacheControl,
            ]);
        }

        return $downloadCallback([
            'Content-Type' => $contentType,
            'Expires' => $this->httpDate($expires),
            'Cache-Control' => $cacheControl,
            'Last-Modified' => $this->httpDate($lastModified),
        ]);
    }

    protected function matchesCache(int $lastModified): bool
    {
        $ifModifiedSince = app(Request::class)->header('if-modified-since');

        return $ifModifiedSince !== null && @strtotime($ifModifiedSince) === $lastModified;
    }

    protected function httpDate(int $timestamp): string
    {
        return sprintf('%s GMT', gmdate('D, d M Y H:i:s', $timestamp));
    }
}