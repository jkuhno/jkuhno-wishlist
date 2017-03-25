<?php

namespace Wishlist\App\Controllers;

use Wishlist\Core\App;
use Wishlist\Core\Gate;
use Wishlist\App\Models\User;
use Wishlist\App\Models\Game;
use Wishlist\Core\Validator;

class AdminController
{
    public function showAdmin()
    {
        if(!Gate::can('see-users')) {
            $_SESSION['failure'] = 'Please login to access that!';
            return header('Location: /login');
        }

        $_SESSION['token'] = '';
        $token= bin2hex(openssl_random_pseudo_bytes(32));
        $_SESSION['token'] = $token;

        $data = array('releasedate ASC', 'name ASC');
        $games = Game::allOrdered($data);

        $users = User::findAllWhere('group_id', 2);

        return view('admin', compact('users', 'token'));
    }
    public function create()
    {
        if(!Gate::can('create-users')) {
            $_SESSION['failure'] = 'Please login to access that!';
            return header('Location: /login');
        }

        $request = App::get('request');

        if(!isset($_SESSION['token']) || $request->get('token') !== $_SESSION['token']) {
            throw new \Exception('CSRF TOKEN MISMATCH EXCPETION');
        }

        $errors = (new Validator([
            'name' => 'required',
            'email' => 'required',
            'email' => 'validEmail',
            'password' => 'required'
        ]))->validate();

        if(count($errors) > 0) {
            $_SESSION['failure'] = $errors;
            return header('Location: /admin');
        }
        User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => password_hash($request->get('password'), PASSWORD_DEFAULT)
        ]);

        $_SESSION['success'] = "Account created!";
        header('Location: /admin');
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
        if($request->has('email') && !empty($request->get('email'))) {
            $errors = (new Validator([
                'email' => 'validEmail'
            ]))->validate();

            if(count($errors) > 0) {
                $_SESSION['failure'] = $errors;
                return header('Location: /admin');
            }
        }

        $data = array();
        if($request->has('name') && !empty($request->get('name'))) {
            $data['name'] = $request->get('name');
        }
        if($request->has('email') && !empty($request->get('email'))) {
            $data['email'] = $request->get('email');
        }
        if($request->has('password') && !empty($request->get('password'))) {
            $data['password'] = password_hash($request->get('password'), PASSWORD_DEFAULT);
        }
        
        if(!empty($data)) {
            User::update($request->get('id'),$data);

            $_SESSION['success'] = "Succesfully updated!";
            header('Location: /admin');
        }
        else {
            $_SESSION['failure'] = "Nothing to update!";
            header('Location: /admin');
        }
    }
}