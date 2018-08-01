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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['middleware' => 'profile_json_response'], function () use ($router) {
    
    // Auth
    $router->post('login', 'AuthController@login');
    $router->post('logout', 'AuthController@logout');
    $router->post('refresh', 'AuthController@refresh');
    $router->post('me', 'AuthController@me');
    
    // User
    $router->get('/users', ['as' => 'users.index', 'uses' => 'UserController@index']);
    $router->get('/users/{id}', ['as' => 'users.show', 'uses' => 'UserController@show']);
});

