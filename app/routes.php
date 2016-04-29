<?php
	/**
	 * Routes
	 * http://localhost/W/docs/tuto/?p=routes
	 *
	 * "GET|POST"          HTTP resquest method
	 * "/services/"        URL mask
	 * "Default#services"  Controller name and method to call
	 * "default_services"  Route name (must be unique)
	 */

	$w_routes = array(

		// ************
		// STATIC PAGES
		// ************

		// Home
		['GET', '/', 'Default#home', 'home'],

		// Legal notice
		['GET', '/Terms&Conditions/', 'Default#legal', 'legal'],

		// About
		['GET', '/AboutUs/', 'Default#about', 'about'],


		// ***********
		// FORMULAIRES
		// ***********

		// Page d'inscription
		['GET|POST', '/register/', 'User#register', 'register'],

		// Page password
		['GET|POST', '/password/', 'User#password', 'password'],

		// Page new password
		['GET|POST', '/new_password/[:token]/[:id]/', 'User#newPassword', 'new_password'],

		// Page connexion
		['GET|POST', '/login/', 'User#login', 'login'],

		// Page de déconnexion
		['GET|POST', '/logout/', 'User#logout', 'logout'],


		// ***********************************
		// Affichage par le moteur de template
		// ***********************************

		// Page de profil (avec liste des séries)
		['GET', '/profile/', 'Profile#profile', 'profile'],

		// Page changement de username
		['GET', '/username/', 'Profile#username', 'username'],

		// Affichage d'une serie
		['GET|POST', '/findserie/[i:id]/', 'Serie#findSerie', 'find_serie'],

		// Page de détail d'un épisode
		['GET', '/episode_detail/[:id]/', 'Episode#episode_detail', 'episode_detail'],


		// ***
		// API
		// ***

		// Route de l'API principale
		['GET|POST', '/tvseriemanagerapi', 'Api#tvSerieManagerSwitch', 'api'],


		// ***********
		// BACK-OFFICE
		// ***********

		/**
		 * scraper
		 * Page de scraping pour "hydrater" la base avec les 50 series les plus populaires
		 * For back-office only
		 */
		['GET', '/scrape', 'Scraper#scrapeMostPopularSeries', 'scrape_1'],
		['GET', '/scrape/', 'Scraper#scrapeMostPopularSeries', 'scrape_2'],

		/**
		 * scraper
		 * Page de scraping pour "hydrater" la base en masse
		 * For back-office only
		 */
		['GET', '/scrapepages/[:from]/[:to]', 'Scraper#scrapePages', 'scrapepages_1'],
		['GET', '/scrapepages/[:from]/[:to]/', 'Scraper#scrapePages', 'scrapepages_2'],

		/**
		 * scrapeserie
		 * Ajout d'une serie dans la base
		 * For back-office only
		 */
		['GET', '/scrapeserie/[:title]', 'Scraper#scrapeSerie', 'scrapeserie_1'],
		['GET', '/scrapeserie/[:title]/', 'Scraper#scrapeSerie', 'scrapeserie_2'],


		// ****************
		// NE PLUS UTILISER
		// ****************

		/**
		 * searchserie
		 * Affichage de series au hazard
		 * @deprecated 1.0
		 */
		['GET|POST', '/randomseries/[i:number]/', 'Serie#getRandomSeries', 'random_serie'],


		/**
		 * searchserie
		 * Recherche d'une serie
		 * @deprecated 1.0
		 */
		['GET|POST', '/searchserie/[:title]/', 'Serie#searchSerie', 'search_serie'],

		/**
		 * detail
		 * Page de détail d'une série
		 * @deprecated 1.0
		 */
		['GET|POST', '/detail/[:id]/', 'Serie#detail', 'detail'],

		//Permet d'ajouter une série dans la collection
		['GET|POST', '/addToCollection/[:id]/', 'Serie#addToCollection', 'addToCollection'],

		//Permet de retirer une série dans la collection
		['GET|POST', '/removeFromCollection/[:id]/', 'Serie#removeFromCollection', 'removeFromCollection'],


		/**
		 * search
		 * Page de recherche en autocomplétion
		 * @deprecated 1.0
		 */
		['GET|POST', '/search/[:title]', 'Serie#search', 'search'],
	);