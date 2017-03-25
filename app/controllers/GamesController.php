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

        if(!$request->has('id'))
        {
            $_SESSION['failure'] = 'Missing id!';
            return;
        }

        Game::delete($request->get('id'));
        $_SESSION['success'] = 'Succesfully removed!';
    }
    public function update()
    {
        if(!Gate::can('update-games')) {
            $_SESSION['failure'] = 'Please login to access that!';
            return header('Location: /login');
        }
        $user_id = $_SESSION['user_id'];
        $request = App::get('request')->request;
        if($request->has('name'))
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
                return;
            }
        }
        if($request->has('releasedate'))
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
                return;
            }
        }

        $_SESSION['success'] = 'Succesfully updated!';
    }
}