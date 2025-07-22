<?php

namespace bradisrad83\LaravelRouteVisualizer\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;

class RouteVisualizerController
{
    public function __invoke(): View
    {
        $groupedRoutes = collect(Route::getRoutes())
            ->map(function ($route): array {
                $middleware = $route->middleware();

                $group = in_array('web', $middleware) ? 'Web'
                    : (in_array('api', $middleware) ? 'API' : 'Other');

                return [
                    'group' => $group,
                    'method' => implode('|', $route->methods()),
                    'uri' => $route->uri(),
                    'name' => $route->getName(),
                    'action' => $route->getActionName(),
                    'middleware' => implode(', ', $middleware),
                ];
            })
            ->groupBy('group')
            ->toArray();

        return view('route-visualizer::index', [
            'groupedRoutes' => $groupedRoutes,
        ]);
    }
}
