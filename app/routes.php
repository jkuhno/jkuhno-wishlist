<?php

$router->get('/', 'HomeController@index');

$router->get('/register', 'UsersController@showRegister');
$router->post('/register', 'UsersController@register');
$router->get('/login', 'UsersController@showLogin');
$router->post('/login', 'UsersController@login');
$router->get('/logout', 'UsersController@logout');
$router->get('/admin', 'UsersController@showAdmin');

$router->get('/games', 'GamesController@index');
$router->post('/games/create', 'GamesController@create');
$router->post('/games/delete', 'GamesController@delete');
$router->post('/games/update', 'GamesController@update');