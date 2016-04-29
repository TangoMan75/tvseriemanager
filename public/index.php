<?php

	//autochargement des classes
	require("../vendor/autoload.php");

	//chargement de Simple Dom HTML Parser
	require("../vendor/simplehtmldom/simple_html_dom.php");
	// require("../vendor/sunra/php-simple-html-dom-parser/Src/Sunra/PhpSimple/simplehtmldom_1_5/simple_html_dom.php");

	//configuration
	require("../app/config.php");

	//rares fonctions globales
	require("../W/globals.php");

	//instancie notre appli en lui passant la config et les routes
	$app = new W\App($w_routes, $w_config);

	//exécute l'appli
	$app->run();