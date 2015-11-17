<?php
$app->group(['namespace' => 'App\Http\Controllers'], function($app){
    $app->get('/', ['uses' => 'IndexController@index']);
    $app->post('/result', ['uses' => 'IndexController@result']);
    $app->get('/result', ['uses' => 'IndexController@jsonResult']);
    $app->post('/order', ['uses' => 'IndexController@order']);

});
$app->group(['prefix' => '/admin', 'middleware' => 'auth', 'namespace' => 'App\Http\Controllers'], function($app){
    $app->get('/', ['uses' => 'AdminController@index']);
    $app->get('/potentials', ['uses' => 'AdminController@potentials']);
    $app->get('/potential/add', ['uses' => 'AdminController@addPotential']);
    $app->post('/potential', ['uses' => 'AdminController@updatePotential']);
});