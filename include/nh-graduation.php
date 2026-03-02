<?php

//////////////////////////////////////////////////////////////////////////////////////////

function esc($s)
{
	$s = _replace($s, "<", "&lt;");
	$s = _replace($s, ">", "&gt;");
	return $s;
}

function getGradProductLabel($id)
{
	global $products;

	$p = $products[$id];
	if (array_key_exists("name", $p)) {
		if (is_string($p["name"])) {
			return $p["name"];
		} else {
			return implode(" / ", array_values($p["name"]));
		}
	} else {
		return strtoupper($id);
	}
}

function getGradManWomanProductCountLabels()
{
	global $personLabels;
	$res = array();
	foreach ($personLabels as $studentTeacher => $labels) {
		$res[$studentTeacher] = array_values($labels);
	}
	return $res;
}
function getGradProductCountLabels()
{
	global $products, $personLabels;

	$manWoman = getGradManWomanProductCountLabels();

	$ps = array();
	foreach ($products as $id => $p) {
		if (array_key_exists("counts", $p)) {
			$ps[$id] = array_values($p["counts"]);
		} else if (is_array($p["size"]["width"])) {
			$ps[$id] = $manWoman;
		} else {
			$ps[$id] = null;
		}
	}
	return array("products" => $ps, "default" => array());
}

function getGradPrice($price, $taxed = false)
{
	if (!$taxed)
		$price = intval(floor($price + ($price * TAX_GRADUATION_HANGER / 100)));
	return number_format($price) . " 円（" . getTxt("includingTax") . "）";
}

function getGradDeadline($date)
{
	$ymd = explode("/", $date);
	$w = date("w", mktime(0, 0, 0, $ymd[1], $ymd[2], $ymd[0]));
	$dayOfWeek = array("日", "月", "火", "水", "木", "金", "土")[$w];
	return $ymd[0] . "年 " . intval($ymd[1]) . "月 " . intval($ymd[2]) . "日（" . $dayOfWeek . "）";
}
function getGradOrderEarlyDeadline($extended = false)
{
	return getGradDeadline($extended ? GRAD_ORDER_EARLY_DEADLINE_EXTENDED : GRAD_ORDER_EARLY_DEADLINE);
}
function getGradPaymentEarlyDeadline()
{
	return getGradDeadline(GRAD_PAYMENT_EARLY_DEADLINE);
}
function getGradOrderDeadline($extended = false)
{
	return getGradDeadline($extended ? GRAD_ORDER_DEADLINE_EXTENDED : GRAD_ORDER_DEADLINE);
}
function getGradPaymentDeadline()
{
	return getGradDeadline(GRAD_PAYMENT_DEADLINE);
}

//////////////////////////////////////////////////////////////////////////////////////////

function gradLog($dir, $datetime, $log)
{
	$datetime = date("Y-m-d H:i:s");

	//	if (is_array($log)) $log = json_encode($log, JSON_UNESCAPED_UNICODE);

	$path = ROOT_PATH . "/" . DIR_LOG . "/$dir/" . date("Y_m") . ".txt";

	//	$line = "$datetime\t$log";
	$arr = array(
		"datetime" => $datetime,
		"log" => $log,
		"server" => $_SERVER,
	);
	$line = json_encode($arr, JSON_UNESCAPED_UNICODE);

	return _append($path, $line);
}

//////////////////////////////////////////////////////////////////////////////////////////

function echoGradCss()
{
	echo "<style>" .
		getFontFamilyStyle("hannari-mincho") .
		"@media only screen and (min-width:769px) {\n" .
		"\t#top .main-image {\n" .
		"\t\tbackground-image: url(" . getImg(GRAD_MAIN_IMAGE_PC) . ");\n" .
		"\t}\n" .
		"\t#grad-menu {\n" .
		"\t\ttop: " . GRAD_MENU_INIT_TOP_PC . "px;\n" .
		"\t}\n" .
		"}\n" .
		"@media only screen and (max-width:768px) {\n" .
		"\t#top .main-image {\n" .
		"\t\tbackground-image: url(" . getImg(GRAD_MAIN_IMAGE_SP) . ");\n" .
		"\t}\n" .
		"\t#grad-menu {\n" .
		"\t\ttop: " . GRAD_MENU_INIT_TOP_SP . "px;\n" .
		"\t}\n" .
		"}\n" .
		"</style>";
}

function echoGradOnLoad($isMenuFixed = true)
{
	if ($isMenuFixed) {
		echo "nh.grad.init(" .
			"'grad-menu', " .
			GRAD_MENU_INIT_TOP_PC . ", " .
			GRAD_MENU_INIT_TOP_SP . ", " .
			GRAD_MENU_MIN_TOP_PC . ", " .
			GRAD_MENU_MIN_TOP_SP .
			");";
	} else {
		echo "_.id('grad-menu').removeAttribute('scroll');";
		echo "_.id('grad-menu').style.opacity = 1;";
	}
}

//////////////////////////////////////////////////////////////////////////////////////////

function echoGradTop()
{
	$url = _url();
	$lastPath = $url["paths"][sizeof($url["paths"]) - 2];

	$menu = array(
		"graduation" => "卒業記念ホーム",
		"products" => "商品",
		"flow" => "ご注文の流れ",
		"faq" => "よくあるご質問",
		"voices" => "お客様の声",
		"sdgs" => "SDGs",
	);

	$menuHtml = "";
	foreach ($menu as $url => $label) {
		$selected = ($url == $lastPath) ? "selected" : "";

		if (_isValidString($menuHtml)) {
			$url = "graduation_$url";
			$menuHtml .= "<li>" .
				"<span device='pc'>／</span>" .
				"<span device='sp'>/</span>" .
				"</li>";
		}

		$menuHtml .= "<li $selected>" .
			"<a href='" . getHref($url) . "' nh-red-border>$label</a>" .
			"</li>";
	}

	echo "<section id='top' nh-margin='header'>" .
		"<div class='main-image' nh-image='1' header-view='bottom'>" .
		"<div class='content-area-container'>" .
		"<div class='content-area'>" .
		"<div class='texts'>" .
		"<h1 nh-gray-border='3'>福（服）をかける卒業記念品【NAKATA HANGER】</h1>" .
		"<h2>使うたびに思い出す<br>母校の記憶</h2>" .
		"</div>" .
		"<div class='buttons'>" .
		"<div class='button'><a href='" . getHref("graduation_catalog") . "' nh-button><span>カタログ請求</span></a></div>" .
		"<div class='button'><a href='" . getHref("graduation_estimate") . "' nh-button>お見積りフォーム</a></div>" .
		"</div>" .
		"</div>" .
		"</div>" .
		"</div>" .
		"</section>" .
		"<div id='grad-menu' fixed='false' scroll='up'>" .
		"<ul>" .
		$menuHtml .
		/*					"<li selected><a href='".getHref("graduation")."' nh-red-border>卒業記念ホーム</a></li>".
					"<li>".
						"<span device='pc'>／</span>".
						"<span device='sp'>/</span>".
					"</li>".
					"<li><a href='".getHref("graduation_products")."' nh-red-border>商品</a></li>".
					"<li>".
						"<span device='pc'>／</span>".
						"<span device='sp'>/</span>".
					"</li>".
					"<li><a href='".getHref("graduation_flow")."' nh-red-border>ご注文の流れ</a></li>".
					"<li>".
						"<span device='pc'>／</span>".
						"<span device='sp'>/</span>".
					"</li>".
					"<li><a href='".getHref("graduation_voices")."' nh-red-border>お客様の声</a></li>".*/
		"</ul>" .
		"</div>";
}

//////////////////////////////////////////////////////////////////////////////////////////
/*
function echoGradHiddens() {
	global $products, $ritsus, $personLabels;

	$personLabelInputs = "";
	foreach ($personLabels as $studentTeacher => $manWomans) {
		foreach ($manWomans as $manWoman => $label) {
			$personLabelInputs .= "<input type='hidden' name='_label-".$studentTeacher."-".$manWoman."' value='$label'>";
		}
	}

	echo	"<input type='hidden' name='_file-name-format' value='".GRAD_ESTIMATE_FILE_NAME_FORMAT."'>".

			"<input type='hidden' name='_tax' value='".TAX_GRADUATION_HANGER."'>".
			"<input type='hidden' name='_ritsu' value='".implode(' ', $ritsus)."'>".

			"<input type='hidden' name='_price-silk-plate' value='".PRICE_SILK_PLATE."'>".
			"<input type='hidden' name='_price-noshi' value='".PRICE_NOSHI."'>".
			"<input type='hidden' name='_min-num-of-hangers-for-regular-price' value='".MIN_NUM_OF_HANGERS_FOR_REGULAR_PRICE."'>".
			"<input type='hidden' name='_min-num-of-hangers-for-free-silk-plate' value='".MIN_NUM_OF_HANGERS_FOR_FREE_SILK_PLATE."'>".
			"<input type='hidden' name='_unit-price-increase-for-small-amount' value='".UNIT_PRICE_INCREASE_FOR_SMALL_AMOUNT."'>".

				"<input type='hidden' name='_label-sale-in-charge' value='".LABEL_SALE_IN_CHARGE."'>".
			"<input type='hidden' name='_label-school-name' value='".LABEL_SCHOOL_NAME."'>".
			"<input type='hidden' name='_label-customer-in-charge' value='".LABEL_CUSTOMER_IN_CHARGE."'>".
			"<input type='hidden' name='_label-customer-contact' value='".LABEL_CUSTOMER_CONTACT."'>".
			"<input type='hidden' name='_label-product' value='".LABEL_PRODUCT."'>".
			"<input type='hidden' name='_label-count' value='".LABEL_COUNT."'>".
			"<input type='hidden' name='_label-order-history' value='".LABEL_ORDER_HISTORY."'>".
			"<input type='hidden' name='_label-noshi' value='".LABEL_NOSHI."'>".
			"<input type='hidden' name='_label-delivery-date' value='".LABEL_DELIVERY_DATE."'>".
			"<input type='hidden' name='_label-notes' value='".LABEL_NOTES."'>".

			$personLabelInputs.

			"<textarea name='_products'>".json_encode($products, JSON_UNESCAPED_UNICODE)."</textarea>";
}
*/
//////////////////////////////////////////////////////////////////////////////////////////

function echoInstagramSection()
{
	echo "<section class='link-buttons' id='instagram'>" .
		"<div class='content-area-container'>" .
		"<div class='content-area' nh-gray-border='3' nh-content-sp='padding'>" .
		"<h3>卒業記念ハンガー<span>Instagram</span></h3>" .
		"<p nh-font='1'>お客様の声や写真を掲載しております。</p>" .
		"<div class='button grad-link-button'>" .
		"<a href='" . getHref("grad_instagram") . "' target='_blank' nh-button>" .
		getLogo("instagram") .
		"<span class='id'>@" . INSTAGRAM_GRAD_ID . "</span>" .
		"</a>" .
		"</div>" .
		"</div>" .
		"</div>" .
		"</section>";
}

function echoFormLinkSection()
{
	echo "<section class='link-buttons' id='form-links'>" .
		"<div class='content-area-container'>" .
		"<div class='content-area' nh-gray-border='3' nh-content-sp='padding'>" .
		"<div class='title'>" .
		"<h3>カタログ請求</h3>" .
		"<span>、</span>" .
		"<h3>見積り申込み</h3>" .
		"</div>" .
		"<div class='layout'>" .
		"<div>" .
		"<div>" .
		"<div class='button grad-link-button'><a href='" . getHref("graduation_catalog") . "' nh-button>カタログ請求</a></div>" .
		"<div class='button grad-link-button'><a href='" . getHref("graduation_estimate") . "' nh-button>お見積り依頼はこちら</a></div>" .
		//"<div class='button grad-link-button'>お見積りフォームの開設は4月後半を予定しております。</div>".
		"</div>" .
		"</div>" .
		"</div>" .
		"</div>" .
		"</div>" .
		"</section>";
}

function echoFaqLinkSections()
{
	echo "<section class='link-buttons' id='faq-link'>" .
		"<div class='content-area-container'>" .
		"<div class='content-area' nh-gray-border='3' nh-content-sp='padding'>" .
		"<div class='layout'>" .
		"<div>" .
		"<div>" .
		"<div><h3>よくあるご質問</h3></div>" .
		"<div class='button grad-link-button'><a href='" . getHref("graduation_faq") . "' nh-button>Read more</a></div>" .
		"</div>" .
		"</div>" .
		"</div>" .
		"</div>" .
		"</div>" .
		"</section>";
}

function echoCommonSections()
{
	echoFormLinkSection();
	echoFaqLinkSections();
	echoInstagramSection();
}

//////////////////////////////////////////////////////////////////////////////////////////

function echoGradFormComplete($text1, $text2)
{
	echo "<section id='form-complete' nh-margin='header'>" .
		"<div class='content-area-container' nh-content-sp='padding'>" .
		"<div class='content-area'>" .
		"<div class='texts'>" .
		"<div class='container'>" .
		"<h2 class='header'>$text1</h2>" .
		"<p>$text2</p>" .
		"</div>" .
		"</div>" .
		"<div class='link'><a href='" . getHref("graduation") . "' nh-link-color>卒業記念品ページ</a></div>" .
		"</div>" .
		"</div>" .
		"</section>";
}

function echoGradFormCompleteError()
{
	echo "<section id='grad-form-error' nh-margin='header'>" .
		"<div class='content-area-container' nh-content-sp='padding'>" .
		"<div class='content-area'>" .
		"<div class='header'>フォームの送信が失敗しました</div>" .
		"<div class='text'>誠に申し訳ございませんが、フォームを正常に送信できませんでした。<br>大変お手数ですが、下記のリンクあるいは電話番号よりお問い合わせください。</div>" .
		"<div class='contact'>" .
		"<div class='link'><a href='" . getHref('inquiry') . "' nh-link-color>お問い合わせフォーム</a></div>" .
		"<div class='tel'>" .
		"<div>お問い合わせ電話番号</div>" .
		"<div><a href='tel:'" . _remove(TEL_HEADQUARTERS, "-") . "'>" . TEL_HEADQUARTERS . "</a></div>" .
		"<div class='time'><div>" . getTxt("mon", "~", "fri", " / ") . HQ_OPEN_AT . " ~ " . HQ_CLOSE_AT . "</div></div>" .
		"</div>" .
		"</div>" .
		"</div>" .
		"</div>" .
		"</section>";
}

//////////////////////////////////////////////////////////////////////////////////////////
