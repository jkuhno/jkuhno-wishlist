<?php
    
namespace Wishlist\App\Controllers;

use \DateTime;
use Wishlist\App\Models\Game;
use Wishlist\Core\App;
use Wishlist\Core\Gate;
use Wishlist\Core\Validator;

class GamesController
{
    public function index()
    {
        if(!Gate::can('see-games')) {
            $_SESSION['failure'] = 'Please login to access that!';
            return header('Location: /login');
        }
        $field = 'user_id';
        $user_id = $_SESSION['user_id'];
        $data = array('releasedate ASC', 'name ASC');
        $games = Game::allWhereOrdered($field, $user_id, $data);

        return view('game', compact('games'));
    }
    public function create()
    {
        if(!Gate::can('create-games')) {
            $_SESSION['failure'] = 'Please login to access that!';
            return header('Location: /login');
        }

        $user_id = $_SESSION['user_id'];

        Game::create([
            'name' => NULL,
            'releasedate' => NULL,
            'user_id' => $user_id   
        ]);

        $_SESSION['success'] = 'Succesfully created!';
    }
    public function delete()
    {
        if(!Gate::can('delete-games')) {
            $_SESSION['failure'] = 'Please login to access that!';
            return header('Location: /login');
        }
        $request = App::get('request')->request;

        if($_SESSION['group_id'] == 1) {
            try {
                if(!isset($_SESSION['token']) || $request->get('token') !== $_SESSION['token']) {
                    throw new \Exception('CSRF TOKEN MISMATCH EXCPETION');
                }
            }
            catch (Exception $e) {
                echo $e->getMessage();
                die();
            }
        }

        $field = 'user_id';
        if($_SESSION['group_id'] == 1) {
            $data = $request->get('user_id');
        } else {
            $data = $_SESSION['user_id'];
        }

        if(!$request->has('id') && !empty($request->get('id'))) {
            $_SESSION['failure'] = "Missing or empty id!";
            return;
        }

        /*if($_SESSION['group_id'] == 1) {
            if(count($hasIDs = (new Validator(['user_id' => 'exists']))->validate()) == 0) {
                $_SESSION['failure'] = $hasIDs;
                return header('Location: /showAdmin');
            }
            $data = $request->get('user_id');
        } else {
            $data = $_SESSION['user_id'];
        }*/

        Game::deleteWhere($request->get('id'),$field,$data);
        $_SESSION['success'] = 'Succesfully removed!';
        if($_SESSION['group_id'] == 1) {
            return header('Location: /showAdmin');
        }
    }
    public function update()
    {
        if(!Gate::can('update-games')) {
            $_SESSION['failure'] = 'Please login to access that!';
            return header('Location: /login');
        }

        $request = App::get('request')->request;

        if($_SESSION['group_id'] == 1) {
            try {
                if(!isset($_SESSION['token']) || $request->get('token') !== $_SESSION['token']) {
                    throw new \Exception('CSRF TOKEN MISMATCH EXCPETION');
                }
            }
            catch (Exception $e) {
                echo $e->getMessage();
                die();
            }
        }

        if($_SESSION['group_id'] == 1) {
            $errors = (new Validator([
                'user_id' => 'exists',
                'id' => 'exists'
            ]))->validate();
            if(count($errors) > 0) {
                $_SESSION['failure'] = $errors;
                return header('Location: /showAdmin');
            }
            $user_id = $request->get('user_id');
        } else {
            $user_id = $_SESSION['user_id'];
        }

        if(count($hasName = (new Validator(['name' => 'exists']))->validate()) == 0)
        {
            if(count($validGameName = (new Validator(['name' => 'validGameName']))->validate()) == 0)
            {
                Game::update($request->get('id'), [
                    'name' => $request->get('name'),
                    'user_id' => $user_id
                ]);
            }
            else
            {
                $_SESSION['failure'] = $validGameName;
                if($_SESSION['group_id'] == 1) {
                    return header('Location: /showAdmin');
                }
                return;
            }
        }
        if(count($hasReleaseDate = (new Validator(['releasedate' => 'exists']))->validate()) == 0)
        {
            if(count($hasReleaseDate = (new Validator(['releasedate' => 'validReleaseDate']))->validate()) == 0)
            {
                $dt = DateTime::createFromFormat("F d, Y", $request->get('releasedate'));
                $rdate = $dt->format("Y-m-d");
                Game::update($request->get('id'), [
                    'releasedate' => $rdate,
                    'user_id' => $user_id
                ]);
            }
            else
            {
                $_SESSION['failure'] = 'Incorrect format for date, please use format: F d, Y; e.g. January 24, 2017!';
                if($_SESSION['group_id'] == 1) {
                    return header('Location: /showAdmin');
                }
                return;
            }
        }

        if(empty($request->get('name')) && empty($request->get('releasedate'))) {
            $_SESSION['failure'] = "Nothing to update!";
        } else if(!empty($request->get('name')) && empty($request->get('releasedate'))) {
            $_SESSION['success'] = "Succesfully updated game name!";
        } else if(empty($request->get('name')) && !empty($request->get('releasedate'))) {
            $_SESSION['success'] = "Succesfully updated game release date!";
        } else {
            $_SESSION['success'] = 'Succesfully updated game name and release date!';
        }
        if($_SESSION['group_id'] == 1) {
            return header('Location: /showAdmin');
        }
    }
}