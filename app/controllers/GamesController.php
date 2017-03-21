<?php
    
namespace Wishlist\App\Controllers;

use Wishlist\App\Models\Game;
use Wishlist\Core\App;

class GamesController
{
    public function index()
    {
        $games = Game::all();

        $message = '';

        if(isset($_SESSION['message']))
        {
            $message = $_SESSION['message'];
            unset($_SESSION['message']);
        }

        date_default_timezone_set('Europe/Helsinki');
        $currentDate = date('Y-m-d');
        $currentMonth = date('m');

        require '/public/resources/views/game.view.php';
    }
    public function create()
    {
        Game::createEmptyRows();
        $_SESSION['message'] = 'Succesfully created!';
        header('Location: /games');
    }
    public function delete()
    {
        $request = App::get('request')->request;

        if(!$request->has('id'))
        {
            $_SESSION['message'] = 'Missing id!';
            return header('Location: /games');
        }

        Game::delete($request->get('id'));
        $_SESSION['message'] = 'Succesfully removed!';
        header('Location: /games');
    }
    public function update()
    {
        $request = App::get('request')->request;

        if($request->has('name'))
        {
            if(!preg_match('/^[A-Za-z0-9_~\-:;.,+?!@#\$%\^&\*\'"\(\)\/\\\\ ]+$/',$request->get('name')))
            {
                $_SESSION['message'] = 'Failed to update!';
                return header('Location: /games');
            }
            Game::update($request->get('id'), $request->get('name'));
        }
        if($request->has('releasedate'))
        {
            $dt = DateTime::createFromFormat("F d, Y", $request->get('releasedate'));
            if($dt === false && array_sum($dt->getLastErrors())) {
                $_SESSION['message'] = 'Failed to update!';
                return header('Location: /games');
            }
            $rdate = $dt->format("Y-m-d");
            Game::update($request->get('id'), $rdate);
        }

        $_SESSION['message'] = 'Succesfully updated!';
        header('Location: /games');
    }
}