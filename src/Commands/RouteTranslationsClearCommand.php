<?php
namespace Czim\LaravelLocalizationRouteCache\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class RouteTranslationsClearCommand extends Command
{

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
        foreach ($this->getActiveLocales() as $locale) {

            $this->files->delete(
                $this->makeLocaleRoutesPath($locale)
            );
        }

        $this->files->delete($this->laravel->getCachedRoutesPath());

        $this->info('Route caches for locales cleared!');
    }

    /**
     * @return string[]
     */
    protected function getActiveLocales()
    {
        return $this->getLaravelLocalization()->getSupportedLanguagesKeys();
    }

    /**
     * @param string $locale
     * @return string
     */
    protected function makeLocaleRoutesPath($locale)
    {
        $path = $this->laravel->getCachedRoutesPath();

        return substr($path, 0, -4) . '_' . $locale . '.php';
    }

    /**
     * @return \Mcamara\LaravelLocalization
     */
    protected function getLaravelLocalization()
    {
        return $this->laravel->make('laravellocalization');
    }

}
