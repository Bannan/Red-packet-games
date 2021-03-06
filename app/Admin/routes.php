<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->get('/api/users', 'UserController@users');

    $router->resources([
        'games' => 'GameController',
        'screenings' => 'ScreeningController',
        'levels' => 'LevelController',
        'users' => 'UserController',
    ]);
});
