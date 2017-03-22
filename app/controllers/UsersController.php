<?php

namespace Wishlist\App\Controllers;

class UserController
{
	public function index()
	{
		return view("login");
	}
    public function login()
    {
        $req = App::get('request');
        $user = User::findWhere('email', $req->get('email'));
        if($user && password_verify($req->get('password'), $user->password)) {
            $_SESSION['name'] = $user->name;
            $_SESSION['user_id'] = $user->id;
            header('Location: /games');
        }
        return view("login", ["message" => "The email or password was invalid"]);
    }
}