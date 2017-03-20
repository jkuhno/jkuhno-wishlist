<?php

namespace Wishlist\App\Controllers;

class HomeController
{
	public function index()
	{
		$message = "Login";

		require 'app/resources/views/user.view.php';

	}
}
