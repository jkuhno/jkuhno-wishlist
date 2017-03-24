<?php require "_header.view.php"; ?>
    <div class="panel-body">
        <div class="center-block well">
            <?php foreach($users as $user) :?>
                <ul class="list-group">
                    <li class="list-group-item">
                    <?= htmlspecialchars($user->name); ?> | <?= htmlspecialchars($user->email); ?> | <?= htmlspecialchars($user->group_id) ?><form action="<?= url('/admin/delete') ?>" method="POST"><input type="hidden" name="token" value="<?= $token; ?>"><input type="hidden" name="id" value="<?= $user->id; ?>"><button type="submit" class="btn btn-link">Remove</button>
                    </form></li>
                </ul>
            <?php endforeach; ?>
            <form class="form-inline" action="<?= url('/register') ?>" method="POST">
                <input type="hidden" name="token" value="<?= $token; ?>">
                <div class="form-group">
                    <label class="sr-only">Name</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input id="name" class="form-control" type="text" name="name" placeholder="Enter your name">
                    </div>
                </div>
                <div class="form-group">
                    <label class="sr-only">Email</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                        <input id="email" class="form-control" type="email" name="email" placeholder="Enter email">
                    </div>
                </div>
                <div class="form-group">
                    <label class="sr-only">Password</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="pwd" class="form-control" type="password" name="password" placeholder="Enter password">
                    </div>
                </div>
                <div>
                    <button class="btn btn-default">Register</button>
                </div>
            </form>
        </div>
    </div>
<?php require "_footer.view.php"; ?>