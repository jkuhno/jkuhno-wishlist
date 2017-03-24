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
        $req = App::get('request');

        if(isset($_SESSION['user_id'])) {
            if(!isset($_SESSION['token']) || $request->get('token') !== $_SESSION['token']) {
                throw new \Exception('CSRF TOKEN MISMATCH EXCPETION');
            }
        }

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
        if($_SESSION['group_id'] == 1) {
            header('Location: /admin');
        } else {
            header('Location: /register');
        }
    }

    public function showAdmin()
    {
        if(!Gate::can('see-users')) {
            $_SESSION['failure'] = 'Please login to access that!';
            return header('Location: /login');
        }

        $_SESSION['token'] = '';
        $token= bin2hex(openssl_random_pseudo_bytes(32));
        $_SESSION['token'] = $token;

        $users = User::findAllWhere('group_id', 2);

        return view('admin', compact('users', 'token'));
    }
    public function delete()
    {
        if(!Gate::can('delete-users')) {
            $_SESSION['failure'] = 'Please login to access that!';
            return header('Location: /login');
        }

        $request = App::get('request')->request;

        if(!isset($_SESSION['token']) || $request->get('token') !== $_SESSION['token']) {
            throw new \Exception('CSRF TOKEN MISMATCH EXCPETION');
        }

        if(!$request->has('id'))
        {
            $_SESSION['failure'] = 'Missing id!';
            return header('Location: /admin');
        }

        User::delete($request->get('id'));
        $_SESSION['success'] = 'Succesfully removed!';
        header('Location: /admin');
    }
    public function update()
    {
        if(!Gate::can('update-users')) {
            $_SESSION['failure'] = 'Please login to access that!';
            return header('Location: /login');
        }

        $request = App::get('request')->request;

        if(!isset($_SESSION['token']) || $request->get('token') !== $_SESSION['token']) {
            throw new \Exception('CSRF TOKEN MISMATCH EXCPETION');
        }
        if(!$request->has('id')) {
            $_SESSION['failure'] = "Missing id!";
            return header('Location: /admin');
        }
        if($request->has('email')) {
            $errors = (new Validator([
                'email' => 'validEmail'
            ]))->validate();

            if(count($errors) > 0) {
                $_SESSION['failure'] = $errors;
                return header('Location: /admin');
            }
        }

        $data = array();
        if($request->has('name')) {
            $data['name'] = $request->get('name');
        }
        if($request->has('email')) {
            $data['email'] = $request->-get('email');
        }
        if($request->has('password')) {
            $data['password'] = password_hash($req->get('password'), PASSWORD_DEFAULT);
        }
        
        if(!empty($data)) {
            User::update($request->get('id'),$data);

            $_SESSION['success'] = "Account created!";
            header('Location: /admin');
        }
        else {
            $_SESSION['failure'] = "Nothing to update!";
            header('Location: /admin');
        }
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
        header('Location: /');
        //return view("index", ["success" => "Succesfully logged out!"]);
    }
}