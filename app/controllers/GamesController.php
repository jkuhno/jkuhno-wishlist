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
        $games = Game::allOrdered($field, $user_id, $data);

        if(isset($_SESSION['success']))
        {
            $message = $_SESSION['success'];
            unset($_SESSION['success']);
        }
        if(isset($_SESSION['failure']))
        {
            $message = $_SESSION['failure'];
            unset($_SESSION['failure']);
        }

        date_default_timezone_set('Europe/Helsinki');
        $currentDate = date('Y-m-d');
        $currentMonth = date('m');

        return view('game', compact('success', 'failure', 'games', 'token', 'currentDate', 'currentMonth'));
    }
    public function create()
    {
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