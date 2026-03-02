<?php
// NH.com
// トップページのトップ動画に関する設定

// 動画の表示
// true: 画像よりも動画が優先されて表示される
// false: 画像（top-image.php）が表示される
define("SHOW_TOP_VIDEO", false);

// 動画ファイル
// /video フォルダ内の動画ファイル
define("TOP_VIDEO", "top_arterton.m4v");

// サムネイル
// /video フォルダ内の画像ファイル
// 設定しない場合は「null」
define("TOP_VIDEO_THUMBNAIL", "top_arterton.jpg");

// 動画の暗さ設定（動画の前面の文字を見えやすくするため）
// 0.0 ~ 1.0（数値が大きいほど暗い）
define("TOP_VIDEO_DARKNESS", 0.3);

?>