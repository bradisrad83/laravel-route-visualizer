<?php

namespace bradisrad83\LaravelRouteVisualizer\Tests;

use bradisrad83\LaravelRouteVisualizer\LaravelRouteVisualizerServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            LaravelRouteVisualizerServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('app.key', 'base64:'.base64_encode(random_bytes(32)));
    }
}
