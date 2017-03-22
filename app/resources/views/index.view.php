<?php require "_header.view.php"; ?>
    <div class="panel-body">
    <?php if(isset($message)): ?>
        <div class="alert alert-success">
            <?= $message ?>
        </div>
    <?php endif; ?>
        <div class="center-block text-center">
            <a href="/login">Login</a><br>
            <a href="/register">Register</a>
        </div>
    </div>
<?php require "_footer.view.php"; ?>