<?php

namespace Xushi\UI;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\ComponentAttributeBag;

class XushiServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(XushiManager::class);
        $this->app->alias(XushiManager::class, 'xushi');

        $loader = AliasLoader::getInstance();
        $loader->alias('Xushi', Xushi::class);
    }

    public function boot(): void
    {
        $this->bootComponents();
        $this->bootLayouts();
        $this->bootTagCompiler();
        $this->bootAssetManager();
        $this->bootDirectives();
        $this->bootMacros();
        $this->bootCommands();
    }

    protected function bootComponents(): void
    {
        $packageViewPath = __DIR__ . '/../stubs/resources/views/components/xushi';

        $this->loadViewsFrom($packageViewPath, 'xushi');

        if (function_exists('resource_path') && file_exists(resource_path('views/components/xushi'))) {
            Blade::anonymousComponentPath(resource_path('views/components/xushi'), 'xushi');
        }

        Blade::anonymousComponentPath($packageViewPath, 'xushi');
    }

    protected function bootLayouts(): void
    {
        // User-published layouts — registered with no prefix so
        // <x-layouts.layout> resolves to resources/views/layouts/layout.blade.php
        // and <x-auth.guest> resolves to resources/views/auth/guest.blade.php
        if (function_exists('resource_path') && file_exists(resource_path('views/components/layouts'))) {
            Blade::anonymousComponentPath(resource_path('views/components/layouts'), 'layouts');
        }

        if (function_exists('resource_path') && file_exists(resource_path('views/components/auth'))) {
            Blade::anonymousComponentPath(resource_path('views/components/auth'), 'auth');
        }
    }

    protected function bootTagCompiler(): void
    {
        $compiler = new XushiTagCompiler(
            app('blade.compiler')->getClassComponentAliases(),
            app('blade.compiler')->getClassComponentNamespaces(),
            app('blade.compiler')
        );

        app()->bind('xushi.compiler', fn () => $compiler);

        app('blade.compiler')->precompiler(function ($value) use ($compiler) {
            return $compiler->compile($value);
        });
    }

    protected function bootAssetManager(): void
    {
        XushiAssetManager::boot();
    }

    protected function bootDirectives(): void
    {
        Blade::directive('xushiStyles', fn () => "<?php echo app('xushi')->renderStyles(); ?>");
        Blade::directive('xushiScripts', fn () => "<?php echo app('xushi')->renderScripts(); ?>");
        Blade::directive('xushiAppearance', fn () => "<?php echo app('xushi')->renderAppearance(); ?>");
    }

    protected function bootMacros(): void
    {
        ComponentAttributeBag::macro('pluck', function ($key, $default = null) {
            $result = $this->get($key);
            unset($this->attributes[$key]);

            return $result ?? $default;
        });
    }

    protected function bootCommands(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            Console\InstallCommand::class,
            Console\PublishCommand::class,
        ]);
    }
}
