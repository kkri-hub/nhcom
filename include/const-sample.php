<?php
//////////////////////////////////////////////////////////////////////////////////////////

define("EMAIL_CSS_FONT_SIZE", "13px");
define("EMAIL_CSS_BG_COLOR", "#f2f2f2");	/* fafafa f0f0f0 f1f1f1 */
define("EMAIL_CSS_BORDER_COLOR", "#dadada");	/* dadada */

define("EMAIL_CSS_TH_BIG", "padding:5px 0 4px 0; font-size:".EMAIL_CSS_FONT_SIZE."; color:#444; border:1px solid ".EMAIL_CSS_BORDER_COLOR."; background-color:".EMAIL_CSS_BG_COLOR."; text-align:center; white-space:nowrap;");
define("EMAIL_CSS_TH", "padding:5px 11px 4px 12px; font-size:".EMAIL_CSS_FONT_SIZE."; font-weight:normal; border:1px solid ".EMAIL_CSS_BORDER_COLOR."; background-color:".EMAIL_CSS_BG_COLOR."; text-align:left; white-space:nowrap;");
define("EMAIL_CSS_TD", "padding:5px 14px 4px 12px; max-width:500px; font-size:".EMAIL_CSS_FONT_SIZE."; border:1px solid ".EMAIL_CSS_BORDER_COLOR.";");

//////////////////////////////////////////////////////////////////////////////////////////

$sampleProducts = array(
	"mensJacket"=>array(
		"label"=>"メンズ スーツ / ジャケット",
		"pids"=>array(69751619, 69751624, 69751621, 69751626, 96123271, 69751649)
	),
	"mensShirt"=>array(
		"label"=>"メンズ シャツ",
		"pids"=>array(69751635, 69751651)
	),
	"bottom"=>array(
		"label"=>"メンズ / レディス ボトム",
		"pids"=>array(117013816, 117013564, 69751637, 69751638, 69751661)
	),
	"womensJacket"=>array(
		"label"=>"レディス スーツ / ジャケット",
		"pids"=>array(133173269, 69751643, 69751652, 145077476)
	),
	"womensShirt"=>array(
		"label"=>"レディス シャツ",
		"pids"=>array(133173633, 69751656)
	),
);

//////////////////////////////////////////////////////////////////////////////////////////

define("SAMPLE_OTHERS_VALUE", 99);

$sampleLabels = array(
	"sample"=>"サンプル貸出",
	"customerName"=>"ご氏名",
	"name"=>"姓名",
	"hurigana"=>"ふりがな",
	"customerContact"=>"ご連絡先",
	"email"=>"メールアドレス",
	"tel"=>"電話番号",
	"address"=>"ご住所",
	"postalCode"=>"郵便番号",
	"prefecture"=>"都道府県",
	"cityStreet"=>"市区町村・番地",
	"product"=>"貸出希望商品",
	"howInformed"=>"NAKATA HANGER をどちらでお知りになりましたか？",
	"wantToCheck"=>"サンプルハンガーでお確かめになりたいことを教えてください",
//	"favoriteSns"=>"よくお使いになる SNS を教えてください",
//	"favoriteAccount"=>"Instagram や YouTube でフォロー（チャンネル登録）している中で、特に好きなアカウントがあれば教えてください",
	"favoriteBrand"=>"好きな洋服ブランドがあれば教えてください",
	"notes"=>"その他",
	"questions"=>"アンケート",
	"requestsQuestions"=>"ご要望やご質問がありましたらお知らせください",
);

$questionHowInformed = array(
//	"1"=>"SNS",
	"6"=>"Instagram",
	"7"=>"Twitter",
	"8"=>"Facebook",
	"9"=>"LINE",
	"2"=>"百貨店",
	"3"=>"雑誌",
	"4"=>"ギフトでもらったことがある",
	"5"=>"TV 番組",
	strval(SAMPLE_OTHERS_VALUE)=>"その他",
);

$questionWantToCheck = array(
	"1"=>"サイズ",
	"2"=>"重量",
	"3"=>"質感",
	"4"=>"色味",
	strval(SAMPLE_OTHERS_VALUE)=>"その他",
);

/*
$questionFavoriteSns = array(
	"1"=>"Twitter",
	"2"=>"Facebook",
	"3"=>"LINE",
	"4"=>"Instagram",
	"5"=>"YouTube",
	"6"=>"TikTok",
	strval(SAMPLE_OTHERS_VALUE)=>"その他",
);
*/
//////////////////////////////////////////////////////////////////////////////////////////
?>