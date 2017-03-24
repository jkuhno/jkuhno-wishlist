<?php require "_header.view.php"; ?>
    <div class="panel-body">
        <div class="center-block well">
            <h3>Users</h3>
            <?php foreach($users as $user) :?>
                <ul class="list-group">
                    <li class="list-group-item">
                        <?= htmlspecialchars($user->id); ?> | <?= htmlspecialchars($user->name); ?> | <?= htmlspecialchars($user->email); ?> | <form class="form-inline" action="<?= url('/admin/delete') ?>" method="POST"><input type="hidden" name="token" value="<?= $token; ?>"><input type="hidden" name="id" value="<?= $user->id; ?>"><button type="submit" class="btn btn-link">Remove</button></form>
                    </li>
                </ul>
            <?php endforeach; ?>
            <h3>Create user</h3>
            <form class="form-inline" action="<?= url('/register') ?>" method="POST">
                <input type="hidden" name="token" value="<?= $token; ?>">
                <div class="form-group">
                    <label class="sr-only">Name</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input id="createname" class="form-control" type="text" name="name" placeholder="Enter name">
                    </div>
                </div>
                <div class="form-group">
                    <label class="sr-only">Email</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                        <input id="createemail" class="form-control" type="email" name="email" placeholder="Enter email">
                    </div>
                </div>
                <div class="form-group">
                    <label class="sr-only">Password</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="createpwd" class="form-control" type="password" name="password" placeholder="Enter password">
                    </div>
                </div>
                <button class="btn btn-default">Create</button>
            </form>
            <h3>Update user</h3>
            <form class="form-inline" action="<?= url('/admin/update') ?>" method="POST">
                <input type="hidden" name="token" value="<?= $token; ?>">
                <div class="form-group">
                    <label class="sr-only">Id</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></span>
                        <input id="updateid" class="form-control" type="number" name="id" placeholder="Enter ID">
                    </div>
                </div>
                <div class="form-group">
                    <label class="sr-only">Name</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input id="updatename" class="form-control" type="text" name="name" placeholder="Enter name">
                    </div>
                </div>
                <div class="form-group">
                    <label class="sr-only">Email</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                        <input id="updateemail" class="form-control" type="email" name="email" placeholder="Enter email">
                    </div>
                </div>
                <div class="form-group">
                    <label class="sr-only">Password</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="updatepwd" class="form-control" type="password" name="password" placeholder="Enter password">
                    </div>
                </div>
                <button class="btn btn-default">Update</button>
            </form>
        </div>
    </div>
<?php require "_footer.view.php"; ?>