<?php
namespace Wishlist\App\Controllers;

class HomeController
{
    public function index()
    {
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
        return view('index', compact('success', 'failure'));
    }
}