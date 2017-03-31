<?php require "_header.view.php"; ?>
    <div class="panel-body">
        <div class="center-block well">
            <h3>Users</h3>
            <div class="row">
                <div class="col-xs-2 align-middle"></div>
                <div class="col-xs-4 align-middle"><strong><u>User name</u></strong></div>
                <div class="col-xs-4 align-middle"><strong><u>User email</u></strong></div>
                <div class="col-xs-2 align-middle"></div>
            </div>
            <?php foreach($users as $user): ?>
                <div class="row bg-info">
                    <div class="col-xs-2 align-middle"><a data-toggle="collapse" href="#collapse<?= htmlspecialchars($user->id); ?>"><?= htmlspecialchars($user->name); ?>'s games</a></div>
                    <div class="col-xs-4 align-middle"><?= htmlspecialchars($user->name); ?></div>
                    <div class="col-xs-4 align-middle"><?= htmlspecialchars($user->email); ?></div>
                    <div class="col-xs-2 align-middle"><form action="<?= url('/user/delete') ?>" method="POST"><input type="hidden" name="token" value="<?= $token; ?>"><input type="hidden" name="id" value="<?= $user->id; ?>"><input type="submit" class="btn btn-link" value="Remove"></form></div>
                </div>
                <div id="collapse<?= htmlspecialchars($user->id); ?>" class="collapse">
                    <div class="row">
                        <div class="col-xs-1 align-middle"><strong><u>Game id</u></strong></div>
                        <div class="col-xs-5 align-middle"><strong><u>Game name</u></strong></div>
                        <div class="col-xs-5 align-middle"><strong><u>Game release date</u></strong></div>
                        <div class="col-xs-1 align-middle"></div>
                    </div>
                    <?php foreach($games as $game): ?>
                        <?php if($game->user_id == $user->id): ?>
                            <div class="row">
                                <div class="col-xs-1 align-middle"><?= htmlspecialchars($game->id); ?></div>
                                <div class="col-xs-5 align-middle"><?php if(!is_null($game->name)):?><?= htmlspecialchars($game->name); ?><?php endif;?></div>
                                <div class="col-xs-5 align-middle"><?php if(!is_null($game->releasedate)):?><?= date_format(date_create(htmlspecialchars($game->releasedate)), "F d, Y"); ?><?php endif;?></div>
                                <div class="col-xs-1 align-middle"><form action="<?= url('/games/delete') ?>" method="POST"><input type="hidden" name="token" value="<?= $token; ?>"><input type="hidden" name="id" value="<?= $game->id; ?>"><input type="hidden" name="user_id" value="<?= $user->id; ?>"><button type="submit" class="btn btn-link">Remove</button></form></div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
            <h3>Update user</h3>
            <form class="form-inline" action="<?= url('/user/update') ?>" method="POST">
                <input type="hidden" name="token" value="<?= $token; ?>">
                <div class="form-group">
                    <label class="sr-only">Id</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></span>
                        <!--<input id="updateid" class="form-control" type="number" name="id" placeholder="Enter ID">-->
                        <select class="form-control" name="id">
                            <option value="" disabled selected hidden>Select user to update</option>
                            <?php foreach($users as $user): ?>
                                <option value="<?= $user->id; ?>"><?= htmlspecialchars($user->name); ?></option>
                            <?php endforeach; ?>
                        </select>
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
                        <span class="input-group-addon"><i class="glyphicon glyphicon-gbp"></i></span>
                        <input id="updategameid" class="form-control" type="number" name="id" placeholder="Enter game id">
                    </div>
                </div>
                <div class="form-group">
                    <label class="sr-only">Name</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-tower"></i></span>
                        <input id="updategamename" class="form-control" type="text" name="name" placeholder="Enter game name">
                    </div>
                </div>
                <div class="form-group">
                    <label class="sr-only">Release date</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                        <input id="updategamerdate" class="form-control" type="text" name="releasedate" placeholder="Enter game release date">
                    </div>
                </div>
                <button class="btn btn-default">Update</button>
            </form>
        </div>
    </div>
<?php require "_footer.view.php"; ?>