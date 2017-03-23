<?php

namespace Wishlist\App\Controllers;

use Wishlist\Core\App;
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
        $req = App::get('request');

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
            'name' => $req->get('name'),
            'email' => $req->get('email'),
            'password' => password_hash($req->get('password'), PASSWORD_DEFAULT)
        ]);

        $_SESSION['success'] = "Account created!";
        header('Location: /register');
    }
    public function showAdmin()
    {
        $users = User::all();
        return view('admin', compact('users'));
    }
    public function delete()
    {
        if(!Gate::can('delete-users')) {
            $_SESSION['failure'] = 'Please login to access that!';
            return header('Location: /login');
        }

        $request = App::get('request')->request;

        if(!$request->has('id'))
        {
            $_SESSION['failure'] = 'Missing id!';
            return;
        }

        User::delete($request->get('id'));
        $_SESSION['success'] = 'Succesfully removed!';
    }
	public function showLogin()
	{
        return view('login');
	}
    public function login()
    {
        $req = App::get('request');
        $user = User::findWhere('email', $req->get('email'));

        if($user && password_verify($req->get('password'), $user->password)) {
            $_SESSION['name'] = $user->name;
            $_SESSION['user_id'] = $user->id;
            $_SESSION['success'] = "Succesfully logged in!";
            if($user->group_id == 1) {
                $_SESSION['superuser'] = true;
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
        header('Location: /');
        //return view("index", ["success" => "Succesfully logged out!"]);
    }
}