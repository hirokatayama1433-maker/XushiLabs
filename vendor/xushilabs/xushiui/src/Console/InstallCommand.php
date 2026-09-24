<?php

namespace Xushi\UI\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'xushi:install')]
class InstallCommand extends Command
{
    protected $signature = 'xushi:install';

    protected $description = 'Wire XushiUI directives into your Laravel app.';

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
        $this->registerServiceProvider();

        $this->newLine();
        $this->components->info('XushiUI is ready.');
        $this->newLine();
        $this->line('  <fg=gray>Add to your layout:</>');
        $this->line('  <fg=cyan>@xushiStyles</> inside <fg=cyan><head></>');
        $this->line('  <fg=cyan>@xushiScripts</> before <fg=cyan></body></>');
        $this->line('  <fg=cyan>@xushiAppearance</> inside <fg=cyan><head></> (optional, for theme persistence)');
        $this->newLine();
        $this->line('  <fg=gray>Set theme on <html>:</> <fg=cyan>class="light"</> | <fg=cyan>class="dark"</> | <fg=cyan>class="abyss"</>');
        $this->newLine();

        return self::SUCCESS;
    }

    protected function ensureAlpineJs(): void
    {
        $packageJsonPath = base_path('package.json');

        if (! $this->files->exists($packageJsonPath)) {
            $this->components->warn('package.json not found. Install Alpine.js manually: npm install alpinejs');

            return;
        }

        $decoded = json_decode($this->files->get($packageJsonPath), true);
        $all = array_merge($decoded['dependencies'] ?? [], $decoded['devDependencies'] ?? []);

        if (array_key_exists('alpinejs', $all)) {
            $this->components->twoColumnDetail('<fg=green>Found</> Alpine.js', '<fg=gray>alpinejs</>');

            return;
        }

        $this->components->warn('Alpine.js not found in package.json.');
        $this->line('  Run: <fg=cyan>npm install alpinejs</>');
    }

    protected function registerServiceProvider(): void
    {
        $bootstrapPath = base_path('bootstrap/providers.php');

        if (! $this->files->exists($bootstrapPath)) {
            $this->components->warn('bootstrap/providers.php not found. XushiUI auto-discovers via composer.json.');

            return;
        }

        $this->components->twoColumnDetail('<fg=green>Auto-discovered</> XushiServiceProvider', '<fg=gray>via composer.json</>');
    }
}
