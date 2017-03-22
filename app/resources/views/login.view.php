<?php require "_header.view.php";?>
    <div class="panel-body">
        <?php if(isset($message)): ?>
        <div class="alert alert-info">
        <?= $message ?>
        </div>
        <?php endif; ?>
        <form action="<?= url('/login') ?>" method="POST">
            <label class="label">Email</label>
            <p class="form-control">
                <input class="input" type="email" name="email" placeholder="Email">
            </p>
            <label class="label">Password</label>
            <p class="form-control">
                <input class="input" type="password" name="password">
            </p>
            <p class="control">
                <button class="button">Log in</button>
            </p>
        </form>
    </div>
<?php require "_footer.view.php";?>