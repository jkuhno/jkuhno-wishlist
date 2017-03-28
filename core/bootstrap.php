<?php
// For debugging.
error_reporting(E_ALL);
ini_set('display_errors', 1);

use Wishlist\Core\App;
use Wishlist\Core\Database\QueryBuilder;
use Wishlist\Core\Database\Connection;
use Symfony\Component\HttpFoundation\Request;

App::bind('config', require 'core/config.php');

App::bind('database', new QueryBuilder(
	Connection::make(App::get('config')['database'])
));

App::bind('request', Request::createFromGlobals());
