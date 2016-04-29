<?php $this->layout('layout', ['title' => 'Lost ?']) ?>

<?php $this->start('main_content'); ?>
<div class="background">
	<h1>Lost ?</h1>
	<h3>Go back to the <a href="<?php echo $this->url('home') ?>">home menu</a> !</h3>
	<img src="<?= $this->assetUrl('img/lost.jpg') ?>" >
</div>
<?php $this->stop('main_content'); ?>
