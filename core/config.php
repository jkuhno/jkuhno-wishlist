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
    'beginning' => 'https://jkuhno-wishlist.herokuapp.com'
];