<?php

define("MAX_NUM_OF_ZIGZAG", 8);
define("MAX_NUM_OF_COLUMNS", 4);

//////////////////////////////////////////////////////////////////////////////////////////

function echoBottomColumn($n, $customTexts) {
	$imageExists = imageExists($customTexts["IMAGE-2-$n"][0]);
	$hasImage = $imageExists ? "true" : "false";
	echo	"<div class='column' has-image='$hasImage'>".
				($imageExists ? "<div class='image' style='background-image:url(\"".cgetImg("IMAGE-2-$n")."');\"></div>" : "").
				"<div class='text'>".
					"<div class='title' nh-gray-border='4'>".cgetText("TITLE-2-$n")."</div>".
					"<div class='body'>".cgetText("TEXT-2-$n")."</div>".
				"</div>".
			"</div>";
}

//////////////////////////////////////////////////////////////////////////////////////////
?>

<?php
for ($n = 0; $n <= MAX_NUM_OF_ZIGZAG; $n++) {
	$postfix = ($n == 0) ? "" : "-$n";
	if (array_key_exists("TITLE-1$postfix", $customTexts)) {
		$videoExists = (array_key_exists("VIDEO-1$postfix", $customTexts) && videoExists($customTexts["VIDEO-1$postfix"][0]));
		if ($videoExists) {
			$thumbnail = array_key_exists("VIDEO-1".$postfix."-THUMBNAIL", $customTexts) ? "poster='".cgetImg("VIDEO-1".$postfix."-THUMBNAIL")."'" : "";
			
			echo	"<div class='top' has-video='true' loaded-video='false'>".
						"<div class='video' playing='false' nh-content-sp='padding'>".
							"<video src='".cgetVideo("VIDEO-1$postfix")."' playsinline muted $thumbnail onloadedmetadata='cms.detail.onLoadVideo(this);' onplay='nh.video.onPlay(this);' onpause='nh.video.onPause(this);'></video>".
							"<div class='icon' onclick='nh.video.onClick(this);'>".
								"<img src='".getImg("play-64.png")."'>".
							"</div>".
						"</div>".
						"<div class='text' nh-content-sp='padding'>".
							"<div class='title'>".cgetText("TITLE-1$postfix")."</div>".
							"<div class='desc'>".cgetText("TEXT-1$postfix")."</div>".
						"</div>".
					"</div>";
		} else {
			$imageExists = imageExists($customTexts["IMAGE-1$postfix"][0]);
			$hasImage = $imageExists ? "true" : "false";
			echo	"<div class='top' has-image='$hasImage'>".
						($imageExists ? "<div class='image' style='background-image:url(\"".cgetImg("IMAGE-1$postfix")."\");'></div>" : "").
						"<div class='text' nh-content-sp='padding'>".
							"<div class='title'>".cgetText("TITLE-1$postfix")."</div>".
							"<div class='desc'>".cgetText("TEXT-1$postfix")."</div>".
						"</div>".
					"</div>";
		}
	}
}
?>

<?php if (array_key_exists("TABLE", $customTexts)) { ?>
<div class="middle" show-image="false">
	<div class="title">商品情報</div>
	<div class="content">
		<div class="table">
			<table><tbody><?php ctable(); ?></tbody></table>
		</div>
		<div class="image">
			<img src="<?php img("product_info"); ?>">
		</div>
	</div>
</div>
<?php } ?>

<?php
$numOfColumns = 0;
for ($n = 1; $n <= MAX_NUM_OF_COLUMNS; $n++) {
	if (array_key_exists("TITLE-2-$n", $customTexts)) $numOfColumns++;
}

if ($numOfColumns != 0) {
	echo "<div class='bottom' nh-content-sp='padding' num-of-columns='$numOfColumns'>";
	for ($n = 1; $n <= MAX_NUM_OF_COLUMNS; $n++) {
		if (array_key_exists("TITLE-2-$n", $customTexts)) echoBottomColumn($n, $customTexts);
	}
	echo "</div>";
}
?>

<?php
/*
<div custom="1">
[TITLE-1]
機能とデザインが融合した弓なりの湾曲

[TEXT-1]
Authenticコレクションの中で一番人気のある、スーツ用ハンガー
見た目の美しさと洋服を型崩れさせない機能性をあわせ持っています。

人工工学に基づいた滑らかな湾曲と肩先の厚み、首後ろの丸みまで、こまかな部分へこだわった本物のハンガー。
掛け心地、洋服のフィット感は抜群です。長年の知識と技術をもつNAKATA HANGERならではの至高の1本。

肩先の厚みがございますので、ジャケット、コート用ハンガーとしてもご使用いただけます。
パンツも掛けられるフェルトバー付き。バランスを取って掛けるだけでずり落ちを防ぎます。アンダーパーツのない「下セットなし」も選択可能です。

ご就職お祝いやご昇進お祝いなどスーツをお召しになる方へのギフトとしても人気です。

[IMAGE-1]
aut05-1.jpg

[TITLE-2-1]
妥協のない機能性とデザイン

[TEXT-2-1]
お洋服が直接当たる部分にフィットする丸みの形状と、ハンガー全体のなめらかな手触りを追求した職人の技術とこだわりが光ります。スーツを愛するお客様のための「メンテナンスハンガー」として、NAKATA HANGER が自信をもってお届けいたします。

[IMAGE-2-1]
aut05-2.jpg

[TITLE-2-2]
背中の湾曲がフィット感をさらにアップ

[TEXT-2-2]
襟元のデザインの違いをご覧ください。（真ん中のハンガーがAUT-05）フックの付け根はシャープな平型に。そして、スーツの襟足部分の湾曲と、肩の背中側へ向かう丸みが通常のスーツハンガーとは異なります。

[IMAGE-2-2]
aut05-3.jpg

[TABLE]
サイズ:w:430 t:57 全長 255mm 毛足の長さ 30mm
木材:ブナ
木部の色:マーズブラウン
金具の色:ゴールド
</div>
*/
?>