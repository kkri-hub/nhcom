<?php

//////////////////////////////////////////////////////////////////////////////////////////

function echoAboutSubmenu() {
	$menu = array(
		array(
			"label"=>getTxt("about"),
			"url"=>getHref("about"),
		),
		array(
			"label"=>getTxt("craftsmanship"),
			"url"=>getHref("craftsmanship"),
		),
		array(
			"label"=>getTxt("companyInfo"),
			"url"=>getHref("company"),
		),
		array(
			"label"=>getTxt("companyHistory"),
			"url"=>getHref("history"),
		),
		array(
			"label"=>getTxt("sdgsActions"),
			"url"=>getHref("sdgs"),
		),
	);
	
	$file = (FILE_NAME == "index") ? "about" : FILE_NAME;
	
	$file;
	if (in_array("sdgs", _url()["paths"])) {
		$file = "sdgs";
	} else if (FILE_NAME == "index") {
		$file = "about";
	} else {
		$file = FILE_NAME;
	}
	
	for ($i = 0, $len = sizeof($menu); $i < $len; $i++) {
		$lastUrl = _afterLast($menu[$i]["url"], "/");
		$lastUrl = _removeExt($lastUrl);
		$menu[$i]["selected"] = ($lastUrl == $file);
	}
	
	echoPageSubmenu($menu);
	
	/*
	$lis = "";
	foreach ($menu as $m) {
		$selected = (_afterLast($m["url"], "/") == $file) ? "selected" : "";
		$lis .=	"<li nh-gray-border='2' $selected><a href='".$m["url"]."' nh-red-border>".$m["label"]."</a></li>";
	}
	
	echo	"<div class='about-submenu' nh-margin='header'>".
				"<ul>$lis</ul>".
			"</div>";
	*/
}

//////////////////////////////////////////////////////////////////////////////////////////

function echoAboutSection($params, $isTop=false) {
	$id = array_key_exists("id", $params) ? "id='".$params["id"]."'" : "";
	
	$titleLang = array_key_exists("titleLang", $params) ? "lang='".$params["titleLang"]."'" : "";
	
	$subTexts = "";
	if (array_key_exists("sub", $params)) {
		foreach ($params["sub"]["texts"] as $sub) {
			$title = array_key_exists("title", $sub) ? "<h2 nh-font='1'>".$sub["title"]."</h2>" : "";
			$subTexts .=	"<div class='container'>".
								$title.
								"<div class='text' nh-lh='desc'>".$sub["text"]."</div>".
							"</div>";
		}
	}
	
	$headerView = $isTop ? "header-view='bottom'" : "";
	
	$sub = "";
	if (array_key_exists("sub", $params)) {
		$sub =	"<div class='sub' nh-gray-bg='1' nh-faded-up='false'>".
					"<div class='image-container'>".
						"<div class='image' style='background-image:url(\"".$params["sub"]["image"]."\");'></div>".
					"</div>".
					"<div class='texts' nh-content-sp='padding'>$subTexts</div>".
				"</div>";
	}
	
	echo	"<section $id class='about-section' nh-faded-up='false'>".
				"<h1 $titleLang>".$params["title"]."</h1>".
				"<div class='main-image' style='background-image:url(\"".$params["main"]["image"]."\");' $headerView></div>".
				"<div class='content-area-container body'>".
					"<div class='content-area'>".
						"<div nh-faded-up='false'>".
							"<div class='main-title' nh-content-sp='padding'>".
								"<h2 nh-font='1'>".$params["main"]["title"]."</h2>".
							"</div>".
							"<div class='main-text' nh-font='1' nh-content-sp='padding'>".
								"<p>".$params["main"]["text"]."</p>".
							"</div>".
						"</div>".
						$sub.
					"</div>".
				"</div>".
			"</section>";
}

//////////////////////////////////////////////////////////////////////////////////////////

function echoAboutHistory($title, $history, $tag) {
	$years = "";
	foreach ($history as $year => $content) {
		$yearTitle = array_key_exists("title", $content) ? "<h2 nh-font='1'><div class='text' nh-gray-border='3'>".$content["title"]."</div></h2>" : "";
		
		$texts = "";
		foreach ($content["texts"] as $text) {
			$texts .= "<$tag>$text</$tag>";
		}
		if ($tag == "li") $texts = "<ul>$texts</ul>";
		
		$image = "";
		if (array_key_exists("image", $content)) {
			$image =	"<div class='image'><img src='".$content["image"]."'></div>";
			if (array_key_exists("caption", $content)) $image .= "<div class='caption'>".$content["caption"]."</div>";
			$image = "<div class='image-caption' nh-faded-up='false'>$image</div>";
		}
		
		$years .=	"<div class='year'>".
						"<div class='year-number' nh-font='2' nh-gray-border='3' nh-red-bg-after>".
							"<div class='number'>$year</div>".
						"</div>".
						"<div class='content'>".
							$yearTitle.
							"<div class='texts-image'>".
								"<div class='texts'>$texts</div>".
								$image.
							"</div>".
						"</div>".
					"</div>";
	}
	
	echo	"<section class='about-section about-history' id='history' tag='$tag' nh-faded-up='false' nh-content-sp='padding'>".
				"<h1>$title</h1>".
				"<div class='content-area-container'>".
					"<div class='content-area'>$years</div>".
				"</div>".
			"</section>";
}

function echoAboutHistoryLink($label, $url) {
	$label = (LANG == LANG_JA) ? getTxt("leftBracket")."<a href='$url' nh-link-color>$label</a>".getTxt("rightBracket", "check-") : "Go to ".getTxt("leftBracket")."<a href='$url' nh-link-color>$label</a>".getTxt("rightBracket");
	echo	"<section id='link-to-history' nh-content-sp='padding'>".
				"<div class='content-area-container'>".
					"<div class='content-area'>→ $label</div>".
				"</div>".
			"</section>";
}

//////////////////////////////////////////////////////////////////////////////////////////

?>