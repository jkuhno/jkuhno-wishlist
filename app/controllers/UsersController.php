<?php

namespace Wishlist\App\Controllers;

use Wishlist\Core\App;
use Wishlist\Core\Gate;
use Wishlist\App\Models\User;
use Wishlist\Core\Validator;

class UsersController
{
    public function showRegister()
    {
        return view('register');
    }
    public function register()
    {
        $request = App::get('request');

        $errors = (new Validator([
            'name' => 'required',
            'email' => 'required',
            'email' => 'validEmail',
            'password' => 'required'
        ]))->validate();

        if(count($errors) > 0) {
            $_SESSION['failure'] = $errors;
            return header('Location: /register');
        }
        User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => password_hash($request->get('password'), PASSWORD_DEFAULT)
        ]);

        $_SESSION['success'] = "Account created!";
        header('Location: /register');
    }
	public function showLogin()
	{
        return view('login');
	}
    public function login()
    {
        $request = App::get('request');
        $user = User::findWhere('email', $request->get('email'));

        if($user && password_verify($request->get('password'), $user->password)) {
            $_SESSION['name'] = $user->name;
            $_SESSION['user_id'] = $user->id;
            $_SESSION['group_id'] = $user->group_id;
            $_SESSION['success'] = "Succesfully logged in!";
            if($_SESSION['group_id'] == 1) {
                header('Location: /admin');
            }
            else{
                header('Location: /games');
            }
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
        header('Location: /'); // Add notification
    }
}