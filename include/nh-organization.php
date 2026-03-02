<?php
//////////////////////////////////////////////////////////////////////////////////////////

function getOrgTitle() {
	global $orgMenu;
	
	$res = getTxt("forOrgTitle");
	
	$paths = explode("/", $_SERVER["REQUEST_URI"]);
	if (in_array("inquiry", $paths)) {
		$res = getTxt("inquiry")." | $res";
	} else {
		$last = $paths[sizeof($paths) - 2];
		if ($last != "organization") $res = $orgMenu[$last]." | $res";
	}
	
	return $res;
}

//////////////////////////////////////////////////////////////////////////////////////////

function echoOrgCss() {
	echo	"<style>".
//				getFontFamilyStyle("hannari-mincho").
				"@media only screen and (min-width:".MIN_PC_VIEW_WIDTH."px) {\n".
					"\t#top .main-image {\n".
						"\t\tbackground-image: url('".getImg(ORG_MAIN_IMAGE_PC)."');\n".
					"\t}\n".
					"\t#org-menu {\n".
						"\t\ttop: ".ORG_MENU_INIT_TOP_PC."px;\n".
					"\t}\n".
					"\t#org-menu[fixed-top='false'] {\n".
						"\t\ttop: ".ORG_MENU_INIT_TOP_PC."px !important;\n".
					"\t}\n".
					"\t#links .message .text {\n".
						"\tbackground-color: ".ORG_LIGHT_GRAY.";\n".
					"\t}\n".
				"}\n".
				"@media only screen and (max-width:".MAX_SP_VIEW_WIDTH."px) {\n".
					"\t#top .main-image {\n".
						"\t\tbackground-image: url('".getImg(ORG_MAIN_IMAGE_SP)."');\n".
					"\t}\n".
					"\t#org-menu {\n".
						"\t\ttop: ".ORG_MENU_INIT_TOP_SP."px;\n".
					"\t}\n".
					"\t#org-menu[fixed-top='false'] {\n".
						"\t\ttop: ".ORG_MENU_INIT_TOP_SP."px !important;\n".
					"\t}\n".
					"\t#links .message {\n".
						"\tbackground-color: ".ORG_LIGHT_GRAY.";\n".
					"\t}\n".
				"}\n".
			"</style>";
}

/*
function echoGradOnLoad($isMenuFixed=true) {
	if ($isMenuFixed) {
		echo	"nh.grad.init(".
					"'grad-menu', ".
					GRAD_MENU_INIT_TOP_PC.", ".
					GRAD_MENU_INIT_TOP_SP.", ".
					GRAD_MENU_MIN_TOP_PC.", ".
					GRAD_MENU_MIN_TOP_SP.
				");";
	} else {
		echo "_.id('grad-menu').removeAttribute('scroll');";
		echo "_.id('grad-menu').style.opacity = 1;";
	}
}
*/
function echoOrgOnLoad($isMenuFixed=true) {
	if ($isMenuFixed) {
		echo	"nh.org.init(".
					"'org-menu', ".
					ORG_MENU_INIT_TOP_PC.", ".
					ORG_MENU_INIT_TOP_SP.", ".
					ORG_MENU_MIN_TOP_PC.", ".
					ORG_MENU_MIN_TOP_SP.
				");\n";
	} else {
		echo "_.id('org-menu').removeAttribute('scroll');";
		echo "_.id('org-menu').style.opacity = 1;";
	}
}

//////////////////////////////////////////////////////////////////////////////////////////

function echoOrgTop() {
	global $orgMenu;
	
	$url = _url();
	$lastPath = $url["paths"][sizeof($url["paths"]) - 2];
	
	$menuHtml = "";
	foreach ($orgMenu as $url => $label) {
		$selected = ($url == $lastPath) ? "selected" : "";
		
		if (_isValidString($menuHtml)) {
			$url = "organization_$url";
			$menuHtml .=	"<li>".
								"<span device='pc'>／</span>".
								"<span device='sp'>/</span>".
							"</li>";
		}
		
		$menuHtml .=	"<li $selected>".
							"<a href='".getHref($url)."' nh-red-border>$label</a>".
						"</li>";
	}
	
	echo	"<section id='top' nh-margin='header' nh-font='1'>".
				"<div class='main-image' nh-image='1' header-view='bottom'>".
					"<div class='content-area-container'>".
						"<div class='content-area' nh-content-sp='padding'>".
							"<div class='texts'>".
								"<div class='top'>ふくをかける</div>".
								"<h1>".getTxt("forOrg")."</h1>".
								"<p>熟練の職人が一本一本心を込めて<br>「感謝」の想いを形に致します。</p>".
							"</div>".
							"<div class='buttons'>".
								"<div class='button'><a href='".getHref("organization_inquiry")."' nh-button nh-red-bg><span>".getTxt("inquiry")."</span></a></div>".
							"</div>".
						"</div>".
					"</div>".
				"</div>".
			"</section>".
			"<div id='org-menu' nh-gray fixed='false' scroll='up'>".
				"<ul>".
					$menuHtml.
				"</ul>".
			"</div>";
}

function echoOrgFooter() {
	global $orgMenu;
	
	echo	"<section id='links'>".
				"<div class='content-area-container'>".
					"<div class='content-area'>".
						"<div><h2 nh-font='1'>お問い合わせ</h2></div>".
						"<div class='desc' nh-font='1' nh-gray-border='4'>お気軽にご連絡ください</div>".
						"<div class='message' nh-content-sp='padding'>".
							"<div class='image'><img src='".getImg("organization-footer.jpg")."'></div>".
							"<div class='text'>ご予算や納期、使用用途など、各企業様のご要望に合わせて、営業担当者が最適なハンガーをご提案いたします。訪問でのヒアリングや、オンライン商談、またはNAKATA HANGER東京青山ショールームでのお打ち合わせも可能です。まずは、お電話または下記お問い合わせボタンよりお気軽にお問い合わせください。</div>".
						"</div>".
						"<div class='buttons' nh-content-sp='padding'>".
							"<div column='2'>".
								"<a href='".getHref("organization_inquiry")."' nh-button nh-font='default'>".getTxt("inquiry")."</a>".
								"<a href='tel:"._remove(TEL_SHOWROOM, "-")."'' nh-button nh-font='default'>お電話&nbsp; ".TEL_SHOWROOM."</a>".
							"</div>".
							"<div column='1'>".
								"<a href='".getHref(URL_ORGANIZATION_FAQ)."' nh-button nh-font='default'>".$orgMenu["faq"]."</a>".
							"</div>".
						"</div>".
						"<div class='links' nh-content-sp='padding'>".
							"<div class='link'><a href='".getHref(URL_ORGANIZATION)."'>".getTxt("forOrg")." ホームへ戻る</a></div>".
						"</div>".
					"</div>".
				"</div>".
			"</section>";
}

//////////////////////////////////////////////////////////////////////////////////////////
?>