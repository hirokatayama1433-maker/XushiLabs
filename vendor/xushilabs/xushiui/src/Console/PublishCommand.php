<?php

namespace Xushi\UI\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'xushi:publish')]
class PublishCommand extends Command
{
    protected $signature = 'xushi:publish
                            {components?* : Names, e.g. button sidebar-navitem layouts/layout auth/guest}
                            {--all : Publish everything}
                            {--components : Publish all components}
                            {--layouts : Publish all layouts, auth layouts and partials}
                            {--force : Overwrite existing files}';

    protected $description = 'Publish XushiUI components and layouts for customization.';

    protected Filesystem $files;

    /** Layouts that need their partials published with them. */
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
        $available = $this->available();

        if ($available === []) {
            $this->components->error('No publishable views found in the package.');

            return self::FAILURE;
        }

        $groups = array_keys(array_filter([
            'components' => $this->option('components'),
            'layouts'    => $this->option('layouts'),
        ]));

        if ($this->option('all')) {
            $targets = array_keys($available);
        } elseif ($groups !== []) {
            $targets = array_keys(array_filter($available, fn ($item) => in_array($item['group'], $groups, true)));
        } else {
            $targets = $this->argument('components')
                ?: [$this->choice('Which component or layout would you like to publish?', array_keys($available))];
        }

        $targets = $this->withPartialDependencies(
            array_map(fn ($target) => $this->normalize($target, $available), $targets)
        );

        $unknown = false;

        foreach ($targets as $name) {
            if (! isset($available[$name])) {
                $this->components->warn("Unknown component or layout: {$name}");
                $unknown = true;

                continue;
            }

            $this->publish($name, $available[$name]);
        }

        return $unknown ? self::FAILURE : self::SUCCESS;
    }

    /**
     * Everything under stubs/resources/views/components, keyed by publish name:
     *   xushi/button.blade.php          => "button"
     *   layouts/layout.blade.php        => "layouts/layout"
     *   layouts/partials/header.blade.php => "layouts/partials/header"
     */
    protected function available(): array
    {
        $root = __DIR__ . '/../../stubs/resources/views/components';

        if (! is_dir($root)) {
            return [];
        }

        $items = [];

        foreach ($this->files->allFiles($root) as $file) {
            $relative = str_replace('\\', '/', $file->getRelativePathname());

            if (! str_ends_with($relative, '.blade.php')) {
                continue;
            }

            $path        = substr($relative, 0, -strlen('.blade.php'));
            $isComponent = str_starts_with($path, 'xushi/');
            $name        = $isComponent ? substr($path, strlen('xushi/')) : $path;

            $items[$name] = [
                'src'   => $file->getPathname(),
                'dest'  => resource_path('views/components/' . $path . '.blade.php'),
                'where' => 'resources/views/components/' . dirname($path) . '/',
                'group' => $isComponent ? 'components' : 'layouts',
            ];
        }

        ksort($items);

        return $items;
    }

    protected function normalize(string $target, array $available): string
    {
        $target = trim(str_replace('.blade.php', '', $target), '/');

        if (isset($available[$target])) {
            return $target;
        }

        if (str_starts_with($target, 'xushi/')) {
            $target = substr($target, strlen('xushi/'));
        }

        // Legacy nested names: sidebar/brand => sidebar-brand
        $flat = str_replace(['/', '.'], '-', $target);

        return isset($available[$flat]) ? $flat : $target;
    }

    protected function withPartialDependencies(array $targets): array
    {
        $all = $targets;

        foreach ($targets as $target) {
            foreach ($this->layoutPartialDependencies[$target] ?? [] as $partial) {
                if (! in_array($partial, $all, true)) {
                    $all[] = $partial;
                }
            }
        }

        return array_values(array_unique($all));
    }

    protected function publish(string $name, array $item): void
    {
        if ($this->files->exists($item['dest']) && ! $this->option('force')) {
            $this->components->twoColumnDetail("<fg=yellow>Skipped</> {$name}.blade.php", '<fg=gray>use --force to overwrite</>');

            return;
        }

        $this->files->ensureDirectoryExists(dirname($item['dest']));
        $this->files->copy($item['src'], $item['dest']);

        $this->components->twoColumnDetail("<fg=green>Published</> {$name}.blade.php", "<fg=gray>{$item['where']}</>");
    }
}
