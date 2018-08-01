<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['middleware' => 'profile_json_response', 'namespace' => 'App\Http\Controllers\Api\V1'], function ($api) {

    // Auth
    $api->post('register', 'ApiAuthController@register');
    $api->post('login', 'ApiAuthController@login');
    $api->post('logout', 'ApiAuthController@logout');
    $api->post('password/reset', 'ApiAuthController@resetPassword');
    $api->post('password/forgot', 'ApiAuthController@forgotPassword');

    // User
    $api->get('/users', ['as' => 'users.index', 'uses' => 'ApiUserController@index']);
    $api->get('/users/{id}', ['as' => 'users.show', 'uses' => 'ApiUserController@show']);

});

