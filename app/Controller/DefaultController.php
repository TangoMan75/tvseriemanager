<?php

namespace Controller;

use \W\Controller\Controller;

class DefaultController extends Controller {

	/**
	 * Page d'accueil par défaut
	 */
	public function home() {
		$this->show('default/home');
	}

	/**
	 * Page mentions légales
	 */
	public function legal()
	{
		$this->show('default/legal');
	}

	/**
	 * Page about
	 */
	public function about()
	{
		$this->show('default/about');
	}
}