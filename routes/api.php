<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

/* $router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('/', function () use ($router) {
        return "API is working.";
    });

    
});
 */

 $router->group(['middleware' => 'auth'], function () use ($router) {
    $router->get('/', 'MMController@index');
    $router->get('lookupUser/{email}', 'MMController@show');
    $router->post('addUser', 'MMController@store');
    $router->delete('deleteUser/{email}', 'MMController@destroy');
});