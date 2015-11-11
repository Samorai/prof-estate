<?php
$app->get('/', ['uses' => 'IndexController@index']);
$app->get('/result', ['uses' => 'IndexController@result']);