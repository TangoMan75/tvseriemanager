<?php

namespace Controller;

use \W\Controller\Controller;

/**
 * Back-office Scraper controller.
 *
 * Scrapes imdb TV series and episodes, sends result to DefaulManager for database storage.
 *
 * This class is not meant for front end purposes.<br><br>
 *
 * Routes :
 * <pre>
 * ../scrape/
 * ../scrapepages/[:from]/[:to]
 * ../scrapeserie/[:title]
 * </pre><br>
 *
 * Offers methods :
 * <pre>
 * scrapeMostPopularSeries()
 * scrapePages($from, $to)
 * scrapeSerie($title)
 * </pre>
 * 
 * @last_modified  14:54 04/03/2016
 * @author         Matthias Morin <matthias.morin@gmail.com>
 * @copyright      2015-2016 - Matthias Morin, Full Stack Web Developer
 */
class ScraperController extends Controller {
	/**
	 * Contains "error" array
	 * @var array
	 */
	protected $error;

	/**
	 * Initializes "error" property
	 * @version 1.0
	 */
	public function __construct() {

		// Sets "error" property
		$this->error = [
				'error'   => true,
				'title'   => 'Unknown error.',
				'summary' => 'Some unknown error occured.',
			];
	}

	/**
	 * Scrapes 50 most popular TV series from imdb result page.
	 *
	 * @version         1.2.3
	 * @return   array  Error
	 */
	public function scrapeMostPopularSeries() {
		// Initializes objects
		$imdbScraper    = new \Scraper\ImdbScraper();
		$defaultManager = new \Manager\DefaultManager();
		// Gets 50 most popular TV series id from imdb result page
		$seriesId = $imdbScraper->scrapeSeriesId('http://www.imdb.com/search/title?start=1&title_type=tv_series');
		// Inserts serie into database
		foreach ($seriesId as $imdb_id) {
			$this->insertSerie($imdb_id);
		}
	}

	/**
	 * Scrapes most popular TV series from imdb result pages.
	 *
	 * @version           1.3.5
	 * @param    integer  $from  Start from page x
	 * @param    integer  $to    ... To page y
	 * @return   array    Error
	 */
	public function scrapePages($from, $to) {
		// Initializes objects
		$imdbScraper    = new \Scraper\ImdbScraper();
		$defaultManager = new \Manager\DefaultManager();
		$from = ($from*50)+1;
		$to = $to*50;
		for ($i=$from; $i<=$to; $i+=50) {
			// Gets 50 series id from imdb from result page
			$seriesId = $imdbScraper->scrapeSeriesId("http://www.imdb.com/search/title?start=$i&title_type=tv_series");
			// Inserts serie into database
			foreach ($seriesId as $imdb_id) {
				$this->insertSerie($imdb_id);
			}
		}
	}

	/**
	 * Scrapes first TV serie from imdb result page, if any.
	 *
	 * @version 2.5.5
	 * @param   string   $title  User query as serie title
	 * @return  string           Contains imdb_id
	 */
	public function scrapeSerie($title) {
		// Initializes scraper
		$imdbScraper    = new \Scraper\ImdbScraper();
		// Gets series id containing $title
		$seriesId = $imdbScraper->scrapeSeriesId('http://www.imdb.com/search/title?title='.urlencode($title).'&title_type=tv_series');
		// Inserting serie into database when results are returned
		if ($seriesId) {
			$this->insertSerie($seriesId[0]);
		}
	}

	/**
	 * Scrapes TV serie from imdb and inserts serie details into database.
	 *
	 * @version                   2.6.0
	 * @param   string  $imdb_id  imdb reference id
	 */
	public function insertSerie($imdb_id) {
		// Initializes objects
		$imdbScraper    = new \Scraper\ImdbScraper();
		$defaultManager = new \Manager\DefaultManager();
		$serieManager   = new \Manager\SerieManager();
		$episodeManager = new \Manager\EpisodeManager();
		// Checks if serie is already into database
		$serie = $defaultManager->findWhere($imdb_id, 'imdb_id', 'series');
		if ($serie) {
			// Sends notification to user
			$this->error['title']   = 'Serie alredy into database';
			$this->error['summary'] = "\"" . $serie['title'] . "\" : Aready into database.";
			debug($this->error);
		} else {
			// Scrapes serie
			$serie = $imdbScraper->scrapeSerieById($imdb_id);
			// Joins genre table data into comma separated string
			$serie['genre'] = join(', ', $serie['genre']);
			// Joins actors table data into comma separated string
			$serie['actors'] = join(', ', $serie['actors']);
			// Sets season count into table
			$serie['season_count'] = count($serie['seasons']);
			// Stores seasons table into new table
			$seasons = $serie['seasons'];
			// Deletes "seasons" table from $series
			unset($serie['seasons']);
			// Includes serie to database
			$serieManager->insert($serie);
			$lastId = $defaultManager->lastId();
			// Includes serie episodes from each season to database
			foreach ($seasons as $seasonIndex => $season) {
				foreach ($season['episodes'] as $episodeIndex => $episode) {
					// Resets max_execution_time
					ini_set('max_execution_time', 30);
					// Inserts series primary key into episodes for future table juncture
					$episode['serie_id'] = $lastId;
					// Inserts season number into episodes table
					$episode['season'] = $seasonIndex;
					// Inserts episode number into episodes table
					$episode['episode'] = $episodeIndex;
					$episodeManager->insert($episode);
				}
			}
			// Tests if insertion performed as expected
			$serie = $defaultManager->findWhere($imdb_id, 'imdb_id', 'series');
			if (!$serie) {
				// Sends error message to client
				$this->error['title']   = 'Database insertion failed.';
				$this->error['summary'] = "TV serie: $imdb_id insertion failed.";
				debug($this->error);
			} else {
				// Shows scrape result to client
				debug($serie);
			}
		}
	}
}