<?php

namespace Xushi\UI;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class XushiAssetManager
{
    public const THEME_STORAGE_KEY = 'xushi-theme';

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

        return static::criticalThemeStyles() . "\n"
            . '<link rel="stylesheet" href="' . url('/xushi/xushi.css?v=' . $version) . '">';
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
        $flags = JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP;

        $script = <<<'JS'
(function () {
    var bases   = __BASES__;
    var accents = __ACCENTS__;
    var layouts = __LAYOUTS__;
    var DEFAULT = __DEFAULT__;
    var STORAGE = __STORAGE__;
    var applied = [];
    var root    = document.documentElement;

    function parse(key) {
        if (typeof key !== 'string' || key.indexOf('xushitheme-') !== 0) return null;
        var p = key.slice(11).split('-');
        if (p.length < 4) return null;
        var layout  = p[p.length - 1];
        var mode    = p[p.length - 2];
        var accent  = p[p.length - 3];
        var palette = p.slice(0, p.length - 3).join('-');
        if (!bases[palette + '-' + mode] || !accents[accent] || !layouts[layout]) return null;
        return { palette: palette, accent: accent, mode: mode, layout: layout };
    }

    function compile(key) {
        var parsed = parse(key);
        if (!parsed) { key = DEFAULT; parsed = parse(key); }

        var tokens = Object.assign(
            {},
            bases[parsed.palette + '-' + parsed.mode],
            accents[parsed.accent],
            layouts[parsed.layout]
        );

        applied.forEach(function (k) {
            if (!(k in tokens)) root.style.removeProperty(k);
        });
        for (var k in tokens) root.style.setProperty(k, tokens[k]);
        applied = Object.keys(tokens);

        root.style.colorScheme = parsed.mode;
        root.setAttribute('data-xushi-theme', key);
        root.setAttribute('data-xushi-mode', parsed.mode);

        return key;
    }

    var stored = null;
    try { stored = localStorage.getItem(STORAGE); } catch (e) {}

    compile(parse(stored) ? stored : (root.getAttribute('data-xushi-theme') || DEFAULT));

    window.XushiCompileTheme     = compile;
    window.XushiThemeParse       = parse;
    window.XushiThemeDefault     = DEFAULT;
    window.XushiThemeStorageKey  = STORAGE;

    try {
        if (localStorage.getItem('xushi-sidebar') === 'true') root.classList.add('sidebar-collapsed');
    } catch (e) {}
})();
JS;

        $script = str_replace(
            ['__BASES__', '__ACCENTS__', '__LAYOUTS__', '__DEFAULT__', '__STORAGE__'],
            [
                json_encode(XushiThemes::$bases, $flags),
                json_encode(XushiThemes::$accents, $flags),
                json_encode(XushiThemes::$layouts, $flags),
                json_encode(XushiThemeRegistry::getDefault(), $flags),
                json_encode(static::THEME_STORAGE_KEY, $flags),
            ],
            $script
        );

        return '<script data-xushi-appearance>' . "\n" . $script . "\n" . '</script>';
    }

    /**
     * Default theme tokens + derived tokens as :root declarations, so the page
     * has color before (or without) the appearance script running.
     */
    protected static function criticalThemeStyles(): string
    {
        $default = XushiThemeRegistry::getDefault();
        $mode    = XushiThemeRegistry::parse($default)['mode'];
        $tokens  = array_merge(XushiThemeRegistry::tokens($default), XushiThemes::$derived);

        $css = 'color-scheme:' . $mode . ';';

        foreach ($tokens as $name => $value) {
            $css .= $name . ':' . $value . ';';
        }

        return '<style data-xushi-critical-theme>:root{' . $css . '}</style>';
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
