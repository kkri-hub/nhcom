<?php
ini_set("display_errors", "On");

//////////////////////////////////////////////////////////////////////////////////////////

require_once("lib/_.php");

//////////////////////////////////////////////////////////////////////////////////////////

function isLocalHost()
{
	return ($_SERVER["SERVER_NAME"] == "localhost");
}
function isDevServer()
{
	return (isLocalHost() || _startsWith($_SERVER["SERVER_NAME"], "192.168."));
}
function isTestEnvironment()
{
	return _startsWith($_SERVER["REQUEST_URI"], "/nakatahanger-2018/");
}
function isRealServiceEnvironment()
{
	return (!isDevServer() && !isTestEnvironment());
}
function isNkkIp()
{
	return ($_SERVER["REMOTE_ADDR"] == IP_NKK_OFFICE);
}

function redirectIfNotOffice()
{
	if (!isNkkIp() && !isLocalHost() && ($_SERVER["SERVER_NAME"] != IP_MY_PC)) {
		header("Location: " . getNhHomeUrl());
	}
}

function getRequestProtocol()
{
	return ((!empty($_SERVER["HTTPS"]) && $_SERVER['HTTPS'] !== "off") || $_SERVER["SERVER_PORT"] == 443) ? "https" : "http";
}

function getNhHomeUrl()
{
	$url = _replace(__FILE__, DIRECTORY_SEPARATOR, "/");
	$url = _after($url, $_SERVER["DOCUMENT_ROOT"]);
	$url = _beforeLast($url, "/");
	$url = _toLast($url, "/");
	if (!_startsWith($url, "/"))
		$url = "/$url";
	return getRequestProtocol() . "://" . $_SERVER["HTTP_HOST"] . $url;
}

function getThisUrl()
{
	return getRequestProtocol() . "://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
}

function getCanonicalUrl()
{
	$url = getThisUrl();
	foreach (array("http", "https") as $protocol) {
		$from = "$protocol://" . DOMAIN_NHCOM;
		if (_startsWith($url, $from)) {
			return _replace($url, $from, "$protocol://" . HOST_NHCOM);
		}
	}
	return $url;
}

function getRootPath()
{
	$path = _beforeLast(__FILE__, DIRECTORY_SEPARATOR);
	return _beforeLast($path, DIRECTORY_SEPARATOR);
}

function getThisFileName()
{
	$trace = debug_backtrace();
	$path = $trace[sizeof($trace) - 1]["file"];
	return _betweenLast($path, DIRECTORY_SEPARATOR, ".");
}

function getDotsToRoot()
{
	$trace = debug_backtrace();

	$arrThisFile = explode(DIRECTORY_SEPARATOR, $trace[0]["file"]);
	$arrTheFile = explode(DIRECTORY_SEPARATOR, $trace[sizeof($trace) - 1]["file"]);

	$numOfCommonDirs = 0;
	for ($i = 0, $len = sizeof($arrThisFile); $i < $len; $i++) {
		if ($arrThisFile[$i] == $arrTheFile[$i]) {
			$numOfCommonDirs++;
		} else {
			break;
		}
	}

	$numOfParentDots = sizeof($arrTheFile) - $numOfCommonDirs - 1;

	$res = "";
	for ($i = 0; $i < $numOfParentDots; $i++) {
		$res .= "../";
	}

	return $res;
}

//////////////////////////////////////////////////////////////////////////////////////////

function getLang()
{
	if (defined("LANG")) {
		return LANG;
	} else if ($_SERVER["SCRIPT_NAME"] == "/index.php") {
		return LANG_JA;
	} else if (_contains($_SERVER["REQUEST_URI"], "/" . LANG_EN . "/")) {
		return LANG_EN;
	} else if (array_key_exists("HTTP_REFERER", $_SERVER) && _startsWith($_SERVER["HTTP_REFERER"], SHOPIFY_HOST . "/" . LANG_EN)) {
		return LANG_EN;
	} else {
		return LANG_JA;
	}
}
function echoLang()
{
	echo getLang();
}

function getOtherLangs()
{
	$langs = array(
		LANG_JA => array("href" => HOME_URL, "label" => getTxt("japanese")),
		LANG_EN => array("href" => getUr1(URL_ENGLISH, false, true) . "/", "label" => getTxt("english")),
		LANG_FR => array("href" => getUr1(URL_ENGLISH, false, true) . "/france/", "label" => getTxt("french")),
	);
	$lang = LANG;
	if (LANG == LANG_EN && in_array("france", _url()["paths"])) {
		$lang = LANG_FR;
	}
	$res = array();
	if ($lang == LANG_JA) {
		array_push($res, $langs[LANG_EN]);
		array_push($res, $langs[LANG_FR]);
	} else if ($lang == LANG_EN) {
		array_push($res, $langs[LANG_JA]);
		array_push($res, $langs[LANG_FR]);
	} else {
		array_push($res, $langs[LANG_JA]);
		array_push($res, $langs[LANG_EN]);
	}
	return $res;
}

function formatDate($d)
{
	return substr($d, 0, 4) . "/" . substr($d, 5, 2) . "/" . substr($d, 8, 2);
}

function getDayOfWeek($dayOfWeek)
{
	switch ($dayOfWeek) {
		case 0:
			return getTxt("sun");
		case 1:
			return getTxt("mon");
		case 2:
			return getTxt("tue");
		case 3:
			return getTxt("wed");
		case 4:
			return getTxt("thu");
		case 5:
			return getTxt("fri");
		case 6:
			return getTxt("sat");
	}
}

function getWeekDay($y, $m, $d)
{
	$dayOfWeek = date("w", mktime(0, 0, 0, intval($m), intval($d), intval($y)));
	return getDayOfWeek($dayOfWeek);
}

function getNowWithDayOfWeek()
{
	return _replace(date("Y/m/d" . getTxt("(") . "*" . getTxt(")") . "H:i"), "*", getDayOfWeek(date("w")));
}

function getSchoolYear()
{
	return intval(date("Y")) - ((intval(date("m")) <= 3) ? 1 : 0);
}

function getPhoneNumber($tel)
{
	return (getLang() == LANG_JA) ? $tel : "+81-" . substr($tel, 1);
}

function formatPrice($n, $includingTax = true)
{
	if (LANG == LANG_JA) {
		return "¥ " . number_format($n) . ($includingTax ? " (" . getTxt("includingTax") . ")" : "");
	} else {
		return "¥ " . number_format($n) . "<span class='jpy'>JPY</span>";
	}
}

function tax($price)
{
	return intval(floor($price + ($price * TAX / 100)));
}

function getFreeShippingPriceIncludingTax()
{
	return tax(FREE_SHIPPING_PRICE_WITHOUT_TAX);
}

function getShowa($year)
{
	return $year - 1925;
}
function getHeisei($year)
{
	return $year - 1989;
}
function getReiwa($year)
{
	$reiwa = $year - 2018;
	return ($reiwa == 1) ? "元" : $reiwa;
}

function getReiwaNendo()
{
	$reiwa = getSchoolYear() - 2018;
	return "令和" . (($reiwa == 1) ? "元" : $reiwa) . "年度";
	//	return "令和".(($reiwa == 1) ? "元" : numberToKanji($reiwa))."年度";
}

function numberToKanji($n)
{
	switch ($n) {
		case 0:
			return "";
		case 1:
			return "一";
		case 2:
			return "二";
		case 3:
			return "三";
		case 4:
			return "四";
		case 5:
			return "五";
		case 6:
			return "六";
		case 7:
			return "七";
		case 8:
			return "八";
		case 9:
			return "九";
		case 10:
			return "十";
	}
	$tens = ($n >= 20) ? numberToKanji(floor($n / 10)) : "";
	return $tens . numberToKanji(10) . numberToKanji($n % 10);
}

function getPrevDate($date)
{
	$separator = substr($date, 4, 1);

	$y = intval(substr($date, 0, 4));
	$m = intval(substr($date, 5, 2));
	$d = intval(substr($date, 8, 2));

	$d--;

	if ($d < 1) {
		$m--;
		if ($m < 1) {
			$m = 12;
			$y--;
		}
		$d = _getNumOfDays($y, $m);
	}

	return $y . $separator . _pre02($m) . $separator . _pre02($d);
}
function getNextDate($date)
{
	$separator = substr($date, 4, 1);

	$y = intval(substr($date, 0, 4));
	$m = intval(substr($date, 5, 2));
	$d = intval(substr($date, 8, 2));

	$d++;
	if ($d > _getNumOfMonthDays($y, $m)) {
		$d = 1;
		$m++;
		if ($m > 12) {
			$m = 1;
			$y++;
		}
	}

	return $y . $separator . _pre02($m) . $separator . _pre02($d);
}

function isShowroomWorkDay($year, $month, $day, $dayOff = null, $holidays = null)
{
	if ($dayOff == null || $holidays == null)
		require_once("update/day-off.php");

	if (array_key_exists($year, $dayOff) && array_key_exists($month, $dayOff[$year]) && in_array($day, $dayOff[$year][$month])) {
		return false;
	} else if (array_key_exists($year, $holidays) && array_key_exists($month, $holidays[$year]) && array_key_exists($day, $holidays[$year][$month])) {
		return false;
	} else if (date("w", mktime(0, 0, 0, $month, $day, $year)) == "0") {
		return false;
	} else {
		return true;
	}
}

function getShowroomWorkDates($numOfMonths)
{
	require_once("update/day-off.php");

	$year = intval(date("Y"));
	$month = intval(date("n"));
	$day = intval(date("j"));

	$toYear = $year;
	$toMonth = $month + $numOfMonths;
	$toDay = $day;

	if ($toMonth > 12) {
		$toMonth -= 12;
		$toYear++;
	}

	$numOfDays = _getNumOfMonthDays($toYear, $toMonth);
	if ($toDay > $numOfDays)
		$toDay = $numOfDays;

	$res = array();

	$numOfDays = _getNumOfMonthDays($year, $month);
	while (true) {
		$day++;
		if ($day > $numOfDays) {
			$day = 1;
			$month++;
			if ($month > 12) {
				$month = 1;
				$year++;
			}
			$numOfDays = _getNumOfMonthDays($year, $month);
		}

		if (isShowroomWorkDay($year, $month, $day, $dayOff, $holidays)) {
			$dayOfWeek = intval(date("w", mktime(0, 0, 0, $month, $day, $year)));

			array_push($res, array(
				"year" => $year,
				"month" => $month,
				"day" => $day,
				"dayOfWeek" => $dayOfWeek,
			));
		}

		if ($day == $toDay && $month == $toMonth && $year == $toYear)
			break;
	}

	return $res;
}

//////////////////////////////////////////////////////////////////////////////////////////

function getTexts()
{
	require_once("text/" . LANG_JA . ".php");
	$default = $texts;

	if (LANG != LANG_JA) {
		require_once("text/" . LANG . ".php");
		foreach ($texts as $k => $v) {
			$default[$k] = $v;
		}
	}

	return $default;
}

function getString(...$keys)
{
	global $texts;
	$text = "";
	foreach ($keys[0] as $key) {
		$text .= array_key_exists($key, $texts) ? $texts[$key] : $key;
	}
	return $text;
}
function getTxt(...$keys)
{
	return getString($keys);
}
function t(...$keys)
{
	echo getString($keys);
}

function getSpacedString(...$keys)
{
	global $texts;
	$text = "";
	foreach ($keys[0] as $key) {
		if (_isValidString($text))
			$text .= " ";
		$text .= array_key_exists($key, $texts) ? $texts[$key] : $key;
	}
	return $text;
}
function getSpacedTxt(...$keys)
{
	return getSpacedString($keys);
}
function ts(...$keys)
{
	echo getSpacedString($keys);
}

function getShortPref($key)
{
	$t = getTxt($key);
	if (LANG == LANG_JA)
		$t = mb_substr($t, 0, mb_strlen($t) - 1);
	return $t;
}

//////////////////////////////////////////////////////////////////////////////////////////

function getNcParam()
{
	return "nc=" . CLEAR_CACHE_VALUE;
}

function getUr1($url, $withNc = true, $ignoreLang = false)
{
	if (_startsWith($url, "https://") || _startsWith($url, "http://")) {
		return $url;
	} else {
		if ($url[0] == "/")
			$url = substr($url, 1);
		$lang = ($ignoreLang || LANG == LANG_JA || (_contains($url, ".") && !_endsWith($url, ".php"))) ? "" : strtolower(LANG) . "/";
		return HOME_URL . "$lang$url" . ($withNc ? "?" . getNcParam() : "");
	}
}
function url($url, $withNc = true)
{
	echo getUr1($url, $withNc);
}

function getFirstLangUrl($url, $withNc = true)
{
	if (_startsWith($url, "https://") || _startsWith($url, "http://")) {
		return $url;
	} else {
		$fromHome = _remove(getThisUrl(), HOME_URL);
		$dir = _toLast($fromHome, "/");
		if (LANG != LANG_JA)
			$dir = _after($dir, LANG);
		return getUr1("$dir$url", $withNc);
	}
}
function firstLangUrl($url, $withNc = true)
{
	echo getFirstLangUrl($url, $withNc);
}

function getHref($url, $queries = null)
{
	if (defined("URL_" . strtoupper($url)))
		$url = constant("URL_" . strtoupper($url));

	if (_isValid($queries) && sizeof($queries) != 0) {
		$kvs = array();
		foreach ($queries as $key => $value) {
			$kv = $key;
			if (_isValid($value))
				$kv .= "=$value";
			array_push($kvs, $kv);
		}
		$query = implode("&", $kvs);
		$url .= (_contains($url, "?") ? "&" : "?") . implode("&", $kvs);
	}

	return getUr1($url, false);
}
function href($url, $queries = null)
{
	echo getHref($url, $queries);
}


function include_grad_cta_button()
{
	include __DIR__ . '/../graduation/_cta_button.php';
}

function getImg($url)
{
	if (defined("IMG_" . strtoupper($url)))
		$url = constant("IMG_" . strtoupper($url));
	return getUr1(DIR_IMG . "/$url");
}
function img($url)
{
	echo getImg($url);
}

function getInstagramImg($file)
{
	return getImg(DIR_IMG_INSTAGRAM . "/$file");
}

function imageExists($file)
{
	if (defined("IMG_" . strtoupper($file)))
		$file = constant("IMG_" . strtoupper($file));
	return file_exists(ROOT_PATH . "/" . DIR_IMG . "/$file");
}

function getVideo($url)
{
	if (defined("VIDEO_" . strtoupper($url)))
		$url = constant("VIDEO_" . strtoupper($url));
	return getUr1(DIR_VIDEO . "/$url");
}

function videoExists($file)
{
	if (defined("VIDEO_" . strtoupper($file)))
		$file = constant("VIDEO_" . strtoupper($file));
	return file_exists(ROOT_PATH . "/" . DIR_VIDEO . "/$file");
}

function getFileUrl($file)
{
	if (defined("FILE_" . strtoupper($file)))
		$file = constant("FILE_" . strtoupper($file));
	return getUr1(DIR_FILE . "/$file");
}

function getIcon($name, $attr = "")
{
	$icon = constant("ICON_" . strtoupper($name));
	return _replace($icon, '$attr', $attr);
}
function icon($name, $attr = "")
{
	echo getIcon($name, $attr);
}

function getLogo($name)
{
	return constant("LOGO_" . strtoupper($name));
}
function logo($name)
{
	echo getLogo($name);
}

function getUpdateImgUrl($file)
{
	return HOME_URL . DIR_IMG . "/$file?" . getNcParam();
}
function echoUpdateImgUrl($file)
{
	echo getUpdateImgUrl($file);
}

function getProductUrl($pid, $link = null)
{
	if (_isValidString($link))
		$link = "&link=$link";
	if (IS_REAL_SERVICE_ENVIRONMENT) {
		return URL_COLOR_ME_NH . "?pid=$pid$link";
	} else {
		return URL_COLOR_ME_NH . "?tid=" . COLOR_ME_TEMPLATE_ID . "&tmpl_type=2&ph=" . COLOR_ME_TEMPLATE_HASH . "&pid=$pid$link";
	}
}

function getFeatureUrl($ymd, $link = null)
{
	if (_isValidString($link))
		$link = "?link=$link";
	//	return HOME_URL.URL_FEATURES."/$ymd$link";
	return getUr1(URL_FEATURES . "/$ymd$link", false);
}

function getCampaignUrl($ymd, $link = null)
{
	if (_isValidString($link))
		$link = "?link=$link";
	return HOME_URL . URL_CAMPAIGN . "/$ymd$link";
}

function getPageUrl($groupId, $link = null)
{
	if (_isValidString($link))
		$link = "?link=$link";
	return HOME_URL . URL_PAGE . "/$groupId$link";
}

function getCmsCategoryUrl($bigCategoryId, $smallCategoryId = 0)
{
	return URL_COLOR_ME_NH . "?mode=cate&cbid=$bigCategoryId&csid=$smallCategoryId";
}

function replaceToHttpsNhUrl($s)
{
	$s = _replace($s, "http://" . DOMAIN_NHCOM, "https://" . DOMAIN_NHCOM);
	$s = _replace($s, "http://" . HOST_NHCOM, "https://" . HOST_NHCOM);
	return $s;
}

function getBannerHtml($name, $attr = "", $queries = null)
{
	$upper = strtoupper($name);
	$text1 = constant("BANNER_" . $upper . "_TEXT_MAIN");
	$text2 = defined("BANNER_" . $upper . "_TEXT_SUB") ? constant("BANNER_" . $upper . "_TEXT_SUB") : null;
	$img = getImg(constant("BANNER_" . $upper . "_IMG"));

	$subSubText = "";
	if ($name == "name" && SHOW_NAME_ENGRAVING_CAMPAIGN && _isValidString(NAME_ENGRAVING_CAMPAIGN_TEXT)) {
		$subSubText = "（" . NAME_ENGRAVING_CAMPAIGN_TEXT . "）";
	}

	return "<a href='" . getHref($name, $queries) . "' $attr>" .
		//				"<div class='image' style='background-image:url(\"$img\");'></div>".
		"<div class='image' url='$img'></div>" .
		"<div class='text-container'>" .
		"<div class='text'>" .
		"<div class='main'>$text1</div>" .
		(_isValid($text2) ? "<div class='sub'>$text2$subSubText</div>" : "") .
		"</div>" .
		"</div>" .
		"</a>";
}
function getBanner($name, $attr = "", $queries = null)
{
	return "<div nh-banner>" . getBannerHtml($name, $attr, $queries) . "</div>";
}
function banner($name, $attr = "", $queries = null)
{
	echo getBanner($name, $attr, $queries);
}

function getBannersHtml(...$names)
{
	if (is_array($names[0]))
		$names = $names[0];
	$as = "";
	foreach ($names as $name) {
		$as .= "<div class='banner-container'>" . getBannerHtml($name) . "</div>";
	}
	return "<div nh-banners='" . sizeof($names) . "' nh-margin-banner='top'>$as</div>";
}
function banners(...$names)
{
	echo getBannersHtml($names);
}

function getBannersHtmlByArray(...$arrs)
{
	$html = "";
	foreach ($arrs as $arr) {
		$html .= "<div class='banner-container'>" . getBannerHtml($arr["key"], null, $arr["queries"]) . "</div>";
	}
	return "<div nh-banners='" . sizeof($arrs) . "' nh-margin-banner='top'>$html</div>";
}

function getFontFamilyStyle($font)
{
	return "@font-face {\n" .
		"\tfont-family: '$font';\n" .
		"\tsrc: url('" . getUr1("/font/$font.otf") . "');\n" .
		"}\n";
}

function echoFixedLine($class = null)
{
	$theClass = _isValid($class) ? "class='$class'" : "";
	echo "<style> footer .scroll-to-top { display:none; } </style>" .
		"<a $theClass nh='line' href='" . getHref("navi") . "'>" .
		"<div><img src='" . getImg("line.png") . "'></div>" .
		"<p>チャット問合せ<br>は こちら</p>" .
		"</a>";
}

//////////////////////////////////////////////////////////////////////////////////////////

function logCommon($dir)
{
	$log = array(
		"datetime" => date("Y-m-d H:i:s"),
		"server" => $_SERVER,
		"get" => $_GET,
		"post" => $_POST,
	);
	$path = ROOT_PATH . "/" . DIR_LOG . "/$dir/" . date("Y_m") . ".txt";
	return _append($path, json_encode($log, JSON_UNESCAPED_UNICODE));
}

//////////////////////////////////////////////////////////////////////////////////////////

function getAmazonUsaProductUrl($id)
{
	return _replace(URL_AMAZON_USA_PRODUCT, "{id}", $id);
}

//////////////////////////////////////////////////////////////////////////////////////////

function echoHead($params = null)
{
	global $texts;

	$title = $texts["nakatahanger"];
	$keywords = $texts["metaKeywordsCommon"];
	$desc = $texts["metaDescTop"];
	$css = FILE_NAME;
	$ogImage = getImg("sns");
	$thumbnail = null;

	if (_isValid($params)) {
		if (array_key_exists("title", $params) && _isValidString($params["title"])) {
			if (array_key_exists("titleNhPrefix", $params) && $params["titleNhPrefix"]) {
				$title = $texts["nakatahanger"] . " | " . $params["title"];
			} else {
				$title = $params["title"] . " | " . $texts["nakatahanger"];
			}
		}
		if (array_key_exists("keywords", $params) && _isValidString($params["keywords"]))
			$keywords .= "," . $params["keywords"];
		if (array_key_exists("desc", $params) && _isValidString($params["desc"]))
			$desc = $params["desc"];
		if (array_key_exists("css", $params) && _isValidString($params["css"]))
			$css = $params["css"];
		if (array_key_exists("ogImage", $params) && _isValidString($params["ogImage"]))
			$ogImage = $params["ogImage"];
		if (array_key_exists("thumbnail", $params) && _isValidString($params["thumbnail"]))
			$thumbnail = getImg($params["thumbnail"]);
	}

	require_once("head.php");
}

function includeCss($name)
{
	if (_startsWith($name, "/")) {
		$home = _endsWith(HOME_URL, "/") ? substr(HOME_URL, 0, strlen(HOME_URL) - 1) : HOME_URL;
		$url = $home . $name;
	} else {
		$url = $name;
	}
	echo "<link rel='stylesheet' type='text/css' href='$url.css?" . getNcParam() . "'>" .
		"<link rel='stylesheet' type='text/css' media='(max-width:" . MAX_SP_VIEW_WIDTH . "px)' href='$url-s.css?" . getNcParam() . "'>" .
		"<link rel='stylesheet' type='text/css' media='(min-width:" . MIN_PC_VIEW_WIDTH . "px)' href='$url-l.css?" . getNcParam() . "'>";
}

function echoHeader($script = true)
{
	if ($script)
		echo "<script> _.event.onLoad(function() { this.onLoad(" . MAX_SP_VIEW_WIDTH . "); }.bind(nh)); </script>";
	require_once("header.php");
}
function echoGradHeader($script = true)
{
	if ($script)
		echo "<script> _.event.onLoad(function() { this.onLoad(" . MAX_SP_VIEW_WIDTH . "); }.bind(nh)); </script>";
	require_once("grad-header.php");
}

function echoSubmenuFeatures($features)
{
	echo "<div class='features'>";
	foreach ($features as $feature) {
		echo "<div class='feature'>";
		echo "<div class='feature-container'>";
		echo "<a href='" . $feature["url"] . "'>";
		if (array_key_exists("image", $feature)) {
			$border = $feature["imageBorder"] ? "true" : "false";
			echo "<div class='image' border='$border'><img nh-gray-border='3' src='" . getUpdateImgUrl($feature["image"]) . "'></div>";
		}
		if (array_key_exists("text", $feature)) {
			echo "<div class='text'>" . $feature["text"] . "</div>";
		}
		echo "</a>";
		echo "</div>";
		echo "</div>";
	}
	echo "</div>";
}

function echoFooter()
{
	require_once("footer.php");
}

//////////////////////////////////////////////////////////////////////////////////////////

function getTopImageHtml($file)
{
	return "<div class='main-image' nh-image='1' header-view='bottom' style='background-image:url(\"" . getImg($file) . "\");'></div>";
}
function echoTopImage($file)
{
	echo getTopImageHtml($file);
}

//////////////////////////////////////////////////////////////////////////////////////////

function echoPageSubmenu($menu)
{
	$lis = "";
	foreach ($menu as $m) {
		$selected = $m["selected"] ? "selected" : "";
		$lis .= "<li nh-gray-border='2' $selected><a href='" . $m["url"] . "' nh-red-border>" . $m["label"] . "</a></li>";
	}
	echo "<div class='page-submenu' nh-margin='header'><ul>$lis</ul></div>";
}

//////////////////////////////////////////////////////////////////////////////////////////

function getEmailPerson($params)
{
	if (is_string($params)) {
		return trim($params);
	} else if (array_key_exists("name", $params)) {
		$name = $params["name"];
		$name = _replace($name, '"', '\"');
		$name = _replace($name, ":", "\:");
		$name = _replace($name, ",", "\,");
		$name = _replace($name, "[", "\[");
		$name = _replace($name, "<", "\<");
		return '"' . trim($name) . '"<' . trim($params["email"]) . ">";
	} else {
		return trim($params["email"]);
	}
}

// "\r\n" はダメで "\n" にする（http://q.hatena.ne.jp/1316786467）
function email($type, $params)
{
	mb_language("Japanese");
	mb_internal_encoding("UTF-8");

	$headers;
	$body;
	if (array_key_exists("files", $params) && sizeof($params["files"]) != 0) {
		$headers = "From: " . getEmailPerson($params["from"]) . "\n" .
			"Content-Type: multipart/mixed;boundary=\"__BOUNDARY__\"\n";

		// 本文
		$body = "--__BOUNDARY__\n" .
			"Content-Type: text/$type; charset=\"ISO-2022-JP\"\n\n" .
			$params["body"] . "\n" .
			"--__BOUNDARY__\n";

		// 添付ファイル
		foreach ($params["files"] as $file) {
			$body .= "Content-Type: application/octet-stream; name=\"" . $file["name"] . "\"\n" .
				"Content-Disposition: attachment; filename=\"" . $file["name"] . "\"\n" .
				"Content-Transfer-Encoding: base64\n\n" .
				chunk_split(base64_encode($file["data"])) .
				"--__BOUNDARY__\n";
		}
	} else {
		$headers = "From: " . getEmailPerson($params["from"]) . "\n" .
			"Content-type: text/$type; charset=ISO-2022-JP\n";
		$body = $params["body"];
	}

	return mb_send_mail(getEmailPerson($params["to"]), $params["subject"], $body, $headers);
}

function emailText($params)
{
	return email("plain", $params);
}

function emailHtml($params)
{
	return email("html", $params);
}

//////////////////////////////////////////////////////////////////////////////////////////

function getNewsConn()
{
	return _getMySqlConn(MYSQL_NEWS_HOST, MYSQL_NEWS_PORT, MYSQL_NEWS_USER, MYSQL_NEWS_PASS, MYSQL_NEWS_DB);
}

function getWpNewsTermIdDefinedName($category)
{
	$langPostfix = (LANG == LANG_JA) ? "" : "_" . strtoupper(LANG);
	return "WP_NEWS_TERM_ID_" . strtoupper($category) . $langPostfix;
}

function wpNewsCategoryExists($category)
{
	return defined(getWpNewsTermIdDefinedName($category));
}

function getWpNewsTermId($category)
{
	$name = getWpNewsTermIdDefinedName($category);
	return defined($name) ? constant($name) : null;
}

function getNewsSql($n, $params)
{
	$categories = array("news", "media", "journal");

	if (_isNull($params))
		$params = array();
	$conditions = array();
	$orderAscDesc = "DESC";
	$offset = 0;

	if (array_key_exists("id", $params)) {
		$id = $params["id"];
		if (is_int($id) || ctype_digit($id)) {
			array_push($conditions, "p.ID = $id");
		}
	}

	if (array_key_exists("year", $params)) {
		$year = intval($params["year"]);
		if ($year > 2000) {
			array_push($conditions, "'$year-01-01 00:00:00' <= p.post_date AND p.post_date < '" . ($year + 1) . "-01-01 00:00:00'");
		}
	}

	if (array_key_exists("page", $params)) {
		$page = intval($params["page"]);
		if ($page > 1) {
			$offset = ($page - 1) * $n;
		}
	}

	if (array_key_exists("postedAfter", $params)) {
		array_push($conditions, "p.post_date > '" . $params["postedAfter"] . "'");
		$orderAscDesc = "ASC";
	}
	if (array_key_exists("postedBefore", $params)) {
		array_push($conditions, "p.post_date < '" . $params["postedBefore"] . "'");
	}

	if (array_key_exists("category", $params)) {
		array_push($conditions, "t.term_id = " . getWpNewsTermId($params["category"]));
	} else {
		$categoryConditions = array();
		foreach ($categories as $category) {
			$termId = getWpNewsTermId($category);
			if (_isValid($termId))
				array_push($categoryConditions, "t.term_id = $termId");
		}
		array_push($conditions, "(" . implode(" OR ", $categoryConditions) . ")");
	}

	$condition = "";
	if (sizeof($conditions) != 0) {
		$condition = "AND " . implode(" AND ", $conditions);
	}

	return "SELECT DISTINCT p.ID, p.post_date, p.post_title, p.post_content FROM wp_terms AS t INNER JOIN wp_term_taxonomy AS tt ON tt.term_id = t.term_id INNER JOIN wp_term_relationships AS tr ON tr.term_taxonomy_id = tt.term_taxonomy_id INNER JOIN wp_posts AS p ON p.ID = tr.object_id WHERE tt.taxonomy = 'category' AND p.post_type = 'post' AND post_status = 'publish' $condition ORDER BY post_date $orderAscDesc LIMIT $offset, $n;";

	/*	if (array_key_exists("category", $params)) {
			if ($params["category"] == "media") {
				array_push($conditions, "t.term_id = ".WP_NEWS_TERM_ID_MEDIA);
			} else {
				array_push($conditions, "t.term_id != ".WP_NEWS_TERM_ID_MEDIA);
			}

			$condition = "";
			if (sizeof($conditions) != 0) {
				$condition = "AND ".implode(" AND ", $conditions);
			}

			return "SELECT DISTINCT p.ID, p.post_date, p.post_title, p.post_content FROM wp_terms AS t INNER JOIN wp_term_taxonomy AS tt ON tt.term_id = t.term_id INNER JOIN wp_term_relationships AS tr ON tr.term_taxonomy_id = tt.term_taxonomy_id INNER JOIN wp_posts AS p ON p.ID = tr.object_id WHERE tt.taxonomy = 'category' AND p.post_type = 'post' AND post_status = 'publish' $condition ORDER BY post_date $orderAscDesc LIMIT $offset, $n;";
		} else {
			$condition = "";
			if (sizeof($conditions) != 0) {
				$condition = "AND ".implode(" AND ", $conditions);
			}

			return "SELECT p.ID, p.post_date, p.post_title, p.post_content FROM wp_posts AS p WHERE p.post_type = 'post' AND p.post_status = 'publish' $condition ORDER BY p.post_date $orderAscDesc LIMIT $offset, $n";
		}*/
}

function _getNews($conn, $n, $params = null)
{
	$sql = getNewsSql($n, $params);

	$news = array();
	//	$res = _mySql($conn, "SELECT ID, post_date, post_title, post_content FROM wp_posts WHERE post_type = 'post' AND post_status = 'publish' ORDER BY post_date DESC LIMIT $n");
	$res = _mySql($conn, $sql);
	while ($r = mysqli_fetch_array($res)) {
		$image = null;
		$dom = new DOMDocument();
		@$dom->loadHTML("<?xml encoding='utf-8' ?>" . $r["post_content"]);
		$imgs = $dom->getElementsByTagName("img");
		foreach ($imgs as $img) {
			$image = replaceToHttpsNhUrl($img->getAttribute("src"));
			break;
		}

		$content = replaceToHttpsNhUrl($r["post_content"]);

		$text = strip_tags($content);
		$text = _replace($text, "&nbsp;", " ");
		$text = _replace($text, "\r", " ");
		$text = _replace($text, "\n", " ");
		$text = trim($text);

		$textPc = $text;
		$textSp = $text;

		if (mb_strlen($textPc) > NEWS_INTRO_NUM_OF_CHARS_PC)
			$textPc = mb_substr($textPc, 0, NEWS_INTRO_NUM_OF_CHARS_PC) . " ...";
		if (mb_strlen($textSp) > NEWS_INTRO_NUM_OF_CHARS_SP)
			$textSp = mb_substr($textSp, 0, NEWS_INTRO_NUM_OF_CHARS_SP) . " ...";

		array_push($news, array(
			"id" => $r["ID"],
			"postedAt" => $r["post_date"],
			"title" => $r["post_title"],
			"content" => $content,
			"textPc" => $textPc,
			"textSp" => $textSp,
			"image" => $image,
		));
	}

	return $news;
}

function getNews($n, $params = null)
{
	if (_isWindows()) {
		return null;
	} else {
		$conn = getNewsConn();
		return _getNews($conn, $n, $params);
	}
}

function getNewsDraft($newsId)
{
	$sql = "SELECT p.ID, p.post_date, p.post_title, p.post_content FROM wp_posts AS p WHERE p.post_type = 'post' AND p.post_status = 'draft' AND p.ID = $newsId";

	$conn = getNewsConn();
	$res = _mySql($conn, $sql);
	while ($r = mysqli_fetch_array($res)) {
		return array(
			"id" => $r["ID"],
			"postedAt" => $r["post_date"],
			"title" => $r["post_title"],
			"content" => $r["post_content"],
			"image" => null,
		);
	}
}

function getPreviewOfReleasedNews($newsId)
{
	$sql = "SELECT p.ID, p.post_date, p.post_title, p.post_content FROM wp_posts AS p WHERE p.ID = $newsId OR p.post_parent = $newsId ORDER BY post_modified DESC";

	$conn = getNewsConn();
	$res = _mySql($conn, $sql);
	while ($r = mysqli_fetch_array($res)) {
		return array(
			"id" => $r["ID"],
			"postedAt" => $r["post_date"],
			"title" => $r["post_title"],
			"content" => $r["post_content"],
			"image" => null,
		);
	}
}

function getNewsCount($conn, $params)
{
	$sql = getNewsSql(0, $params);
	$fromWhere = _from($sql, " FROM ");
	$fromWhere = _beforeLast($fromWhere, " ORDER BY ");

	$res = _mySql($conn, "SELECT COUNT(1) AS c $fromWhere");
	while ($r = mysqli_fetch_array($res)) {
		return intval($r["c"]);
	}
}

function getNewsAndCount($n, $params = null)
{
	$conn = getNewsConn();
	$news = _getNews($conn, $n, $params);
	$count = getNewsCount($conn, $params);
	return array("news" => $news, "count" => $count);
}

function getNewsUrl($newsId)
{
	return getHref("news") . "/$newsId";
}

function redirectFromOldNewsToNewNews()
{
	$url = _url();
	$paths = $url["paths"];
	$newsId = $paths[sizeof($paths) - 1];
	if (_isNullString($newsId))
		$newsId = $paths[sizeof($paths) - 2];
	$target = _isValid($newsId) ? getNewsUrl($newsId) : HOME_URL;
	header("Location: $target");
}

function getNewsHtml($news)
{
	$image;
	if (_isValidString($news["image"])) {
		$image = "<div class='image' nh-gray-border='2' style='background-image:url(\"" . $news["image"] . "\");'></div>";
	} else {
		$image = "<div class='image' nh-gray-border='2'>" . LOGO_NAKATA_HANGER . "</div>";
	}

	return "<a href='" . getNewsUrl($news["id"]) . "' nh-gray-bg-hover='1-l'>" .
		"<div class='date' nh-font='2'>" . formatDate($news["postedAt"]) . "</div>" .
		$image .
		"<div class='text'>" .
		"<div class='title'>" . $news["title"] . "</div>" .
		"<div class='content' device='pc'>" . $news["textPc"] . "</div>" .
		"<div class='content' device='sp'>" . $news["textSp"] . "</div>" .
		"</div>" .
		"</a>";
}

function getCategoryIds($newsId)
{
	$categoryIds = array();
	$conn = getNewsConn();
	$res = _mySql($conn, "SELECT tr.term_taxonomy_id FROM wp_term_relationships AS tr INNER JOIN wp_posts AS p ON p.ID = tr.object_id WHERE p.ID = $newsId ORDER BY tr.term_order;");
	while ($r = mysqli_fetch_array($res)) {
		array_push($categoryIds, intval($r["term_taxonomy_id"]));
	}
	return $categoryIds;
}

//////////////////////////////////////////////////////////////////////////////////////////

function getSdgsUrl($id)
{
	return getHref("sdgs") . "/$id";
}

function getSdgsPostSql($count, $params)
{
	global $_sdgsCategoryIds;

	$categories = array();
	if (array_key_exists("categories", $params)) {
		foreach ($params["categories"] as $category) {
			if (in_array($category, $_sdgsCategoryIds))
				array_push($categories, $category);
		}
	}
	if (sizeof($categories) == 0)
		$categories = $_sdgsCategoryIds;

	$offset = 0;
	if (array_key_exists("page", $params)) {
		$page = intval($params["page"]);
		if ($page > 0)
			$offset = ($page - 1) * $count;
	}

	return "SELECT DISTINCT p.ID, p.post_date, p.post_title, p.post_content FROM wp_terms AS t INNER JOIN wp_term_taxonomy AS tt ON tt.term_id = t.term_id INNER JOIN wp_term_relationships AS tr ON tr.term_taxonomy_id = tt.term_taxonomy_id INNER JOIN wp_posts AS p ON p.ID = tr.object_id WHERE tt.taxonomy = 'category' AND p.post_type = 'post' AND post_status = 'publish' AND t.term_id IN (" . implode(", ", $categories) . ") ORDER BY p.post_date DESC LIMIT $offset, $count;";
}

function rowToPost($row)
{
	$res = array();

	$image = null;
	$dom = new DOMDocument();
	@$dom->loadHTML("<?xml encoding='utf-8' ?>" . $row["post_content"]);
	$imgs = $dom->getElementsByTagName("img");
	foreach ($imgs as $img) {
		$image = replaceToHttpsNhUrl($img->getAttribute("src"));
		break;
	}

	$content = replaceToHttpsNhUrl($row["post_content"]);

	$text = strip_tags($content);
	$text = _replace($text, "&nbsp;", " ");
	$text = _replace($text, "\r", " ");
	$text = _replace($text, "\n", " ");
	$text = trim($text);

	$textPc = $text;
	$textSp = $text;

	if (mb_strlen($textPc) > SDGS_INTRO_NUM_OF_CHARS_PC)
		$textPc = mb_substr($textPc, 0, SDGS_INTRO_NUM_OF_CHARS_PC) . " ...";
	if (mb_strlen($textSp) > NEWS_INTRO_NUM_OF_CHARS_SP)
		$textSp = mb_substr($textSp, 0, NEWS_INTRO_NUM_OF_CHARS_SP) . " ...";

	return array(
		"id" => intval($row["ID"]),
		"postedAt" => $row["post_date"],
		"title" => $row["post_title"],
		"content" => $content,
		"texts" => array("pc" => $textPc, "sp" => $textSp),
		"image" => $image,
	);
}

function getSdgsPosts($conn, $count, $params)
{
	$res = array();
	$sql = getSdgsPostSql($count, $params);
	$rows = _mySql($conn, $sql);
	while ($row = mysqli_fetch_array($rows)) {
		$post = rowToPost($row);
		array_push($res, $post);
	}
	return $res;
}

function getSdgsPostCount($conn, $params)
{
	$sql = getSdgsPostSql(0, $params);
	$sql = _from($sql, " FROM ");
	$sql = _beforeLast($sql, " ORDER BY ");
	$sql = "SELECT COUNT(DISTINCT(p.ID)) AS c $sql";
	$rows = _mySql($conn, $sql);
	while ($row = mysqli_fetch_array($rows)) {
		return intval($row["c"]);
	}
}

function getSdgsExistingCategories($conn)
{
	global $_sdgsCategoryIds;

	$sql = "SELECT t.term_id, t.name FROM `wp_terms` AS t INNER JOIN `wp_term_taxonomy` AS tt ON tt.term_id = t.term_id WHERE t.term_id IN (" . implode(", ", $_sdgsCategoryIds) . ") AND tt.count != 0";

	$termIdToName = array();
	$rows = _mySql($conn, $sql);
	while ($row = mysqli_fetch_array($rows)) {
		$termIdToName[$row["term_id"]] = $row["name"];
	}

	$res = array();
	foreach ($_sdgsCategoryIds as $id) {
		if (array_key_exists($id, $termIdToName))
			array_push($res, array("id" => $id, "name" => $termIdToName[$id]));
	}
	return $res;
}

function getSdgsPostsAndCount($count, $params = null)
{
	$conn = getNewsConn();
	$posts = getSdgsPosts($conn, $count, $params);
	$total = getSdgsPostCount($conn, $params);
	$categories = getSdgsExistingCategories($conn);
	return array("posts" => $posts, "count" => $total, "categories" => $categories);
}

//////////////////////////////////////////////////////////////////////////////////////////

function showNotFound()
{
	require_once(DOTS_TO_ROOT . "error/404.php");
	exit(0);
}

//////////////////////////////////////////////////////////////////////////////////////////

function getCmsProducts()
{
	$now = time();
	$products = _catJson(DOTS_TO_ROOT . FILE_CMS_PRODUCTS);
	foreach ($products as $productId => $product) {
		if (array_key_exists("sale_start_date", $product) && $product["sale_start_date"] > $now) {
			unset($products[$productId]);
		}
	}
	return $products;
}

//////////////////////////////////////////////////////////////////////////////////////////
/*
function _getGetParams($params) {
	$arr = array();
	foreach ($params as $key => $value) {
		array_push($arr, "$key=".urlencode($value));
	}
	return implode("&", $arr);
}

function _requestGet($context, $url, $params) {
	if (_isValid($params)) $url .= "?"._getGetParams($params);
	return file_get_contents($url, false, $context);
}
*/
//////////////////////////////////////////////////////////////////////////////////////////
/*
function _getCmsApiContext() {
	$options = array(
		"http"=>array(
			"method"=>"GET",
			"header"=>"Authorization: Bearer ".CMS_API_ACCESS_TOKEN."\r\n",
		),
	);
	return stream_context_create($options);
}

function _requestCmsProducts($context, $params, $offset=0) {
	if (_isNull($params)) $params = array();
	
	$params["offset"] = 0;
	$params["limit"] = CMS_API_LIMIT_GET_PRODUCTS;
	$params["display_state"] = "showing";
	
	$res = _requestGet($context, CMS_API_URL.CMS_API_URL_GET_PRODUCTS, $params);
	return json_decode($res, true);
}
*/

function getGetRequestContext()
{
	$options = array(
		"http" => array(
			"method" => "GET",
			"header" => USER_AGENT_IMITATION,
		),
	);
	return stream_context_create($options);
}

function getCmsContext()
{
	$options = array(
		"http" => array(
			"method" => "GET",
			"header" => "Authorization: Bearer " . CMS_API_ACCESS_TOKEN . "\r\n",
		),
	);
	return stream_context_create($options);
}

function curlCmsCategories()
{
	if (_isWindows()) {
		$res = file_get_contents(CMS_API_URL . CMS_API_URL_GET_CATEGORIES, false, getCmsContext());
	} else {
		$res = _curl(CMS_API_URL . CMS_API_URL_GET_CATEGORIES, null, "Authorization: Bearer " . CMS_API_ACCESS_TOKEN);
	}
	return json_decode($res, true);
}

/*
$options = array(
	"http"=>array(
		"method"=>"GET",
		"header"=>USER_AGENT_IMITATION,
	),
);
$context = stream_context_create($options);
$res = file_get_contents("http://www.nakatahanger-shop.com/?mode=cate&csid=0&cbid=1689147", false, $context);

$res = mb_convert_encoding(mb_convert_encoding($res, "sjis", "eucJP"), "UTF-8", "sjis-win");
*/

/*
function getCmsBigCategoryFreeSpaces($categoryId) {
	$context = getGetRequestContext();
	$res = file_get_contents(getCmsCategoryUrl($categoryId), false, $context);
	$html = mb_convert_encoding(mb_convert_encoding($res, "sjis", "eucJP"), "UTF-8", "sjis-win");
	d($html);
}

function getCmsBigCategory($categoryId, $includingFreeSpaces=true) {
	$categories = curlCmsCategories();
	foreach ($categories["categories"] as $category) {
		if ($category["id_big"] == $categoryId) {
			if ($includingFreeSpaces) {
				$spaces = getCmsBigCategoryFreeSpaces($categoryId);
				d($spaces);
			}
			return $category;
		}
	}
}
*/

function curlCmsProducts($params = null, $offset = 0)
{
	if (_isNull($params))
		$params = array();

	$params["offset"] = $offset;
	$params["limit"] = CMS_API_LIMIT_GET_PRODUCTS;

	if (array_key_exists("display_state", $params)) {
		if ($params["display_state"] === false) {
			unset($params["display_state"]);
		}
	} else if (!array_key_exists("display_state", $params)) {
		$params["display_state"] = "showing";
	}

	if (_isWindows()) {
		$url = CMS_API_URL . CMS_API_URL_GET_PRODUCTS . "?" . _getGetParams($params);
		$res = file_get_contents($url, false, getCmsContext());
	} else {
		$res = _curl(CMS_API_URL . CMS_API_URL_GET_PRODUCTS, $params, "Authorization: Bearer " . CMS_API_ACCESS_TOKEN);
	}
	return json_decode($res, true);
}

function _getCmsProducts($params = null, $sortByCategory = false)
{
	//	$context = _getCmsApiContext();
//	$res = _requestCmsProducts($context, $params);
	$res = curlCmsProducts($params);

	$products = $res["products"];
	$total = $res["meta"]["total"];
	$limit = $res["meta"]["limit"];

	if ($total > $limit) {
		$reqCount = intval($total / $limit);
		if ($total % $limit != 0)
			$reqCount++;

		$offset = 0;
		for ($i = 1; $i < $reqCount; $i++) {
			$offset += CMS_API_LIMIT_GET_PRODUCTS;
			//			$res = _requestCmsProducts($context, $offset);
			$res = curlCmsProducts($params, $offset);
			$products = array_merge($products, $res["products"]);
		}
	}

	$now = time();
	$validProducts = array();
	foreach ($products as $product) {
		if (_isNull($product["sale_end_date"]) || $product["sale_end_date"] > $now) {
			array_push($validProducts, $product);
		}
	}

	if ((_isValid($params) && array_key_exists("group_ids", $params)) || $sortByCategory) {
		$sortedProducts = sortCmsProductsByCategory($validProducts);
	} else {
		$sortedProducts = sortCmsProducts($validProducts);
	}

	return setCmsCustomData($sortedProducts);
}

function getCmsProduct($pid)
{
	return _getCmsProducts(array("ids" => $pid));
}
function getCmsProductMapById($pids)
{
	$res = array();
	$products = getCmsProduct(implode(",", $pids));
	foreach ($products as $p) {
		$res[$p["id"]] = $p;
	}
	return $res;
}

function getCmsProductMap()
{
	$res = array();
	$products = _getCmsProducts();
	foreach ($products as $p) {
		$res[$p["id"]] = $p;
	}
	return $res;
}

function getCmsCategoryProductsIncludingNotOpenIfOffice($bigCategoryId)
{
	$params = array("category_id_big" => $bigCategoryId);
	if ((isNkkIp() || isLocalHost()) && array_key_exists("list", $_GET) && $_GET["list"] == "all") {
		$params["display_state"] = false;
	}
	return _getCmsProducts($params, true);
}

function sortCmsProducts($products)
{
	$orderToNameToProduct = array();
	foreach ($products as $p) {
		$n = $p["sort"];

		if (!array_key_exists($n, $orderToNameToProduct))
			$orderToNameToProduct[$n] = array();
		$orderToNameToProduct[$n][$p["name"]] = $p;
	}

	ksort($orderToNameToProduct);

	$res = array();
	foreach ($orderToNameToProduct as $n => $nameToProduct) {
		ksort($nameToProduct);
		$res = array_merge($res, array_values($nameToProduct));
	}

	return $res;
}

function sortCmsProductsByCategory($products)
{
	global $topProductIdsInCategoryList;

	$categoryIdsInOrder = array();
	$categories = curlCmsCategories();
	foreach ($categories["categories"] as $big) {
		array_push($categoryIdsInOrder, $big["id_big"] . " 0");

		$sortToChildCategoryIds = array();
		foreach ($big["children"] as $small) {
			$sort = _isValid($small["sort"]) ? $small["sort"] : 0;
			if (!array_key_exists($sort, $sortToChildCategoryIds))
				$sortToChildCategoryIds[$sort] = array();
			array_push($sortToChildCategoryIds[$sort], $small["id_small"]);
		}

		ksort($sortToChildCategoryIds);

		foreach ($sortToChildCategoryIds as $sort => $childIds) {
			foreach ($childIds as $childId) {
				array_push($categoryIdsInOrder, $big["id_big"] . " $childId");
			}
		}
	}

	$res = array();
	$categoryIdToProducts = array();
	$sortedProducts = sortCmsProducts($products);
	foreach ($sortedProducts as $p) {
		if (in_array($p["id"], $topProductIdsInCategoryList)) {
			array_push($res, $p);
		} else {
			$cid = $p["category"]["id_big"] . " " . $p["category"]["id_small"];
			if (!array_key_exists($cid, $categoryIdToProducts))
				$categoryIdToProducts[$cid] = array();
			array_push($categoryIdToProducts[$cid], $p);
		}
	}

	foreach ($categoryIdsInOrder as $cid) {
		if (array_key_exists($cid, $categoryIdToProducts))
			$res = array_merge($res, $categoryIdToProducts[$cid]);
	}

	return $res;
}

function getSorts($products)
{
	$lineupOrder = array();
	$priceToProductList = array();

	foreach ($products as $p) {
		array_push($lineupOrder, $p["id"]);

		if (!array_key_exists($p["sales_price"], $priceToProductList))
			$priceToProductList[$p["sales_price"]] = array();
		array_push($priceToProductList[$p["sales_price"]], $p["id"]);
	}

	$ascPriceOrder = array();
	$descPriceOrder = array();

	ksort($priceToProductList);
	foreach ($priceToProductList as $productList) {
		$ascPriceOrder = array_merge($ascPriceOrder, $productList);
	}

	krsort($priceToProductList);
	foreach ($priceToProductList as $productList) {
		$descPriceOrder = array_merge($descPriceOrder, $productList);
	}

	return array("lineupOrder" => $lineupOrder, "ascPriceOrder" => $ascPriceOrder, "descPriceOrder" => $descPriceOrder);
}

function setCmsCustomData($products)
{
	for ($i = 0, $len = sizeof($products); $i < $len; $i++) {
		$products[$i]["custom"] = getCmsCustomData($products[$i]);
	}
	return $products;
}
function getCmsCustomData($p)
{
	global $colorNameToId;

	$cmsName = _replace($p["name"], "／", "/");
	$arr = explode("/", $cmsName);

	$name = trim($arr[0]);
	$category = null;
	$size = null;
	$sizeNum = null;
	$notice = null;

	$color = (sizeof($arr) >= 3) ? $arr[2] : null;
	if (_isNull($color) && sizeof($arr) > 1 && array_key_exists($arr[1], $colorNameToId)) {
		$color = $arr[1];
	}
	$colorId = (_isValid($color) && array_key_exists($color, $colorNameToId)) ? $colorNameToId[$color] : null;

	$name = _replace($name, "［", "[");
	$name = _replace($name, "］", "]");

	if (_contains($name, "[") && _contains($name, "]")) {
		$notice = trim(_between($name, "[", "]"));
		$name = trim(_after($name, "]"));
	}

	if (sizeof($arr) >= 3 || (sizeof($arr) == 2 && _contains($name, "-"))) {
		$category = $arr[1];
	}

	$name = _replace($name, "：", ":");
	if (_contains($name, ":")) {
		$size = _after($name, ":");
		$name = _before($name, ":");

		$size = _replace($size, "ｗ", "w");
		if (_startsWith($size, "w")) {
			$sizeNum = intval(_remove($size, "w"));
		}
	}

	//	$price = floor($p["sales_price"] + ($p["sales_price"] * TAX / 100));
	$price = tax($p["sales_price"]);
	$regularPrice = _isValid($p["price"]) ? tax($p["price"]) : $price;

	return array("name" => $name, "size" => $size, "sizeNum" => $sizeNum, "category" => $category, "color" => $color, "colorId" => $colorId, "notice" => $notice, "price" => $price, "regularPrice" => $regularPrice);
}

function getSearchWords($word, $lower = true)
{
	$res = array();
	$word = trim($word);
	if ($lower)
		$word = strtolower($word);
	$word = _replace($word, "　", " ");
	$words = explode(" ", $word);
	foreach ($words as $w) {
		if (_isValidString($w))
			array_push($res, $w);
	}
	return $res;
}

function filterProducts($products, $words)
{
	$res = array();
	foreach ($products as $p) {
		$name = _replace($p["name"], "／", "/");
		$name = strtolower($name);
		$names = explode("/", $name);

		$containsWords = true;
		foreach ($words as $w) {
			$containsWord = false;
			foreach ($names as $n) {
				if (_contains($n, $w)) {
					$containsWord = true;
					break;
				}
			}
			if (!$containsWord) {
				$containsWords = false;
				break;
			}
		}

		if ($containsWords)
			array_push($res, $p);
	}
	return $res;
}

function searchProducts($word)
{
	global $notSearchedProductIds;

	$words = getSearchWords($word);
	$products = _getCmsProducts(null, true);

	for ($i = sizeof($products) - 1; $i >= 0; $i--) {
		if (in_array($products[$i]["id"], $notSearchedProductIds)) {
			array_splice($products, $i, 1);
		}
	}

	return filterProducts($products, $words);
}

function getProductSorts($products)
{
	$lineupOrder = array();
	$priceToProductList = array();

	foreach ($products as $p) {
		array_push($lineupOrder, $p["id"]);

		if (!array_key_exists($p["sales_price"], $priceToProductList))
			$priceToProductList[$p["sales_price"]] = array();
		array_push($priceToProductList[$p["sales_price"]], $p["id"]);
	}

	$ascPriceOrder = array();
	$descPriceOrder = array();

	ksort($priceToProductList);
	foreach ($priceToProductList as $productList) {
		$ascPriceOrder = array_merge($ascPriceOrder, $productList);
	}

	krsort($priceToProductList);
	foreach ($priceToProductList as $productList) {
		$descPriceOrder = array_merge($descPriceOrder, $productList);
	}

	return array("lineupOrder" => $lineupOrder, "ascPriceOrder" => $ascPriceOrder, "descPriceOrder" => $descPriceOrder);
}

//////////////////////////////////////////////////////////////////////////////////////////

function getCmsProductsByGroup($groupId)
{
	$res = array();
	$products = _getCmsProducts(null, true);
	foreach ($products as $product) {
		if (in_array($groupId, $product["group_ids"])) {
			array_push($res, $product);
		}
	}
	return $res;
}

function getCmsGroup($groupId)
{
	if (_isWindows()) {
		$url = CMS_API_URL . CMS_API_URL_GET_GROUPS;
		$res = file_get_contents($url, false, getCmsContext());
	} else {
		$res = _curl(CMS_API_URL . CMS_API_URL_GET_GROUPS, null, "Authorization: Bearer " . CMS_API_ACCESS_TOKEN);
	}
	$groups = json_decode($res, true);

	foreach ($groups["groups"] as $group) {
		if ($group["id"] == $groupId)
			return $group;
	}
	return null;
}

//////////////////////////////////////////////////////////////////////////////////////////

function getProductListHtml($pids)
{
	$idToProduct = getCmsProductMapById($pids);
	$products = array();
	foreach ($pids as $pid) {
		array_push($products, $idToProduct[$pid]);
	}
	return getProductsHtml($products);
}

function echoProductListHtml($pids)
{
	echo getProductListHtml($pids);
}

//////////////////////////////////////////////////////////////////////////////////////////

function getShopifyApiUrl($url = null, $params = null)
{
	$res = "https://" . SHOPIFY_API_KEY . ":" . SHOPIFY_API_PASS . "@" . SHOPIFY_ORIGINAL_DOMAIN . "/admin/api/" . SHOPIFY_API_VER;
	if (_isValidString($url))
		$res .= "/$url";
	if (_isValid($params)) {
		$query = "";
		foreach ($params as $k => $v) {
			if (_isValidString($query))
				$query .= "&";
			$query .= "$k=$v";
		}
		if (_isValidString($query))
			$res .= "?$query";
	}
	return $res;
}

/////////////////////////////////////////////

function getShopifyPolicies()
{
	$res = _curlGet(getShopifyApiUrl("policies.json"));
	if ($res["ok"]) {
		$data = json_decode($res["data"], true);
		$res = array();
		foreach ($data["policies"] as $policy) {
			$res[$policy["handle"]] = $policy;
		}
	}
	return $res;
}

function getShopifyShippingZones()
{
	$res = _curlGet(getShopifyApiUrl("shipping_zones.json"));
	if ($res["ok"])
		$res = json_decode($res["data"], true)["shipping_zones"];
	return $res;
}

/////////////////////////////////////////////

function getShopifyProductApiUrl($params)
{
	return getShopifyApiUrl("products.json", $params);
}

function getShopifyProducts($params)
{
	$params["limit"] = 250;
	$url = getShopifyProductApiUrl($params);
	$res = _curlGet($url);
	if ($res["ok"])
		$res["products"] = json_decode($res["data"], true)["products"];
	return $res;
}

function getShopifyPublishedProducts()
{
	return getShopifyProducts(array("published_status" => "published"));
}

/////////////////////////////////////////////

function getShopifyDefaultVariant($product)
{
	$res = $product["variants"][0];

	$numOfVariants = sizeof($product["variants"]);
	if ($numOfVariants != 1) {
		$widthOptionNumber = null;
		for ($i = 0, $size = sizeof($product["options"]); $i < $size; $i++) {
			if (trim(strtolower($product["options"][$i]["name"])) == "width") {
				$widthOptionNumber = $i + 1;
				break;
			}
		}
		if (_isValid($widthOptionNumber)) {
			/*			$defaultWidth = null;
						$title = strtolower($product["title"]);
						if (_contains($title, "women")) {
							$defaultWidth = HANGER_WIDTH_DEFAULT_WOMEN."";
						} else if (_contains($title, "men")) {
							$defaultWidth = HANGER_WIDTH_DEFAULT_MEN."";
						}

						if (_isValid($defaultWidth)) {
							for ($i = 0; $i < $numOfVariants; $i++) {
								$variant = $product["variants"][$i];
								if ($variant["option".$widthOptionNumber] == $defaultWidth) {
									$res = $product["variants"][$i];
									break;
								}
							}
						}*/
			$defaultWidths = array();
			$title = strtolower($product["title"]);
			if (_contains($title, "women")) {
				array_push($defaultWidths, HANGER_WIDTH_DEFAULT_WOMEN);
			} else if (_contains($title, "men")) {
				array_push($defaultWidths, HANGER_WIDTH_DEFAULT_MEN);
				array_push($defaultWidths, HANGER_WIDTH_DEFAULT_MEN_2);
			}

			if (sizeof($defaultWidths) != 0) {
				for ($i = 0; $i < $numOfVariants; $i++) {
					$variant = $product["variants"][$i];
					if (in_array($variant["option" . $widthOptionNumber], $defaultWidths)) {
						$res = $product["variants"][$i];
						break;
					}
				}
			}
		}
	}

	return $res;
}

function getShopifyProductUrl($product, $variant = null, $lang = null)
{
	if (_isNull($variant))
		$variant = getShopifyDefaultVariant($product);
	if (_isValid($lang)) {
		if (!_startsWith($lang, "/"))
			$lang = "/" . $lang;
	} else {
		$lang = (LANG == LANG_EN) ? "/en" : "";
	}
	return SHOPIFY_HOST . "$lang/products/" . $product["handle"] . (sizeof($product["variants"]) == 1 ? "" : "?variant=" . $variant["id"]);
}

function isInCategory($urlCategory, $titleName, $titleCategory, $notice, $outlet)
{
	if ($outlet)
		return in_array("outlet", $urlCategory);

	$titleName = strtolower($titleName);
	$titleCategory = strtolower($titleCategory);

	$satisfiesForWhom = false;
	if ($urlCategory[0] == "others") {
		$satisfiesForWhom = true;
	} else if ($urlCategory[0] == "women") {
		if (!_contains($titleCategory, "kid")) {
			if (_contains($titleCategory, "women")) {
				$satisfiesForWhom = true;
			} else if (_contains($titleCategory, "trouser") || _contains($titleName, "belt") || _contains($titleName, "stole") || _contains($titleName, "scarf")) {
				$satisfiesForWhom = true;
			} else if (!_contains($titleCategory, "men")) {
				if (_contains($titleCategory, "suit hanger") || _contains($titleCategory, "jacket hanger") || _contains($titleCategory, "shirt hanger")) {
					$satisfiesForWhom = true;
				}
			}
		}
	} else if ($urlCategory[0] == "men") {
		if (!_contains($titleCategory, "kid")) {
			if (_contains($titleCategory, "men") && !_contains($titleCategory, "women")) {
				$satisfiesForWhom = true;
			} else if (_contains($titleCategory, "trouser") || _contains($titleName, "belt") || _contains($titleName, "tie")) {
				$satisfiesForWhom = true;
			} else if (_contains($titleCategory, "wajima") || _contains($titleCategory, "fuji")) {
				$satisfiesForWhom = true;
			} else if (!_contains($titleCategory, "women")) {
				if (_contains($titleCategory, "suit hanger") || _contains($titleCategory, "jacket hanger") || _contains($titleCategory, "shirt hanger")) {
					$satisfiesForWhom = true;
				}
			}
		}
	} else if ($urlCategory[0] == "gift") {
		if (_contains($titleName, "gft-") || strtolower($notice) == "gift") {
			$satisfiesForWhom = true;
		}
	} else if (sizeof($urlCategory) >= 2 && $urlCategory[1] == "bottom") {
		$satisfiesForWhom = true;
	} else if (sizeof($urlCategory) >= 2 && _contains($urlCategory[1], "belt")) {
		$satisfiesForWhom = true;
	}

	if ($satisfiesForWhom) {
		if (sizeof($urlCategory) == 1) {
			return true;
		} else {
			if ($urlCategory[1] == "jacket") {
				if (_contains($titleCategory, "jacket") || _contains($titleCategory, "suit") || _contains($titleCategory, "wajima") || _contains($titleCategory, "fuji")) {
					return true;
				}
			} else if ($urlCategory[1] == "shirt") {
				if (_contains($titleCategory, "shirt")) {
					return true;
				}
			} else if ($urlCategory[1] == "bottom") {
				if (_contains($titleCategory, "trouser")) {
					return true;
				}
			} else if (_contains($urlCategory[1], "necktie")) {
				if (_contains($titleName, "tie") || _contains($titleName, "belt")) {
					return true;
				}
			} else if (_contains($urlCategory[1], "stole")) {
				if (_contains($titleName, "stole") || _contains($titleName, "scarf") || _contains($titleName, "belt")) {
					return true;
				}
			} else if ($urlCategory[1] == "brush-shoehorn") {
				if (_contains($titleName, "brush") || _contains($titleCategory, "brush") || (_contains($titleName, "shoe") && _contains($titleName, "horn"))) {
					return true;
				}
			} else if ($urlCategory[1] == "rack-stand") {
				if (_contains($titleCategory, "valet") || _contains($titleCategory, "rack")) {
					return true;
				}
			} else if ($urlCategory[1] == "kimono") {
				if (_contains($titleCategory, "kimono")) {
					return true;
				}
			} else if ($urlCategory[1] == "kids") {
				if (_contains($titleCategory, "kid")) {
					return true;
				}
			} else if ($urlCategory[1] == "pet") {
				if (_contains($titleName, "pet")) {
					return true;
				}
			}
		}
	}

	return false;
}

function getReviews() {
	$idToSummary = array();
	$dirs = scandir(__DIR__."/review/en");
	foreach ($dirs as $dir) {
		if (!_startsWith($dir, ".")) {
			$arr = explode(" ", $dir);
			$idToSummary[$arr[0]] = $arr[1];
		}
	}
	return $idToSummary;
}

function getShopifyCategoryProducts($urlCategory, $colorNameToId, $colorVariations)
{
	$idToProduct = array();
	$pidWithWidthOptions = array();

	$products = getShopifyPublishedProducts();
	
	$idToReview = getReviews();

	foreach ($colorNameToId as $name => $id) {
		$colorNameToId[strtolower($name)] = $id;
	}

	foreach ($products["products"] as $p) {
		$notice = null;
		$outlet = false;

		$title = trim($p["title"]);

		if (_startsWith($title, "[") && _contains($title, "]")) {
			$notice = trim(_between($title, "[", "]"));
			$title = trim(_after($title, "]"));
			if (strtolower($notice) == "outlet")
				$outlet = true;
		}

		$titles = explode("/", $title);
		$titleSize = sizeof($titles);
		for ($i = 0, $size = $titleSize; $i < $size; $i++) {
			$titles[$i] = trim($titles[$i]);
		}

		$titleName = $titles[0];
		$titleCategory = null;
		$colorId = null;
		$color = null;

		if ($titleSize >= 2) {
			$titleLast = $titles[$titleSize - 1];
			$lowerTitleLast = strtolower($titleLast);
			if (array_key_exists($lowerTitleLast, $colorNameToId)) {
				$colorId = $colorNameToId[$lowerTitleLast];
				$color = $titleLast;
			}

			if ($titleSize == 2) {
				if (_isNull($colorId))
					$titleCategory = $titleLast;
			} else {
				$titleCategory = $titles[1];
			}
		}

		if (_isNull($urlCategory) || isInCategory($urlCategory, $titleName, $titleCategory, $notice, $outlet)) {
			$variant = getShopifyDefaultVariant($p);

			$hasWidthOption = false;
			foreach ($p["options"] as $option) {
				if (strtolower(trim($option["name"])) == "width") {
					$hasWidthOption = true;
					break;
				}
			}

			$p["group_ids"] = array();
			$p["url"] = getShopifyProductUrl($p, $variant);
			$p["image_url"] = $p["images"][0]["src"];
			$p["isSizeSelectable"] = $hasWidthOption;
			$p["expl"] = _replace($p["body_html"], "<br>", "\n");
			$p["custom"] = array(
				"name" => $titleName,
				"category" => $titleCategory,
				//				"size"=>null,
				"price" => $variant["price"],
				"colorId" => $colorId,
				"color" => $color,
				"regularPrice" => $variant["compare_at_price"],
				"notice" => $notice,
				"review"=>array_key_exists($p["id"], $idToReview) ? $idToReview[$p["id"]] : null,
			);

			$idToProduct[$p["id"]] = $p;

			if ($hasWidthOption)
				array_push($pidWithWidthOptions, $p["id"]);
		}
	}

	foreach ($colorVariations as $variations) {
		$ids = array_keys($variations);
		if (array_key_exists($ids[0], $idToProduct)) {
			$size = sizeof($ids);
			if ($size > 1) {
				$colors = array();
				for ($i = 0; $i < $size; $i++) {
					$id = $ids[$i];
					if (array_key_exists($id, $idToProduct)) {
						array_push($colors, $idToProduct[$id]);
						if ($i != 0)
							unset($idToProduct[$id]);
					}
				}
				$idToProduct[$ids[0]]["colors"] = $colors;
			}
		}
	}

	$categories = array(
		"jacket" => array(),
		"shirt" => array(),
		"trouser" => array(),
		"others" => array(),
	);
	$series = array(
		"wajima" => $categories,
		"fuji" => $categories,
		"nh" => $categories,
		"aut" => $categories,
		"set" => $categories,
		"tie" => $categories,
		"scarf" => $categories,
		"belt" => $categories,
		"others" => $categories,
	);
	foreach ($idToProduct as $id => $p) {
		//		d($p["custom"]["name"]);
//		d($p["custom"]["category"]);
//		d();

		$name = strtolower($p["custom"]["name"]);
		$category = strtolower($p["custom"]["category"]);

		$theSeries = "others";
		if (_contains($category, "wajima")) {
			$theSeries = "wajima";
		} else if (_contains($category, "fuji")) {
			$theSeries = "fuji";
		} else if (_startsWith($name, "nh-")) {
			$theSeries = "nh";
		} else if (_startsWith($name, "aut-")) {
			$theSeries = "aut";
		} else if (_startsWith($name, "set-")) {
			$theSeries = "set";
		} else if (_contains($name, "tie")) {
			$theSeries = "tie";
		} else if (_contains($name, "stole")) {
			$theSeries = "scarf";
		} else if (_contains($name, "belt")) {
			$theSeries = "belt";
		}

		$theCategory = "others";
		if (_contains($category, "jacket") || _contains($category, "suit")) {
			$theCategory = "jacket";
		} else if (_contains($category, "shirt")) {
			$theCategory = "shirt";
		}

		array_push($series[$theSeries][$theCategory], $p);
	}

	$res = array();
	foreach ($series as $seriesKey => $categories) {
		foreach ($categories as $categoryKey => $products) {
			$res = array_merge($res, $products);
		}
	}

	return array("products" => $res, "sizeSelectables" => $pidWithWidthOptions);
}

function getShopifyArrangedProducts()
{
	global $enColorNameToId, $enColorVariations;
	return getShopifyCategoryProducts(null, $enColorNameToId, $enColorVariations);
}

function getShopifyProductMapById()
{
	$res = array();
	$products = getShopifyArrangedProducts();
	foreach ($products["products"] as $p) {
		$p["custom"]["notice"] = null;
		$p["custom"]["size"] = null;
		if (_isNull($p["custom"]["regularPrice"])) {
			$p["custom"]["regularPrice"] = $p["custom"]["price"];
		}
		$res[$p["id"]] = $p;

		if (array_key_exists("colors", $p)) {
			foreach ($p["colors"] as $p2) {
				$p2["custom"]["notice"] = null;
				$p2["custom"]["size"] = null;
				if (_isNull($p2["custom"]["regularPrice"])) {
					$p2["custom"]["regularPrice"] = $p2["custom"]["price"];
				}
				$res[$p2["id"]] = $p2;
			}
		}
	}
	return $res;
}

//////////////////////////////////////////////////////////////////////////////////////////

function getProductsHtml($products)
{
	$lis = "";
	foreach ($products as $p) {
		$notice = _isValid($p["custom"]["notice"]) ? "<div class='notice'>" . $p["custom"]["notice"] . "</div>" : "";

		$size = "";
		if (_isValid($p["custom"]["size"])) {
			$value = _isValid($p["custom"]["sizeNum"]) ? $p["custom"]["sizeNum"] . " mm" : $p["custom"]["size"];
			$size = "<span class='size'>($value)</span>";
		}

		$regularPrice = "";
		$showRegularPrice = "false";
		if ($p["custom"]["price"] != $p["custom"]["regularPrice"]) {
			$regularPrice = "<div class='regular-price'>" . formatPrice($p["custom"]["regularPrice"]) . "</div>";
			$showRegularPrice = "true";
		}

		$url = (LANG == LANG_JA) ? getProductUrl($p["id"]) : $p["url"];

		$lis .= "<li product-id='" . $p["id"] . "' nh-gray-border='2' show-regular-price='$showRegularPrice'>" .
			"<a href='$url'>" .
			$notice .
			//						"<div class='image' style='background-image:url(\"".$p["image_url"]."\");'></div>".
			"<div class='image' url='" . $p["image_url"] . "'></div>" .
			//						"<div class='image' style='background-image:url(\"".$p["thumbnail_image_url"]."\");'></div>".
			"<div class='text'>" .
			"<div class='name'>" . $p["custom"]["name"] . "$size</div>" .
			"<div class='category'>" . $p["custom"]["category"] . "</div>" .
			"<div class='color'>" . $p["custom"]["color"] . "</div>" .
			"<div class='prices'>" .
			$regularPrice .
			"<div class='price'>" . formatPrice($p["custom"]["price"]) . "</div>" .
			"</div>" .
			"</div>" .
			"</a>" .
			"</li>";
	}
	return "<ul nh-list-product>$lis</ul>";
}

function echoProductList($products)
{
	echo "<section nh-product-list>" .
		"<div class='content-area-container'>" .
		"<div class='content-area'>" .
		"<div class='total-sort' nh-content-sp='padding'>" .
		"<div class='total'>" . sizeof($products) . " " . getTxt("productCountUnit") . "</div>" .
		"<div class='sort'>" .
		"<ul>" .
		"<li sort='lineupOrder' selected><div class='text' nh-red-border onclick='nh.product.onClickSort(this);'>" . getTxt("lineupOrder") . "</div></li>" .
		"<li sort='descPriceOrder'><div class='text' nh-red-border onclick='nh.product.onClickSort(this);'>" . getTxt("descPriceOrder") . "</div></li>" .
		"<li sort='ascPriceOrder'><div class='text' nh-red-border onclick='nh.product.onClickSort(this);'>" . getTxt("ascPriceOrder") . "</div></li>" .
		"</ul>" .
		"<select onchange='nh.product.onChangeSort(this);'>" .
		"<option value='lineupOrder'>" . getTxt("lineupOrder") . "</option>" .
		"<option value='descPriceOrder'>" . getTxt("descPriceOrder") . "</option>" .
		"<option value='ascPriceOrder'>" . getTxt("ascPriceOrder") . "</option>" .
		"</select>" .
		"</div>" .
		"</div>" .
		"<div class='list'>" . getProductsHtml($products) . "</div>" .
		"</div>" .
		"</div>" .
		"</section>";
}
/*
<section nh-product-list>
	<div class="content-area-container">
		<div class="content-area">
			<div class="total-sort" nh-content-sp="padding">
				<div class="total"><?php echo sizeof($products)." ".getTxt("productCountUnit"); ?></div>
				<div class="sort">
					<ul>
						<li sort="lineupOrder" selected><div class="text" nh-red-border onclick="nh.product.onClickSort(this);"><?php t("lineupOrder"); ?></div></li>
						<li sort="descPriceOrder"><div class="text" nh-red-border onclick="nh.product.onClickSort(this);"><?php t("descPriceOrder"); ?></div></li>
						<li sort="ascPriceOrder"><div class="text" nh-red-border onclick="nh.product.onClickSort(this);"><?php t("ascPriceOrder"); ?></div></li>
					</ul>
					<select onchange="nh.product.onChangeSort(this);">
						<option value="lineupOrder"><?php t("lineupOrder"); ?></option>
						<option value="descPriceOrder"><?php t("descPriceOrder"); ?></option>
						<option value="ascPriceOrder"><?php t("ascPriceOrder"); ?></option>
					</select>
				</div>
			</div>
			<div class="list"><?php echo getProductsHtml($products); ?></div>
		</div>
	</div>
</section>
*/

/////////////////////////////////////////////

function getTopProductHtml($product)
{
	global $productInfo;

	$pid = $product["id"];

	$title = "";
	$desc = "";
	if (array_key_exists($pid, $productInfo)) {
		$info = $productInfo[$pid];
		if (array_key_exists("title", $info) && _isValidString($info["title"])) {
			$title = "<div class='title' nh-font='1'>" . $productInfo[$pid]["title"] . "</div>";
		}
		if (array_key_exists("text", $info) && _isValidString($info["text"])) {
			$desc = "<div class='desc'>" . $productInfo[$pid]["text"] . "</div>";
		}
	}

	return "<div nh-top-product nh-gray-border='2'>" .
		"<div class='item'>" .
		"<div>" . getProductShapeHtml($product, false) . "</div>" .
		"</div>" .
		"<div class='text' nh-gray-bg='1' nh-content-sp='padding'>" .
		"<div>" .
		"<div>$title$desc</div>" .
		"</div>" .
		"</div>" .
		"</div>";
}

function getProductShapeHtml_old2($p, $withDesc = true)
{
	global $productInfo;

	$scaleGroupIds = array(COLOR_ME_GROUP_ID_MEN_JACKET, COLOR_ME_GROUP_ID_MEN_SHIRT, COLOR_ME_GROUP_ID_WOMEN_JACKET, COLOR_ME_GROUP_ID_WOMEN_SHIRT);

	$isSizeSelectable = (array_key_exists("isSizeSelectable", $p) && $p["isSizeSelectable"]);

	$firstImages = "";
	$names = "";
	$prices = "";
	$colorButtons = "";

	$colors = array_key_exists("colors", $p) ? $p["colors"] : array($p);
	for ($i = 0, $size = sizeof($colors); $i < $size; $i++) {
		$c = $colors[$i];
		$selected = ($i == 0) ? "true" : "false";

		$notice = _isValidString($c["custom"]["notice"]) ? "<div class='notice'>" . $c["custom"]["notice"] . "</div>" : "";

		$firstImages .= "<div class='first' pid='" . $c["id"] . "' selected='$selected'>" .
			"<div class='image' url='" . $c["image_url"] . "'></div>" .
			$notice .
			"</div>";
		$prices .= "<div class='price' pid='" . $c["id"] . "' price='" . $c["custom"]["price"] . "' selected='$selected'>" . formatPrice($c["custom"]["price"]) . "</div>";

		$name = $c["custom"]["name"];
		if (!$isSizeSelectable && _isValidString($c["custom"]["size"])) {
			$name .= "（" . $c["custom"]["size"] . "）";
		}
		$names .= "<div class='name' pid='" . $c["id"] . "' selected='$selected'>$name</div>";

		if (_isValidString($c["custom"]["colorId"])) {
			$colorButtons .= "<div class='button' pid='" . $c["id"] . "' nh-bg-color='" . $c["custom"]["colorId"] . "' title='" . $c["custom"]["color"] . "' onclick='nh.product.onClickColor(event, this);'></div>";
		}
	}

	$second = "";
	$desc = "";
	if (array_key_exists($p["id"], $productInfo)) {
		if (array_key_exists("image", $productInfo[$p["id"]]) && _isValidString($productInfo[$p["id"]]["image"])) {
			$second = "<div class='second image' url='" . getImg($productInfo[$p["id"]]["image"]) . "'></div>";
		}
		if ($withDesc && array_key_exists("text", $productInfo[$p["id"]]) && _isValidString($productInfo[$p["id"]]["text"])) {
			$desc = "<div>" . $productInfo[$p["id"]]["text"] . "</div>";
		}
	}

	$scaleFirstImage = "false";
	if (_startsWith($p["custom"]["name"], "SET-")) {
		$scaleFirstImage = "true";
	} else {
		foreach ($scaleGroupIds as $groupId) {
			if (in_array($groupId, $p["group_ids"])) {
				$scaleFirstImage = "true";
				break;
			}
		}
	}

	$spSecond = "";
	$sliderButtons = "";
	$sliderIcons = "";
	if (_isValidString($second)) {
		$spSecond = "<div>$second</div>";

		$sliderButtons = "<div class='swiper-button-next'></div>" .
			"<div class='swiper-button-prev'></div>";

		foreach (array("left", "right") as $side) {
			//			$sliderIcons .=	"<div slider='$side' onclick='f.carousel.onClick"._capitalize($side)."Slider();'>".
//								"<div class='icon'>".getIcon($side, "nh-gray-bg-ba='3'")."</div>".
//							"</div>";
			$sliderIcons .= "<div class='arrow $side-arrow' nh-gray-bg-ba-hover='4' onclick='nh.product.onClickCarousel" . _capitalize($side) . "Arrow(event, this);'>" .
				"<div icon='$side'>" .
				"<span class='top' nh-gray-bg-ba='3'></span>" .
				"<span class='bottom' nh-gray-bg-ba='3'></span>" .
				"</div>" .
				"</div>";
		}
	}
	$spImages = "<div class='images carousel' device='sp'>" .
		"<div class='swiper-slider-container'>" .
		"<div class='swiper-container'>" .
		"<div class='swiper-wrapper'>" .
		"<div class='firsts' scale='$scaleFirstImage'>$firstImages</div>" .
		$spSecond .
		"</div>" .
		$sliderButtons .
		"</div>" .
		$sliderIcons .
		"</div>" .
		"</div>";

	$sizeStyle = $isSizeSelectable ? "" : "style='display:none;'";

	return "<a href='" . getProductUrl($p["id"]) . "' nh-gray-border-hover='2'>" .
		"<div class='images' device='pc'>" .
		$second .
		"<div class='firsts' scale='$scaleFirstImage'>$firstImages</div>" .
		"</div>" .
		$spImages .
		"<div class='vars' nh-content-sp='padding'>" .
		"<div class='colors'>$colorButtons</div>" .
		"<div class='size' $sizeStyle>" . getTxt("sizeSelectable") . "</div>" .
		"</div>" .
		"<div class='texts' nh-content-sp='padding'>" .
		"<div class='names'>$names</div>" .
		"<div class='category'>" . $p["custom"]["category"] . "</div>" .
		"<div class='prices'>$prices</div>" .
		($withDesc ? "<div class='desc'>$desc</div>" : "") .
		"</div>" .
		"</a>";
}

/*
		$regularPrice = "";
		$showRegularPrice = "false";
		if ($p["custom"]["price"] != $p["custom"]["regularPrice"]) {
			$regularPrice = "<div class='regular-price'>".formatPrice($p["custom"]["regularPrice"])."</div>";
			$showRegularPrice = "true";
		}

		$lis .=	"<li product-id='".$p["id"]."' nh-gray-border='2' show-regular-price='$showRegularPrice'>".
					"<a href='".getProductUrl($p["id"])."'>".
						$notice.
//						"<div class='image' style='background-image:url(\"".$p["image_url"]."\");'></div>".
						"<div class='image' url='".$p["image_url"]."'></div>".
//						"<div class='image' style='background-image:url(\"".$p["thumbnail_image_url"]."\");'></div>".
						"<div class='text'>".
							"<div class='name'>".$p["custom"]["name"]."$size</div>".
							"<div class='category'>".$p["custom"]["category"]."</div>".
							"<div class='color'>".$p["custom"]["color"]."</div>".
							"<div class='prices'>".
								$regularPrice.
								"<div class='price'>".formatPrice($p["custom"]["price"])."</div>".
							"</div>".
						"</div>".
					"</a>".
				"</li>";
*/
function getProductShapeHtml($p)
{
	$productInfo;
	if (LANG == LANG_JA) {
		global $productInfo;
	} else {
		global $enProductInfo;
		$productInfo = $enProductInfo;
	}

	$scaleGroupIds = array(COLOR_ME_GROUP_ID_MEN_JACKET, COLOR_ME_GROUP_ID_MEN_SHIRT, COLOR_ME_GROUP_ID_WOMEN_JACKET, COLOR_ME_GROUP_ID_WOMEN_SHIRT);

	$pid = $p["id"];

	$isSizeSelectable = (array_key_exists("isSizeSelectable", $p) && $p["isSizeSelectable"]);

	$names = "";
	$prices = "";
	$pcFirstImages = "";
	$colorButtons = "";
	$soldOuts = "";
	$hasSoldOut = false;

	$colors = array_key_exists("colors", $p) ? $p["colors"] : array($p);
	for ($i = 0, $size = sizeof($colors); $i < $size; $i++) {
		$c = $colors[$i];
		$custom = $c["custom"];

		$selected = ($i == 0) ? "true" : "false";

		$notice = (array_key_exists("notice", $custom) && _isValidString($custom["notice"])) ? "<div class='notice'>" . $custom["notice"] . "</div>" : "";
		$pcFirstImages .= "<div class='first' pid='" . $c["id"] . "' selected='$selected'>" .
			"<div class='image' url='" . $c["image_url"] . "'></div>" .
			$notice .
			"</div>";

		$name = $custom["name"];
		if (!$isSizeSelectable && array_key_exists("size", $custom) && _isValidString($custom["size"])) {
			$name .= "（" . $custom["size"] . "）";
		}
		$names .= "<div class='name' pid='" . $c["id"] . "' selected='$selected'>$name</div>";

		$stock = getProductStock($c);
		$soldOut = "";
		if (_isValid($stock) && $stock == 0) {
			$soldOut = getTxt("soldOut");
			$hasSoldOut = true;
		}
		$soldOuts .= "<span class='sold-out' pid='" . $c["id"] . "' selected='$selected' nh-red>$soldOut</span>";

		//		$prices .= "<div class='price' pid='".$c["id"]."' price='".$custom["price"]."' selected='$selected'>".formatPrice($custom["price"])."</div>";
		$strikedPrice = "";
		if (_isValid($custom["regularPrice"]) && $custom["price"] != $custom["regularPrice"]) {
			$strikedPrice = "<div class='striked-price'>" . formatPrice($custom["regularPrice"]) . "</div>";
		}
		$prices .= "<div class='price' pid='" . $c["id"] . "' price='" . $custom["price"] . "' selected='$selected'>" .
			$strikedPrice .
			"<div class='selling-price'>" . formatPrice($custom["price"]) . "</div>" .
			"</div>";

		if (array_key_exists("colorId", $custom) && _isValidString($custom["colorId"])) {
			$enAttr = (LANG == LANG_JA) ? "" : "s-url='" . $c["url"] . "'";
			$colorButtons .= "<div class='button' pid='" . $c["id"] . "' $enAttr nh-bg-color='" . $custom["colorId"] . "' title='" . $custom["color"] . "' onclick='nh.product.onClickColor(event, this);'></div>";
		}
	}

	$scaleFirstImage = "false";
	$set = "false";
	if (_startsWith($p["custom"]["name"], "SET-")) {
		$scaleFirstImage = "true";
		$set = "true";
	} else {
		foreach ($scaleGroupIds as $groupId) {
			if (in_array($groupId, $p["group_ids"])) {
				$scaleFirstImage = "true";
				break;
			}
		}
	}

	$shortDesc = "";
	$longDesc = "";
	$pcSecondImage = "";

	if (array_key_exists($pid, $productInfo)) {
		$info = $productInfo[$pid];

		if (array_key_exists("text", $info))
			$shortDesc = $info["text"];
		if (array_key_exists("desc", $info))
			$longDesc = $info["desc"];

		if (array_key_exists("image", $info))
			$pcSecondImage = "<div class='second image' url='" . getImg($info["image"]) . "'></div>";
	}

	if (_isNullString($shortDesc) && array_key_exists("expl", $p) && _contains($p["expl"], "[TITLE-1]")) {
		$headers = array();
		$divided = explode("[TITLE-1]", $p["expl"]);
		$lines = explode("\n", trim($divided[1]));
		//		if (sizeof($lines) != 0) $shortDesc = $lines[0];
		foreach ($lines as $line) {
			$line = trim($line);
			if (_isNullString($line) || (_startsWith($line, "[") && _endsWith($line, "]"))) {
				break;
			}
			array_push($headers, $line);
		}
		if (sizeof($headers) != 0)
			$shortDesc = implode("", $headers);
	}

	$spSecondImage = "";
	$sliderButtons = "";
	$sliderIcons = "";
	if (_isValidString($pcSecondImage)) {
		$spSecondImage = "<div>$pcSecondImage</div>";

		$sliderButtons = "<div class='swiper-button-next'></div>" .
			"<div class='swiper-button-prev'></div>";

		foreach (array("left", "right") as $side) {
			$sliderIcons .= "<div class='arrow $side-arrow' nh-gray-bg-ba-hover='4' onclick='nh.product.onClickCarousel" . _capitalize($side) . "Arrow(event, this);'>" .
				"<div icon='$side'>" .
				"<span class='top' nh-gray-bg-ba='3'></span>" .
				"<span class='bottom' nh-gray-bg-ba='3'></span>" .
				"</div>" .
				"</div>";
		}
	}
	$spImages = "<div class='images carousel' device='sp'>" .
		"<div class='swiper-slider-container'>" .
		"<div class='swiper-container'>" .
		"<div class='swiper-wrapper'>" .
		"<div class='firsts' scale='$scaleFirstImage' set='$set'>$pcFirstImages</div>" .
		$spSecondImage .
		"</div>" .
		$sliderButtons .
		"</div>" .
		$sliderIcons .
		"</div>" .
		"</div>";

	$sizeStyle = $isSizeSelectable ? "" : "style='display:none;'";
	
	$review = "";
	if (array_key_exists("review", $p["custom"]) && _isValid($p["custom"]["review"])) {
		$rate = floatval($p["custom"]["review"]) * 100;
//		$rate = 345;
		
		$numOfFilled = intval(floor($rate / 100));
		$numOfEmpty = 5 - $numOfFilled;
		
		$decimal = $rate % 100;
		if ($decimal != 0) $numOfEmpty--;
		
		$stars = "";
		for ($i = 0; $i < $numOfFilled; $i++) {
			$stars .= "<span star><span>★</span></span>";
		}
		if ($decimal != 0) {
			$stars .=	"<span class='part'>".
							"<span star><span>★</span></span>".
							"<span star style='width:$decimal%;'><span>★</span></span>".
						"</span>";
		}
		for ($i = 0; $i < $numOfEmpty; $i++) {
			$stars .=	"<span class='part'>".
							"<span star><span>★</span></span>".
						"</span>";
		}
		
		$label = round($rate / 100, 1)."";
		if (!_contains($label, ".")) $label .= ".0";
		
		$review =	"<div class='rate'>".
						"<span class='summary'>$label</span>".
						"<span stars>$stars</span>".
					"</div>";
	}

	$descs = "";
	if (_isValidString($shortDesc))
		$descs .= "<div class='short' nh-font='1'>$shortDesc</div>";
	if (_isValidString($longDesc))
		$descs .= "<div class='long' nh-gray-border='3'>$longDesc</div>";

	/*	return	"<a href='".getProductUrl($pid)."' nh-gray-border='2'>".
					"<div class='top'>".
						"<div class='images' device='pc'>".
							$pcSecondImage.
							"<div class='firsts' scale='$scaleFirstImage'>$pcFirstImages</div>".
						"</div>".
						$spImages.
					"</div>".
					"<div class='bottom'>".
						"<div class='vars'>".
							"<div class='colors'>$colorButtons</div>".
							"<div class='size' $sizeStyle>".getTxt("sizeSelectable")."</div>".
						"</div>".
						"<div class='texts'>".
							"<div class='name-category'>".
								"<div class='names'>$names</div>".
								"<div class='category'>".$p["custom"]["category"]."</div>".
							"</div>".
						"</div>".
					"</div>".
				"</a>";*/

	$url = (LANG == LANG_JA) ? getProductUrl($pid) : $p["url"];

	return	"<a href='$url' nh-gray-border='2'>" .
				"<div class='product'>" .
					"<div class='images'>" .
						"<div device='pc'>" .
							$pcSecondImage .
							"<div class='firsts' scale='$scaleFirstImage'>$pcFirstImages</div>" .
						"</div>" .
						$spImages .
					"</div>" .
					"<div class='text-vars'>" .
						"<div class='text'>" .
							"<div class='name-category'>" .
								"<span class='names'>$names</span>" .
								"<span class='category'>" . $p["custom"]["category"] . "</span>" .
							"</div>" .
							"<div class='prices'>$prices</div>" .
						"</div>" .
						"<div class='vars'>" .
							"<div class='colors'>$colorButtons</div>" .
							"<div class='size' $sizeStyle>" . getTxt("sizeSelectable") . "</div>" .
							$review.
							"<div class='sold-outs' sold-out='" . ($hasSoldOut ? "true" : "false") . "'>$soldOuts</div>" .
						"</div>" .
					"</div>" .
				"</div>" .
				"<div class='descs'>$descs</div>" .
			"</a>";

	/*	return	"<a href='".getProductUrl($pid)."' nh-gray-border='2'>".
					"<div class='images'>".
						"<div device='pc'>".
							$pcSecondImage.
							"<div class='firsts' scale='$scaleFirstImage'>$pcFirstImages</div>".
						"</div>".
						$spImages.
					"</div>".
					"<div class='texts'>".
						"<div class='info'>".
							"<div class='text'>".
								"<div class='name-category'>".
									"<span class='names'>$names</span>".
									"<span class='category'>".$p["custom"]["category"]."</span>".
								"</div>".
								"<div class='prices'>$prices</div>".
							"</div>".
							"<div class='vars'>".
								"<div class='colors'>$colorButtons</div>".
								"<div class='size' $sizeStyle>".getTxt("sizeSelectable")."</div>".
							"</div>".
						"</div>".
						"<div class='desc' nh-font='1'>$title</div>".
					"</div>".
				"</a>";*/

	/*	return	"<a href='".getProductUrl($pid)."' nh-gray-border='2'>".
					"<div class='text' nh-content-sp='padding'>".
						"<div class='title' nh-font='1'>".
							"<div>$title</div>".
						"</div>".
						"<div class='desc' nh-gray-border='3'>$desc</div>".
					"</div>".
					"<div class='info'>".
						"<div class='images' device='pc'>".
							$pcSecondImage.
							"<div class='firsts' scale='$scaleFirstImage'>$pcFirstImages</div>".
						"</div>".
						$spImages.
						"<div class='details' nh-content-sp='padding'>".
							"<div class='vars'>".
								"<div class='colors'>$colorButtons</div>".
								"<div class='size' $sizeStyle>".getTxt("sizeSelectable")."</div>".
							"</div>".
							"<div class='texts'>".
								"<div class='names'>$names</div>".
								"<div class='category'>".$p["custom"]["category"]."</div>".
								"<div class='prices'>$prices</div>".
							"</div>".
						"</div>".
					"</div>".
				"</a>";*/
}

function getProductShapesHtml($products)
{
	$lis = "";
	for ($i = 0, $size = sizeof($products); $i < $size; $i++) {
		$lis .= "<li index='$i'>" . getProductShapeHtml($products[$i]) . "</li>";
	}
	return "<ul nh-product-shape-ul>" .
		"$lis<li></li>" .
		"</ul>";
}

function getProductShapesHtml_old2($products)
{
	$lis = "";
	for ($i = 0, $size = sizeof($products); $i < $size; $i++) {
		$lis .= "<li index='$i'>" . getProductShapeHtml($products[$i]) . "</li>";
	}
	return "<ul nh-shape-list-product>$lis</ul>";
}

function getProductShapesHtml_old($products, $productInfo, $sizeSelectablePids)
{
	$scaleGroupIds = array(COLOR_ME_GROUP_ID_MEN_JACKET, COLOR_ME_GROUP_ID_MEN_SHIRT, COLOR_ME_GROUP_ID_WOMEN_JACKET, COLOR_ME_GROUP_ID_WOMEN_SHIRT);

	$lis = "";
	foreach ($products as $p) {
		$firstImages = "";
		$names = "";
		//		$sizePids = "";
		$colorButtons = "";
		$colors = array_key_exists("colors", $p) ? $p["colors"] : array($p);
		for ($i = 0, $size = sizeof($colors); $i < $size; $i++) {
			$c = $colors[$i];
			$selected = ($i == 0) ? "true" : "false";

			$firstImages .= "<div class='image' pid='" . $c["id"] . "' selected='$selected' url='" . $c["image_url"] . "'></div>";
			$names .= "<div class='name' pid='" . $c["id"] . "' selected='$selected'>" . $c["custom"]["name"] . "</div>";
			$colorButtons .= "<div class='button' pid='" . $c["id"] . "' nh-bg-color='" . $c["custom"]["colorId"] . "' title='" . $c["custom"]["color"] . "' onclick='nh.product.onClickColor(event, this);'></div>";

			//			if (array_key_exists("sizes", $c) && sizeof($c["sizes"]) != 0) $sizePids .= "_".$c["id"]."_";
		}

		$second = "";
		$desc = "";
		if (array_key_exists($p["id"], $productInfo)) {
			if (array_key_exists("image", $productInfo[$p["id"]]) && _isValidString($productInfo[$p["id"]]["image"])) {
				$second = "<div class='second image' url='" . getImg($productInfo[$p["id"]]["image"]) . "'></div>";
			}
			if (array_key_exists("text", $productInfo[$p["id"]]) && _isValidString($productInfo[$p["id"]]["text"])) {
				$desc = $productInfo[$p["id"]]["text"];
			}
		}

		$scaleFirstImage = "false";
		foreach ($scaleGroupIds as $groupId) {
			if (in_array($groupId, $p["group_ids"])) {
				$scaleFirstImage = "true";
				break;
			}
		}

		$sizeStyle = in_array($p["id"], $sizeSelectablePids) ? "" : "style='display:none;'";

		$lis .= "<li>" .
			"<a href='" . getProductUrl($p["id"]) . "'>" .
			"<div class='images'>" .
			$second .
			"<div class='firsts' scale='$scaleFirstImage'>$firstImages</div>" .
			"</div>" .
			"<div class='vars'>" .
			"<div class='colors'>$colorButtons</div>" .
			"<div class='size' $sizeStyle>" . getTxt("sizeSelectable") . "</div>" .
			"</div>" .
			"<div class='texts'>" .
			"<div class='names'>$names</div>" .
			"<div class='category'>" . $p["custom"]["category"] . "</div>" .
			"<div class='price'>" . formatPrice($p["custom"]["price"]) . "</div>" .
			"<div class='desc'>$desc</div>" .
			"</div>" .
			"</a>" .
			"</li>";

		/*		$notice = _isValid($p["custom"]["notice"]) ? "<div class='notice'>".$p["custom"]["notice"]."</div>" : "";

				$size = "";
				if (_isValid($p["custom"]["size"])) {
					$value = _isValid($p["custom"]["sizeNum"]) ? $p["custom"]["sizeNum"]." mm" : $p["custom"]["size"];
					$size = "<span class='size'>($value)</span>";
				}

				$lis .=	"<li product-id='".$p["id"]."' nh-gray-border='2'>".
							"<a href='".getProductUrl($p["id"])."'>".
								$notice.
								"<div class='image' url='".$p["image_url"]."'></div>".
								"<div class='text'>".
									"<div class='name'>".$p["custom"]["name"]."$size</div>".
									"<div class='category'>".$p["custom"]["category"]."</div>".
									"<div class='color'>".$p["custom"]["color"]."</div>".
									"<div class='price'>".formatPrice($p["custom"]["price"])."</div>".
								"</div>".
							"</a>".
						"</li>";*/
	}
	return "<ul nh-shape-list-product>$lis</ul>";
}

/////////////////////////////////////////////

function getProductStock($product)
{
	if (LANG == LANG_JA) {
		return $product["stocks"];
	} else {
		$stock = 0;
		$stockManaged = false;
		foreach ($product["variants"] as $v) {
			if (array_key_exists("inventory_quantity", $v) && _isValid($v["inventory_quantity"])) {
				$stock += $v["inventory_quantity"];
				$stockManaged = true;
			}
		}
		return $stockManaged ? $stock : null;
	}
}

//////////////////////////////////////////////////////////////////////////////////////////

function en_echoMaintenance($from = "0000.00.00 00:00:00", $to = "9999.99.99 99:99:99")
{
	$now = _now();
	if ($from <= $now && $now < $to) {
		echo "<section id='maintenance' nh-margin='header' nh-content-sp='padding'>" .
			"<div class='header'>Under Maintenance</div>" .
			"<div>" .
			"<p>This page is currently under maintenance.<br>Sorry for the inconvenience.<br><br>Maintenance Schedule : <br device='sp'>Mar. 27th 9:00-16:30 JST</p>" .
			"</div>" .
			"</section>";
		echoFooter();
		echo "</body></html>";
		exit();
	}
}

//////////////////////////////////////////////////////////////////////////////////////////

function echoFeatureBanners($features, $dates = null, $fadeUp = false, $linkKey = null, $newWindow = false)
{
	if (_isValid($dates)) {
		$dateToFeature = array();
		foreach ($features as $feature) {
			$dateToFeature[$feature["date"]] = $feature;
		}
		$features = array();
		for ($i = 0, $size = sizeof($dates); $i < $size; $i++) {
			array_push($features, $dateToFeature[$dates[$i]]);
		}
	}

	$lis = "";
	$pcStyles = array();
	$spStyles = array();

	$size = sizeof($features);
	for ($i = 0; $i < $size; $i++) {
		$f = $features[$i];

		$fadeUpAttr = $fadeUp ? "nh-fade-up-follow='feature-banner' nh-faded-up='false'" : "";

		$imageStyle = array_key_exists("banner-image-style", $f) ? $f["banner-image-style"] : "";

		$t1 = "";
		if (array_key_exists("title-en", $f)) {
			$t1Style = array_key_exists("title-en-style", $f) ? "style='" . $f["title-en-style"] . "'" : "";
			$t1 = "<div class='text-1' nh-font='1' $t1Style>" . $f["title-en"] . "</div>";
		}

		$t2 = array_key_exists("title-ja", $f) ? "<div class='text-2' nh-font='1'>" . $f["title-ja"] . "</div>" : "";
		$t3 = (array_key_exists("ended", $f) && $f["ended"]) ? "<div class='text-3'>(" . getTxt("saleEnded") . ")</div>" : "";

		$href = "";
		if (array_key_exists("url", $f)) {
			$href = $f["url"];
			if (_isValidString($linkKey) && array_key_exists($linkKey, $f)) {
				$href .= (_contains($href, "?") ? "&" : "?") . "link=" . $f[$linkKey];
			}
		} else {
			$href = (_isValidString($linkKey) && array_key_exists($linkKey, $f)) ? getFeatureUrl($f["date"], $f[$linkKey]) : getFeatureUrl($f["date"]);
		}

		$lis .= "<li $fadeUpAttr>" .
			"<a href='$href' nh-link " . ($newWindow ? "target='_blank'" : "") . ">" .
			"<div class='image' style='background-image:url(\"" . getImg($f["image"]) . "\"); $imageStyle'></div>" .
			"<div class='black'></div>" .
			"<div class='text-container'>" .
			"<div class='texts'>$t1$t2$t3</div>" .
			"<div class='date' nh-font='2'>" . _replace($f["date"], "-", ".") . "</div>" .
			"</div>" .
			"</a>" .
			"</li>";

		if (array_key_exists("banner-image-style-pc", $f))
			array_push($pcStyles, "[nh-feature-banners] li:nth-child(" . ($i + 1) . ") .image { " . $f["banner-image-style-pc"] . " }");
		if (array_key_exists("banner-image-style-sp", $f))
			array_push($spStyles, "[nh-feature-banners] li:nth-child(" . ($i + 1) . ") .image { " . $f["banner-image-style-sp"] . " }");
	}

	if ($size > 3) {
		$numOfEmpties = $size % 3;
		for ($i = 0; $i < $numOfEmpties; $i++) {
			$lis .= "<li class='empty'></li>";
		}
	}

	echo "<div nh-feature-banners num-of-banners='$size'>" .
		"<ul>$lis</ul>" .
		"<style>" .
		"@media only screen and (min-width:" . MIN_PC_VIEW_WIDTH . "px) {\n\t" . implode("\n\t", $pcStyles) . "\n}\n" .
		"@media only screen and (max-width:" . MAX_SP_VIEW_WIDTH . "px) {\n\t" . implode("\n\t", $spStyles) . "\n}" .
		"</style>" .
		"</div>";
}

//////////////////////////////////////////////////////////////////////////////////////////

function isShowNameEngravingCampaign()
{
	return (SHOW_FREE_NAME_ENGRAVING && _isNowIn(NAME_ENGRAVING_CAMPAIGN_FROM, NAME_ENGRAVING_CAMPAIGN_TO));
}

//////////////////////////////////////////////////////////////////////////////////////////

function echoCorporateLink() {
	echo	"<section id='corporate' nh-margin-section='top'>".
				"<div class='content-area-container'>".
					"<div class='content-area' nh-content-sp='padding' style='background-image:url(\"".getImg("corporate_dark.jpg")."\");'>".
						"<div class='container'>".
							"<div class='logo'><img src='".getImg("corporate_logo_white.svg")."'></div>".
							"<div class='text'>".
								"<h2 nh-font='1' padding>ふくをかける以上の価値を。</h2>".
								"<p padding padding>子どものような好奇心と冒険心を持ちながら、今の時代に求められている本当の価値を探究し、仕事を通じて豊かに「成長」できる。そんな会社を目指して活動しています。</p>".
								"<div class='button'><a href='https://www.nakatakogei.com/' target='_blank' nh-button>コーポレート サイト</a></div>".
							"</div>".
						"</div>".
					"</div>".
				"</div>".
			"</section>";
}

//////////////////////////////////////////////////////////////////////////////////////////

function echoAccordion($titleToText)
{
	echo "<div class='nh-accordion'>";
	foreach ($titleToText as $title => $text) {
		echo "<div class='row' opened='false'>" .
			"<div class='header' nh-gray-bg-hover='1' onclick='nh.accordion.toggle(this);'>" .
			"<div nh-font='1' nh-content-sp='padding'>$title</div>" .
			"<div class='plus-minus' nh-content-sp='padding'>" .
			"<div>" . getIcon("plus_minus") . "</div>" .
			"</div>" .
			"</div>" .
			"<div class='body' nh-content-sp='padding'>" .
			"<div nh-gray-border='2' nh-font='1'>$text</div>" .
			"</div>" .
			"</div>";
	}
	echo "</div>";
}

//////////////////////////////////////////////////////////////////////////////////////////

function echoVideoHtml($video, $thumbnail = null, $autoplay = true, $mute = true, $controls = false)
{
	$poster = _isValid($thumbnail) ? "poster='" . getImg($thumbnail) . "'" : "";
	$auto = $autoplay ? "true" : "false";
	$muted = ($mute || $autoplay) ? "muted" : "";
	$control = $controls ? "control" : "";
	echo "<div nh-video playing='false' played='false' auto='$auto'>" .
		"<div class='container'>" .
		"<video src='" . getVideo($video) . "' playsinline $muted $poster $control onplay='nh.video.onPlay(this);' onpause='nh.video.onPause(this);'></video>" .
		"<div class='icons' onclick='nh.video.onClick(this);'><img class='play' src=" . getImg("play-64.png") . "></div>" .
		"</div>" .
		($mute ? "" : "<div class='sound'>" . getTxt("(", "videoHasSound", ")") . "</div>") .
		"</div>";
}

//////////////////////////////////////////////////////////////////////////////////////////

function isValidInstragram($post)
{
	if (
		array_key_exists("lang", $post) && sizeof($post["lang"]) != 0 &&
		array_key_exists("url", $post) && _isValidString($post["url"]) &&
		array_key_exists("user", $post) && _isValidString($post["user"]) &&
		array_key_exists("date", $post) && _isValidString($post["date"]) &&
		array_key_exists("text", $post) && _isValidString($post["text"]) &&
		array_key_exists("images", $post) && sizeof($post["images"]) != 0
	) {

		if (!in_array(LANG, $post["lang"]))
			return false;

		if (!_startsWith($post["url"], URL_INSTAGRAM_HOST))
			return false;

		$date = _replace($post["date"], "-", "/");
		$ymd = explode("/", $date);
		if (sizeof($ymd) == 3) {
			foreach ($ymd as $number) {
				if (!is_numeric($number))
					return false;
			}

			$month = intval($ymd[1]);
			if ($month < 1 || 12 < $month)
				return false;

			$day = intval($ymd[2]);
			if ($day < 1 || 31 < $day)
				return false;
		} else {
			return false;
		}

		foreach ($post["images"] as $image) {
			if (_isNullString($image) || !_contains($image, "."))
				return false;
		}

		if (array_key_exists("schedule", $post)) {
			if (strlen($post["schedule"]) != 10)
				return false;

			$schedule = _replace($post["schedule"], "-", "/");
			if ($schedule > _today("/"))
				return false;
		}

		return true;
	} else {
		return false;
	}
}

function getInstagramPosts($size = null)
{
	global $instagram;
	$res = array();
	foreach ($instagram as $post) {
		if (isValidInstragram($post)) {
			array_push($res, $post);
			if (_isValid($size) && sizeof($res) >= $size)
				break;
		}
	}
	return $res;
}

function getSnsWords($text, $char)
{
	preg_match_all("/" . $char . "(w*[一-龠_ぁ-ん_ァ-ヴーａ-ｚＡ-Ｚa-zA-Z0-9]+|[a-zA-Z0-9_]+|[a-zA-Z0-9_]w*)/", $text, $res);
	return _removeDuplicate($res[0]);
}

function setInstagramLinks($text, $char, $url)
{
	$texts = getSnsWords($text, $char);
	foreach ($texts as $t) {
		$href = _replace($url, "*", substr($t, 1));
		$chars = array("<", " ", $char);
		foreach ($chars as $char) {
			$text = _replace($text, $t . $char, "<a href='$href' target='_blank'>$t</a>$char");
		}
	}
	return $text;
}

function echoInitInstagram($posts, $indexKey = null)
{
	for ($i = 0, $size = sizeof($posts); $i < $size; $i++) {
		$text = $posts[$i]["text"] . " ";

		$urls = _getUniqueUrls($text);
		foreach ($urls as $url) {
			$label = _replace($url, "/", "<span style='font-size:1px;'> </span>/<span style='font-size:1px;'> </span>");
			$chars = array(" ", "<");
			foreach ($chars as $char) {
				$text = _replace($text, $url . $char, "<a href='$url' target='_blank'>$label</a>$char");
			}
		}

		$text = setInstagramLinks($text, "@", URL_INSTAGRAM_USER);
		$text = setInstagramLinks($text, "#", URL_INSTAGRAM_TAG);

		$posts[$i]["text"] = trim($text);
	}

	$index = _isValidString($indexKey) ? "'$indexKey'" : "";

	echo "nh.instagram.const.url.home = '" . HOME_URL . "';\n" .
		"nh.instagram.const.url.icon = '" . getUr1(DIR_IMG, false, true) . "/';\n" .
		"nh.instagram.const.url.image = '" . getUr1(DIR_IMG . "/" . DIR_IMG_INSTAGRAM, false, true) . "/';\n" .
		"nh.instagram.const.url.product = '" . getProductUrl("") . "';\n" .
		"nh.instagram.const.url.instagram = { account:'" . URL_INSTAGRAM_USER . "', hashtag:'" . URL_INSTAGRAM_TAG . "' };\n" .
		"nh.instagram.posts = " . json_encode($posts) . ";\n" .
		"nh.instagram.text = { " .
		"inquiry:'" . getTxt("inquiryAboutContents") . "', " .
		"backToList:'" . getTxt("backToList") . "', " .
		"showMore:'" . getTxt("showMore") . "', " .
		"};" .
		"nh.instagram.init($index);\n";
}

function getInstagramHtml($post, $index)
{
	$multi = (sizeof($post["images"]) >= 2) ? "<div class='multi'><img src='" . getImg("multi-images-white.png") . "'></div>" : "";

	return "<div instagram='post' onclick='nh.instagram.open($index);'>" .
		//				"<div class='image' style='background-image:url(\"".getInstagramImg($post["images"][0])."\");'></div>".
		"<div class='image' instagram-image-url='" . getInstagramImg($post["images"][0]) . "'></div>" .
		$multi .
		"<div class='text'>" .
		"<div class='top'>" .
		"<div class='user'>" . $post["user"] . "</div>" .
		"<div>" . $post["date"] . "</div>" .
		"</div>" .
		"<p>" .
		//						"<span class='user'>".$post["user"]."</span>".
//						"<span>".
//							"<span>".$post["date"]."</span>".
//							"<span class='user'>".$post["user"]."</span>".
//						"</span>".
		_replace($post["text"], "<br>", " ") .
		"</p>" .
		//					"<div class='date'>".$post["date"]."</div>".
		"</div>" .
		"</div>";
}

function getInstagramsHtml($posts)
{
	echo "<div instagram='posts'>" .
		"<div>";

	for ($i = 0, $size = sizeof($posts); $i < $size; $i++) {
		$post = $posts[$i];
		if ($i != 0 && $i % 3 == 0)
			echo "</div><div>";
		echo "<div>" . getInstagramHtml($post, $i) . "</div>";
	}

	echo "</div>" .
		"</div>";
}

//////////////////////////////////////////////////////////////////////////////////////////

function echoGallery($images)
{
	echo "<div nh-gallery='list'>" .
		"<div>";
	for ($i = 0, $size = sizeof($images); $i < $size; $i++) {
		if ($i % 3 == 0)
			echo "</div><div>";
		echo "<div>" .
			"<div nh-gallery-image index='$i' url='" . getImg($images[$i]) . "' onclick='nh.gallery.onClickImage(this);'>" .
			"<div>" . ICON_EXPAND . "</div>" .
			"</div>" .
			"</div>";
	}
	echo "</div>" .
		"</div>";
}

//////////////////////////////////////////////////////////////////////////////////////////

function w_accessControlAllowOrigin()
{
	//	$domain = $_SERVER["HTTP_HOST"];
	$domain;
	if (array_key_exists("HTTP_ORIGIN", $_SERVER)) {
		$domain = _after($_SERVER["HTTP_ORIGIN"], "://");
	} else {
		$domain = $_SERVER["HTTP_HOST"];
	}
	$domains = array(DOMAIN_RELEASE, DOMAIN_LOCALHOST, DOMAIN_MACBOOKPRO);
	if (in_array($domain, $domains)) {
		header("Access-Control-Allow-Origin: http://$domain");
	} else {
		header("HTTP/1.0 403 Forbidden");
	}
}

//////////////////////////////////////////////////////////////////////////////////////////

function echoReCaptchaButton($id) {
	echo	"<div recaptcha>\n".
				"<script src='https://www.google.com/recaptcha/api.js' async defer></script>\n".
				"<script>\n".
					"function recaptchaCallback(token) {\n".
						"let e = document.getElementById('$id');\n".
						"while (e != null) {\n".
							"e = e.parentElement;\n".
							"if (e.tagName.toLocaleLowerCase() == 'form') {\n".
								"e.submit();\n".
								"return;\n".
							"}\n".
						"}\n".
					"}\n".
				"</script>\n".
			"</div>\n".
			"<button id='$id' class='g-recaptcha' data-sitekey='".RECAPTCHA_SITE_KEY."' data-callback='recaptchaCallback' data-size='invisible'></button>";
}

function isValidRecaptcha($post) {
	if (array_key_exists("g-recaptcha-response", $post)) {
		$token = $post["g-recaptcha-response"];
		
//		$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".urlencode(RECAPTCHA_SECRET_KEY)."&response=".urlencode($token));
//		$res = json_decode($response, true);
//		return (array_key_exists("success", $res) && $res["success"] === true);
		
		$data = array(
			"secret"=>RECAPTCHA_SECRET_KEY,
			"response"=>$token,
			"remoteip"=>$_SERVER["REMOTE_ADDR"],
		);
		
		$curl = curl_init("https://www.google.com/recaptcha/api/siteverify");
		
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
		
		$result = curl_exec($curl);
		
		$error = false;
		if (curl_errno($curl)) $error = true;
		
		curl_close($curl);
		
		if ($error) {
			return false;
		} else {
			$res = json_decode($result, true);
			return (array_key_exists("success", $res) && $res["success"] === true);
		}
	} else {
		return false;
	}
}

//////////////////////////////////////////////////////////////////////////////////////////

require_once("const-before-text.php");

define("HOME_URL", getNhHomeUrl());
if (!defined("LANG"))
	define("LANG", getLang());

if (isRealServiceEnvironment()) {
	define("EMAIL_INQUIRY", (LANG == LANG_JA) ? EMAIL_ORDER : EMAIL_INFO);
	define("EMAIL_SAMPLE", EMAIL_INFO);
	define("EMAIL_GRAD", "grad@" . DOMAIN_NHCOM);
	define("EMAIL_ORG", EMAIL_INFO);
	define("EMAIL_CONCIERGE", EMAIL_INFO);
	define("EMAIL_INSTAGRAM", EMAIL_INFO);
} else {
	define("EMAIL_INQUIRY", "ryo.nakata.nkk@gmail.com");
	define("EMAIL_SAMPLE", "ryo.nakata.nkk@gmail.com");
	define("EMAIL_GRAD", "ryo.nakata.nkk@gmail.com");
	define("EMAIL_ORG", "ryo.nakata.nkk@gmail.com");
	define("EMAIL_CONCIERGE", "nkk.test.01@gmail.com");
	define("EMAIL_INSTAGRAM", "ryo.nakata.nkk@gmail.com");
}

if (LANG == LANG_EN) {
	define("URL_CART", SHOPIFY_HOST . "/" . LANG_EN . "/cart");
	define("URL_ACCOUNT", SHOPIFY_HOST . "/" . LANG_EN . "/account");
} else {
	//	define("URL_CART", URL_COLOR_ME_CART."proxy/basket?shop_id=".COLOR_ME_SHOP_ID."&shop_domain=".COLOR_ME_DOMAIN);
//	define("URL_CART", URL_COLOR_ME_CART."cart/");
	define("URL_CART", URL_COLOR_ME_CART);
	define("URL_ACCOUNT", URL_COLOR_ME_NH . "?mode=myaccount");
}

$texts = getTexts();

require_once("update.php");
require_once("update/color-variations.php");
require_once("update/color-variations-en.php");
require_once("update/size-variations.php");
require_once("update/search.php");

define("SHOW_NAME_ENGRAVING_CAMPAIGN", isShowNameEngravingCampaign());
define("COLOR_ME_PRODUCT_ID_NAME_ENGRAVING_CURRENT", SHOW_NAME_ENGRAVING_CAMPAIGN ? COLOR_ME_PRODUCT_ID_NAME_ENGRAVING_FREE : COLOR_ME_PRODUCT_ID_NAME_ENGRAVING);

require_once("const-after-text.php");

define("ROOT_PATH", getRootPath());
define("DOTS_TO_ROOT", getDotsToRoot());
define("FILE_NAME", getThisFileName());

define("DIR_TEMPLATE_FILE", ROOT_PATH . "/" . DIR_INCLUDE . "/" . DIR_TEXT . "/" . DIR_TEMPLATE);

?>