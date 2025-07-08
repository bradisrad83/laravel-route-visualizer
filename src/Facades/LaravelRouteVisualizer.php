<?php

namespace bradisrad83\LaravelRouteVisualizer\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \bradisrad83\LaravelRouteVisualizer\LaravelRouteVisualizer
 */
class LaravelRouteVisualizer extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \bradisrad83\LaravelRouteVisualizer\LaravelRouteVisualizer::class;
    }
}
