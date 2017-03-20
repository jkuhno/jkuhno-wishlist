<?php
    
    require 'app/models/Game.php';

    $error = true;
    $rowId = 0;
    $name = '';
    $rdate = '';
    $msg = '';

    if(isset($_POST['action'])) {
        /* Create row */
        if($_POST['action'] == 'create') {
            $error = false;
            Game::createEmptyRow();
            $msg = array('status' => !$error, 'msg' => 'Creation succeeded!');
        }
        /* Remove row */
        if($_POST['action'] == 'remove') {
            if(isset($_POST['id']) && is_numeric($_POST['id'])) {
                $rowId = $_POST['id'];
                $error = false;
            } else {
                $error = true;
            }

            if(!$error) {
                Game::delete($rowId);
                $msg = array('status' => !$error, 'msg' => 'Remove succeeded!');
            } else {
                $msg = array('status' => !$error, 'msg' => 'Remove failed!');
            }
        }
        /* Update row */
        if($_POST['action'] == 'update') {
            if(isset($_POST['id']) && is_numeric($_POST['id'])) {
                $rowId = $_POST['id'];
                if(isset($_POST['name']) || isset($_POST['releasedate'])) {
                    $error = false;
                    if(isset($_POST['name']) && !empty($_POST['name'])) {
                        if(preg_match('/^[A-Za-z0-9_~\-:;.,+?!@#\$%\^&\*\'"\(\)\/\\\\ ]+$/',$_POST['name'])) {
                            $name = $_POST['name'];
                        }
                        else {
                            $error = true;
                        }
                    }
                    if(isset($_POST['releasedate']) && !empty($_POST['releasedate']) && !$error) {
                        $dt = DateTime::createFromFormat("F d, Y", $_POST['releasedate']);
                        if($dt !== false && !array_sum($dt->getLastErrors())) {
                            $rdate = $dt->format("Y-m-d");
                            $error = false;
                        }
                        else {
                            $error = true;
                        }
                    }
                }
                else {
                    $error = true;
                }
            }
            else {
                $error = true;
            }
            if(!$error) {
                if(isset($_POST['name'])) {
                    Game::update($rowId, $name);
                }
                if(isset($_POST['releasedate'])) {
                    Game::update($rowId, $rdate);
                }
                $msg = array('status' => !$error, 'msg' => 'Update succeeded!');
            } else {
                $msg = array('status' => !$error, 'msg' => 'Update failed!');
            }
        }
    }

    if(!empty($msg)) {
        header('Content-type: application/json; charset=utf-8');
        print json_encode($msg);
    }

    /*Request list of games in database.*/
    $games = Game::all();

    date_default_timezone_set('Europe/Helsinki');
    $currentDate = date('Y-m-d');
    $currentMonth = date('m');
    require 'app/resources/views/index.view.php';