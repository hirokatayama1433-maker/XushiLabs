<?php

namespace Xushi\UI;

class XushiThemeRegistry
{
    /** Key format: xushitheme-{palette}-{accent}-{mode}-{layout} */
    protected static string $default = 'xushitheme-neutral-neutral-light-default';

    public static function getDefault(): string
    {
        return static::$default;
    }

    public static function setDefault(string $theme): void
    {
        if (! static::isValid($theme)) {
            throw new \InvalidArgumentException("Unknown Xushi theme [{$theme}].");
        }

        static::$default = $theme;
    }

    public static function palettes(): array
    {
        $palettes = [];

        foreach (array_keys(XushiThemes::$bases) as $base) {
            $palettes[] = substr($base, 0, strrpos($base, '-'));
        }

        return array_values(array_unique($palettes));
    }

    public static function modes(): array
    {
        return ['light', 'dark'];
    }

    public static function accents(): array
    {
        return array_keys(XushiThemes::$accents);
    }

    public static function layouts(): array
    {
        return array_keys(XushiThemes::$layouts);
    }

    public static function key(string $palette, string $accent, string $mode, string $layout): string
    {
        return "xushitheme-{$palette}-{$accent}-{$mode}-{$layout}";
    }

    /**
     * @return array{palette:string,accent:string,mode:string,layout:string}|null
     */
    public static function parse(string $key): ?array
    {
        if (! str_starts_with($key, 'xushitheme-')) {
            return null;
        }

        $parts = explode('-', substr($key, strlen('xushitheme-')));

        if (count($parts) < 4) {
            return null;
        }

        $layout  = array_pop($parts);
        $mode    = array_pop($parts);
        $accent  = array_pop($parts);
        $palette = implode('-', $parts);

        if (! isset(
            XushiThemes::$bases["{$palette}-{$mode}"],
            XushiThemes::$accents[$accent],
            XushiThemes::$layouts[$layout]
        )) {
            return null;
        }

        return compact('palette', 'accent', 'mode', 'layout');
    }

    public static function isValid(string $key): bool
    {
        return static::parse($key) !== null;
    }

    /**
     * Compiled tokens for a theme key. Falls back to the default theme
     * when the key is unknown.
     */
    public static function tokens(string $key): array
    {
        $parsed = static::parse($key) ?? static::parse(static::$default);

        return array_merge(
            XushiThemes::$bases["{$parsed['palette']}-{$parsed['mode']}"],
            XushiThemes::$accents[$parsed['accent']],
            XushiThemes::$layouts[$parsed['layout']]
        );
    }

    public static function getThemeNames(): array
    {
        $names = [];

        foreach (static::palettes() as $palette) {
            foreach (static::modes() as $mode) {
                foreach (static::accents() as $accent) {
                    foreach (static::layouts() as $layout) {
                        $names[] = static::key($palette, $accent, $mode, $layout);
                    }
                }
            }
        }

        return $names;
    }

    public static function javascriptThemeNames(): string
    {
        return json_encode(static::getThemeNames(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
}
