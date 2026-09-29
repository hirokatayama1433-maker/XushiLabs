# Xushi UI

Xushi UI is a CSS token-driven component engine for Laravel + Blade.

```blade
<head>
    @xushiAppearance
    @xushiStyles
</head>
<body>
    <xushi:button variant="solid" color="primary">Save</xushi:button>
    @xushiScripts
    {{-- load Alpine.js 3 after @xushiScripts --}}
</body>
```

## Themes

Key format: `xushitheme-{palette}-{accent}-{mode}-{layout}`

- palettes: neutral, warm, cool, rose, forest, slate
- modes: light, dark
- layouts: rounded, default, sharp

Default theme (e.g. in a service provider):

```php
\Xushi\UI\XushiThemeRegistry::setDefault('xushitheme-warm-blue-dark-rounded');
```

A visitor's saved choice (`localStorage['xushi-theme']`) takes priority over the
`data-xushi-theme` attribute on `<html>`, which takes priority over the default.

## Commands

```bash
php artisan xushi:install
php artisan xushi:publish button modal      # specific components
php artisan xushi:publish --components      # all components
php artisan xushi:publish --layouts         # layouts, auth layouts, partials
php artisan xushi:publish --all --force
```
