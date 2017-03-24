<?php require "_header.view.php"; ?>
    <div class="panel-body">
        <div class="center-block well">
            <?php foreach($users as $user) :?>
                <ul class="list-group">
                    <li class="list-group-item"><?= htmlspecialchars($user->name); ?> | <?= htmlspecialchars($user->email); ?> | <?= htmlspecialchars($user->group_id) ?><form action="<?= url('/admin/delete') ?>" method="POST"><input type="hidden" name="token" value="<?= $token; ?>"><input type="hidden" name="id" value="<?= $users->id; ?>"><button type="submit" class="btn btn-link">Remove</button>
                    </form></li>
                </ul>
            <?php endforeach; ?>
        </div>
    </div>
<?php require "_footer.view.php"; ?>