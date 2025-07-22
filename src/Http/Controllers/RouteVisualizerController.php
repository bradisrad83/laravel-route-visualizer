<?php

namespace bradisrad83\LaravelRouteVisualizer\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Routing\Route as LaravelRoute;
use Illuminate\Support\Facades\Route;

class RouteVisualizerController
{
    public function __invoke(): View
    {
        $routes = iterator_to_array(Route::getRoutes()->getIterator());

        $groupedRoutes = collect($routes)
            ->map(function (LaravelRoute $route): array {
                $middleware = $route->middleware();

                // Ensure middleware is an array
                $middlewareArray = is_array($middleware) ? $middleware : [];

                $group = in_array('web', $middlewareArray) ? 'Web'
                    : (in_array('api', $middlewareArray) ? 'API' : 'Other');

                return [
                    'group' => $group,
                    'method' => implode('|', $route->methods()),
                    'uri' => $route->uri(),
                    'name' => $route->getName(),
                    'action' => $route->getActionName(),
                    'middleware' => implode(', ', $middlewareArray),
                ];
            })
            ->groupBy('group')
            ->toArray();

        return view('route-visualizer::index', [
            'groupedRoutes' => $groupedRoutes,
        ]);
    }
}
