<?php

namespace Wishlist\App\Controllers;

use Wishlist\Core\App;
use Wishlist\Core\Gate;
use Wishlist\App\Models\User;
use Wishlist\App\Models\Game;
use Wishlist\Core\Validator;

class AdminController
{
    public function __construct()
    {
        if(!Gate::can('see-admin')) {
            $_SESSION['failure'] = 'Please login to access that!';
            return header('Location: /login');
        }
    }
    public function showAdmin()
    {
        $_SESSION['token'] = '';
        $token= bin2hex(openssl_random_pseudo_bytes(32));
        $_SESSION['token'] = $token;

        $data = array('releasedate ASC', 'name ASC');
        $games = Game::allOrdered($data);

        $users = User::findAllWhere('group_id', 2);

        return view('admin', compact('users', 'games', 'token'));
    }
}