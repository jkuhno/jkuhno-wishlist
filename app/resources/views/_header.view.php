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
    <body>
        <div class="container">
        <div class="panel panel-default">
        <div class="panel-heading">
            <?php if(isset($_SESSION['user_id'])): ?>
                <div class="text-right">
                    <p class="small">You are logged in as <?= $_SESSION['name']; ?></p>
                    <a class="btn btn-sm" href="<?= url('/logout') ?>"><span class="glyphicon glyphicon-log-out"></span> Log out</a>
                </div>
            <?php endif; ?>
            <h1>Wishlist</h1>
        </div>
        <?php if(isset($success)): ?>
            <script>
                localStorage.setItem('success', '<?= $_SESSION['success']; ?>')
            </script>
        <?php endif; ?>
        <?php if(isset($failure)): ?>
            <script>
                localStorage.setItem('failure', '<?= $_SESSION['failure']; ?>')
            </script>
        <?php endif; ?>