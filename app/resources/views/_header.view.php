<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <meta content="<?= bin2hex(openssl_random_pseudo_bytes(32)); ?>" name="csrf-token"/>
        <title>Wishlist</title>
        <!-- Favicon -->
        <link rel="icon" href="app/resources/img/favicon.png"/>

        <!-- Latest Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>

        <!-- Toastr CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css"/>

        <!-- Custom stylesheet -->
        <link rel="stylesheet" href="app/resources/css/style.css"/>

        <!-- Lates jQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    
        <!-- Latest Bootstrap JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <!-- Toastr JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    
        <!-- Custom scripts -->
        <script src="app/resources/scripts/script.js"></script>
    </head>
    <?php if(isset($_SESSION['success'])) {
            $success = $_SESSION['success'];
            unset($_SESSION['success']);
        }
    ?>
    <?php if(isset($_SESSION['failure'])) {
            $failure = $_SESSION['failure'];
            unset($_SESSION['failure']);
        }
    ?>
    <?php
        if (isset($_GET['msg'])) {
            $success = base64_decode(urldecode$_GET['msg']));
        }
    ?>
    <?php if(isset($success)): ?>
        <script>
            localStorage.setItem('success', '<?= $success; ?>');
        </script>
    <?php endif; ?>
    <?php if(isset($failure)): ?>
        <?php if(is_array($failure)): ?>
            <script>
                localStorage.setItem('failure', '<?= implode("<br>",$failure); ?>');
            </script>
        <?php else: ?>
            <script>
                localStorage.setItem('failure', '<?= $failure; ?>');
            </script>
        <?php endif; ?>
    <?php endif; ?>
    <body>
        <div class="container">
        <div class="panel panel-default">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span> 
                    </button>
                    <a class="navbar-brand" href="#">Wishlist</a>
                </div>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <div class="collapse navbar-collapse" id="myNavbar">
                        <?php if($_SESSION['group_id'] == 2): ?>
                            <ul class="nav navbar-nav">
                                <li><a href="<?= url('/games') ?>">Games</a></li>
                            </ul>
                        <?php endif; ?>
                        <ul class="nav navbar-nav navbar-right">
                            <?php if($_SESSION['group_id'] != 1): ?>
                                <li><a href="<?= url('/user') ?>"><span class="glyphicon glyphicon-user"></span> <?= $_SESSION['name'] ?></a></li>
                            <?php endif; ?>
                            <li><a href="<?= url('/logout') ?>"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <div class="collapse navbar-collapse" id="myNavbar">
                        <ul class="nav navbar-nav">
                            <li><a href="<?= url('/') ?>">Home</a></li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="<?= url('/register') ?>"><span class="glyphicon glyphicon-user"></span> Register</a></li>
                            <li><a href="<?= url('/login') ?>"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </nav>