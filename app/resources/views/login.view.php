<?php require "_header.view.php"; ?>
<div class="panel-body">
<a href="/games">Games</a>
</div><!--panel-body-->
<?php require "_footer.view.php"; ?>

<?php require "_header.view.php"; ?>
    <div class="panel">
        <p class="panel-heading">Log in</h3>
        <div class="panel-block">
            <?php if(isset($message)): ?>
                <div class="notification is-warning">
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
    </div>
<?php require "_footer.view.php"; ?>