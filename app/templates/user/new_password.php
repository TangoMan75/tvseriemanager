<?php $this->layout('layout', ['title' => 'new_password']) ?>

<?php $this->start('main_content') ?>

<form method="POST" class="background">
	<input type="password" name="password" placeholder="New password"><br />
	<input type="password" name="password_bis" placeholder="Confirm password"><br />
	<input type="submit" value="Change it" />
	
</form>

<?php $this->stop('main_content') ?>