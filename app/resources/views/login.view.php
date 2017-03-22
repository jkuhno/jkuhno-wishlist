<?php require "_header.view.php";?>
    <div class="panel-body">
        <?php if(isset($message)): ?>
        <div class="alert alert-info">
        <?= $message ?>
        </div>
        <?php endif; ?>
        <div class="center-block login-form rounded">
            <form action="<?= url('/login') ?>" method="POST">
                <div class="form-group">
                    <label for="email" class="label">Email:</label>
                    <input id="email" class="form-control" type="email" name="email" placeholder="Enter email">
                </div>
                <div class="form-group">
                    <label for="pwd" class="label">Password:</label>
                    <input id="pwd" class="form-control" type="password" name="password" placeholder="Enter password">
                </div>
                <button type="submit" class="btn btn-default">Log in</button>
            </form>
        </div>
    </div>
<?php require "_footer.view.php";?>