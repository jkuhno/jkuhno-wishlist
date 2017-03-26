<?php
$dbopts = parse_url(getenv('DATABASE_URL'));
return [
	'database' => [
        'name' => ltrim($dbopts["path"],'/'),
        'username' => $dbopts["user"],
        'password' => $dbopts["pass"],
        'connection' => 'pgsql:host='.$dbopts["host"].';port='.$dbopts["port"],
		'options' => [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
		]
	],
<<<<<<< HEAD
    'beginning' => 'https://jkuhno-wishlist.herokuapp.com' //https://jkuhno-wishlist-experimental.herokuapp.com
=======
    'beginning' => 'https://jkuhno-wishlist-experimental.herokuapp.com' //https://jkuhno-wishlist.herokuapp.com
>>>>>>> experimental
];