<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->post('/api/users', 'AuthController@register');
$router->post('/api/users/login', 'AuthController@login');
$router->get('/api/users/activate', 'AuthController@activate');
$router->get('/api/users/me', 'AuthController@currentUser');

$router->get('/', function () use ($router) {
    return $router->app->version();
});
