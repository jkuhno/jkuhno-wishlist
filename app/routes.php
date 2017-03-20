<?php
$router->get('/', 'GamesController@index');
$router->post('/create', 'GamesController@create');
$router->post('/delete', 'GamesController@delete');
$router->post('/update', 'GamesController@update');