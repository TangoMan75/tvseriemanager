<?php $this->layout('layout', ['title' => 'logout']) ?>

<?php $this->start('main_content') ?>

	<h3>You're logged out.</h3><br />
	<a href="<?php echo $this->url('home') ?>" title="Home">Go to the home menu</a><br />

<?php $this->stop('main_content') ?>