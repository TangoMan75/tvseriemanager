<?php

namespace Controller;

use \W\Controller\Controller;

/**
 * Controls tvseriemanager main API.
 *
 * API allows control of four main methods :
 *
 * <code>searchSerie()</code><br>
 * <code>scrapeSerie()</code><br>
 * <code>getSerie()</code><br>
 * <code>getRandomSeries()</code><br><br>
 *
 * User must provide the following arguments with the get method :
 * <pre>
 * $_GET['api_key']          As string   API key (fake)
 * $_GET['method']           As string   One of four availlable methods
 * $_GET['getserie']         As string   Returns TV serie details in json format
 * $_GET['id']               As integer  TV serie primary key
 * $_GET['searchserie']      As string   Searches for TV serie into database by title
 * $_GET['scrapeserie']      As string   Searches for TV serie by title and scrapes TV serie details from imdb when not present into database
 * $_GET['getrandomseries']  As string   Sends random series from database in json format
 * $_GET['limit']            As integer  TV serie count to send to client
 * </pre>
 *
 * @see             \Manager\EpisodeManager        \Manager\EpisodeManager
 * @see             \Manager\DefaultManager        \Manager\DefaultManager
 * @see             \Scraper\ImdbScraper           \Scraper\ImdbScraper
 * @last_modified    13:50 04/03/2016
 * @author           Matthias Morin <matthias.morin@gmail.com>
 * @copyright        2015-2016 - Matthias Morin, Full Stack Web Developer
 */
class ApiController extends Controller {
	/**
	 * Contains client "method" call
	 * @var string
	 */
	protected $method;

	/**
	 * Contains clients "api_key"
	 * @var string
	 */
	protected $apiKey;

	/**
	 * Contains "error" array
	 * @var array
	 */
	protected $error;

	/**
	 * Initializes "method", "apiKey" and "error" properties.
	 * 
	 * @version 1.1.1
	 */
	public function __construct() {
		// Gets $method from $_GET
		$this->method = $_GET['method'];
		// Gets $apikey from $_GET
		$this->apiKey = $_GET['api_key'];
		// Sets "error" property
		$this->error = [
				'error'   => true,
				'title'   => 'Error',
				'summary' => 'Sorry, unknown error occurred.',
			];
	}

	/**
	 * tvseriemanager API main switch.
	 *
	 * Sends user requests to child methods.<br>
	 *
	 * This method is directly called by router.
	 *
	 * @version 1.1.9
	 * @api
	 * @see     ApiController::searchSerie()      ApiController::searchSerie()
	 * @see     ApiController::scrapeSerie()      ApiController::scrapeSerie()
	 * @see     ApiController::getSerie()         ApiController::getSerie()
	 * @see     ApiController::getRandomSeries()  ApiController::getRandomSeries()
	 * @see     ApiController::$method            ApiController::$method
	 * @see     ApiController::$apiKey            ApiController::$apiKey
	 * @see     ApiController::$error             ApiController::$error
	 * @return  object                            Error in json format
	 */
	public function tvSerieManagerSwitch() {

		// API key validation
		if ($this->apiKey != 'inwexrlzidlwncjfrrahtexduwskgtvk'){

			// Returns error to client in json format
			$this->error['title']   = 'Invalid api key';
			$this->error['summary'] = "Key : \"$this->apiKey\" is invalid. You need a valid api key to perform this action.";
			$this->showJson($this->error);
		} else {
			switch ($this->method) {
				case 'searchserie':
					// Gets $keyword from $_GET
					$keyword = $_GET['keyword'];
					$this->searchSerie($keyword);
					break;
				case 'getserie':
					// Gets $id from $_GET
					$id = $_GET['id'];
					$this->getSerie($id);
					break;
				case 'scrapeserie':
					// Gets $keyword from $_GET
					$keyword = $_GET['keyword'];
					$this->scrapeSerie($keyword);
					break;
				case 'getrandomseries':
					// Gets $limit from $_GET
					$limit = $_GET['limit'];
					$this->getRandomSeries($limit);
					break;
				default:
					// Returns error to client in json format
					$this->error['title']   = 'Invalid method';
					$this->error['summary'] = "\"$this->method\" method is illegal.";
					$this->showJson($this->error);
			}
		}
	}

	/**
	 * Searches for TV serie into database by title.
	 *
	 * Returns TV serie details in json format (by title)
	 *
	 * @version                    1.1.3
	 * @param    string  $keyword  TV serie title
	 * @return   object            TV series details (json)
	 * @uses                       \Manager\DefaultManager   \Manager\DefaultManager
	 */
	protected function searchSerie($keyword) {
		$defaultManager = new \Manager\DefaultManager();
		// Searches for TV serie into database by title
		$series = $defaultManager->findLike($keyword, 'title', 'series');
		// When TV serie not present into database
		if (!$series) {
			// Returns error to client in json format
			$this->error['title']   = 'Not found';
			$this->error['summary'] = 'TV serie not present into database.';
			$this->showJson($this->error);
		} else {
			// Returns json to client
			$this->showJson($series);
		}
	}

	/**
	 * Searches for TV serie by title and scrapes TV serie details from imdb when not present into database.
	 *
	 * Adds TV serie details into database when found on imdb<br>
	 *
	 * Returns TV serie details in json format (by primary key)
	 *
	 * @version                  1.1.3
	 * @param    string  $title  TV serie title
	 * @return   object          TV serie details (json)
	 * @uses                     \Controller\ScraperController  \Controller\ScraperController
	 * @uses                     \Manager\DefaultManager        \Manager\DefaultManager
	 */
	protected function scrapeSerie($title) {
		$scraperController = new \Controller\ScraperController();
		$defaultManager    = new \Manager\DefaultManager();
		// Searches for TV serie into database by title
		$serie = $defaultManager->findLike($title, 'title', 'series');
		// When TV serie not present into database
		if (!$serie) {
			// Scrapes TV serie (by title)
			$scraperController->scrapeSerie($title);
			// Searches for TV serie into database by title
			$serie = $defaultManager->findLike($title, 'title', 'series');
			// When TV serie not present into database
			if (!$serie) {
				// Returns error to client in json format
				$this->error['title']   = 'Not found';
				$this->error['summary'] = 'TV serie not present into database.';
				$this->showJson($this->error);
			} else {
				// Returns json to client
				$this->showJson($serie);
			}
		} else {
			// Returns json to client
			$this->showJson($serie);
		}
	}

	/**
	 * Gets TV serie, seasons and episodes from database by id.
	 *
	 * Returns TV serie details in json format (by primary key)
	 *
	 * @version               1.0.3
	 * @param    string  $id  TV serie title
	 * @return   object       TV series details (json)
	 * @uses                  \Controller\Controller\ApiController::getSeasons()  getSeasons()
	 * @uses                  \Manager\DefaultManager                             \Manager\DefaultManager
	 * @url                   http://localhost/tvseriemanager/public/tvseriemanagerapi?method=getserie&id=1&api_key=inwexrlzidlwncjfrrahtexduwskgtvk
	 */
	protected function getSerie($id) {
		$defaultManager = new \Manager\DefaultManager();
		// Gets TV serie from database by id
		$serie = $defaultManager->findWhere($id, 'id', 'series');
		// When TV serie not present into database
		if (!$serie) {
			// Returns error to client in json format
			$this->error['title']   = 'Not found';
			$this->error['summary'] = 'TV serie not present into database.';
			$this->showJson($this->error);
		} else {
			// Gets every season episode
			$seasons = $this->getSeasons($id, $serie['season_count']);
			// Inserts seasons into $serie array
			$serie['seasons'] = $seasons;
			// Returns json to client
			$this->showJson($serie);
		}
	}

	/**
	 * Sends random series from database in json format.
	 *
	 * @version                   1.4.2
	 * @param    integer  $limit  Series count to retrieve from database
	 * @return   object           TV serie details (json)
	 * @uses                      \Manager\DefaultManager  \Manager\DefaultManager
	 */
	protected function getRandomSeries($limit) {
		$defaultManager = new \Manager\DefaultManager();
		// Finds random serie into database
		$series = $defaultManager->getRandom($limit, 'series');
		if (!$series) {
			// Returns error to client in json format
			$this->showJson($this->error);
		} else {
			// Returns json to client
			$this->showJson($series);
		}
	}

	/**
	 * Returns TV serie season and episodes from database by serie primary key and season.
	 *
	 * Gets TV serie season and episodes and rebuilds usable associative array
	 *
	 * @version                            2.3.2
	 * @param       integer  $id           TV serie primary key
	 * @param       integer  $seasonCount  TV serie season count
	 * @return      array                  TV serie seasons and episodes
	 * @uses                               \Manager\EpisodeManager  \Manager\EpisodeManager
	 */
	protected function getSeasons($id, $seasonCount) {
		$episodeManager = new \Manager\EpisodeManager();
		// Gets serie episodes by season
		for ($i=1; $i<=$seasonCount; $i++){
			// Gets TV serie seasons from database by id
			$seasons[$i]['episodes'] = $episodeManager->findEpisodes($id, $i);
		}
		// When TV serie not present into database
		if (!$seasons) {
			// Returns error to client in json format
			$this->error['title']   = 'Seasons not found';
			$this->error['summary'] = 'Seasons not present into database.';
			$this->showJson($this->error);
		} else {
			// Returns array
			return $seasons;
		}
	}
}
