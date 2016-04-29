<?php

namespace Manager;

use \W\Manager\Manager;

/**
 * Manages TV series queries.
 *
 * @last_modified  18:04 04/03/2016
 * @author         Matthias Morin <matthias.morin@gmail.com>
 * @copyright      2015-2016 - Matthias Morin, Full Stack Web Developer
 */
class SerieManager extends Manager {

	/**
	 * Searches for $keyword into database and returns serie id, title, poster_id, start_date
	 *
	 * @version                  1.1.1
	 * @deprecated               1.1.1
 	 * @author                   Matthias Morin <matthias.morin@gmail.com>
	 * @param  string  $keyword  User request
	 * @return arrray            Contains id, title, poster_id, start_date
	 */
	public function search($keyword) {
		$sql = "SELECT id, title, poster_id, start_date FROM series
				WHERE title LIKE :keyword";
		$statement = $this->dbh->prepare($sql);
		$statement->execute([':keyword' => '%' . $keyword . '%']);
		$series = $statement->fetchAll();
		if (!$serie) {
			return false;
		} else {
			return $series;
		}
	}

	/**
	 * Gets database serie from serie primary key
	 *
	 * @version              1.0.1
	 * @deprecated           1.0.1
 	 * @author               Matthias Morin <matthias.morin@gmail.com>
	 * @param  integer  $id  Serie primary key
	 * @return array         Contains serie data
	 * @return boolean       False when serie not found
	 */
	public function getSerie($id) {
		$sql = "SELECT * FROM series WHERE id = $id";
		$statement = $this->dbh->prepare($sql);
		$statement->execute([
			':id' => $id
		]);
		$serie = $statement->fetch();
		if (!$serie) {
			return false;
		} else {
			return $serie;
		}
	}

	/**
	 * Gets database serie from imdb reference id and season number
	 *
	 * @version                   1.0.2
	 * @deprecated                1.0.2
 	 * @author                    Matthias Morin <matthias.morin@gmail.com>
	 * @param  string   $imdb_id  Serie imdb_id
	 * @param  integer  $season   Serie season number
	 * @return array              Contains serie data
	 * @return boolean            False when serie not found
	 */
	public function getSeason($imdb_id, $season) {
		$sql = "SELECT * FROM series WHERE imdb_id = :imdb_id AND season = :season";
		$statement = $this->dbh->prepare($sql);
		$statement->execute([
			':imdb_id' => $imdb_id,
			':season'  => $season,
		]);
		$seasons = $statement->fetch();
		if (!$seasons) {
			return false;
		} else {
			return $seasons;
		}
	}
}