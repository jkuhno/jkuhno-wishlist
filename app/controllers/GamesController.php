<?php
    
namespace Wishlist\App\Controllers;

use \DateTime;
use Wishlist\App\Models\Game;
use Wishlist\Core\App;

class GamesController
{
    public function index()
    {
        $games = Game::allOrdered();

        $message = '';

        if(isset($_SESSION['message']))
        {
            $message = $_SESSION['message'];
            unset($_SESSION['message']);
        }

        date_default_timezone_set('Europe/Helsinki');
        $currentDate = date('Y-m-d');
        $currentMonth = date('m');

        require 'app/resources/views/game.view.php';
    }
    public function create()
    {
        Game::create([
            'name' => NULL,
            'releasedate' => NULL    
        ]);
        $_SESSION['message'] = 'Succesfully created!';
    }
    public function delete()
    {
        $request = App::get('request')->request;

        if(!$request->has('id'))
        {
            $_SESSION['message'] = 'Missing id!';
            return;
        }

        Game::delete($request->get('id'));
        $_SESSION['message'] = 'Succesfully removed!';
    }
    public function update()
    {
        $request = App::get('request')->request;
        if($request->has('name'))
        {
            if(preg_match('/^[A-Za-z0-9_~\-:;.,+?!@#\$%\^&\*\'"\(\)\/\\\\ ]+$/',$request->get('name')))
            {
                Game::update($request->get('id'), ['name' => $request->get('name')]);
            }
            else
            {
                $_SESSION['message'] = 'Failed to update!';
                return;
            }
        }
        if($request->has('releasedate'))
        {
            $dt = DateTime::createFromFormat("F d, Y", $request->get('releasedate'));
            if($dt !== false && !array_sum($dt->getLastErrors())) {
                $rdate = $dt->format("Y-m-d");
                Game::update($request->get('id'), ['releasedate' => $rdate]);
            }
            else
            {
                $_SESSION['message'] = 'Failed to update!';
                return;
            }
        }

        $_SESSION['message'] = 'Succesfully updated!';
    }
}