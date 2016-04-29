<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title><?= $this->e($title) ?></title>

	<link rel="stylesheet" href="<?= $this->assetUrl('css/normalize.css') ?>">
	<link rel="stylesheet" href="<?= $this->assetUrl('css/bootstrap.min.css') ?>">
	<link rel="stylesheet" href="<?= $this->assetUrl('css/style.css') ?>">

	<link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

</head>


<body>

	<div id="main-content" class="container-fluid">

 		<!-- <nav class="navbar navbar-default" role="navigation"> -->

  		<header>

		   	<!--logo-->
	  		<a href="<?php echo $this->url('home') ?>" id="site-logo">
	  			<img src="<?= $this->assetUrl('img/logoSM.png') ?>" alt="logo" class="hidden-xs">
	  			<img src="<?= $this->assetUrl('img/logoSMsmall.png') ?>" alt="logo" class="visible-xs">
  			</a>

			<!-- login -->
			<div id="log-nav" class="hidden-xs">
			<?php if (!empty($w_user)) { ?>
				<p>You are logged as <?= $w_user['username'] ?></p>

				<!-- logout -->
				<a href="<?php echo $this->url('logout') ?>" title="Logout">Logout</a><br />
			<?php } else { ?>
				<form action="<?php echo $this->url('login') ?>" method="POST" id="log-form">
					<div class="form-group">
						<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
						<input type="username" name="username" placeholder="Username">
					</div>

					<div class="form-group">
						<span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
						<input type="password" name="password" placeholder="Password">
						<br />
						<a href="<?php echo $this->url('password') ?>" title="Password" id="pw-forgot">Forgot your password ?</a>
					</div>

					<input type="submit" value="Log In" id="login-input">

				</form>
				<?php
				}
				?>
			</div>

    		<!--menu-->
    		<?php
    			if (!empty($w_user)) {
    				?>
		    		<div id="menu">
			    		<ul class="nav-menu">
			    		  <li><a href="<?php echo $this->url('home') ?>" title="Home">Home</a></li>
			    		  <li><a href="<?php echo $this->url('profile') ?>">Profile</a></li>
			    		</ul>
		    		</div>
	    		<?php
	    		}
	    		else{?>
		    		<div id="menu-logout">
			    		<ul class="nav-menu">
			    		  <li><a href="<?php echo $this->url('home') ?>" title="Home">Home</a></li>
			    		  <li><a data-toggle="collapse" href="#collapseLogin" aria-expanded="false" aria-controls="collapseLogin" class="visible-xs">Login</a>
			    		  <div class="collapse" id="collapseLogin">
			    		    <div class="well">

								<!-- Collapse login -->
			    		      <?php
			    		      	if (!empty($w_user)) {
			    		      		?>
			    		      		<p>You are logged as <?= $w_user['username'] ?></p>

			    		      		<!-- logout -->
			    		      		<a href="<?php echo $this->url('logout') ?>" title="Logout">Logout</a><br />
			    		      <?php
			    		      }
			    		      else {?>
			    		      	<form action="<?php echo $this->url('login') ?>" method="POST" id="log-form-collapse">
			    		      		<div class="form-group">
			    		      			<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
			    		      			<input type="username" name="username" placeholder="Username">
			    		      		</div>

			    		      		<div class="form-group">
			    		      			<span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
			    		      			<input type="password" name="password" placeholder="Password">
			    		      			<br />
			    		      			<a href="<?php echo $this->url('password') ?>" title="Password" id="pw-forgot">Forgot your password ?</a>
			    		      		</div>

			    		      		<input type="submit" value="Log In" id="login-input">

			    		      	</form>
			    		      	<?php
			    		      	}
			    		      	?>

			    		   </div>
			    		  <li><a href="<?php echo $this->url('register') ?>">Register</a></li>
			    		</ul>
		    		</div>
	    		<?php
	    		}
	    		?>

	    		<div id="login-name" class="visible-xs">
	    		<?php
	    			if (!empty($w_user)) {
	    				?>
	    				<p>You are logged as <?= $w_user['username'] ?></p>

	    				<!-- logout -->
	    				<a href="<?php echo $this->url('logout') ?>" title="Logout">Logout</a><br />
	    		<?php
	    		}
	    		?>
	    		</div>



		<form id="serie-search-form">
			<input type="search" name="keyword" id="keyword-input" class="form-control" placeholder="Search by title...">
		</form>
		<div id="result-search"></div>

		</header><!-- container-fluid-->



		<!-- for masonry -->
		<section id="section">
			<?= $this->section('main_content') ?>
		</section>

		<!-- for sticky footer -->
		<div class="push"></div>

	</div> <!-- main-content -->

	<footer>
		<ul>
			<li><a href="<?php echo $this->url('home') ?>"><p>Home</p></a><span> | </span></li>
			<li><a href="<?php echo $this->url('register') ?>"><p>Register</p></a><span> | </span></li>
			<li><a href="<?php echo $this->url('legal') ?>"><p>Terms & Conditions</p></a><span> | </span></li>
			<li><a href="<?php echo $this->url('about') ?>"><p>About Us</p></a></li>
		</ul>
		<p><span class="glyphicon glyphicon-copyright-mark" aria-hidden="true"></span> SeriesManager</p>
		<p>Made by CAMS Squad</p>
	</footer>

	<script>
		// Defines asset url
		var strAssetUrl = "<?= $this->assetUrl('') ?>";
	</script>


	<script src="<?= $this->assetUrl('js/jquery-1.12.0.min.js') ?>"></script>

	<script src="<?= $this->assetUrl('js/bootstrap.min.js') ?>"></script>

	<script src="<?= $this->assetUrl('js/masonry.pkgd.js') ?>"></script>

	<script src="<?= $this->assetUrl('js/main.js') ?>"></script>

</body>
</html>