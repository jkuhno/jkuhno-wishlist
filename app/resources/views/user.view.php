<?php require "_header.view.php"; ?>
    <div class="panel-body">
        <div class="center-block well">
            <h3>User info</h3>
            <p>Name: <?= $_SESSION['name']; ?></p>
            <p>Email: <?= $_SESSION['email']; ?></p>
            <h3>Update user</h3>
            <p></p>
            <form class="form-inline" action="<?= url('/user/update') ?>" method="POST">
                <input type="hidden" name="token" value="<?= $token; ?>">
                <input type="hidden" name="id" value="<?= $_SESSION['user_id']; ?>">
                <div class="form-group">
                    <label class="sr-only">Name</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input id="updatename" class="form-control" type="text" name="name" placeholder="New password">
                    </div>
                </div>
                <div class="form-group">
                    <label class="sr-only">Email</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                        <input id="updateemail" class="form-control" type="email" name="email" placeholder="New password">
                    </div>
                </div>
                <div class="form-group">
                    <label class="sr-only">Password</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="updatepwd" class="form-control" type="password" name="password" placeholder="New password">
                    </div>
                </div>
                <button class="btn btn-default">Update</button>
            </form>
            <h3>Delete user</h3>
            <form class="form-inline" action="<?= url('/user/delete') ?>" method="POST">
                <input type="hidden" name="token" value="<?= $token; ?>">
                <input type="hidden" name="id" value="<?= $_SESSION['user_id']; ?>">
                <button type="submit" class="btn btn-default">Remove user</button>
            </form>
        </div>
    </div>
<?php require "_footer.view.php"; ?>