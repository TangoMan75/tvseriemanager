<?php

namespace Manager;

use \W\Manager\Manager;

/**
 * Manages requests to episodes table.
 *
 * @last_modified                13:11 04/03/2016
 * @author                       Matthias Morin <matthias.morin@gmail.com>
 * @copyright                    2015-2016 - Matthias Morin, Full Stack Web Developer
 */
class EpisodeManager extends Manager {
	/**
	 * Finds serie episodes by season (by serie primary key).
	 *
	 * @version                     1.6.1
	 * @param   integer  $id        Serie primary key
	 * @param   integer  $season    Season number
	 * @see     Manager::$dbh       Uses dbh property from Manager class
	 * @return  boolean             False When query returns no result
	 * @return  array               Associative array containing all episodes
	 */
	public function findEpisodes($serie_id, $season) {
		// Searches database for season episodes
		$sql = 'SELECT * FROM `episodes` WHERE `serie_id` = :serie_id AND `season` = :season ORDER BY `episode`;';
		$statement = $this->dbh->prepare($sql);
		$statement->execute([
			':serie_id' => $serie_id,
			':season'   => $season,
			]);
		$episodes = $statement->fetchAll();
		// Shifts array indexes (We want episodes to start with index 1)
		foreach ($episodes as $key => $value) {
			$temp[$key+1] = $value;
		}
		$episodes = $temp;
		// If fetchAll returned results
		if ( $episodes ) {
			return $episodes;
		} else {
			return false;
		}
	}
}