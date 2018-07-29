<?php
namespace Nevoss\Enumeration;

use Illuminate\Support\ServiceProvider;
use Nevoss\Enumeration\Console\EnumMakeCommand;

class EnumerationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                EnumMakeCommand::class,
            ]);
        }
    }
    
    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
    
    }
}
