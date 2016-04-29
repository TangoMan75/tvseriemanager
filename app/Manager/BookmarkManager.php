<?php

namespace Manager;

use \W\Manager\Manager;

/**
 * Manages bookmarks.
 *
 * @last_modified    13:39 06/03/2016
 * @author           Matthias Morin <matthias.morin@gmail.com>
 * @copyright        2015-2016 - Matthias Morin, Full Stack Web Developer
 */
class BookmarkManager extends Manager {
	/**
	 * Deletes bookmark from user collection.
	 *
	 */
	public function deleteBookmark($serie_id) {
		$sql = 'DELETE FROM `bookmarks` WHERE user_id = :user_id AND serie_id = :serie_id';
		$statement = $this->dbh->prepare($sql);
		$statement->execute([
			':user_id' => $_SESSION['user']['id'],
			':serie_id' => $serie_id,
		]);
	}

	/**
	 * addToCollection.
	 * 
	 * @version                        1.0
	 * @param    integer  $element_id  TV serie title
	 */
	public function addToCollection($element_id) {
		if (!$this->getUser()) {
			$this->redirectToRoute('register');
		}
		$user = $this->getUser();
		$bookmarkManager = new \Manager\BookmarkManager();
		$bookmarkManager->insert([
			':user_id'    => $user['id'],
			':element_id' => $element_id,
		]);
	}

	/**
	 * removeFromCollection.
	 * 
	 * @version                        1.0
	 * @param    integer  $element_id  TV serie title
	 */
	public function removeFromCollection($element_id) {
		if (!$this->getUser()){
			$this->redirectToRoute('register');
		}
		$user = $this->getUser();
		$bookmarkManager = new \Manager\BookmarkManager();
		$bookmarkManager->delete([
			':user_id'    => $user['id'],
			':element_id' => $element_id,
		]);
	}

	/**
	 * Finds bookmark in user collection.
	 *
	 * @param  string  $id [description]
	 * @return boolean     [description]
	 */
	public function isInCollection($serie_id) {
		$sql = "SELECT users.username, bookmarks.serie_id
				FROM `users` JOIN `bookmarks`
				ON users.id = bookmarks.user_id
				WHERE users.id = :user_id AND bookmarks.serie_id = :serie_id";
		$statement = $this->dbh->prepare($sql);
		$statement->execute([
				':user_id' => $_SESSION['user']['id'],
				':serie_id' => $serie_id['serie_id'],
			]);
		$foundBookmark = $statement->fetchAll();
		return ($foundBookmark);
	}

	/**
	 * Gets bookmarked series id from user collection.
	 *
	 * @param  [type]  $id [description]
	 * @return boolean     [description]
	 */
	public function getCollection($user_id) {
		$sql = "SELECT bookmarks.serie_id
				FROM `users` JOIN `bookmarks`
				ON users.id = bookmarks.user_id
				WHERE users.id = :user_id AND bookmarks.serie_id = :serie_id";
		$statement = $this->dbh->prepare($sql);
		$statement->execute([
				':user_id' => $_SESSION['user']['id'],
				':serie_id' => $serie_id['serie_id'],
			]);
		$collection = $statement->fetchAll();
		return $collection;
	}
}