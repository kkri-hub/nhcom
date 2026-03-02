<?php
//////////////////////////////////////////////////////////////////////////////////////////

define("ORG_MAIN_IMAGE_PC", "organization-top-pc.jpg");
define("ORG_MAIN_IMAGE_SP", "organization-top-sp.jpg");

define("ORG_MENU_INIT_TOP_PC", 648);
define("ORG_MENU_INIT_TOP_SP", 335);
define("ORG_MENU_MIN_TOP_PC", 53);
define("ORG_MENU_MIN_TOP_SP", 53);

define("ORG_LIGHT_GRAY", "#f7f8f9");

define("ORG_OTHERS_VALUE", 99);

//////////////////////////////////////////////////////////////////////////////////////////

$orgMenu = array(
	"organization"=>"ホーム",
	"products"=>"商品イメージ",
	"logo"=>"ロゴ・名入れサービス",
	"faq"=>"よくあるご質問",
	"steps"=>"ご注文の流れ",
	"cases"=>"納品事例",
);

//////////////////////////////////////////////////////////////////////////////////////////

define("EMAIL_CSS_FONT_SIZE", "13px");
define("EMAIL_CSS_BG_COLOR", "#f2f2f2");	/* fafafa f0f0f0 f1f1f1 */
define("EMAIL_CSS_BORDER_COLOR", "#dadada");	/* dadada */

define("EMAIL_CSS_TH_BIG", "padding:5px 0 4px 0; font-size:".EMAIL_CSS_FONT_SIZE."; color:#444; border:1px solid ".EMAIL_CSS_BORDER_COLOR."; background-color:".EMAIL_CSS_BG_COLOR."; text-align:center; white-space:nowrap;");
define("EMAIL_CSS_TH", "padding:5px 11px 4px 12px; max-width:125px; font-size:".EMAIL_CSS_FONT_SIZE."; font-weight:normal; border:1px solid ".EMAIL_CSS_BORDER_COLOR."; background-color:".EMAIL_CSS_BG_COLOR."; text-align:left;");
define("EMAIL_CSS_TD", "padding:5px 14px 4px 12px; max-width:500px; font-size:".EMAIL_CSS_FONT_SIZE."; border:1px solid ".EMAIL_CSS_BORDER_COLOR.";");

//////////////////////////////////////////////////////////////////////////////////////////

$form = array(
	"customerInfo"=>array(
		"label"=>"お客様情報",
		"inputs"=>array(
			"orgName"=>array("label"=>"法人名・団体名"),
			"department"=>array("label"=>"部署名"),
			"customerName"=>array("label"=>"ご担当者様 ご氏名"),
			"contact"=>array(
				"label"=>"ご担当者様 ご連絡先",
				"inputs"=>array(
					"email"=>array("label"=>"メールアドレス"),
					"tel"=>array("label"=>"電話番号"),
				),
			),
		),
	),
	"inquiry"=>array(
		"label"=>"お問い合わせ内容",
		"inputs"=>array(
			"budget"=>array("label"=>"ご予算"),
			"quantity"=>array("label"=>"数量"),
			"use"=>array("label"=>"用途"),
			"logoName"=>array(
				"label"=>"ロゴ・名入れ",
				"options"=>array(
					"yes"=>"希望する",
					"no"=>"不要",
				),
			),
			"deliveryDate"=>array("label"=>"ご希望納期"),
			"request"=>array("label"=>"ご質問・ご要望など"),
		),
	),
	"questions"=>array(
		"label"=>"その他",
		"inputs"=>array(
			"howInformed"=>array(
				"label"=>"NAKATA HANGER を知ったきっかけを教えてください",
				"options"=>array(
					"self"=>"ご自身が以前購入したから",
					"gift"=>"ギフトでもらったから",
					"internet"=>"インターネット検索",
					"sns_media"=>"SNS、メディア",
					"store"=>"店舗で知った",
					"other"=>"その他",
				),
			),
			"otherProducts"=>array("label"=>"他に検討している商品がありましたら参考までに教えてください"),
		),
	),
);

//////////////////////////////////////////////////////////////////////////////////////////
?>