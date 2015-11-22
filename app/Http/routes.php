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

    $app->get('/potential/edit/{id}', ['uses' => 'AdminController@editPotential']);
    $app->get('/potential/delete/{id}', ['uses' => 'AdminController@deletePotential']);
    $app->get('/potential/add', ['uses' => 'AdminController@addPotential']);
    $app->post('/potential', ['uses' => 'AdminController@updatePotential']);

    $app->get('/checked/view/{id}', ['uses' => 'AdminController@viewChecked']);
    $app->get('/checked/data/{id}', ['uses' => 'AdminController@dataChecked']);
    $app->get('/checked/delete/{id}', ['uses' => 'AdminController@deleteChecked']);

    $app->get('/settings', ['uses' => 'AdminController@getSettings']);
    $app->post('/settings', ['uses' => 'AdminController@editSettings']);

    $app->get('/setting/delete/{id}', ['uses' => 'AdminController@deleteSetting']);
});