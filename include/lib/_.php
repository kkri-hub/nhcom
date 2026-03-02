<?php

//////////////////////////////////////////////////////////////////////////////////////////

function d($x=null) {
	if (func_num_args() == 0) {
		echo "<br/>";
	} else {
		if (is_string($x)) $x = str_replace("<", "&lt;", $x);
		echo "<pre class='debug'>";
		var_dump($x);
		echo "</pre>";
	}
}

function d2() {
	echo "<pre style='font-family:sans-serif; font-size:11px;'>";
	$trace = debug_backtrace();
	for ($i = sizeof($trace) - 1; $i >= 0; $i--) {
		$t = $trace[$i];
		echo $t["file"].":".$t["line"]." ".((!array_key_exists("class", $t) || $t["class"] == null) ? "" : $t["class"].".").$t["function"]."()\n";
	}
	$args = func_get_args();
	foreach ($args as $a) {
		if (is_string($a)) $a = str_replace("<", "&lt;", $a);
		var_dump($a);
	}
	echo "</pre>";
}

function dj($x) {
	echo	"<pre class='debug'>".
				json_encode($x, JSON_UNESCAPED_UNICODE).
			"</pre>";
}

function de($x=null) {
	d($x);
	exit();
}

function dje($x=null) {
	dj($x);
	exit();
}

//////////////////////////////////////////////////////////////////////////////////////////

function _isNull($x) {
	return ($x === null);
}

function _isValid($x) {
	return !_isNull($x);
}

//////////////////////////////////////////////////////////////////////////////////////////

function _isNullString($s) {
	return (_isNull($s) || (trim($s) == ""));
}

function _isValidString($s) {
	return !_isNullString($s);
}

/////////////////////////////////////////////

function _isNumber($c) {
	return ("0" <= $c && $c <= "9");
}

function _isAlphabet($c) {
	return (_isLowerCaseAlphabet($c) || _isUpperCaseAlphabet($c));
}

function _isUpperCaseAlphabet($c) {
	return ("A" <= $c && $c <= "Z");
}

function _isLowerCaseAlphabet($c) {
	return ("a" <= $c && $c <= "z");
}

/////////////////////////////////////////////

function _contains($s, $find) {
	return (strpos($s, $find) !== false);
}

function _startsWith($s, $find) {
	return (strpos($s, $find) === 0);
}
function _endsWith($s, $find) {
	$i = strrpos($s, $find);
	if ($i === -1) return false;
	return ($i === (strlen($s) - strlen($find))) ? true : false;
}

/////////////////////////////////////////////

function _before($s, $find) {
	$i = strpos($s, $find);
	return ($i === false) ? null : substr($s, 0, $i);
}
function _beforeLast($s, $find) {
	$i = strrpos($s, $find);
	return ($i === false) ? null : substr($s, 0, $i);
}

function _to($s, $find) {
	$i = strpos($s, $find);
	return ($i === false) ? null : substr($s, 0, $i + strlen($find));
}
function _toLast($s, $find) {
	$i = strrpos($s, $find);
	return ($i === false) ? null : substr($s, 0, $i + strlen($find));
}

function _from($s, $find) {
	if ($s == $find) {
		return $s;
	} else {
		$i = strpos($s, $find);
		return ($i === false) ? null : substr($s, $i);
	}
}
function _fromLast($s, $find) {
	if ($s == $find) {
		return $s;
	} else {
		$i = strrpos($s, $find);
		return ($i === false) ? null : substr($s, $i);
	}
}

function _after($s, $find) {
	if ($s == $find) {
		return "";
	} else {
		$i = strpos($s, $find);
		return ($i === false) ? null : substr($s, $i + strlen($find));
	}
}
function _afterLast($s, $find) {
	if ($s == $find) {
		return null;
	} else {
		$i = strrpos($s, $find);
		return ($i === false) ? null : substr($s, $i + strlen($find));
	}
}

function _between($s, $find1, $find2) {
	$s = _after($s, $find1);
	return _isValid($s) ? _before($s, $find2) : null;
}
function _betweenLast($s, $find1, $find2) {
	$s = _beforeLast($s, $find2);
	return _isValid($s) ? _afterLast($s, $find1) : null;
}

/////////////////////////////////////////////

function _replace($s, $from, $to) {
	return str_replace($from, $to, $s);
}
function _remove($s, $find) {
	return _replace($s, $find, "");
}
function _removeExt($s) {
	$file = _beforeLast($s, ".");
	return _isValidString($file) ? $file : $s;
}

/////////////////////////////////////////////

function _pre0($n, $width) {
	$s = "$n";
	$len = strlen($s);
	if ($len >= $width) {
		return $s;
	} else {
		$numOf0s = $width - $len;
		for ($i = 0; $i < $numOf0s; $i++) {
			$s = "0$s";
		}
		return $s;
	}
}
function _pre02($n) {
	return _pre0($n, 2);
}

/////////////////////////////////////////////

function _capitalize($s) {
	return strtoupper($s[0]).substr($s, 1);
}
function _capitalizeAll($s) {
	$arr = explode(" ", $s);
	for ($i = 0, $len = sizeof($arr); $i < $len; $i++) {
		$arr[$i] = _capitalize($arr[$i]);
	}
	return implode(" ", $arr);
}

function _camelize($s) {
	$s = trim($s);
	$s = strtolower($s);
	$s = _replace($s, "-", " ");
	$s = _replace($s, "_", " ");
	$arr = explode(" ", $s);
	$words = array($arr[0]);
	for ($i = 1, $len = sizeof($arr); $i < $len; $i++) {
		$word = $arr[$i];
		if (_isValidString($word)) array_push($words, _capitalize($word));
	}
	return implode("", $words);
}

function _hyphenate($s) {
	if (_isNullString($s)) {
		return $s;
	} else {
		$len = strlen($s);
		if ($len == 1) {
			return strtolower($s);
		} else {
			$res = "";
			$lastChar = null;
			for ($i = 0; $i < $len; $i++) {
				$thisChar = $s[$i];
				if ($i != 0) {
					if (_isUpperCaseAlphabet($thisChar)) {
						if (_isLowerCaseAlphabet($lastChar) || _isNumber($lastChar)) {
							$res .= "-";
						} else if (_isUpperCaseAlphabet($lastChar) && ($i + 1 < $len)) {
							if (_isLowerCaseAlphabet($s[$i + 1])) $res .= "-";
						}
					}
				} else if (_isLowerCaseAlphabet($thisChar) && _isNumber($lastChar)) {
					$res .= "-";
				} else if (_isNumber($thisChar) && _isAlphabet($lastChar)) {
					$res .= "-";
				}
				$res .= strtolower($thisChar);
				$lastChar = $thisChar;
			}
			return $res;
		}
	}
}

//////////////////////////////////////////////////////////////////////////////////////////

function _removeAt($arr, $i) {
	array_splice($arr, $i, 1);
	return $arr;
}

//////////////////////////////////////////////////////////////////////////////////////////

function _getUrls($s) {
	preg_match_all("(https?://[-_.!~*'()a-zA-Z0-9;/?:@&=+$,%#]+)", $s, $res);
	return $res[0];
}

function _getUniqueUrls($s) {
	return _removeDuplicate(_getUrls($s));
}

//////////////////////////////////////////////////////////////////////////////////////////

function _merge($s, $params) {
	foreach ($params as $k => $v) {
		$s = _replace($s, '$'.$k, $v);
	}
	return $s;
}

function _mergeFile($path, $params) {
	return _merge(_cat($path), $params);
}

//////////////////////////////////////////////////////////////////////////////////////////

function _removeDuplicate($arr) {
	$res = array();
	foreach ($arr as $a) {
		if (!in_array($a, $res)) array_push($res, $a);
	}
	return $res;
}

//////////////////////////////////////////////////////////////////////////////////////////

function _now($separator=true) {
	return $separator ? date("Y.m.d H:i:s") : date("YmdHis");
}

function _today($separator="") {
	return date("Y".$separator."m".$separator."d");
}

function _isNowIn($from, $to) {
	$now = time();
	if (_isValid($from) && $now < strtotime($from)) {
		return false;
	} else if (_isValid($to) && strtotime($to) <= $now) {
		return false;
	} else {
		return true;
	}
}

function _getNumOfMonthDays($y, $m) {
	switch ($m) {
		case  1:
		case  3:
		case  5:
		case  7:
		case  8:
		case 10:
		case 12: return 31;
		case  4:
		case  6:
		case  9:
		case 11: return 30;
		case  2: return ($y % 4 == 0) ? 29 : 28;
	}
}

//////////////////////////////////////////////////////////////////////////////////////////

function _ls($path) {
	$res = array();
	$ls = shell_exec("ls ".escapeshellarg($path));
	if (_isNull($ls)) {
		return null;
	} else {
		$ls = trim($ls);
		$files = explode("\n", $ls);
		foreach ($files as $file) {
			if (_isValidString($file)) array_push($res, $file);
		}
		return $res;
	}
}

function _find($dirPath, $cond="") {
	if (_endsWith($dirPath, "/")) $dirPath = substr($dirPath, 0, strlen($dirPath) - 1);
	$dirPath = escapeshellarg($dirPath);
	$find = shell_exec("find $dirPath $cond");
	
	if (_isNull($find)) {
		return null;
	} else {
		$paths = explode("\n", trim($find));
		for ($i = sizeof($paths) - 1; $i >= 0; $i--) {
			if (_endsWith($paths[$i], "/.DS_Store")) $paths = _removeAt($paths, $i);
		}
		return $paths;
	}
}

function _findByName($dirPath, $name="") {
	if (_isValidString($name)) {
		$name = escapeshellarg($name);
		$name = "-name $name";
	}
	return _find($dirPath, $name);
}

/////////////////////////////////////////////

function _read($path) {
	return file_get_contents($path);
}

function _cat($path) {
	if (_isWindows()) {
		return _read($path);
	} else {
		$path = escapeshellarg($path);
		return shell_exec("cat $path");
	}
}

function _catLines($path) {
	$cat = _cat($path);
	return explode("\n", trim($cat));
}

function _catJson($path) {
	$cat = _cat($path);
	return _isNullString($cat) ? array() : json_decode($cat, true);
}

function _writeBig($path, $v) {
	$file = fopen($path, "w");
	if ($file) {
		if (flock($file, LOCK_EX)) {
			if (fwrite($file, $v) === false) {
				return 'Failed to write to the file: fwrite($file, $v)';
			}
		} else {
			return 'Failed to lock the file: flock($file, LOCK_EX)';
		}
	} else {
		return "Failed to open the file: fopen($path, \"w\")";
	}
	if (fclose($file)) {
		// Succeeded
		return null;
	} else {
		return 'Failed to close the file: fclose($file)';
	}
}

function _append($path, $s) {
	return file_put_contents($path, $s.PHP_EOL, (FILE_APPEND | LOCK_EX));
}

//////////////////////////////////////////////////////////////////////////////////////////

function _url($url=null) {
	if (_isNull($url)) $url = $_SERVER["REQUEST_URI"];
	
	$res = array(
		"query"=>array(),
	);
	
	$urlWithoutQuery = $url;
	
	if (_contains($url, "?")) {
		$indexOfQuestion = strpos($url, "?");
		$urlWithoutQuery = substr($url, 0, $indexOfQuestion);
		$query = substr($url, $indexOfQuestion + 1);
		
		$arr = explode("&", $query);
		foreach ($arr as $kv) {
			$index = strpos($kv, "=");
			$key = substr($kv, 0, $index);
			$value = substr($kv, $index + 1);
			$res["query"][$key] = $value;
		}
	}
	
	$res["path"] = $urlWithoutQuery;
	
	$res["paths"] = explode("/", $urlWithoutQuery);
	array_shift($res["paths"]);
	
	return $res;
}

function _redirect($url) {
	header("Location: $url", true, 301);
	exit;
}

//////////////////////////////////////////////////////////////////////////////////////////

function _getGetParams($params) {
	$arr = array();
	foreach ($params as $key => $value) {
		array_push($arr, "$key=".urlencode($value));
	}
	return implode("&", $arr);
}

/*
function _curl($url, $params=null, $header="") {
	if (_isValid($params) && sizeof($params) != 0) $url = '"'.$url."?"._getGetParams($params).'"';
	if (_isValidString($header)) $header = '-H"'.$header.'"';
	return shell_exec("curl $header $url");
}
*/
function _curl($url, $params=null, $header="") {
	if (_isValid($params) && sizeof($params) != 0) $url = $url."?"._getGetParams($params);
	
	$options = array(
		CURLOPT_RETURNTRANSFER=>true,
	);
	
	if (_isValidString($header)) $options[CURLOPT_HTTPHEADER] = array($header);
	
	$curl = curl_init($url);
	curl_setopt_array($curl, $options);
	
	$data = curl_exec($curl);
	$status = curl_errno($curl);
	
	curl_close($curl);
	
	return $data;
}
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

function _curlGet($url) {
	$options = array(
		CURLOPT_RETURNTRANSFER=>true,
	);
	
	if (_contains($url, "nakatahanger.myshopify.com") && _contains($url, "api")) {
		$options[CURLOPT_SSL_VERIFYPEER] = false;	// 2023.01.19 追加：なぜか下記 curl_errno() の結果が 60 (SSL certificate problem) になるようになってしまった。この（証明書の検証を無効にする）ヘッダーを追加することで解決した。でも証明書の検証を無効にしてよいの？
	} 
	
	$curl = curl_init($url);
	curl_setopt_array($curl, $options);
	
	$data = curl_exec($curl);
	$status = curl_errno($curl);
	
	curl_close($curl);
	
	return array(
		"status"=>$status,
		"ok"=>($status === CURLE_OK),
		"data"=>$data,
	);
}

//////////////////////////////////////////////////////////////////////////////////////////

function _isWindows() {
	return (PHP_OS === "WIN32" || PHP_OS === "WINNT");
}

//////////////////////////////////////////////////////////////////////////////////////////

function _getMySqlConn($host, $port, $user, $pass, $db) {
	$conn = mysqli_init();
	if (mysqli_real_connect($conn, $host, $user, $pass, $db, $port)) {
		mysqli_query($conn, "SET NAMES UTF8");
		return $conn;
	} else {
		echo "FAILED: _getMySqlConn()";
	}
}

function _mySql($conn, $sql) {
	return mysqli_query($conn, $sql);
}

//////////////////////////////////////////////////////////////////////////////////////////

?>