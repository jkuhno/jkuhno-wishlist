<?php require "_header.view.php";?>
    <div class="panel-body">
        <div class="pull-left text-left login-form">
            <h3>Log in:</h3>
            <form action="<?= url('/login') ?>" method="POST">
                <div class="form-group">
                    <label class="sr-only">Email</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
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
                    <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-log-in"></span> Log in</button>
                </div>
            </form>
        </div>
    </div>
<?php require "_footer.view.php";?>