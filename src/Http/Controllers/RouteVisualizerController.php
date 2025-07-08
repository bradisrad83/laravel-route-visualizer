<?php

namespace bradisrad83\LaravelRouteVisualizer\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Route;

class RouteVisualizerController extends Controller
{
    public function index()
    {

        $allRoutes = collect(Route::getRoutes());

        $groupedRoutes = [
            'Web' => [],
            'API' => [],
            'Other' => [],
        ];

        foreach ($allRoutes as $route) {
            $middleware = collect($route->middleware());
            $group = $middleware->contains('web') ? 'Web' :
                     ($middleware->contains('api') ? 'API' : 'Other');

            $groupedRoutes[$group][] = [
                'method' => implode('|', $route->methods()),
                'uri' => $route->uri(),
                'name' => $route->getName(),
                'action' => $route->getActionName(),
                'middleware' => implode(', ', $route->middleware()),
            ];
        }

        return view('route-visualizer::index', [
            'groupedRoutes' => $groupedRoutes,
            'csrfToken' => csrf_token(),
        ]);
    }
}
