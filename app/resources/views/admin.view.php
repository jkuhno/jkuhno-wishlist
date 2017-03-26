<?php require "_header.view.php"; ?>
    <div class="panel-body">
        <div class="center-block well">
            <h3>Users</h3>
            <ul class="list-group">
                <?php foreach($users as $user): ?>
                    <li>ID: <?= htmlspecialchars($user->id); ?> | Name: <?= htmlspecialchars($user->name); ?> | Email: <?= htmlspecialchars($user->email); ?> | <form class="form-inline" action="<?= url('/user/delete') ?>" method="POST"><input type="hidden" name="token" value="<?= $token; ?>"><input type="hidden" name="id" value="<?= $user->id; ?>"><input type="submit" class="btn btn-link" value="Remove"></form></li>
                    <ul>
                        <?php foreach($games as $game): ?>
                            <?php if($game->user_id == $user->id): ?>
                                <li>Game id: <?= htmlspecialchars($game->id); ?> | Game name: <?= htmlspecialchars($game->name); ?> | Game release date: <?= htmlspecialchars($game->releasedate); ?> | <form action="<?= url('/games/delete') ?>" method="POST"><input type="hidden" name="token" value="<?= $token; ?>"><input type="hidden" name="id" value="<?= $game->id; ?>"><input type="hidden" name="user_id" value="<?= $user->id; ?>"><button type="submit" class="btn btn-link">Remove</button></form></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                <?php endforeach; ?>
            </ul>
            <h3>Update user</h3>
            <form class="form-inline" action="<?= url('/user/update') ?>" method="POST">
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
            <h3>Update game</h3>
            <form class="form-inline" action="<?= url('/games/update') ?>" method="POST">
                <input type="hidden" name="token" value="<?= $token; ?>">
                <div class="form-group">
                    <label class="sr-only">User ID</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></span>
                        <input id="updategameuserid" class="form-control" type="number" name="user_id" placeholder="Enter user id">
                    </div>
                </div>
                <div class="form-group">
                    <label class="sr-only">Game ID</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></span>
                        <input id="updategameid" class="form-control" type="number" name="id" placeholder="Enter game id">
                    </div>
                </div>
                <div class="form-group">
                    <label class="sr-only">Name</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input id="updategamename" class="form-control" type="text" name="name" placeholder="Enter name">
                    </div>
                </div>
                <div class="form-group">
                    <label class="sr-only">Release date</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                        <input id="updategamerdate" class="form-control" type="text" name="releasedate" placeholder="Enter release date">
                    </div>
                </div>
                <button class="btn btn-default">Update</button>
            </form>
        </div>
    </div>
<?php require "_footer.view.php"; ?>