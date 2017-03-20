<?php
$dbopts = parse_url(getenv('DATABASE_URL'));
/*'pdo.dsn' => 'pgsql:dbname='.ltrim($dbopts["path"],'/').';host='.$dbopts["host"] . ';port=' . $dbopts["port"],
'pdo.username' => $dbopts["user"],
'pdo.password' => $dbopts["pass"]*/
return [
    'database' => [
        'name' => 'pgsql:dbname='.ltrim($dbopts["path"],'/'),
        'username' => $dbopts["user"],
        'password' => $dbopts["pass"],
        'connection' => 'pgsql:host='$dbopts["host"] . ';port=' . $dbopts["port"],
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    ]
];