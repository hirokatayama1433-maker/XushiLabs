<?php

namespace Xushi\UI\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'xushi:install')]
class InstallCommand extends Command
{
    protected $signature = 'xushi:install';

    protected $description = 'Check requirements and print the XushiUI setup steps.';

    protected Filesystem $files;

    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    public function handle(): int
    {
        $this->components->info('Setting up XushiUI...');
        $this->newLine();

        $this->ensureAlpineJs();

        $this->newLine();
        $this->components->info('XushiUI is ready (the service provider is auto-discovered via composer.json).');
        $this->newLine();
        $this->line('  <fg=gray>Add to your layout:</>');
        $this->line('  <fg=cyan>@xushiAppearance</> then <fg=cyan>@xushiStyles</> inside <fg=cyan><head></>');
        $this->line('  <fg=cyan>@xushiScripts</> before <fg=cyan></body></>, and load Alpine.js 3 after it');
        $this->newLine();
        $this->line('  <fg=gray>Theme key:</> <fg=cyan>xushitheme-{palette}-{accent}-{mode}-{layout}</>');
        $this->line('  <fg=gray>Default theme:</> <fg=cyan>XushiThemeRegistry::setDefault(\'xushitheme-warm-blue-dark-rounded\')</>');
        $this->line('  <fg=gray>Per page:</> <fg=cyan><html data-xushi-theme="..."></> (a visitor\'s saved choice wins)');
        $this->newLine();

        return self::SUCCESS;
    }

    protected function ensureAlpineJs(): void
    {
        $packageJsonPath = base_path('package.json');

        if (! $this->files->exists($packageJsonPath)) {
            $this->components->warn('package.json not found. Load Alpine.js from a CDN or run: npm install alpinejs');

            return;
        }

        $decoded = json_decode($this->files->get($packageJsonPath), true);
        $all = array_merge($decoded['dependencies'] ?? [], $decoded['devDependencies'] ?? []);

        if (array_key_exists('alpinejs', $all)) {
            $this->components->twoColumnDetail('<fg=green>Found</> Alpine.js', '<fg=gray>alpinejs</>');

            return;
        }

        $this->components->warn('Alpine.js not found in package.json. Use a CDN script tag, or run: npm install alpinejs');
    }
}
