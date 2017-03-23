<?php

namespace Wishlist\App\Controllers;

use Wishlist\Core\App;
use Wishlist\App\Models\User;
use Wishlist\Core\Validator;

class UsersController
{
    public function showRegister()
    {
        if(isset($_SESSION['success']))
        {
            $success = $_SESSION['success'];
            unset($_SESSION['success']);
        }
        if(isset($_SESSION['failure']))
        {
            $failure = $_SESSION['failure'];
            unset($_SESSION['failure']);
        }

        return view('register', compact('success', 'failure'));
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

        $_SESSION['success'] = "Account created!";
        header('Location: /register');
    }
	public function showLogin()
	{
        if(isset($_SESSION['success']))
        {
            $success = $_SESSION['success'];
            unset($_SESSION['success']);
        }
        if(isset($_SESSION['failure']))
        {
            $failure = $_SESSION['failure'];
            unset($_SESSION['failure']);
        }
        return view('login', compact('success', 'failure'));
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
            $_SESSION['failure'] = "Invalid email or password!";
            return header('Location: /login');
        }
    }
    public function logout()
    {
        session_unset();
        session_destroy();

        return view("index", ["success" => "Succesfully logged out!"]);
    }
}