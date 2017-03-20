<?php
    require '/core/bootstrap.php';

    require Router::define(require '/app/routes.php')
        ->fire(Request::uri());