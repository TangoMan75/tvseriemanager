<?php foreach ($series as $serie): ?>

	<div id="search-info">
		<a href="<?= $this->url("detail", ["id"=>$serie["id"]]) ?>">
			<img src="http://ia.media-imdb.com/images/M/<?= $serie["poster_id"] ?>._V1_UX67_CR0,0,67,98_AL_.jpg"  /><?= $serie["title"] ?> (<?= $serie["start_date"] ?>)
		</a>
	</div>

<?php endforeach; ?>
