<?php
class Request
{
    public static function uri()
    {
        $parts = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
        return strlen($parts[0]) > 0 ? $parts[0] : '/';
    }
}