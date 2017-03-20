<?php require "_header.view.php"; ?>
<div class="panel-body">

<?php if(strlen($message) > 0): ?>
<div class="notification is-primary">
	<?= $message; ?>
</div>
<?php endif; ?>
<a href="/games">Games</a>
</div><!--panel-body-->
<?php require "_footer.view.php"; ?>