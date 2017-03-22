<?php require "_header.view.php"; ?>
    <div class="panel-body">
        <?php if(isset($message)): ?>
            <div class="alert alert-success">
                <?= $message ?>
            </div>
        <?php endif; ?>
        <?php if(isset($errors)): ?>
            <div class="alert alert-error">
                <ul>
            <?php foreach($errors as $error): ?>
                <li><?= $error; ?></li>
            <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <div class="center-block register-form">
            <form action="<?= url('/register') ?>" method="POST">
                <div class="input-group">
                    <span class="glyphicon glyphicon-user"></i></span>
                    <input class="input" type="text" name="name" placeholder="Enter your name">
                </div>
                <div class="input-group">
                    <span class="glyphicon glyphicon-envelope"></i></span>
                    <input class="input" type="email" name="email" placeholder="Enter email">
                </div>
                <div class="input-group">
                    <span class="glyphicon glyphicon-lock"></i></span>
                    <input class="input" type="password" name="password" placeholder="Enter password">
                </div>
                <div class="text-center">
                    <button class="btn btn-default">Register</button>
                </div>
            </form>
        </div>
    </div>
<?php require "_footer.view.php"; ?>