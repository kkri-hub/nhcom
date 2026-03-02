<?php

//////////////////////////////////////////////////////////////////////////////////////////

define("PRODUCT_LINK_LABEL_TYPE_COLOR", "color");

//////////////////////////////////////////////////////////////////////////////////////////

function getProductLinksHtml($idToProduct, $pids, $labelType) {
	global $colorNameToId;
	
	$lis = "";
	foreach ($pids as $pid) {
		if (array_key_exists($pid, $idToProduct)) {
			$c = $idToProduct[$pid]["custom"];
		
			$label = "";
			if ($labelType == PRODUCT_LINK_LABEL_TYPE_COLOR) {
				$label = $c["color"];
			} else {
				$label = $c["name"];
				if ($c["category"]) $label .= "　".$c["category"];
//				if ($c["color"]) $label .= "　".$c["color"];
			}
			
			$label = _remove($label, "木製");
			$label = _remove($label, "John Pole Hanger（ジョン・ポールハンガー）　");
			foreach ($colorNameToId as $colorName => $colorId) {
				$label = _remove($label, $colorName);
			}
			$label = _replace($label, "　　", "　");
			
			$label .= "　".formatPrice($c["price"]);
			
			$lis .=	"<li><a href='".getProductUrl($pid)."'>$label</a></li>";
		}
	}
	return "<ul>$lis</ul>";
}

function getFeatureItemsHtml($idToProduct, $pids) {
	$products = array();
	foreach ($pids as $pid) {
		if (array_key_exists($pid, $idToProduct)) {
			array_push($products, $idToProduct[$pid]);
		}
	}
	
	return	"<div class='items'>".
				"<h2 nh-font='2'>Items</h2>".
				"<div class='list'>".getProductsHtml($products)."</div>".
			"</div>";
}

function echoFeatureButtonSection($url, $label) {
	echo	"<section feature-section='button'>".
				"<div class='content-area-container' nh-content-sp='padding'>".
					"<div class='content-area' feature-title='1' nh-gray-border='2'>".
						"<div class='button'>".
							"<a href='$url' nh-button nh-font='default' nh-gray-bg-hover='2'>$label</a>".
						"</div>".
					"</div>".
				"</div>".
			"</section>";
}

/////////////////////////////////////////////

function echoFeatures($items) {
	echo	"<section feature-section='items'>".
			"<div class='content-area-container' nh-content-sp='padding'>".
			"<div class='content-area'>";
	
	foreach ($items as $item) {
		$keys = array_keys($item);
		$numOfKeys = sizeof($keys);
		if ($numOfKeys == 1) {
			if ($keys[0] == "title") {
				echo	"<div class='section-title'>".
							"<h1>".$item["title"]."</h1>".
						"</div>";
			} else if ($keys[0] == "image")  {
				echo "<div><img src='".getImg($item["image"])."'></div>";
			}
		} else if ($numOfKeys == 2) {
			if (in_array("products", $keys) && in_array("pids", $keys)) {
				echo getFeatureItemsHtml($item["products"], $item["pids"]);
			}
		} else {
			if (in_array("image", $keys) && in_array("text", $keys)) {
				$html = "";
				if (in_array("links", $keys)) {
					// TODO
				} else {
					$html = getFeatureParagraphHtml1(null, $item);
				}
				$isImageFirst = true;
				foreach ($keys as $key) {
					if ($key == "image") {
						break;
					} else if ($key == "text") {
						$isImageFirst = false;
					}
				}
				if (!$isImageFirst) $html = _replace($html, " class='paragraph'", " class='paragraph reverse'");
				echo $html;
			}
		}
	}
	
	echo	"</div>".
			"</div>".
			"</section>";
}

/////////////////////////////////////////////

function getFeatureTopImageHtml($image) {
	$res = "";
	if (is_string($image)) {
		$res = getTopImageHtml($image);
	} else if (is_array($image)) {
		$res =	"<div class='main-image' nh-image='1' header-view='bottom' device='pc' style='background-image:url(\"".getImg($image["pc"])."\");'></div>".
					"<div class='main-image' nh-image='1' header-view='bottom' device='sp' style='background-image:url(\"".getImg($image["sp"])."\");'></div>";
	}
	return $res;
}

function echoFeatureTopImage($pcImage, $spImage=null) {
	if (_isValid($spImage)) {
		echo	"<section id='top' nh-margin='header'>".
					"<div class='main-image' nh-image='1' header-view='bottom' device='pc' style='background-image:url(\"".getImg($pcImage)."\");'></div>".
					"<div class='main-image' nh-image='1' header-view='bottom' device='sp' style='background-image:url(\"".getImg($spImage)."\");'></div>".
				"</section>";
	} else {
		echo "<section id='top' nh-margin='header'>".getTopImageHtml($pcImage)."</section>";
	}
}

/////////////////////////////////////////////

function echoFeatureTop1($image, $texts) {
	echo	"<section id='top' nh-margin='header'>".
				getFeatureTopImageHtml($image).
				"<div class='content-area-container' nh-content-sp='padding'>".
					"<div class='content-area' feature-title='1'>".
						"<div class='container'>".
							"<div class='top' nh-gray-border='3'>".
								"<div nh-font='1'>".$texts[0]."</div>".
							"</div>".
							"<div class='title'>".
								"<h1>".$texts[1]."</h1>".
								"<h2 nh-font='1'>".$texts[2]."</h2>".
							"</div>".
							"<div class='desc' nh-font='1'>".$texts[3]."</div>".
							"<div class='bottom' nh-gray-border='3'></div>".
						"</div>".
					"</div>".
				"</div>".
			"</section>";
}

function echoFeatureTop2($image, $texts) {
	$img;
	$alt = array_key_exists("alt", $texts) ? 'alt="'._replace($texts["alt"], '"', '\"').'"' : "";
	if (array_key_exists("image-pc", $texts) && array_key_exists("image-sp", $texts)) {
		$img =	"<img src='".getImg($texts["image-pc"])."' device='pc' $alt>".
				"<img src='".getImg($texts["image-sp"])."' device='sp' $alt>";
	} else {
		$img = "<img src='".getImg($texts["image"])."' $alt>";
	}
	
	echo	"<section id='top' nh-margin='header'>".
				getFeatureTopImageHtml($image).
				"<div class='content-area-container' nh-content-sp='padding'>".
					"<div class='content-area' feature-title='2'>".
						"<div class='container'>".
							"<div>$img</div>".
							(array_key_exists("text", $texts) ? "<h1>".$texts["text"]."</h1>" : "").
							(array_key_exists("text2", $texts) ? $texts["text2"] : "").
						"</div>".
					"</div>".
				"</div>".
			"</section>";
}

function echoFeatureTop3($image, $text1, $text2=null) {
	$html2 = _isValidString($text2) ? "<h2 nh-font='1'>$text2</h2>" : "";
	
	echo	"<section id='top' nh-margin='header'>".
				getFeatureTopImageHtml($image).
				"<div class='content-area-container' nh-content-sp='padding'>".
					"<div class='content-area' feature-title='3'>".
						"<div class='container'>".
							"<h1>$text1</h1>".
							$html2.
						"</div>".
					"</div>".
				"</div>".
			"</section>";
}

function echoFeatureTop4($topImage, $text1, $text2=null, $text3=null, $image=null) {
	$html2 = _isValidString($text2) ? "<h2 nh-font='1'>$text2</h2>" : "";
	$html3 = _isValidString($text3) ? "<div class='text' nh-font='1'>$text3</div>" : "";
	$htmlImage = _isValidString($image) ? "<div class='image'><img src='".getImg($image)."'></div>" : "";
	
	echo	"<section feature-top='4' id='top' nh-margin='header'>".
				getFeatureTopImageHtml($image).
				"<div class='content-area-container' nh-content-sp='padding'>".
					"<div class='content-area' feature-title='3'>".
						"<div class='container'>".
							"<h1>$text1</h1>".
							$html2.
							$html3.
							$htmlImage.
						"</div>".
					"</div>".
				"</div>".
			"</section>";
}

/////////////////////////////////////////////

function getFeatureParagraphHtml1($idToProduct, $params, $imgTag=false) {
	$title = "";
	if (array_key_exists("title", $params)) {
		$title = "<h2>".$params["title"]."</h2>";
	}
	
	$image;
	if ($imgTag) {
		$image = "<img src='".getImg($params["image"])."'>";
	} else {
		$image = "<div style='background-image:url(\"".getImg($params["image"])."\");'></div>";
	}
	
	$links = "";
	if (array_key_exists("links", $params)) {
		$label = array_key_exists("label", $params["links"]) ? $params["links"]["label"] : null;
		
		$links =	"<div class='links'>".
						"<div class='title'>".$params["links"]["title"]."</div>".
						"<div class='anchors'>".getProductLinksHtml($idToProduct, $params["links"]["pids"], $label)."</div>".
					"</div>";
	}
	
	return	"<div class='paragraph'>".
				"<div class='image'>$image</div>".
				"<div class='text'>".
					$title.
					"<div class='desc'>".$params["text"]."</div>".
					$links.
				"</div>".
			"</div>";
}

function getFeatureParagraphHtml2($idToProduct, $params, $imgTag=false) {
	$title = "";
	if (array_key_exists("title", $params)) {
		$title = "<h2>".$params["title"]."</h2>";
	}
	
	$image1;
	if ($imgTag) {
		$image1 = "<img src='".getImg($params["image-1"])."'>";
	} else {
		$image1 = "<div style='background-image:url(\"".getImg($params["image-1"])."\");'></div>";
	}
	
	$image2 =	"<div class='image-2'>".
					"<div style='background-image:url(\"".getImg($params["image-2"])."\");'></div>".
				"</div>";
	
	$links = "";
	if (array_key_exists("links", $params)) {
		$label = array_key_exists("label", $params["links"]) ? $params["links"]["label"] : null;
		
		$links =	"<div class='links'>".
						"<div class='title'>".$params["links"]["title"]."</div>".
						"<div class='anchors'>".getProductLinksHtml($idToProduct, $params["links"]["pids"], $label)."</div>".
					"</div>";
	}
	
	return	"<div class='paragraph paragraph-2'>".
				"<div class='image'>$image1</div>".
				"<div class='text'>".
					$title.
					"<div class='desc'>".$params["text"]."</div>".
					$links.
					$image2.
				"</div>".
			"</div>";
}

/////////////////////////////////////////////

function echoFeatureSection1($idToProduct, $title, $params, $items) {
	$paragraphs = "";
	foreach ($params as $param) {
		$paragraphs .= getFeatureParagraphHtml1($idToProduct, $param);
	}
	
	echo	"<section feature-section='1'>".
				"<div class='content-area-container'>".
					"<div class='content-area' nh-gray-border='2'>".
						"<div class='section-title' nh-content-sp='padding'>".
							"<h1>$title</h1>".
						"</div>".
						"<div class='paragraphs' nh-content-sp='padding'>$paragraphs</div>".
						getFeatureItemsHtml($idToProduct, $items).
					"</div>".
				"</div>".
			"</section>";
}

function echoFeatureSection2($idToProduct, $title1, $title2, $params, $imageAlignLeft=true, $imgTag=false, $items=null) {
	$paragraphs = "";
	foreach ($params as $param) {
		$paragraphs .= getFeatureParagraphHtml1($idToProduct, $param, $imgTag);
	}
	
	$itemHtml = _isValid($items) ? getFeatureItemsHtml($idToProduct, $items) : "";
	
	echo	"<section feature-section='2' image-align='".($imageAlignLeft ? "left" : "right")."'>".
				"<div class='content-area-container'>".
					"<div class='content-area' nh-gray-border='2'>".
						"<div class='section-title' nh-content-sp='padding'>".
							"<h1>$title1</h1>".
							"<h2 nh-font='1'>$title2</h2>".
						"</div>".
						"<div class='paragraphs' nh-content-sp='padding'>$paragraphs</div>".
						$itemHtml.
					"</div>".
				"</div>".
			"</section>";
}

function echoFeatureSection3($idToProduct, $title, $params, $imageAlignLeft=true) {
	$paragraphs = "";
	foreach ($params as $param) {
		$paragraphs .= getFeatureParagraphHtml1($idToProduct, $param);
	}
	
	echo	"<section feature-section='3' image-align='".($imageAlignLeft ? "left" : "right")."'>".
				"<div class='content-area-container'>".
					"<div class='content-area' nh-gray-border='2'>".
						"<div class='section-title' nh-content-sp='padding'>".
							"<h1>$title</h1>".
						"</div>".
						"<div class='paragraphs' nh-content-sp='padding'>$paragraphs</div>".
					"</div>".
				"</div>".
			"</section>";
}

function echoFeatureSection4($idToProduct, $params1, $params2, $imageAlignLeft=true) {
	$h1 = array_key_exists("h1", $params1) ? "<h1>".$params1["h1"]."</h1>" : "";
	$h2 = array_key_exists("h2", $params1) ? "<h2>".$params1["h2"]."</h2>" : "";
	$p = array_key_exists("text", $params1) ? "<div class='top-paragraph'><p>".$params1["text"]."</p></div>" : "";
	
	$paragraphs = "";
	foreach ($params2 as $param) {
		$paragraphs .= getFeatureParagraphHtml1($idToProduct, $param);
	}
	
	echo	"<section feature-section='4' image-align='".($imageAlignLeft ? "left" : "right")."'>".
				"<div class='content-area-container'>".
					"<div class='content-area' nh-gray-border='2' nh-content-sp='padding'>".
						"<div class='section-title'>".
							$h1.
							$h2.
						"</div>".
						$p.
						"<div class='paragraphs'>$paragraphs</div>".
					"</div>".
				"</div>".
			"</section>";
}

function echoFeatureSection5($params) {
	$h1 = array_key_exists("h1", $params) ? "<h1>".$params["h1"]."</h1>" : "";
	$h2 = array_key_exists("h2", $params) ? "<h2>".$params["h2"]."</h2>" : "";
	$image = array_key_exists("image", $params) ? "<img src='".getImg($params["image"])."'>" : "";
	$p = array_key_exists("text", $params) ? "<p>".$params["text"]."</p>" : "";
	
	echo	"<section feature-section='5' nh-content-sp='padding'>".
				"<div class='content-area-container'>".
					"<div class='content-area' nh-gray-border='2'>".
						"<div class='section-title'>".
							$h1.
							$h2.
						"</div>".
						$image.
						$p.
					"</div>".
				"</div>".
			"</section>";
}

function echoFeatureSection6($params) {
	$h1 = array_key_exists("h1", $params) ? "<h1>".$params["h1"]."</h1>" : "";
	$h2 = array_key_exists("h2", $params) ? "<h2>".$params["h2"]."</h2>" : "";
	$image = array_key_exists("image", $params) ? "<img src='".getImg($params["image"])."'>" : "";
	$p = array_key_exists("text", $params) ? "<p>".$params["text"]."</p>" : "";
	
	echo	"<section feature-section='5' nh-content-sp='padding'>".
				"<div class='content-area-container'>".
					"<div class='content-area' nh-gray-border='2'>".
						"<div class='section-title'>".
							$h1.
							$h2.
						"</div>".
						$image.
						$p.
					"</div>".
				"</div>".
			"</section>";
}

function echoFeatureSection7($idToProduct, $title1, $title2, $params, $imageAlignLeft=true, $imgTag=false, $items=null) {
	$paragraphs = "";
	foreach ($params as $param) {
		$paragraphs .= getFeatureParagraphHtml2($idToProduct, $param, $imgTag);
	}
	
	$itemHtml = _isValid($items) ? getFeatureItemsHtml($idToProduct, $items) : "";
	
	echo	"<section feature-section='2' image-align='".($imageAlignLeft ? "left" : "right")."'>".
				"<div class='content-area-container'>".
					"<div class='content-area' nh-gray-border='2'>".
						"<div class='section-title' nh-content-sp='padding'>".
							"<h1>$title1</h1>".
							"<h2 nh-font='1'>$title2</h2>".
						"</div>".
						"<div class='paragraphs' nh-content-sp='padding'>$paragraphs</div>".
						$itemHtml.
					"</div>".
				"</div>".
			"</section>";
}

//////////////////////////////////////////////////////////////////////////////////////////

function echoFeatureImage1($imagePc, $imageSp) {
	echo	"<section feature-image='1'>".
				"<div class='content-area-container'>".
					"<div class='content-area' nh-content-sp='padding'>".
						"<img device='pc' src='".getImg($imagePc)."'>".
						"<img device='sp' src='".getImg($imageSp)."'>".
					"</div>".
				"</div>".
			"</section>";
}

//////////////////////////////////////////////////////////////////////////////////////////

function getFeatureColumnHtml($params) {
	$lis = "";
	foreach ($params as $param) {
		$pTitle = array_key_exists("title", $param) ? "<h2>".$param["title"]."</h2>" : "";
		
		$text = array_key_exists("text", $param) ? "<div class='text'>".$param["text"]."</div>" : "";
		
		$lis .=	"<li>".
						"<div>".
							"<img src='".getImg($param["image"])."'>".
						"</div>".
						$pTitle.
						$text.
					"</li>";
	}
	return "<ul>$lis</ul>";
}

function echoFeatureColumnSection($n, $texts, $columns) {
	echo	"<section feature-column-section='$n'>".
				"<div class='content-area-container'>".
					"<div class='content-area'>".
						$texts.
						"<div column='".sizeof($columns)."' nh-content-sp='padding'>".
							getFeatureColumnHtml($columns).
						"</div>".
					"</div>".
				"</div>".
			"</section>";
}

function echoFeatureColumnSection1($idToProduct, $columns, $title=null, $desc=null) {
	$texts = "";
	if (_isValidString($title) || _isValidString($desc)) {
		$texts = "<div class='text' nh-content-sp='padding'>";
		if (_isValidString($title)) $texts .= "<h1>$title</h1>";
		if (_isValidString($desc)) $texts .= "<p nh-font='1'>$desc</p>";
		$texts .= "</div>";
	}
	echoFeatureColumnSection(1, $texts, $columns);
}

function echoFeatureColumnSection2($idToProduct, $columns, $h1=null, $h2=null, $text=null) {
	$texts = "";
	if (_isValidString($h1) || _isValidString($h2) || _isValidString($desc)) {
		$texts = "<div class='text' nh-content-sp='padding'>";
		if (_isValidString($h1)) $texts .= "<h1>$h1</h1>";
		if (_isValidString($h2)) $texts .= "<h2>$h2</h2>";
		if (_isValidString($text)) $texts .= "<p nh-font='1'>$text</p>";
		$texts .= "</div>";
	}
	echoFeatureColumnSection(2, $texts, $columns);
}

function echoFeatureColumnSection3($idToProduct, $params) {
	$texts = "";
	if (array_key_exists("h1", $params) && _isValidString($params["h1"])) {
		$texts = "<div class='text' nh-content-sp='padding'>";
		if (_isValidString($params["h1"])) $texts .= "<h1>".$params["h1"]."</h1>";
		$texts .= "</div>";
	}
	
	$zigzag = "";
	if (array_key_exists("zigzag", $params)) {
		$rows = "";
		foreach ($params["zigzag"] as $imageText) {
			$rows .=	"<div>".
							"<div><img src='".getImg($imageText["image"])."'></div>".
							"<div>".$imageText["text"]."</div>".
						"</div>";
		}
		$zigzag = "<div class='zigzag' nh-content-sp='padding'>$rows</div>";
	}
	
	$columns = "";
	if (array_key_exists("columns", $params)) {
		$columns =	"<div column='".sizeof($params["columns"])."' nh-content-sp='padding'>".
						getFeatureColumnHtml($params["columns"]).
					"</div>";
	}
	
	$items = array_key_exists("products", $params) ? getFeatureItemsHtml($idToProduct, $params["products"]) : "";
	
	echo	"<section feature-column-section='3'>".
				"<div class='content-area-container'>".
					"<div class='content-area'>".
						$texts.
						$zigzag.
						$columns.
						$items.
					"</div>".
				"</div>".
			"</section>";
}

//////////////////////////////////////////////////////////////////////////////////////////

function echoFeatureImageColumns1($params) {
	$images = "";
	foreach ($params["images"] as $image) {
		$images .=	"<div style='background-image:url(\"".getImg($image)."\");'></div>";
	}
	
	echo	"<section feature-images-column-section='1'>".
				"<div class='content-area-container' nh-content-sp='padding'>".
					"<div class='content-area'>".
						"<div class='images' columns='".sizeof($params["images"])."'>$images</div>".
						"<div class='text' nh-font='1'>".$params["text"]."</div>".
					"</div>".
				"</div>".
			"</section>";
}

//////////////////////////////////////////////////////////////////////////////////////////

?>