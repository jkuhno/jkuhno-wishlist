<?php

namespace Wishlist\App\Controllers;

use Wishlist\Core\App;
use Wishlist\App\Models\User;
use Wishlist\Core\Validator;

class UsersController
{
    public function showRegister()
    {
        return view('register', compact('message'));
    }
    public function register()
    {
        $req = App::get('request');
        $errors = (new Validator([
            'name' => 'required',
            'email' => 'required',
            'email' => 'validEmail',
            'password' => 'required'
        ]))->validate();
        if(count($errors) > 0) {
            return view("register", compact("errors"));
        }
        User::create([
            'name' => $req->get('name'),
            'email' => $req->get('email'),
            'password' => password_hash($req->get('password'), PASSWORD_DEFAULT)
        ]);
        return view("register", ["message" => "Account created!"]);
        // SRP!!!
    }
	public function showLogin()
	{
		return view('login', compact('message'));
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
        else
        {
            return view("login", ["message" => "Invalid email or password!"]);
            // SRP!!!
            //$_SESSION['message'] = "Invalid email or password!";
            //header('Location: /');
        }
    }
    public function logout()
    {
        session_unset();
        session_destroy();

        return view("index", ["message" => "Session closed"]);
        // SRP !!!!
        //$_SESSION['message'] = "Succesfully logged out!";
        //header('Location: /');
    }
}