<?php
    
namespace Wishlist\App\Controllers;

use \DateTime;
use Wishlist\App\Models\Game;
use Wishlist\Core\App;
use Wishlist\Core\Gate;

class GamesController
{
    public function __construct()
    {
        if(!Gate::can('see-games')) {
            $_SESSION['failure'] = 'Please login to access that!';
            return header('Location: /login');
        }
    }
    public function index()
    {
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

            if($request->has('user_id') && !empty($request->get('user_id'))) {
                $data['user_id'] = $request->get('user_id');
            } else {
                $_SESSION['failure'] = "Missing id!";
                return header('Location: /showAdmin');
            }
            if($request->has('name') && !empty($request->get('name'))) {
                $data['name'] = $request->get('name');
            }
            if($request->has('releasedate') && !empty($request->get('releasedate'))) {
                $data['releasedate'] = $request->get('releasedate');
            }

            if(!empty($data)) {
                Game::create($data);
            } else {
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

        if(!$request->has('id') && !empty($request->get('id')))
        {
            $_SESSION['failure'] = 'Missing id!';
            if($_SESSION['group_id'] == 1) {
                return header('Location: /showAdmin');
            }
            return;
        }

        $field = 'user_id';
        if($_SESSION['group_id'] == 1) {
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

        if($_SESSION['group_id'] == 1) {
            if(!isset($_SESSION['token']) || $request->get('token') !== $_SESSION['token']) {
                throw new \Exception('CSRF TOKEN MISMATCH EXCPETION');
            }
        }

        $request = App::get('request')->request;

        if($_SESSION['group_id'] == 1) {
            if(!$request->has('user_id') && !empty($request->has('user_id'))) {
                $_SESSION['failure'] = "Missing user id!";
                return header('Location: /showAdmin');
            }
            $user_id = $request->get('user_id');
        } else {
            $user_id = $_SESSION['user_id'];
        }

        if($request->has('name') && !empty($request->has('name')))
        {
            if(preg_match('/^[A-Za-z0-9_~\-:;.,+?!@#\$%\^&\*\'"\(\)\/\\\\ ]+$/',$request->get('name')))
            {
                Game::update($request->get('id'), [
                    'name' => $request->get('name'),
                    'user_id' => $user_id
                ]);
            }
            else
            {
                $_SESSION['failure'] = 'Failed to update!';
                if($_SESSION['group_id'] == 1) {
                    return header('Location: /showAdmin');
                }
                return;
            }
        }
        if($request->has('releasedate') && !empty($request->has('releasedate')))
        {
            $dt = DateTime::createFromFormat("F d, Y", $request->get('releasedate'));
            if($dt !== false && !array_sum($dt->getLastErrors())) {
                $rdate = $dt->format("Y-m-d");
                Game::update($request->get('id'), [
                    'releasedate' => $rdate,
                    'user_id' => $user_id
                ]);
            }
            else
            {
                $_SESSION['failure'] = 'Failed to update!';
                if($_SESSION['group_id'] == 1) {
                    return header('Location: /showAdmin');
                }
                return;
            }
        }

        if(empty($request->get('name')) && empty($request->get('releasedate'))) {
            $_SESSION['failure'] = "Nothing to update!";
        } else {
            $_SESSION['success'] = 'Succesfully updated!';
        }
        if($_SESSION['group_id'] == 1) {
            return header('Location: /showAdmin');
        }
    }
}