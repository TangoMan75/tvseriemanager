<?php

namespace Manager;

use \W\Manager\Manager;

/**
 * Extends W framework manager with 5 cool new functionalities.
 *
 * New functionalities availlable are :<br>
 * <code>countRows()</code><br>
 * <code>lastId()</code><br>
 * <code>findLike()</code><br>
 * <code>findWhere()</code><br>
 * <code>getrandom()</code><br>
 * 
 * @last_modified  14:13 04/03/2016
 * @author         Matthias Morin <matthias.morin@gmail.com>
 * @copyright      2015-2016 - Matthias Morin, Full Stack Web Developer
 */
class DefaultManager extends Manager {
	/**
	 * Counts table total rows.
	 * 
	 * @version                   1.0
	 * @see      Manager::$dbh    Uses dbh property from Manager class
	 * @param    string   $table  Table name
	 * @return   integer          Row count
	 */
	public function countRows($table) {
		// Searches database for $search into $column from $table
		$sql = 'SELECT COUNT(*) FROM ' . $table;
		$statement = $this->dbh->prepare($sql);
		$statement->execute();
		$result = $statement->fetchAll();
		return $result[0]["COUNT(*)"];
    }

	/**
	 * Retrieves id from last inserted element.
	 * 
	 * @version                 1.0
	 * @see      Manager::$dbh  Uses dbh property from Manager class
	 * @return   integer        Last inserted object primary key
	 */
	public function lastId() {
		return $this->dbh->lastInsertId();
    }

	/**
	 * Finds all lines containing $query string into target table and column.
	 * 
	 * @version                    1.0.2
	 * @param    string   $search  Text search
	 * @param    string   $column  Target column
	 * @param    string   $table   Table name
	 * @return   boolean           False When query returns no result
	 * @return   array             Associative array containing data from database
	 */
	public function findLike($search, $column, $table) {
		// Searches database for $search into $column from $table
		$sql = 'SELECT * FROM ' . $table . ' WHERE ' . $column . ' LIKE :search;';
		$statement = $this->dbh->prepare($sql);
		$statement->execute([
			':search' => '%' . $search . '%'
		]);
		$result = $statement->fetchAll();
		// If fetchAll returned results
		if ( $result ) {
			return $result;
		} else {
			return false;
		}
	}

	/**
	 * Finds all lines matching exact $query string into target table and column.
	 *
	 * @version                   1.1.1
	 * @param   string   $query   Text query
	 * @param   string   $column  Target column
	 * @param   string   $table   Table name
	 * @see     Manager::$dbh     Uses dbh property from Manager class
	 * @return  boolean           False When query returns no result
	 * @return  array             Associative array containing data from database
	 */
	public function findWhere($query, $column, $table) {
		// Searches database for $query into $column from $table
		$sql = 'SELECT * FROM ' . $table . ' WHERE ' . $column . ' = :query;';
		$statement = $this->dbh->prepare($sql);
		$statement->execute([
			':query' => $query
		]);
		$result = $statement->fetch();
		// If fetchAll returned results
		if ( $result ) {
			return $result;
		} else {
			return false;
		}
	}

	/**
	 * Returns random lines from target table with given limit.
	 *
	 * @version                   1.0.2
	 * @param   integer  $limit   Lines count to retreive
	 * @param   string   $table   Table name
	 * @see     Manager::$dbh     Uses dbh property from Manager class
	 * @return  boolean           False When query returns no result
	 * @return  array             Associative array containing data from database
	 */
	public function getRandom($limit, $table) {
		// Searches database for $query into $column from $table
		$sql = 'SELECT * FROM ' . $table . ' ORDER BY RAND() LIMIT ' . $limit . ';';
		$statement = $this->dbh->prepare($sql);
		$statement->execute();
		$result = $statement->fetchAll();
		// If fetchAll returned results
		if ( $result ) {
			return $result;
		} else {
			return false;
		}
	}
}