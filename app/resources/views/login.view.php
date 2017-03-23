<?php require "_header.view.php";?>
    <div class="panel-body">
        <?php if(isset($message)): ?>
            <div class="alert alert-info">
                <?= $message ?>
            </div>
        <?php endif; ?>
        <div class="center-block login-form">
            <form action="<?= url('/login') ?>" method="POST">
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input id="email" class="form-control" type="email" name="email" placeholder="Enter email">
                </div>
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    <input id="pwd" class="form-control" type="password" name="password" placeholder="Enter password">
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-log-in"></span>Log in</button>
                </div>
            </form>
        </div>
    </div>
<?php require "_footer.view.php";?>