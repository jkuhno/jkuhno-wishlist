<?php
    //Debugging.
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    require "core/App.php";
    require "core/Request.php";
    require "core/Router.php";
    require "core/database/connection.php";
    require "core/database/QueryBuilder.php";
    require "core/database/Model.php";
    App::bind('config', require 'core/config.php');
    App::bind('database', new QueryBuilder(
        Connection::make(App::get('config')['database'])
    ));