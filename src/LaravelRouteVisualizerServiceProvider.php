<?php

namespace bradisrad83\LaravelRouteVisualizer;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelRouteVisualizerServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-route-visualizer')
            ->hasRoutes('web')
            ->hasViews();
    }
}
