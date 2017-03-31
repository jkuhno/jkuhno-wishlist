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

        $_SESSION['success'] = 'Row succesfully created!';
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

        $id_error = (new Validator([
            'id' => 'exists'
        ]))->validate();

        if(count($id_error) > 0) {
            $_SESSION['failure'] = $id_error;
            if($_SESSION['group_id'] == 1) {
                return header('Location: /showAdmin');
            }
            return;
        }

        Game::deleteWhere($request->get('id'),$field,$data);
        $_SESSION['success'] = 'Game succesfully removed!';
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
            $id_errors = (new Validator([
                'user_id' => 'exists',
                'id' => 'exists'
            ]))->validate();
            if(count($id_errors) > 0) {
                $_SESSION['failure'] = $id_errors;
                return header('Location: /showAdmin');
            }
            $user_id = $request->get('user_id');
        } else {
            $id_error = (new Validator([
                'id' => 'exists'
            ]))->validate();
            if(count($id_error) > 0) {
                $_SESSION['failure'] = $id_error;
                return;
            }
            $user_id = $_SESSION['user_id'];
        }

        $name_exists = (new Validator([
            'name' => 'exists'
        ]))->validate();
        $rdate_exists = (new Validator([
            'releasedate' => 'exists'
        ]))->validate();

        if(count($name_exists) == 0)
        {
            $name_valid = (new Validator([
                'name' => 'validGameName'
            ]))->validate();

            if(count($name_valid) == 0)
            {
                Game::update($request->get('id'), [
                    'name' => $request->get('name'),
                    'user_id' => $user_id
                ]);
            }
            else
            {
                $_SESSION['failure'] = $name_valid;
                if($_SESSION['group_id'] == 1) {
                    return header('Location: /showAdmin');
                }
                return;
            }
        }
        if(count($rdate_exists) == 0)
        {
            $rdate_valid = (new Validator([
                'releasedate' => 'validReleaseDate'
            ]))->validate();

            if(count($rdate_valid) == 0)
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
                $_SESSION['failure'] = $rdate_valid;
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