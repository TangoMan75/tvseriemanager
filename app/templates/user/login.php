<?php $this->layout('layout', ['title' => 'login']) ?>

<?php $this->start('main_content') ?>
	<h3>Bienvenue <?= $w_user['username'] ?></h3>
	
	<a href="<?php echo $this->url('profile') ?>" title="Profile">Go to your profile</a><br />
	<a href="<?php echo $this->url('home') ?>" title="Home">Go to the home menu</a><br />


<?php $this->stop('main_content') ?>

