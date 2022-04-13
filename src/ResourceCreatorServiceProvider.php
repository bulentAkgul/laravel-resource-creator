<?php

namespace Bakgul\ResourceCreator;

use Bakgul\Kernel\Concerns\HasConfig;
use Illuminate\Support\ServiceProvider;

class ResourceCreatorServiceProvider extends ServiceProvider
{
    use HasConfig;

    public function boot()
    {
        $this->commands([
            \Bakgul\ResourceCreator\Commands\CreateResourceCommand::class,
        ]);
    }

    public function register()
    {
        $this->registerConfigs(__DIR__ . DIRECTORY_SEPARATOR . '..');
    }
}
