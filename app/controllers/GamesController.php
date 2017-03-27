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

        if($_SESSION['group_id'] == 1) {
            $request = App::get('request')->request;

            if(!isset($_SESSION['token']) || $request->get('token') !== $_SESSION['token']) {
                throw new \Exception('CSRF TOKEN MISMATCH EXCPETION');
            }

            $data = array();

            if(count($hasUser = (new Validator(['user_id' => 'exists']))->validate()) == 0) {
                $data['user_id'] = $request->get('user_id');
            } else {
                $_SESSION['failure'] = $hasUser;
                return header('Location: /showAdmin');
            }
            if(count($hasName = (new Validator(['name' => 'exists']))->validate()) == 0) {
                $data['name'] = $request->get('name');
            }
            if(count($hasReleaseDate = (new Validator(['releasedate' => 'exists']))->validate()) == 0) {
                $data['releasedate'] = $request->get('releasedate');
            }

            if(!empty($data)) {
                Game::create($data);
            } else { // INDIVIDUALITY!
                $_SESSION['failure'] = "Nothing to update!";
                return header('Location: /showAdmin');
            }
        }
        else {
            $user_id = $_SESSION['user_id'];

            Game::create([
                'name' => NULL,
                'releasedate' => NULL,
                'user_id' => $user_id   
            ]);
        }
        $_SESSION['success'] = 'Succesfully created!';
        if($_SESSION['group_id'] == 1) {
            return header('Location: /showAdmin');
        }
    }
    public function delete()
    {
        if(!Gate::can('delete-games')) {
            $_SESSION['failure'] = 'Please login to access that!';
            return header('Location: /login');
        }
        $request = App::get('request')->request;

        if($_SESSION['group_id'] == 1) {
            if(!isset($_SESSION['token']) || $request->get('token') !== $_SESSION['token']) {
                throw new \Exception('CSRF TOKEN MISMATCH EXCPETION');
            }
        }

        if(count($hasID = (new Validator(['id' => 'exists']))->validate()) == 0)
        {
            $_SESSION['failure'] = $hasID;
            if($_SESSION['group_id'] == 1) {
                return header('Location: /showAdmin');
            }
            return;
        }

        $field = 'user_id';
        if($_SESSION['group_id'] == 1) {
            if(count($hasUserID = (new Validator(['user_id' => 'exists']))->validate()) == 0) {
                $_SESSION['failure'] = $hasUserID;
                return header('Location: /showAdmin');
            }
            $data = $request->get('user_id');
        } else {
            $data = $_SESSION['user_id'];
        }

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
            if(!isset($_SESSION['token']) || $request->get('token') !== $_SESSION['token']) {
                throw new \Exception('CSRF TOKEN MISMATCH EXCPETION');
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
            $dt = DateTime::createFromFormat("F d, Y", $request->get('releasedate'));
            //if($dt !== false && !array_sum($dt->getLastErrors())) {
            if(count($hasReleaseDate = (new Validator([$dt => 'exists']))->validate()) == 0)
            {
                $rdate = $dt->format("Y-m-d");
                Game::update($request->get('id'), [
                    'releasedate' => $rdate,
                    'user_id' => $user_id
                ]);
            }
            else
            {
                $_SESSION['failure'] = 'Incorrect format for date, please use e.g. January 24, 2017!';
                if($_SESSION['group_id'] == 1) {
                    return header('Location: /showAdmin');
                }
                return;
            }
        }

        if(empty($request->get('name')) && empty($request->get('releasedate'))) {
            $_SESSION['failure'] = "Nothing to update!";
        } else { //INDIVIDUALITY!
            $_SESSION['success'] = 'Succesfully updated!';
        }
        if($_SESSION['group_id'] == 1) {
            return header('Location: /showAdmin');
        }
    }
}