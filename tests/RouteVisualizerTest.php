<?php

use Illuminate\Support\Facades\Route;

test('route visualizer page loads with or without routes', function () {
    $response = $this->get('/routes');
    $response
        ->assertStatus(200)
        ->assertViewIs('route-visualizer::index')
        ->assertSee('Laravel Route Visualizer')
        ->assertSee('Filter Routes')
        ->assertSee('HTTP Methods:')
        ->assertSee('Middleware:');

    $routes = Route::getRoutes();
    if ($routes->count() === 0) {
        $response->assertSee('No routes match your filters');
    } else {
        $response
            ->assertSee('URI')
            ->assertSee('Action')
            ->assertSee('Name');
    }
});
