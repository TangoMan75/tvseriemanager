<?php $this->layout('layout', ['title' => 'Série']) ?>

<?php $this->start('main_content') ?>

	<div id="serie-info" class="background">
		<h2><?= $serie["title"] ?></h2>
		<img src="http://ia.media-imdb.com/images/M/<?= $serie["poster_id"] ?>._V1_SX640_SY720_.jpg" />
		<div class="detail-serie">
			<p id="serie-start"><strong>Start: </strong><?= $serie["start_date"] ?></p>
			<p id="serie-genre"><strong>Genre: </strong><?= $serie["genre"] ?></p>
			<p id="serie-actors"><strong>Main Actors: </strong><?= $serie["actors"] ?></p>
			<p id="serie-summary"><strong>Synopsis: </strong><?= $serie["summary"] ?></p>
			<div id="serie-collection">
			<?php
			if (!empty($w_user)) {
				
				if ($foundCollection){
					?>
					<a href="<?= $this->url('removeFromCollection', ["id"=>$serie["id"]]) ?>" id="remove-collection"><i class="fa fa-times"></i> Remove from my collection</a>
					<?php
				} 
				else {
					?>
					<a href="<?= $this->url('addToCollection', ["id"=>$serie["id"]]) ?>" id="add-collection"><i class="fa fa-heart"></i> Add to my collection</a>
				<?php
				}
			} else {
				?>
				<p>You can add this show to your collection if you <a href="<?php echo $this->url('register') ?>"> register</a>.</p>
			<?php 
			}
			?>
			</div>			
		</div>
	

	
	
	<div id="links">

		<a href="http://www.amazon.fr/s/ref=nb_sb_noss_2?__mk_fr_FR=%C3%85M%C3%85%C5%BD%C3%95%C3%91&url=search-alias%3Daps&field-keywords=<?= $serie["title"] ?>" target="_blank"><i class="fa fa-amazon"> Amazon</i></a>

		<br />

		<a href="https://kat.cr/usearch/<?= $serie["title"] ?>/" target="_blank"><i class="fa fa-download"> Get torrents from KickassTorrents	</i></a>
	</div>
	</div>
	
<?php $this->stop('main_content') ?>