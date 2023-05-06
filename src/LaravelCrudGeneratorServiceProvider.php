<?php

namespace afdav\CrudGeneradorLaravel;

use Illuminate\Support\ServiceProvider;
use afdav\CrudGeneradorLaravel\Commands\GenerateCrudFromTable;

class CrudGeneradorLaravelServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                GenerateCrudFromTable::class,
            ]);
        }
    }
}
