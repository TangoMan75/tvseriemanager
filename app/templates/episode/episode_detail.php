<?php $this->layout('layout', ['title' => 'Episode']) ?>

<?php $this->start('main_content') ?>

	<div id="episode-info" class="background">
		<h2><?= $episode["title"] ?></h2>
		<div id="season-episode">Season <?= $episode["season"] ?>, Episode <?= $episode["episode"] ?></div>
		<img src="http://ia.media-imdb.com/images/M/<?= $episode["poster_id"] ?>._V1_SX640_SY720_.jpg" />
		<div class="detail-serie">
			<div id="episode-start"><strong>Original air date :</strong> <?= $episode["air_date"] ?></div>
			<div id="episode-summary"><strong>Synopsis :</strong> <?= $episode["summary"] ?></div>
		</div>
	</div>
	
	
<?php $this->stop('main_content') ?>
