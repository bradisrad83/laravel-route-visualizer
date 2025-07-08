<?php

use bradisrad83\LaravelRouteVisualizer\Http\Controllers\RouteVisualizerController;
use Illuminate\Support\Facades\Route;

Route::middleware('web')->get('/routes', [RouteVisualizerController::class, 'index'])->name('visualizer.index');
