<?php

namespace Wishlist\App\Controllers;

class UserController
{
	public function index()
	{
		$message = "Login";

		require 'app/resources/views/user.view.php';

	}
}
