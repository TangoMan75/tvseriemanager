<?php $this->layout('layout', ['title' => 'password']) ?>

<?php $this->start('main_content') ?>

<form method="POST" class="background">
	<h3>You want to change your password ?</h3>
	<label>Please enter your email : </label><br />
	<input type="email" name="email" placeholder="Enter your email">
	<input type="submit" value="Recover">
</form>

<?php $this->stop('main_content') ?>