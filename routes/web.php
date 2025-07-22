<?php

use bradisrad83\LaravelRouteVisualizer\Http\Controllers\RouteVisualizerController;
use Illuminate\Support\Facades\Route;

Route::get('/routes', RouteVisualizerController::class)
    ->middleware('web')
    ->name('visualizer.index');
