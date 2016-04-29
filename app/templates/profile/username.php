<?php $this->layout('layout', ['title' => 'Profile']) ?>

<?php $this->start('main_content') ?>
	
	<div class="background">
		<h3>Want to change your username ?</h3>
		
		<form method="POST">
			<label>Please enter your new username : </label><br />
			<input type="username" name="username" placeholder="My new username">
			<input type="submit" value="Change it">
		</form>
	</div>

<?php $this->stop('main_content') ?>