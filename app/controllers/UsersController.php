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
            'name' => 'exists',
            'email' => 'exists',
            'email' => 'validEmail',
            'password' => 'exists'
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
    public function showUser()
    {
        if(!Gate::can('see-users')) {
            $_SESSION['failure'] = 'Please login to access that!';
            return header('Location: /login');
        }
        $_SESSION['token'] = '';
        $token= bin2hex(openssl_random_pseudo_bytes(32));
        $_SESSION['token'] = $token;

        return view('user', compact('token'));
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

        $errors = (new Validator([
            'id' => 'exists'
        ]))->validate();

        if(count($errors) > 0) {
            $_SESSION['failure'] = $errors;
            if($_SESSION['group_id'] == 1) {
                return header('Location: /showAdmin');
            }
            return header('Location: /user');
        }

        User::delete($request->get('id'));
        $_SESSION['success'] = 'Succesfully removed!';
        if($_SESSION['group_id'] == 1) {
            return header('Location: /showAdmin');
        }
        header('Location: /logout');
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

        $errors = (new Validator([
            'id' => 'exists',
        ]))->validate();

        if(count($errors) > 0) {
            $_SESSION['failure'] = $errors;
            if($_SESSION['group_id'] == 1) {
                return header('Location: /showAdmin');
            }
            return header('Location: /user');
        }

        $data = array();
        if(count($hasName = (new Validator(['name' => 'exists']))->validate()) == 0) {
            $data['name'] = $request->get('name');
            if($_SESSION['group_id'] != 1) {
                $_SESSION['name'] = $request->get('name');
            }
        }
        if(count($hasEmail = (new Validator(['email' => 'exists']))->validate()) == 0) {
            if(count($validEmail = (new Validator(['email' => 'validEmail']))->validate()) == 0) {
                $data['email'] = $request->get('email');
                if($_SESSION['group_id'] != 1) {
                    $_SESSION['email'] = $request->get('email');
                }
            }
            else
            {
                $_SESSION['failure'] = $validEmail;
                if($_SESSION['group_id'] == 1) {
                    return header('Location: /showAdmin');
                }
                return header('Location: /user');
            }
        }
        if(count($hasPassword = (new Validator(['password' => 'exists']))->validate()) == 0) {
            $data['password'] = password_hash($request->get('password'), PASSWORD_DEFAULT);
        }
        
        if(!empty($data)) {
            User::update($request->get('id'),$data);
            
            $_SESSION['success'] = "Succesfully updated!"; // INDIVIDUALITY!

            if($request->has('password') && !empty($request->get('password')) && $_SESSION['group_id'] != 1) {
                return header('Location: /logout');
            }
            if($_SESSION['group_id'] == 1) {
                return header('Location: /showAdmin');
            }
            header('Location: /user');
        }
        else {
            $_SESSION['failure'] = "Nothing to update!";
            if($_SESSION['group_id'] == 1) {
                return header('Location: /showAdmin');
            }
            header('Location: /user');
        }
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
            $_SESSION['email'] = $user->email;
            $_SESSION['user_id'] = $user->id;
            $_SESSION['group_id'] = $user->group_id;
            $_SESSION['success'] = "Succesfully logged in!";
            if($_SESSION['group_id'] == 1) {
                header('Location: /showAdmin');
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
        header('Location: /?msg=' . urlencode(base64_encode("Succesfully logged out!")));
    }
}
