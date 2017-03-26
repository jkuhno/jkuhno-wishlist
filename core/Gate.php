<?php

namespace Wishlist\Core;

class Gate
{
    public static function can($rule)
    {
        $method = str_replace(' ', '', ucwords(str_replace('-', ' ', $rule)));
        if(!method_exists(__CLASS__, $method)) {
            throw new \Exception("No authorization rule {$rule} defined.");
        }
        return static::$method();
    }
    private static function SeeGames()
    {
        return isset($_SESSION['user_id']);
    }
    private static function CreateGames()
    {
        return isset($_SESSION['user_id']);
    }
    private static function UpdateGames()
    {
        return isset($_SESSION['user_id']);
    }
    private static function DeleteGames()
    {
        return isset($_SESSION['user_id']);
    }
    private static function SeeUsers()
    {
        return isset($_SESSION['user_id']);
    }
    private static function CreateUsers()
    {
        return isset($_SESSION['user_id']);
    }
    private static function UpdateUsers()
    {
        return isset($_SESSION['user_id']);
    }
    private static function DeleteUsers()
    {
        return isset($_SESSION['user_id']);
    }
    private static function SeeAdmin()
    {
        if(isset($_SESSION['group_id']) && $_SESSION['group_id'] == 1) {
            return true;
        }
        return false;
    }
}