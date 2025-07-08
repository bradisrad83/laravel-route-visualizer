<?php
use Illuminate\Support\Facades\Route;

test('route visualizer page loads with or without routes', function () {
    $response = $this->get('/routes');
    $response->assertStatus(200);
    $response->assertViewIs('route-visualizer::index');
    $response->assertSee('Laravel Route Visualizer');
    $response->assertSee('Filter Routes');
    $response->assertSee('HTTP Methods:');
    $response->assertSee('Middleware:');

    $routes = Route::getRoutes();   
    if ($routes->count() === 0) {
        $response->assertSee('No routes match your filters');
    } else {
        $response->assertSee('URI');
        $response->assertSee('Action');
        $response->assertSee('Name');
    }
});