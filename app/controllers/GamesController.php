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
            return header('Location: /');
        }
    }
    public function index()
    {
        $field = 'user_id';
        $user_id = $_SESSION['user_id'];
        $games = Game::allOrdered($field, $user_id);

        $message = '';

        if(isset($_SESSION['message']))
        {
            $message = $_SESSION['message'];
            unset($_SESSION['message']);
        }

        $_SESSION['token'] = '';
        if (function_exists('mcrypt_create_iv')) {
            $token = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
        } else {
            $token = bin2hex(openssl_random_pseudo_bytes(32));
        }
        $_SESSION['token'] = $token;

        date_default_timezone_set('Europe/Helsinki');
        $currentDate = date('Y-m-d');
        $currentMonth = date('m');

        return view('game', compact('message', 'games', 'token', 'currentDate', 'currentMonth'));
    }
    public function create()
    {
        $user_id = $_SESSION['user_id'];
        Game::create([
            'name' => NULL,
            'releasedate' => NULL,
            'user_id' => $user_id   
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
                $_SESSION['message'] = 'Failed to update!';
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
                $_SESSION['message'] = 'Failed to update!';
                return;
            }
        }

        $_SESSION['message'] = 'Succesfully updated!';
    }
}