<?php

namespace Nevoss\Enumeration\Tests;

use Nevoss\Enumeration\EnumerationServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    /**
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            EnumerationServiceProvider::class
        ];
    }
}
