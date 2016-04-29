//==================================================
// SERIESMANAGER.TV
//==================================================

/**
 * @version        1.1.1
 * @lastmodified   20:27 04/02/2016
 * @category       linear
 * @author         Matthias Morin <matthias.morin@gmail.com>
 * @purpose        Manages layout and ajax for front end
 * @requires       jQuery, Bootstrap, Masonry, Font-Awesome
 */

// Sets $Grid as global variable
$Grid = $("#grid");

// Initializes script
init();

//--------------------------------------------------
// fnAppendCardImage
//--------------------------------------------------


function fnAppendCardImage(intSerieId, strSerieImageSrc, $Target){

/**
 * @version        1.0.0
 * @lastmodified   11:34 04/02/2016
 * @category       tvseriemanager_DOM
 * @author         Matthias Morin <matthias.morin@gmail.com>
 * @purpose        Append Serie image to DOM
 * @input          intSerieId as Integer, strSerieImageSrc as String, $Target as jQuery object
 * @requires       jQuery
 * @uses           fnGetSerie
 */

	// Empties $Target
	$Target.empty();
	// Creates SerieImage
	var $SerieImage = $("<img>");
	$SerieImage.attr("src", strSerieImageSrc);
	$SerieImage.attr("width", 240);
	$SerieImage.attr("height", 354);
	$SerieImage.attr("data-serie-id", intSerieId);
	// $SerieImage.addClass("serie-image img-responsive center-block");
	$SerieImage.addClass("serie-image");
	// Listens to events on image
	$SerieImage.on("mousedown", function(){
		// Gets intSerieId from image attribute (anonymous function doesn't accept arguments)
		var intSerieId = $(this).attr("data-serie-id");
		// Targets $Card
		var $Card = $(this).parent().parent();
		fnGetSerie(intSerieId, $Grid);
	});
	// Appends SerieImage to DOM
	$Target.append($SerieImage);
}




//--------------------------------------------------
// fnAppendEpisodesCards
//--------------------------------------------------


function fnAppendEpisodesCards(intSerieId, arEpisodes, $Target){

/**
 * @version        1.2.0
 * @lastmodified   12:39 04/02/2016
 * @category       tvseriemanager_DOM
 * @author         Matthias Morin <matthias.morin@gmail.com>
 * @purpose        Appends episodes cards
 * @input          intSerieId as Integer, arEpisodes as Array, $Target as jQuery object
 * @requires       jQuery, Bootstrap, Masonry
 * @uses           fnAppendCardImage
 */

	// Initializes masonry
	$Target.masonry({
		itemSelector: ".grid-item",
		gutter: 20,
	});

	// Empties $Target
	$Target.empty();

	for (var i in arEpisodes){

		// --------------------------------------------------
		// CARD
		// --------------------------------------------------

		// Creates card to contain TV series
		var $Card = $("<div>");
		$Card.addClass("card grid-item col-sm-6 col-lg-3 thumbnail");

		// --------------------------------------------------
		// TITLE
		// --------------------------------------------------

		strTitle = arEpisodes[i].title;
		// Adds title
		var $Episode = $("<h1>");
		// Adds title content
		$Episode.html(strTitle);
		// Append title to card
		$Card.append($Episode);

		// --------------------------------------------------
		// IMAGE CONTAINER
		// --------------------------------------------------

		// Build images src from $poster_id :
		var strXxs    = '._V1_UY67_CR0,0,45,67_AL_.jpg';
		var strXs     = '._V1._SY74_CR0,0,54,74_.jpg';
		var strSmall  = '._V1_UX67_CR0,0,67,98_AL_.jpg';
		var strMedium = '._V1_SY317_CR0,0,214,317_AL_.jpg';
		var strLarge  = '._V1_SX640_SY720_.jpg'; // 488 x 720

		strPosterId = arEpisodes[i].poster_id;
		if (!strPosterId || strPosterId == '01') {
			strImageSrc = strAssetUrl + 'img/chill-out.jpg';
		} else {
			strImageSrc = 'http://ia.media-imdb.com/images/M/' + strPosterId + strMedium;
		};

		// Adds ImageContainer
		var $ImageContainer = $("<div>");
		// Adds class to ImageContainer
		$ImageContainer.addClass("image-box");
		// Adds attribute for intSerieId easy access
		$ImageContainer.attr("data-serie-id", intSerieId);
		// Adds ImageContainer content
		fnAppendCardImage(intSerieId, strImageSrc, $ImageContainer);
		// Appends ImageContainer to card
		$Card.append($ImageContainer);

		// --------------------------------------------------
		// TEXT CONTAINER
		// --------------------------------------------------

		// Creates TextContainer
		var $TextContainer = $("<div>");
		// Adds class to TextContainer
		$TextContainer.addClass("list-box");
		// Adds attribute to target TextContainer easily
		$TextContainer.attr("data-serie-id", intSerieId);
		// Appends TextContainer to card
		$Card.append($TextContainer);

		// --------------------------------------------------
		// SExEPx
		// --------------------------------------------------

		strEpisodeSeason = 'se' + arEpisodes[i].season + 'ep' + arEpisodes[i].episode + '&nbsp;&nbsp;-&nbsp;&nbsp;' + arEpisodes[i].air_date;
		var $EpisodeSeason = $("<p>");
		// Add content to EpisodeSeason
		$EpisodeSeason.html(strEpisodeSeason);
		// Appends EpisodeSeason to card
		$Card.append($EpisodeSeason);

		// --------------------------------------------------
		// SUMMARY
		// --------------------------------------------------

		strSummary = arEpisodes[i].summary;
		var $Summary = $("<p>");
		// Add content to Summary
		$Summary.html(strSummary);
		// Appends Summary to card
		$Card.append($Summary);

		// --------------------------------------------------
		// APPENDS TO DOM
		// --------------------------------------------------

		// Appends $Card to $Grid
		$Target.append($Card);
		// Updates masonry
		$Target.masonry("appended", $Card);
	}
	// Reloads masony layout
	$Target.masonry("reloadItems");
	// Refreshes $Target layout
	$Target.masonry("layout");
}




//--------------------------------------------------
// fnAppendSeriesCards
//--------------------------------------------------


function fnAppendSeriesCards(arSeries, $Target){

/**
 * @version        1.2.0
 * @lastmodified   12:39 04/02/2016
 * @category       tvseriemanager_DOM
 * @author         Matthias Morin <matthias.morin@gmail.com>
 * @purpose        Appends series cards
 * @input          arSeries as Array, $Target as jQuery object
 * @requires       jQuery, Bootstrap, Masonry
 * @uses           fnAppendCardImage
 */

	// Initializes masonry
	$Target.masonry({
		itemSelector: ".grid-item",
		gutter: 20,
	});

	// Empties $Target
	$Target.empty();

	for (var i in arSeries){

		// --------------------------------------------------
		// CARD
		// --------------------------------------------------

		// Creates card to contain TV series
		var $Card = $("<div>");
		$Card.addClass("card grid-item col-sm-6 col-lg-3 thumbnail");

		// --------------------------------------------------
		// TITLE
		// --------------------------------------------------

		strSerieTitle = arSeries[i].title;
		// Adds title
		var $SerieTitle = $("<h1>");
		// Adds title content
		$SerieTitle.html(strSerieTitle);
		// Append title to card
		$Card.append($SerieTitle);

		// --------------------------------------------------
		// IMAGE CONTAINER
		// --------------------------------------------------

		// Build images src from $poster_id :
		var strXxs    = '._V1_UY67_CR0,0,45,67_AL_.jpg';
		var strXs     = '._V1._SY74_CR0,0,54,74_.jpg';
		var strSmall  = '._V1_UX67_CR0,0,67,98_AL_.jpg';
		var strMedium = '._V1_SY317_CR0,0,214,317_AL_.jpg';
		var strLarge  = '._V1_SX640_SY720_.jpg'; // 488 x 720

		strSerieImageSrc = arSeries[i].poster_id;
		if (!strSerieImageSrc) {
			strSerieImageSrc = strAssetUrl + 'img/chill-out.jpg';
		} else {
			strSerieImageSrc = 'http://ia.media-imdb.com/images/M/' + strSerieImageSrc + strMedium;
		};

		// Adds ImageContainer
		var $ImageContainer = $("<div>");

		// Appends Serie primary key for easy acces
		intSerieId = arSeries[i].id;
		// Adds class to ImageContainer
		$ImageContainer.addClass("image-box");

		// Adds attribute for intSerieId easy access
		$ImageContainer.attr("data-serie-id", intSerieId);
		// Adds ImageContainer content
		fnAppendCardImage(intSerieId, strSerieImageSrc, $ImageContainer);
		// Appends ImageContainer to card
		$Card.append($ImageContainer);

		// --------------------------------------------------
		// TEXT CONTAINER
		// --------------------------------------------------

		// Creates TextContainer
		var $TextContainer = $("<div>");
		// Adds class to TextContainer
		$TextContainer.addClass("list-box");
		// Adds attribute to target TextContainer easily
		$TextContainer.attr("data-serie-id", intSerieId);
		// Appends TextContainer to card
		$Card.append($TextContainer);

		// --------------------------------------------------
		// GENRE
		// --------------------------------------------------

		strSerieGenre   = arSeries[i].genre;
		var $Genre = $("<p>");
		// Add content to Genre
		$Genre.html(strSerieGenre);
		// Appends Genre to card
		$Card.append($Genre);

		// --------------------------------------------------
		// SUMMARY
		// --------------------------------------------------

		strSerieSummary = arSeries[i].summary;
		var $Summary = $("<p>");
		// Add content to Summary
		$Summary.html(strSerieSummary);
		// Appends Summary to card
		$Card.append($Summary);

		// --------------------------------------------------
		// APPENDS TO DOM
		// --------------------------------------------------

		// Appends $Card to $Grid
		$Target.append($Card);
		// Updates masonry
		$Target.masonry("appended", $Card);
	}
	// Reloads masony layout
	$Target.masonry("reloadItems");
	// Refreshes $Target layout
	$Target.masonry("layout");
}




//--------------------------------------------------
// fnAppendSerieSheet
//--------------------------------------------------


function fnAppendSerieSheet(arSerie, $Target){

/**
 * @version        1.0.0
 * @lastmodified   11:34 04/02/2016
 * @category       tvseriemanager_DOM
 * @author         Matthias Morin <matthias.morin@gmail.com>
 * @purpose        Appends serie details sheet
 * @input          arSerie as Array, $Target as jQuery object
 * @requires       jQuery, Bootstrap, Masonry
 */

	// Empties $Grid
	$Target.empty();

	// --------------------------------------------------
	// SHEET
	// --------------------------------------------------

	// Creates sheet to contain TV series
	var $Sheet = $("<div>");
	$Sheet.addClass("sheet grid-item col-sm-12 col-lg-12 thumbnail");
	// Appends $Sheet to $Grid
	$Target.append($Sheet);

	// --------------------------------------------------
	// TITLE
	// --------------------------------------------------

	strSerieTitle = arSerie.title;
	// Adds title
	var $SerieTitle = $("<h1>");
	// Adds title content
	$SerieTitle.html(strSerieTitle);
	$SerieTitle.addClass("serie-title sheet-item col-sm-12 col-lg-12");
	// Append title to sheet
	$Sheet.append($SerieTitle);

	// --------------------------------------------------
	// IMAGE CONTAINER
	// --------------------------------------------------

	// Appends Serie primary key for easy acces
	intSerieId      = arSerie.id;
	// Adds ImageContainer
	var $ImageContainer = $("<div>");
	// Adds class to ImageContainer
	$ImageContainer.addClass("image-box sheet-item");
	// Adds attribute for intSerieId easy access
	$ImageContainer.attr("data-serie-id", intSerieId);
	// Appends ImageContainer to sheet
	$Sheet.append($ImageContainer);

	// --------------------------------------------------
	// IMAGE
	// --------------------------------------------------

	// Build images src from poster_id :
	var strXxs    = '._V1_UY67_CR0,0,45,67_AL_.jpg';
	var strXs     = '._V1._SY74_CR0,0,54,74_.jpg';
	var strSmall  = '._V1_UX67_CR0,0,67,98_AL_.jpg';
	var strMedium = '._V1_SY317_CR0,0,214,317_AL_.jpg';
	var strLarge  = '._V1_SX640_SY720_.jpg';
	strSerieImageSrc = arSerie.poster_id;
	if (!strSerieImageSrc) {
		strSerieImageSrc = strAssetUrl + 'img/chill-out.jpg';
	} else {
		strSerieImageSrc = 'http://ia.media-imdb.com/images/M/' + strSerieImageSrc + strLarge;
	};

	// Adds ImageContainer content
	var $SerieImage = $("<img>");
	$SerieImage.attr("src", strSerieImageSrc);
	$SerieImage.addClass("serie-image img-responsive center-block");
	// Appends Image to ImageContainer
	$ImageContainer.append($SerieImage);

	// --------------------------------------------------
	// TEXT CONTAINER
	// --------------------------------------------------

	// Creates TextContainer
	var $TextContainer = $("<div>");
	// Adds class to TextContainer
	$TextContainer.addClass("list-box sheet-item col-sm-12 col-lg-12");
	// Adds attribute to target TextContainer easily
	$TextContainer.attr("data-serie-id", intSerieId);
	// Appends TextContainer to sheet
	$Sheet.append($TextContainer);

	// --------------------------------------------------
	// GENRE
	// --------------------------------------------------

	strSerieGenre   = arSerie.genre;
	var $Genre = $("<p>");
	// Adds class to Genre
	$Genre.addClass("genre sheet-item col-sm-12 col-lg-6 thumbnail");
	// Add content to Genre
	$Genre.html("Genre : " + strSerieGenre);
	// Appends Genre to TextContainer
	$TextContainer.append($Genre);

	// --------------------------------------------------
	// AMAZON
	// --------------------------------------------------

	// Adds link
	var $AmazonLink = $("<a>");
	$AmazonLink.addClass("genre sheet-item col-sm-12 col-lg-3 thumbnail");
	strLink = "http://www.amazon.fr/s/ref=nb_sb_noss_2?__mk_fr_FR=%C3%85M%C3%85%C5%BD%C3%95%C3%91&url=search-alias%3Daps&field-keywords=" + arSerie.title;
	$AmazonLink.attr("href", strLink);
	$AmazonLink.attr("target", "_blank");
	$AmazonLink.html('<i class="fa fa-amazon">&nbsp;Amazon</i>');
	// Append title to sheet
	$TextContainer.append($AmazonLink);

	// --------------------------------------------------
	// KICKASS
	// --------------------------------------------------

	// Adds link
	var $Kisckass = $("<a>");
	$Kisckass.addClass("genre sheet-item col-sm-12 col-lg-3 thumbnail");
	strLink = "https://kat.cr/usearch/" + arSerie.title;
	$Kisckass.attr("href", strLink);
	$Kisckass.attr("target", "_blank");
	$Kisckass.html('<i class="fa fa-download">&nbsp;KickassTorrents</i>');
	// Append title to sheet
	$TextContainer.append($Kisckass);

	// --------------------------------------------------
	// ACTORS
	// --------------------------------------------------

	strSerieActors  = arSerie.actors;
	var $Actors = $("<p>");
	// Adds class to Actors
	$Actors.addClass("actors sheet-item col-sm-12 col-lg-6 thumbnail");
	// Add content to Actors
	$Actors.html("Actors : " + strSerieActors);
	// Appends Actors to sheet
	$TextContainer.append($Actors);

	// --------------------------------------------------
	// SUMMARY
	// --------------------------------------------------

	strSerieSummary = arSerie.summary;
	var $Summary = $("<p>");
	// Adds class to Summary
	$Summary.addClass("summary sheet-item col-sm-12 col-lg-6 thumbnail");
	// Add content to Summary
	$Summary.html(strSerieSummary);
	// Appends Summary to sheet
	$TextContainer.append($Summary);

	// --------------------------------------------------
	// SEASONS
	// --------------------------------------------------

	fnBuildSerieSeasons(arSerie, $TextContainer);
}




//--------------------------------------------------
// fnBuildSerieSeasons
//--------------------------------------------------


function fnBuildSerieSeasons(arSerie, $Target){

/**
 * @version        1.1.0
 * @lastmodified   11:34 04/02/2016
 * @category       HTML
 * @author         Matthias Morin <matthias.morin@gmail.com>
 * @purpose        Build serie seasons
 * @input          arSerie as Array, $Target as jQuery object
 * @requires       jQuery, Bootstrap, Masonry, Font-Awesome
 * @uses           fnGetSeasons
 */

	// For each season
	for (i=1; i<=arSerie["season_count"]; i++){

		// Creates Season
		$Season = $("<div>");
		$Season.addClass("season sheet-item col-sm-12 col-lg-6 thumbnail");
		$Season.attr("data-season", i);
		$Season.attr("data-serie-id", arSerie.id);

		// Initializes strHtml
		strHtml = "";
		// Display Season number
		strHtml += '<h2>Season&nbsp;' + i +  '</h2>';

		// For each episode
		strHtml += '<ul class="sheet-item">\n';
		for (var j in arSerie["seasons"][i].episodes){
			strHtml += "<li>Episode&nbsp;" + j + "&nbsp;:&nbsp;" + arSerie["seasons"][i]["episodes"][j].title + "</li>\n";
		}
		strHtml += "</ul>\n";
		$Season.html(strHtml);
		// Appends Season to DOM
		$Target.append($Season);

		// Listens to events on image
		$Season.on("mousedown", function(){

			// Gets intSerieId from image attribute (anonymous function doesn't accept arguments)
			var intSerieId = $(this).attr("data-serie-id");

			// Gets intSeason from image attribute
			var intSeason = $(this).attr("data-season");

			// Targets $Grid
			var $Grid = $(this).parent().parent();
			fnGetSeasons(intSerieId, intSeason, $Grid);
		});
	}
}




//--------------------------------------------------
// fnGetRandomSeries
//--------------------------------------------------


function fnGetRandomSeries($Target){

/**
 * @version        1.1.0
 * @lastmodified   11:34 04/02/2016
 * @category       ajax
 * @author         Matthias Morin <matthias.morin@gmail.com>
 * @purpose        Gets random series from tvseriemanager with Ajax
 * @input          $Target as jQuery object
 * @requires       jQuery
 * @uses           fnAppendSeriesCards
 */

	$.ajax({
		"url": "http://localhost/tvseriemanager/public/tvseriemanagerapi",
		"type": "GET",
		"data":{
				"method"  : "getrandomseries",
				"limit"   : 20,
				"api_key" : "inwexrlzidlwncjfrrahtexduwskgtvk"
		}
	})
	.done(function(response){
		var arSeries = response;
		// Appends arSeries to DOM
		fnAppendSeriesCards(arSeries, $Target);
	});
}




//--------------------------------------------------
// fnGetSeasons
//--------------------------------------------------


function fnGetSeasons(intSerieId, intSeason, $Target){

/**
 * @version        2.0.0
 * @lastmodified   13:47 04/02/2016
 * @category       ajax
 * @author         Matthias Morin <matthias.morin@gmail.com>
 * @purpose        Gets seasons and episodes from tvseriemanager API with Ajax
 * @input          intSerieId as Integer, intSeason as Integer, $Target as jQuery object
 * @requires       jQuery
 * @uses           fnAppendEpisodesCards
 * @note           Caches jSon object into sessionStorage
 */

	// Checks if data is availlable in sessionStorage to avoid unnecessary server requests
	var jsSerie = window.sessionStorage.getItem(intSerieId);
	if (!!jsSerie){
		// Parses json
		arSerie = JSON.parse(jsSerie);
		// Appends jsSerie to DOM
		fnAppendEpisodesCards(intSerieId, arSerie["seasons"][intSeason].episodes, $Target);
	}else{
		$.ajax({
		"url": "http://localhost/tvseriemanager/public/tvseriemanagerapi",
		"type": "GET",
		"data":{
				"method"  : "getserie",
				"id"      : intSerieId,
				"api_key" : "inwexrlzidlwncjfrrahtexduwskgtvk"
		}
		})
		.done(function(response){
			// Stringifys response to properly cache it into sessionStorage
			var jsSerie = JSON.stringify(response);
			// Caches resulting string into sessionStorage in order to avoid unnecessary server requests
			window.sessionStorage.setItem(intSerieId, jsSerie);
			// Returns response value
			var arSerie = response;
			// Appends arSerie to DOM
			fnAppendEpisodesCards(intSerieId, arSerie["seasons"][intSeason].episodes, $Target);
		});
	}
}


//--------------------------------------------------
// fnGetSerie
//--------------------------------------------------


function fnGetSerie(intSerieId, $Target){
/**
 * @version        2.0.0
 * @lastmodified   13:36 04/02/2016
 * @category       ajax
 * @author         Matthias Morin <matthias.morin@gmail.com>
 * @purpose        Gets serie, seasons and episodes from tvseriemanager API with Ajax
 * @input          intSerieId as Integer, $Target as jQuery object
 * @requires       jQuery
 * @uses           fnAppendSerieSheet
 * @note           Caches jSon object into sessionStorage
 */

	// Checks if data is availlable in sessionStorage to avoid unnecessary server requests
	var jsSerie = window.sessionStorage.getItem(intSerieId);
	if (!!jsSerie){
		// Appends jsSerie to DOM
		fnAppendSerieSheet(JSON.parse(jsSerie), $Target);
	}else{
		$.ajax({
		"url": "http://localhost/tvseriemanager/public/tvseriemanagerapi",
		"type": "GET",
		"data":{
				"method"  : "getserie",
				"id"      : intSerieId,
				"api_key" : "inwexrlzidlwncjfrrahtexduwskgtvk"
		}
		})
		.done(function(response){
			// Stringifys response to properly cache it into sessionStorage
			var jsSerie = JSON.stringify(response);
			// Caches resulting string into sessionStorage in order to avoid unnecessary server requests
			window.sessionStorage.setItem(intSerieId, jsSerie);
			// Returns response value
			var arSerie = response;
			// Appends arSerie to DOM
			fnAppendSerieSheet(arSerie, $Target);
		});
	}
}


//--------------------------------------------------
// init
//--------------------------------------------------


function init() {

/**
 * @version        1.1.2
 * @lastmodified   11:34 04/02/2016
 * @category       init
 * @author         Matthias Morin <matthias.morin@gmail.com>
 * @purpose        Initialyzes script
 * @input          N/A
 * @return         N/A
 * @assumes        $Grid
 * @requires       jQuery, Masonry
 * @uses           fnGetRandomSeries, fnAppendSeriesCards
 * @todo           Please wait
 */

	// Loads random series
	fnGetRandomSeries($Grid);

	// Listens submit event on search form
	$("#serie-search-form").on("submit", function(e){
		// Prevents browser from refreshing page after form submit
		e.preventDefault();
		var keyword = $("#keyword-input").val();
		$.ajax({
			"url": "http://localhost/tvseriemanager/public/tvseriemanagerapi",
			"type": "GET",
			"data":{
				"method"  : "scrapeserie",
				"api_key" : "inwexrlzidlwncjfrrahtexduwskgtvk",
				"keyword" : keyword
			}
		}).done(function(response) {
			// Appends result to card
			fnAppendSeriesCards(response, $Grid);
		});
	});

	// Listens keyup event on search form
	$("#keyword-input").on("keyup", function(e) {
		e.preventDefault();
		var strKeyword = $("#keyword-input").val();

		if (strKeyword.length>1) {
			$.ajax({
				"url": "http://localhost/tvseriemanager/public/tvseriemanagerapi",
				"type": "GET",
				"data":{
					"method"  : "searchserie",
					"api_key" : "inwexrlzidlwncjfrrahtexduwskgtvk",
					"keyword" : strKeyword
				}
			}).done(function(response) {
				// Appends result to card
				fnAppendSeriesCards(response, $Grid);
			});
		} else {
			// Loads random series
			fnGetRandomSeries($Grid);
		}
	});
}