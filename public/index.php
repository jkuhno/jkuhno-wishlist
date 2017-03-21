<?php

session_start();

require '/../vendor/autoload.php';

use Wishlist\Core\Router;
use Wishlist\Core\App;

Router::define('/../app/routes.php')
	->fire(
		App::get('request')->getPathInfo(),
		App::get('request')->getMethod()
	);