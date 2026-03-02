<?php

//////////////////////////////////////////////////////////////////////////////////////////

//define("GRAD_HANGER_WIDTH_CM_MAN", 42);
//define("GRAD_HANGER_WIDTH_CM_WOMAN", 38);

define("PRICE_SILK_PLATE", 6000);
define("PRICE_INDIVIDUAL_NAME", 500);
define("PRICE_NOSHI", 150);

//define("TAX_GRADUATION_HANGER", 8);
define("TAX_GRADUATION_HANGER", 10);

define("MIN_NUM_OF_HANGERS_FOR_REGULAR_PRICE", 20);
define("MIN_NUM_OF_HANGERS_FOR_EARLY_DISCOUNT", 20);
define("MIN_NUM_OF_HANGERS_FOR_FREE_SILK_PLATE", 20);
define("UNIT_PRICE_INCREASE_FOR_SMALL_AMOUNT", 500);
define("REDUCTION_BY_AIRCAP_FOR_REGULAR_PRICE", 100);
define("REDUCTION_BY_AIRCAP_FOR_EARLY_DISCOUNT", 50);

define("CASE_TYPE", "c");

//define("URL_DOWNLOAD_EXCEL", "http://".IP_MY_PC.":8080/Proc_20190521/api/nh/grad/estimate/excel");
define("URL_DOWNLOAD_EXCEL", "http://".IP_WORKS_SERVER.":8080/Proc_20190521/api/nh/grad/estimate/excel");

//define("URL_DOWNLOAD_EXCEL_OFFICE", "http://".IP_MY_PC.":8080/Proc_20190521/api/nh/grad/estimate/excel/office");
define("URL_DOWNLOAD_EXCEL_OFFICE", "http://".IP_WORKS_SERVER.":8080/Proc_20190521/api/nh/grad/estimate/excel/office");
//define("URL_DOWNLOAD_EXCEL_OFFICE", "http://ec2-18-179-37-167.ap-northeast-1.compute.amazonaws.com/Proc_20190521/api/nh/grad/estimate/excel/office");

//define("URL_DOWNLOAD_EXCEL_PUBLIC", "http://".IP_MY_PC.":8080/Proc_20190521/api/nh/grad/estimate/excel/public");
define("URL_DOWNLOAD_EXCEL_PUBLIC", "http://ec2-18-179-37-167.ap-northeast-1.compute.amazonaws.com/Proc_20190521/api/nh/grad/estimate/excel/public_20230421");

define("GRAD_ESTIMATE_FILE_NAME_FORMAT", "お見積書（{school}）{date}.xlsx");

//////////////////////////////////////////////////////////////////////////////////////////

define("EMAIL_CSS_FONT_SIZE", "13px");
define("EMAIL_CSS_BG_COLOR", "#f2f2f2");	/* fafafa f0f0f0 f1f1f1 */
define("EMAIL_CSS_BORDER_COLOR", "#dadada");	/* dadada */

define("EMAIL_CSS_TH_BIG", "padding:5px 0 4px 0; font-size:".EMAIL_CSS_FONT_SIZE."; color:#444; border:1px solid ".EMAIL_CSS_BORDER_COLOR."; background-color:".EMAIL_CSS_BG_COLOR."; text-align:center; white-space:nowrap;");
define("EMAIL_CSS_TH", "padding:5px 11px 4px 12px; font-size:".EMAIL_CSS_FONT_SIZE."; font-weight:normal; border:1px solid ".EMAIL_CSS_BORDER_COLOR."; background-color:".EMAIL_CSS_BG_COLOR."; text-align:left; white-space:nowrap;");
define("EMAIL_CSS_TD", "padding:5px 14px 4px 12px; max-width:500px; font-size:".EMAIL_CSS_FONT_SIZE."; border:1px solid ".EMAIL_CSS_BORDER_COLOR.";");

//////////////////////////////////////////////////////////////////////////////////////////

define("GRAD_MAIN_IMAGE_PC", "grad-top-pc.jpg");
define("GRAD_MAIN_IMAGE_SP", "grad-top-sp.jpg");

define("GRAD_MENU_INIT_TOP_PC", 719);
define("GRAD_MENU_INIT_TOP_SP", 380);
define("GRAD_MENU_MIN_TOP_PC", 53);
define("GRAD_MENU_MIN_TOP_SP", 53);

//////////////////////////////////////////////////////////////////////////////////////////

$products = array(
	"sk-01"=>array(
		"open"=>true,
		"excel"=>true,
		"name"=>"SK-01N",
		"price"=>array(
			"early"=>array(
				"price"=>1850,
				"taxed"=>true,
			),
			"regular"=>array(
				"price"=>1900,
				"taxed"=>true,
			),
			"original"=>array(
				"price"=>3850,
				"taxed"=>true,
			),
		),
		"size"=>array(
			"width"=>400,
			"thickness"=>40,
		),
		"parts"=>"ー",
		"color"=>array(
			"body"=>"ナチュラル",
			"emblem"=>"ブラウン",
		),
	),
	"sk-02"=>array(
		"open"=>true,
		"excel"=>true,
		"name"=>array(
			"feltbar"=>"SK-02F",
			"clip"=>"SK-02C",
//			"feltbar"=>"SK-02M",
//			"clip"=>"SK-02W",
		),
		"price"=>array(
			"early"=>array(
				"price"=>2200,
				"taxed"=>true,
			),
			"regular"=>array(
				"price"=>2300,
				"taxed"=>true,
			),
			"original"=>array(
				"price"=>4400,
				"taxed"=>true,
			),
		),
		"size"=>array(
			"width"=>400,
//			"width"=>array(
//				"man"=>420,
//				"woman"=>380,
//			),
			"thickness"=>40,
		),
		"counts"=>array(
			"feltbar"=>"フェルトバー",
			"clip"=>"クリップ",
		),
		"parts"=>array(
			"feltbar"=>"フェルトバー",
			"clip"=>"クリップ",
		),
		"color"=>array(
			"body"=>"ナチュラル",
			"emblem"=>"ブラウン",
		),
	),
	"sk-03"=>array(
		"open"=>true,
		"excel"=>true,
		"name"=>array(
			"man"=>"SK-03M",
			"woman"=>"SK-03W",
		),
		"price"=>array(
			"early"=>array(
				"price"=>2600,
				"taxed"=>true,
			),
			"regular"=>array(
				"price"=>2750,
				"taxed"=>true,
			),
			"original"=>array(
				"price"=>4400,
				"taxed"=>true,
			),
		),
		"size"=>array(
			"width"=>array(
				"man"=>420,
				"woman"=>380,
			),
			"thickness"=>40,
		),
		"parts"=>array(
			"man"=>"フェルトバー",
			"woman"=>"クリップ",
		),
		"color"=>array(
			"body"=>array(
				"man"=>"チョコレート",
				"woman"=>"ワインレッド",
			),
			"emblem"=>"シルバー",
		),
	),
	"sk-04"=>array(
		"open"=>false,
		"excel"=>true,
		"price"=>array(
			"regular"=>array(
				"price"=>1500,
				"taxed"=>false,
			),
		),
		"size"=>array(
			"width"=>array(
				"man"=>420,
				"woman"=>380,
			),
			"thickness"=>20,
		),
		"parts"=>"ー",
		"color"=>array(
			"body"=>"ナチュラル",
			"emblem"=>"ブラウン",
		),
	),
	"sk-05"=>array(
		"open"=>false,
		"excel"=>true,
		"price"=>array(
			"regular"=>array(
				"price"=>1700,
				"taxed"=>false,
			),
		),
		"size"=>array(
			"width"=>array(
				"man"=>420,
				"woman"=>380,
			),
			"thickness"=>20,
		),
		"parts"=>array(
			"man"=>"フェルトバー",
			"woman"=>"クリップ",
		),
		"color"=>array(
			"body"=>"ナチュラル",
			"emblem"=>"ブラウン",
		),
	),
/*	"sk-12"=>array(
		"open"=>true,
		"excel"=>false,
		"price"=>array(
			"regular"=>array(
				"price"=>1800,
				"taxed"=>true,
			),
			"original"=>array(
				"price"=>4400,
				"taxed"=>true,
			),
		),
		"parts"=>array(
			"woman"=>"クリップ",
		),
		"color"=>array(
			"woman"=>"ナチュラル",
		),
	),
	"sk-13"=>array(
		"open"=>true,
		"excel"=>false,
		"price"=>array(
			"regular"=>array(
				"price"=>2000,
				"taxed"=>true,
			),
			"original"=>array(
				"price"=>4400,
				"taxed"=>true,
			),
		),
		"parts"=>array(
			"woman"=>"クリップ",
		),
		"color"=>array(
			"woman"=>"スモークブラウン",
		),
	),*/
);

$ritsus = array("国立", "都立", "道立", "府立", "県立", "区立", "市立", "町立", "郡立", "村立", "私立");

//////////////////////////////////////////////////////////////////////////////////////////

$personLabels = array(
	"student"=>array(
		"man"=>"男子用",
		"woman"=>"女子用",
	),
	"teacher"=>array(
		"man"=>"先生男性用",
		"woman"=>"先生女性用",
	),
);
/*
$personLabels = array(
//	"man"=>"男子・先生男性",
//	"woman"=>"女子・先生女性",
	"man"=>"男子",
	"woman"=>"女子",
);
*/

//////////////////////////////////////////////////////////////////////////////////////////

define("GRAD_OTHERS_VALUE", 99);

$gradPublicLabels = array(
	"personTypes"=>$personLabels,
	"customerInfo"=>"お客様情報",
	"schoolName"=>"学校名",
	"schoolAddress"=>"学校ご住所",
	"postalCode"=>"郵便番号",
	"prefecture"=>"都道府県",
	"cityStreet"=>"市区町村・番地",
	"customerName"=>"ご担当者様 ご氏名",
	"name"=>"ご氏名",
	"hurigana"=>"ふりがな",
	"customerContact"=>"ご担当者様 ご連絡先",
	"email"=>"メールアドレス",
	"tel"=>"電話番号",
	"estimateContents"=>"お見積もり内容",
	"product"=>"商品",
	"counts"=>"予定本数",
	"priceType"=>"早割希望",
	"firstTime"=>"貴校での弊社卒業記念ハンガーのご利用は初めてですか？",
	"noshi"=>"熨斗シール",
	"useDate"=>"記念品の使用予定日",
	"deliveryDate"=>"納品のご希望日",
	"notes"=>"その他",
	"requestsQuestions"=>"ご要望やご質問がありましたらお知らせください",
	"questions"=>"アンケート",
	"howInformed"=>"卒業記念ハンガーをどちらで知りましたか？",
	"otherProducts"=>"ハンガー以外にご検討されている記念品はございますか？",
	"priority"=>"卒業記念品を選ぶ際は何を優先されますか？",
	
	"sendingAddress"=>"お届け先ご住所",
);

$productAdditionalOptions = array(
//	"another"=>"その他",
//	"undecided"=>"まだ決まっていない",
	"anotherUndecided"=>"その他・まだ決まっていない",
);

$priceType = array(
	"early"=>"早割見積もりを希望する",
	"regular"=>"通常見積もりを希望する",
	"both"=>"両方希望する",
);

$firstTime = array(
	"true"=>"初めて",
	"false"=>"利用したことがある",
	"dont-know"=>"わからない",
);

$questionHowInformed = array(
	"1"=>"前任者からのご紹介",
	"2"=>"他校のお知り合いからのご紹介",
	"3"=>"届いたカタログを見て",
	strval(GRAD_OTHERS_VALUE)=>"その他",
);

$questionPriority = array(
	"1"=>"商品価値・品質",
	"2"=>"価格",
	"3"=>"実用性",
	"4"=>"長く使えるもの",
	"5"=>"校章が入れられるもの",
	"6"=>"思い出に残るもの",
	"7"=>"子どもが喜ぶもの",
	"8"=>"親として渡したいもの",
	strval(GRAD_OTHERS_VALUE)=>"その他",
);

//////////////////////////////////////////////////////////////////////////////////////////

?>