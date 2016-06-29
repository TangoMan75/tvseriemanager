<?php

namespace Controller;

use \W\Controller\Controller;

/**
 * Controls all serie related data.
 * 
 * @last_modified  23:34 03/02/2016
 * @author         Axel Merlin <merlin.axel@gmail.com>
 * @copyright      2015-2016 - Matthias Morin, Full Stack Web Developer
 */
class SerieController extends Controller {

	/**
	 * addToCollection.
	 * 
	 * @version                1.0
	 * @deprecated             1.0
	 * @author                 Axel Merlin <merlin.axel@gmail.com>
	 * @param    integer  $id  TV serie title
	 */
	public function addToCollection($id) {
		if (!$this->getUser()){
			$this->redirectToRoute("register");
		}
		$user=$this->getUser();
		$bookmarkManager = new \Manager\BookmarkManager();
		$bookmarkManager->insert([
			"user_id" => $user["id"],
			"serie_id" => $id,
		]);
		$this->redirectToRoute("detail", ["id"=>$id]);
	}

	/**
	 * removeFromCollection.
	 * 
	 * @version                1.0
	 * @deprecated             1.0
	 * @author                 Axel Merlin <merlin.axel@gmail.com>
	 * @param    integer  $id  TV serie title
	 */
	public function removeFromCollection($id) {
		if (!$this->getUser()){
			$this->redirectToRoute("register");
		}
		$user=$this->getUser();
		$bookmarkManager = new \Manager\BookmarkManager();
		$bookmarkManager->delete([
			"user_id" => $user["id"],
			"serie_id" => $id,
		]);
		$this->redirectToRoute("detail", ["id"=>$id]);
	}

	/**
	 * detail method
	 * @version               1.0
	 * @deprecated            1.0
	 * @author                Axel Merlin <merlin.axel@gmail.com>
	 * @param    string  $id  TV serie title
	 * @return   object       TV serie details
	 */
	public function detail($id)	{
		if (!$this->getUser()){
			$this->redirectToRoute("register");
		}
		$serieManager = new \Manager\SerieManager();
		$serie = $serieManager->find($id);
		$userManager = new \Manager\BookmarkManager();
		$foundBookmark = $userManager->isInCollection($id);
		$this->show('serie/detail', [
			"serie" => $serie,
			"foundCollection" => $foundBookmark
		]);
	}

	/**
	 * search method
	 * @version        1.0 beta
	 * @deprecated     1.0 beta
	 * @last_modified  21:09 31/01/2016
	 * @author         Axel Merlin <merlin.axel@gmail.com>
	 * @author         Matthias Morin <matthias.morin@gmail.com>
	 * @return object  Series from db
	 */
	public function search($title) {
		$serieManager = new \Manager\SerieManager();
		$series = $serieManager->search($title);
		$this->show('serie/search', [
					"series" => $series
		]);
	}
}