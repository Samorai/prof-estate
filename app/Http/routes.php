<?php
$app->get('/', ['uses' => 'IndexController@index']);
$app->post('/result', ['uses' => 'IndexController@result']);
$app->get('/result', ['uses' => 'IndexController@jsonResult']);
$app->post('/order', ['uses' => 'IndexController@order']);