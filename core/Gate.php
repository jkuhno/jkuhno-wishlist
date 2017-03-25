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
        if (isset($_SESSION['group_id']) && $_SESSION['group_id'] == 2) {
            return true;
        }
        return false;
    }
    private static function CreateGames()
    {
        if (isset($_SESSION['group_id']) && $_SESSION['group_id'] == 2) {
            return true;
        }
        return false;
    }
    private static function UpdateGames()
    {
        if (isset($_SESSION['group_id']) && $_SESSION['group_id'] == 2) {
            return true;
        }
        return false;
    }
    private static function DeleteGames()
    {
        if (isset($_SESSION['group_id']) && $_SESSION['group_id'] == 2) {
            return true;
        }
        return false;
    }
    private static function SeeUsers()
    {
        if (isset($_SESSION['group_id']) && $_SESSION['group_id'] == 1) {
            return true;
        }
        return false;
    }
    private static function CreateUsers()
    {
        if (isset($_SESSION['group_id']) && $_SESSION['group_id'] == 1) {
            return true;
        }
        return false;
    }
    private static function UpdateUsers()
    {
        if (isset($_SESSION['group_id']) && $_SESSION['group_id'] == 1) {
            return true;
        }
        return false;
    }
    private static function DeleteUsers()
    {
        if (isset($_SESSION['group_id']) && $_SESSION['group_id'] == 1) {
            return true;
        }
        return false;
    }
}