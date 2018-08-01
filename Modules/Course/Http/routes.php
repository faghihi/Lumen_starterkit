<?php

// web

Route::group(['middleware' => 'profile_json_response', 'prefix' => 'course', 'namespace' => 'Modules\Course\Http\Controllers'], function()
{
    Route::get('/all', 'CourseController@index');
    Route::get('/{id}', 'CourseController@show');
});

// api

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['middleware' => 'profile_json_response', 'namespace' => 'Modules\Course\Http\Controllers\Api\V1'], function ($api)
{
    $api->get('course/all', ['as' => 'courses.index', 'uses' => 'ApiCourseController@index']);
    $api->get('course/{id}', ['as' => 'courses.show', 'uses' => 'ApiCourseController@show']);
});


