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

        $fields_exist = (new Validator([
            'name' => 'exists',
            'email' => 'exists',
            'password' => 'exists'
        ]))->validate();

        if(count($fields_exist) > 0) {
            $_SESSION['failure'] = $fields_exist;
            return header('Location: /register');
        }

        $email_valid = (new Validator([
            'email' => 'validEmail'
        ]))->validate();

        if(count($email_valid) > 0) {
            $_SESSION['failure'] = $email_valid;
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

        try {
            if(!isset($_SESSION['token']) || $request->get('token') !== $_SESSION['token']) {
                throw new \Exception('CSRF TOKEN MISMATCH EXCPETION');
            }
        }
        catch (Exception $e) {
            echo $e->getMessage();
            die();
        }

        $id_error = (new Validator([
            'id' => 'exists'
        ]))->validate();

        if(count($id_error) > 0) {
            $_SESSION['failure'] = $id_error;
            if($_SESSION['group_id'] == 1) {
                return header('Location: /showAdmin');
            }
            return header('Location: /user');
        }

        User::delete($request->get('id'));
        $_SESSION['success'] = 'User removed!';
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

        try {
            if(!isset($_SESSION['token']) || $request->get('token') !== $_SESSION['token']) {
                throw new \Exception('CSRF TOKEN MISMATCH EXCPETION');
            }
        }
        catch (Exception $e) {
            echo $e->getMessage();
            die();
        }

        $id_error = (new Validator([
            'id' => 'exists'
        ]))->validate();

        if(count($id_error) > 0) {
            $_SESSION['failure'] = $id_error;
            if($_SESSION['group_id'] == 1) {
                return header('Location: /showAdmin');
            }
            return header('Location: /user');
        }

        $data = array();
        $success = array();

        $name_exists = (new Validator([
            'name' => 'exists'
        ]))->validate();

        if(count($name_exists) == 0) {
            $data['name'] = $request->get('name');
            $success[] = "Name updated!";
            if($_SESSION['group_id'] != 1) {
                $_SESSION['name'] = $request->get('name');
            }
        }

        $email_exists = (new Validator([
            'email' => 'exists'
        ]))->validate();

        if(count($email_exists) == 0) {
            $email_valid = (new Validator([
                'email' => 'validEmail'
            ]))->validate();

            if(count($email_valid) == 0) {
                $data['email'] = $request->get('email');
                $success[] = "Email updated!";
                if($_SESSION['group_id'] != 1) {
                    $_SESSION['email'] = $request->get('email');
                }
            }
            else
            {
                $_SESSION['failure'] = $email_valid;
                if($_SESSION['group_id'] == 1) {
                    return header('Location: /showAdmin');
                }
                return header('Location: /user');
            }
        }

        $password_exists = (new Validator([
            'password' => 'exists'
        ]))->validate();

        if(count($password_exists) == 0) {
            $data['password'] = password_hash($request->get('password'), PASSWORD_DEFAULT);
            $success[] = "Password updated!";
        }
        
        if(!empty($data)) {
            User::update($request->get('id'),$data);

            $_SESSION['success'] = $success;

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
            $_SESSION['success'] = "Logged in!";
            if($_SESSION['group_id'] == 1) {
                header('Location: /showAdmin');
            }
            else{
                header('Location: /games');
            }
        }
        else
        {
            if(empty($request->get('email')) || empty($request->get('password'))) {
                if(empty($request->get('email')) && empty($request->get('password'))) {
                    $_SESSION['failure'] = "Please enter email and password to log in!";
                }
                else if(empty($request->get('email'))) {
                    $_SESSION['failure'] = "Email is required!";
                }
                else if(empty($request->get('password'))) {
                    $_SESSION['failure'] = "Password is required!";
                }
            }
            else {
                if(!$user && !password_verify($request->get('password'), $user->password)) {
                    $_SESSION['failure'] = "Invalid email and password!";
                }
                else if(!$user) {
                    $_SESSION['failure'] = "Invalid email!";
                }
                else if(!password_verify($request->get('password'), $user->password)) {
                    $_SESSION['failure'] = "Invalid password!";
                }
            }
            return header('Location: /login');
        }
    }
    public function logout()
    {
        session_unset();
        session_destroy();
        header('Location: /?msg=' . urlencode(base64_encode("Logged out!")));
    }
}
