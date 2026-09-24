<?php

namespace Xushi\UI\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'xushi:publish')]
class PublishCommand extends Command
{
    protected $signature = 'xushi:publish
                            {components?* : Component name(s) to publish}
                            {--all : Publish all components}
                            {--force : Overwrite existing files}';

    protected $description = 'Publish Xushi UI components and layouts for customization.';

    protected Filesystem $files;

    protected array $publishableComponents = [
        'button', 'badge', 'alert', 'avatar', 'card', 'progress',
        'modal', 'drawer', 'dropdown', 'tooltip', 'popover',
        'input', 'textarea', 'select', 'checkbox', 'radio', 'range', 'file', 'toggle', 'fieldset',
        'theme-toggle',
        'layout/header', 'layout/main', 'layout/sidebar',
        'header/brand', 'header/avatar', 'header/nav',
        'sidebar/brand', 'sidebar/avatar', 'sidebar/label',
        'sidebar/navitem', 'sidebar/navtree', 'sidebar/navtreeitem',
        'separator',
        'heading',
        'text',
        'callout',
        'skeleton',
        'breadcrumbs',
        'breadcrumb/item',
        'accordion',
        'accordion/item',
        'toast',
        'pagination',
        'profile',
        'timeline',
        'timeline/item',
        'carousel',
        'carousel/slide',
        'header/brand', 'header/avatar', 'header/nav', 'header/search',
    ];

    protected array $publishableLayouts = [
        'layouts/layout',
        'layouts/layout2',
        'layouts/layout3',
    ];

    protected array $publishableAuthLayouts = [
        'auth/guest',
        'auth/guest2',
    ];

    protected array $layoutPartials = [
        'layouts/partials/header',
        'layouts/partials/sidebar',
    ];

    protected array $layoutPartialDependencies = [
        'layouts/layout'  => ['layouts/partials/header', 'layouts/partials/sidebar'],
        'layouts/layout2' => ['layouts/partials/sidebar'],
        'layouts/layout3' => ['layouts/partials/header'],
    ];

    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    public function handle(): int
    {
        $targets = $this->option('all')
            ? array_merge(
                $this->publishableComponents,
                $this->publishableLayouts,
                $this->publishableAuthLayouts,
                $this->layoutPartials
            )
            : ($this->argument('components') ?: $this->askWhichComponent());

        $targets = $this->withPartialDependencies($targets);

        foreach ($targets as $component) {
            $this->publishComponent($component);
        }

        return self::SUCCESS;
    }

    protected function withPartialDependencies(array $targets): array
    {
        $withDependencies = $targets;

        foreach ($targets as $target) {
            foreach ($this->layoutPartialDependencies[$target] ?? [] as $partial) {
                if (! in_array($partial, $withDependencies, true)) {
                    $withDependencies[] = $partial;
                }
            }
        }

        return $withDependencies;
    }

    protected function askWhichComponent(): array
    {
        $choice = $this->choice(
            'Which component or layout would you like to publish?',
            array_merge($this->publishableComponents, $this->publishableLayouts, $this->publishableAuthLayouts)
        );

        return [$choice];
    }

    protected function publishComponent(string $component): void
    {
        $force = $this->option('force');

        [$bladeSrc, $bladeDest, $publishLocation] = $this->resolveBladePath($component);

        if ($this->files->exists($bladeSrc)) {
            if ($this->files->exists($bladeDest) && ! $force) {
                $this->components->twoColumnDetail("<fg=yellow>Skipped</> {$component}.blade.php", '<fg=gray>use --force to overwrite</>');
            } else {
                $this->files->ensureDirectoryExists(dirname($bladeDest));
                $this->files->copy($bladeSrc, $bladeDest);
                $this->components->twoColumnDetail(
                    "<fg=green>Published</> {$component}.blade.php",
                    "<fg=gray>{$publishLocation}</>"
                );
            }
        }

        if ($this->isLayoutTarget($component)) {
            return;
        }

        $className = $this->componentToClassName($component);
        $phpSrc    = __DIR__ . '/../Components/' . $className . '.php';
        $phpDest   = app_path('View/Components/Xushi/' . $className . '.php');

        if ($this->files->exists($phpSrc)) {
            if ($this->files->exists($phpDest) && ! $force) {
                $this->components->twoColumnDetail("<fg=yellow>Skipped</> {$className}.php", '<fg=gray>use --force to overwrite</>');
            } else {
                $this->files->ensureDirectoryExists(dirname($phpDest));
                $contents = str_replace(
                    'namespace Xushi\\UI\\Components',
                    'namespace App\\View\\Components\\Xushi',
                    $this->files->get($phpSrc)
                );
                $this->files->put($phpDest, $contents);
                $this->components->twoColumnDetail("<fg=green>Published</> {$className}.php", '<fg=gray>app/View/Components/Xushi/</>');
            }
        }
    }

    protected function componentToClassName(string $component): string
    {
        return collect(explode('/', $component))
            ->map(fn ($part) => str($part)->studly())
            ->implode('/');
    }

    protected function resolveBladePath(string $component): array
        {
            // 1. xushi components → views/components/xushi/
            $componentSrc  = __DIR__ . '/../../stubs/resources/views/components/xushi/' . $component . '.blade.php';
            $componentDest = resource_path('views/components/xushi/' . $component . '.blade.php');

            if ($this->files->exists($componentSrc)) {
                return [$componentSrc, $componentDest, 'resources/views/components/xushi/'];
            }

            // 2. layouts/* and auth/* → views/components/{layouts|auth}/
            //    Source lives in stubs/resources/views/components/{layouts|auth}/
            //    Destination goes to views/components/{layouts|auth}/
            $viewSrc  = __DIR__ . '/../../stubs/resources/views/components/' . $component . '.blade.php';
            $viewDest = resource_path('views/components/' . $component . '.blade.php');

            if ($this->files->exists($viewSrc)) {
                return [$viewSrc, $viewDest, 'resources/views/components/' . dirname($component) . '/'];
            }

            // 3. Legacy fallback for old stub locations (views/layouts/, views/auth/)
            $legacySrc  = __DIR__ . '/../../stubs/resources/views/' . $component . '.blade.php';
            $legacyDest = resource_path('views/components/' . $component . '.blade.php');

            return [$legacySrc, $legacyDest, 'resources/views/components/' . dirname($component) . '/'];
        }

    protected function isLayoutTarget(string $component): bool
    {
        // Anything that is NOT a xushi component (layouts/*, auth/*) has no
        // PHP class to publish alongside the Blade view.
        $componentSrc = __DIR__ . '/../../stubs/resources/views/components/xushi/' . $component . '.blade.php';

        return ! $this->files->exists($componentSrc);
    }
}
