<?php

namespace Manager;

// classe de base du framework

class UserManager extends \W\Manager\UserManager
{
	public function isInCollection($id) {
		$sql = "SELECT users.username, bookmarks.serie_id 
				FROM users JOIN bookmarks 
				ON users.id = bookmarks.user_id 
				WHERE users.id =" . $_SESSION["user"]["id"] . 
								" AND bookmarks.serie_id =" . $id;
		$getBookmark = $this->dbh->prepare($sql);
		$getBookmark->execute();
		$foundBookmark = $getBookmark->fetchAll();

		return ($foundBookmark);
	}
}