<?php require "_header.view.php"; ?>
    <div class="panel-body">
        <div class="well">
            <h3>User info</h3>
            <p>Name: <?= $_SESSION['name']; ?></p>
            <p>Email: <?= $_SESSION['email']; ?></p>
            <h3>Update info</h3>
            <form class="form" action="<?= url('/user/update') ?>" method="POST">
                <div class="row"><div class="col-xs-4"><span class="help-block bg-info">Enter a new value to the field(s) you want to update.</span></div></div>
                <input type="hidden" name="token" value="<?= $token; ?>">
                <input type="hidden" name="id" value="<?= $_SESSION['user_id']; ?>">
                <div class="form-group">
                    <label class="sr-only">Name</label>
                    <div class="input-group col-xs-4">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input id="updatename" class="form-control" type="text" name="name" placeholder="New name">
                    </div>
                </div>
                <div class="form-group">
                    <label class="sr-only">Email</label>
                    <div class="input-group col-xs-4">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                        <input id="updateemail" class="form-control" type="email" name="email" placeholder="New email">
                    </div>
                </div>
                <div class="form-group">
                    <label class="sr-only">Password</label>
                    <div class="input-group col-xs-4">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="updatepwd" class="form-control" type="password" name="password" placeholder="New password">
                    </div>
                    <small class="text-muted">Changing password will log you out.</small>
                </div>
                <button class="btn btn-default">Update</button>
            </form>
            <h3>Delete account</h3>
            <form class="form-inline" action="<?= url('/user/delete') ?>" method="POST">
                <input type="hidden" name="token" value="<?= $token; ?>">
                <input type="hidden" name="id" value="<?= $_SESSION['user_id']; ?>">
                <div class="row"><div class="col-xs-4"><span class="help-block bg-danger">THIS WILL PERMANENTLY DELETE YOUR ACCOUNT AND ALL GAMES ASSOCIATED WITH IT!</span></div></div>
                <button type="submit" class="btn btn-danger">Remove user</button>
            </form>
        </div>
    </div>
<?php require "_footer.view.php"; ?>