<?php

namespace Xushi\UI;

class XushiThemeRegistry
{
    protected static string $default = 'xushitheme-neutral-neutral-light-default';

    public static function getThemeNames(): array
    {
        $names = [];

        foreach (array_keys(XushiThemes::$bases) as $base) {
            $lastDash = strrpos($base, '-');
            $palette  = substr($base, 0, $lastDash);
            $mode     = substr($base, $lastDash + 1);

            foreach (array_keys(XushiThemes::$accents) as $accent) {
                foreach (array_keys(XushiThemes::$layouts) as $layout) {
                    $names[] = "xushitheme-{$palette}-{$accent}-{$mode}-{$layout}";
                }
            }
        }

        return $names;
    }

    public static function getDefault(): string
    {
        return static::$default;
    }

    public static function setDefault(string $theme): void
    {
        static::$default = $theme;
    }

    public static function javascriptThemeNames(): string
    {
        return json_encode(static::getThemeNames(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
}