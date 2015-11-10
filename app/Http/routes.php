<?php
$app->get('/', ['uses' => 'IndexController@index']);
$app->get('/form', ['uses' => 'IndexController@form']);