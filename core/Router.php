<?php
class Router
{
    protected $routes = [];
    public static function define($routes)
    {
        $self = new static;
        $self->routes = $routes;
        return $self;
    }
    public function fire($route)
    {
        if(array_key_exists($route, $this->routes)) {
            return 'app/controllers/' . $this->routes[$route] . '.php';
        }
        throw new Exception("404 File not found as route {$route} is not defined.");
    }
}