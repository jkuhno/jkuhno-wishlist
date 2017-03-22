<?php
namespace Wishlist\Core;
class Gate
{
    public static function can($rule)
    {
        if(isset($_SESSION['superuser']) && $_SESSION['superuser'] == true) {
            return true;
        }
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
}