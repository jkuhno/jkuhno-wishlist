<?php

$router->get('/', 'UsersController@index');
$router->post('login', 'UsersController@login');

$router->get('/games', 'GamesController@index');
$router->post('/games/create', 'GamesController@create');
$router->post('/games/delete', 'GamesController@delete');
$router->post('/games/update', 'GamesController@update');