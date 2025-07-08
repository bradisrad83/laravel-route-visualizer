<?php

use Illuminate\Support\Facades\Route;
use bradisrad83\LaravelRouteVisualizer\Http\Controllers\RouteVisualizerController;

Route::middleware('web')->get('/routes', [RouteVisualizerController::class, 'index'])->name('visualizer.index');

