<?php
namespace Czim\LaravelLocalizationRouteCache\Commands;

use Czim\LaravelLocalizationRouteCache\Traits\TranslatedRouteCommandContext;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class RouteTranslationsClearCommand extends Command
{
    use TranslatedRouteCommandContext;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'route:trans:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove the translated route cache files for each locale';

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Create a new route clear command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        foreach ($this->getSupportedLocales() as $locale) {

            $path = $this->makeLocaleRoutesPath($locale);

            if ($this->files->exists($path)) {
                $this->files->delete($path);
            }
        }

        $path = $this->laravel->getCachedRoutesPath();

        if ($this->files->exists($path)) {
            $this->files->delete($path);
        }

        $this->info('Route caches for locales cleared!');
    }

}
