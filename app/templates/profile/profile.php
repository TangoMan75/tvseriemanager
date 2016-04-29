<?php $this->layout('layout', ['title' => 'Profile']) ?>

<?php $this->start('main_content') ?>
	
	<div id="profile-list" class="background">
		<h2>My profile</h2>
		<ul>
			<li><i class="fa fa-user"></i><a href=""> Change username</a></li>
			<li><i class="fa fa-key"></i>
			<a href="<?php echo $this->url('password') ?>">Change password</a></li>
		</ul>



	</div>

<?php $this->stop('main_content') ?>
