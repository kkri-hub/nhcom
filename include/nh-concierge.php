<?php

//////////////////////////////////////////////////////////////////////////////////////////

define("FORM_NAME", "お問い合わせ");

define("NUM_OF_DATETIMES", 3);

//////////////////////////////////////////////////////////////////////////////////////////

/*
$form = array(
	"price"=>array(
		"label"=>"料金コース選択",
		"label_email"=>"料金コース",
		"options"=>array(
			"5"=>"5万円〜コース ※約20本",
			"10"=>"10万円〜コース ※約40本",
			"15"=>"15万円〜コース ※約60本",
		),
	),
	"course"=>array(
		"label"=>"コース選択",
		"label_email"=>"コース",
		"options"=>array(
			"luxury"=>"ラグジュアリー",
			"classic"=>"シック",
			"natural"=>"ナチュラル",
			"another"=>"その他",
		),
	),
	"jacket_size"=>array(
		"label"=>"ジャケットサイズ選択",
		"label_email"=>"ジャケットサイズ",
		"options"=>array(360, 380, 400, 430, 460, 480, 500, 520),
		"default"=>460,
		"option_label"=>"肩幅 * mm",
	),
	"showroom"=>array(
		"label"=>"来店希望",
		"label_email"=>"来店",
		"options"=>array(
			"true"=>"希望する",
			"false"=>"希望しない",
		),
	),
	"name"=>array("label"=>"お名前"),
	"address"=>array("label"=>"住所（都道府県のみ）"),
	"email"=>array("label"=>"メールアドレス"),
	"tel"=>array("label"=>"TEL"),
);
*/

$form = array(
	"hanger_type"=>array(
		"label"=>"ご相談ハンガーの種類",
		"options"=>array(
			"outer"=>"コート、アウター用",
			"suit"=>"スーツ用",
			"jacket"=>"ジャケット用",
			"shirt"=>"シャツ用",
			"bottom"=>"ボトム用",
			"other"=>"その他",
		),
	),
	"inquiry_type"=>array(
		"label"=>"ご相談内容",
		"options"=>array(
			"inquiry"=>"問合せ",
			"estimate"=>"見積り依頼",
		),
	),
	"how_informed"=>array(
		"label"=>"NAKATA HANGER コンシェルジュを知ったきっかけ",
		"options"=>array(
			"concierge"=>"以前から NAKATA HANGER コンシェルジュを利用していて",
			"nhcom"=>"NAKATA HANGER 公式通販サイト",
			"instagram"=>"Instagram",
			"twitter"=>"Twitter",
			"facebook"=>"Facebook",
			"friend"=>"友人や知人から",
			"search"=>"インターネット検索",
			"other"=>"その他",
		),
	),
	"inquiry_reason"=>array(
		"label"=>"ご相談のきっかけ",
		"options"=>array(
			"new_house"=>"新築",
			"move"=>"お引越し",
			"change_clothes"=>"衣替え",
			"hanger_size"=>"ハンガーのサイズが気になる",
			"hanger_color_shape"=>"ハンガーの色、形が気になる",
			"other"=>"その他",
		),
	),
	"clothes_size"=>array(
		"label"=>"普段のお洋服のサイズ",
		"options"=>array(
			"man"=>array(
				"label"=>"メンズ",
				"options"=>array(
					"s"=>"S",
					"m"=>"M",
					"l"=>"L",
					"xl"=>"XL",
				),
			),
			"woman"=>array(
				"label"=>"レディース",
				"options"=>array(
					"xs"=>"XS",
					"s"=>"S",
					"m"=>"M",
					"l"=>"L",
				),
			),
			"other"=>array("label"=>"その他"),
		),
	),
	"budget"=>array("label"=>"ご予算"),
	"quantity"=>array(
		"label"=>"ご検討本数",
		"options"=>array(
			"5"=>"5 本",
			"10"=>"10 本",
			"15"=>"15 本",
			"20"=>"20 本",
			"25"=>"25 本",
			"30"=>"30 本",
			"35"=>"35 本",
			"40"=>"40 本",
			"45"=>"45 本",
			"50"=>"50 本 以上",
		),
	),
	"method"=>array(
		"label"=>"ご相談方法",
		"options"=>array(
			"message"=>"メール もしくは LINE",
			"online"=>"オンライン接客を希望（Zoom、LINE、Skype など）",
			"showroom"=>"来店を希望",
		),
	),
	"name"=>array("label"=>"お名前"),
	"email"=>array("label"=>"メールアドレス"),
	"tel"=>array("label"=>"電話番号"),
	"note"=>array("label"=>"その他"),
);

//////////////////////////////////////////////////////////////////////////////////////////
/*
function getJacketLabel($n) {
	global $form;
	return _replace($form["jacket_size"]["option_label"], "*", $n);
}
function echoJacketLabel($n) {
	echo getJacketLabel($n);
}
*/

function getMethodTimeLabel($hour) {
	return "$hour:00 ~";
}

//////////////////////////////////////////////////////////////////////////////////////////

?>