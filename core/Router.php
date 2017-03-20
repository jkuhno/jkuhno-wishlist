<?php

namespace Wishlist\Core;

class Router
{
	protected $routes = [
		'GET' => [],
		'POST' => []
	];
	public static function define($routes)
	{
		$router = new static;
		require $routes;
		return $router;
	}
	public function get($uri, $controller)
	{
		$this->routes['GET'][$uri] = $controller;
	}
	public function post($uri, $controller)
	{
		$this->routes['POST'][$uri] = $controller;
	}
	public function fire($route, $requestType)
	{
		if(array_key_exists($route, $this->routes[$requestType])) {
			$routeParts = explode('@', $this->routes[$requestType][$route]);
			return $this->callMethod($routeParts[0], $routeParts[1]);
		}
		throw new \Exception("404 File not found as route {$route} is not defined.");
	}
	protected function callMethod($controller, $method)
	{
		$controller = "Wishlist\\App\\Controllers\\{$controller}";
		$controller = new $controller;
		if(!method_exists($controller, $method)) {
			throw new \Exception("{$controller} does not have method {$method}");
		}
		return $controller->$method();
	}
}