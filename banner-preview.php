<?php
// ローカルプレビュー用 スタブ定義
define('LANG', 'ja');
define('LANG_JA', 'ja');
define('SHOPIFY_HOST', 'https://shop.nakatahanger.com');
define('SHOPIFY_DOMAIN', 'shop.nakatahanger.com');
define('SHOPIFY_ORIGINAL_DOMAIN', 'nakatahanger.myshopify.com');
define('SHOPIFY_API_KEY', '');
define('SHOPIFY_API_PASS', '');
define('SHOPIFY_API_VER', '2020-07');
define('CMS_API_ACCESS_TOKEN', '');
define('CMS_API_URL', '');
define('RECAPTCHA_SITE_KEY', '');
define('RECAPTCHA_SECRET_KEY', '');

function getFeatureUrl($slug, $param = '') {
    return 'https://www.nakatahanger.com/features/' . $slug . '/';
}
function getProductUrl($id, $param = '') {
    return 'https://www.nakatahanger.com/products/' . $id . '/';
}
function getCategoryUrl($slug, $param = '') {
    return 'https://www.nakatahanger.com/products/category/' . $slug . '/';
}
function getNewsUrl($id, $param = '') {
    return 'https://www.nakatahanger.com/news/' . $id . '/';
}
function isShowNameEngravingCampaign() { return false; }
function getNcParam() { return ''; }
function getHref($slug, $param = '') { return 'https://www.nakatahanger.com/' . $slug . '/'; }
function getSpUrl($slug, $param = '') { return 'https://www.nakatahanger.com/' . $slug . '/'; }
function isNkkIp() { return false; }
function isLocalHost() { return true; }
function _isValid($v) { return !empty($v); }

define('COLOR_ME_PRODUCT_ID_NAME_ENGRAVING', 0);
define('COLOR_ME_PRODUCT_ID_NAME_ENGRAVING_FREE', 0);
define('COLOR_ME_PRODUCT_ID_NAME_ENGRAVING_CURRENT', 0);
define('SHOW_NAME_ENGRAVING_CAMPAIGN', false);

require_once('include/update.php');

// 本番画像ベースURL
$imgBase = 'https://www.nakatahanger.com/images/header/';

// バナー一覧定義
$banners = [
    ['label' => 'ヘッダーニュース 1（日本語）', 'show' => SHOW_HEADER_NEWS_1,  'img' => defined('HEADER_NEWS_1_IMAGE_PC_1')  ? $imgBase . HEADER_NEWS_1_IMAGE_PC_1  : '', 'bg' => defined('HEADER_NEWS_1_BACKGROUND_COLOR')  ? HEADER_NEWS_1_BACKGROUND_COLOR  : '#fff'],
    ['label' => 'ヘッダーニュース 2（日本語）', 'show' => SHOW_HEADER_NEWS_2,  'img' => defined('HEADER_NEWS_2_IMAGE_PC_1')  ? $imgBase . HEADER_NEWS_2_IMAGE_PC_1  : '', 'bg' => defined('HEADER_NEWS_2_BACKGROUND_COLOR')  ? HEADER_NEWS_2_BACKGROUND_COLOR  : '#fff'],
    ['label' => 'ヘッダーニュース 1（英語）',   'show' => EN_SHOW_HEADER_NEWS_1, 'img' => defined('EN_HEADER_NEWS_1_IMAGE_PC_1') ? $imgBase . EN_HEADER_NEWS_1_IMAGE_PC_1 : '', 'bg' => defined('EN_HEADER_NEWS_1_BACKGROUND_COLOR') ? EN_HEADER_NEWS_1_BACKGROUND_COLOR : '#fff'],
    ['label' => 'ヘッダーニュース 2（英語）',   'show' => EN_SHOW_HEADER_NEWS_2, 'img' => defined('EN_HEADER_NEWS_2_IMAGE_PC_1') ? $imgBase . EN_HEADER_NEWS_2_IMAGE_PC_1 : '', 'bg' => defined('EN_HEADER_NEWS_2_BACKGROUND_COLOR') ? EN_HEADER_NEWS_2_BACKGROUND_COLOR : '#fff'],
];
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>バナープレビュー | NAKATA HANGER</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { background: #f6f4ef; font-family: 'Hiragino Kaku Gothic ProN', sans-serif; padding: 40px 24px; color: #2e2e2e; }
    h1 { font-size: 13px; letter-spacing: 0.2em; color: #4b3621; margin-bottom: 32px; font-weight: normal; }
    .banner-list { display: flex; flex-direction: column; gap: 24px; max-width: 900px; }
    .banner-item { border: 1px solid #ddd; background: #fff; overflow: hidden; }
    .banner-header { display: flex; align-items: center; justify-content: space-between; padding: 12px 16px; border-bottom: 1px solid #eee; }
    .banner-label { font-size: 12px; letter-spacing: 0.1em; }
    .status { font-size: 11px; padding: 4px 12px; letter-spacing: 0.1em; }
    .status.on  { background: #2e2e2e; color: #fff; }
    .status.off { background: #eee; color: #999; }
    .banner-img { width: 100%; display: block; }
    .no-img { padding: 24px; font-size: 11px; color: #999; text-align: center; }
    .edit-link { font-size: 11px; color: #4b3621; padding: 8px 16px; display: block; border-top: 1px solid #eee; text-decoration: none; }
    .edit-link:hover { background: #f6f4ef; }
  </style>
</head>
<body>
  <h1>NAKATA HANGER — バナープレビュー</h1>
  <p style="font-size:11px; color:#999; margin-bottom:24px; letter-spacing:0.1em;">
    編集: <code>include/update.php</code> の SHOW_HEADER_NEWS_* を true / false で切り替え
  </p>
  <div class="banner-list">
    <?php foreach ($banners as $banner): ?>
    <div class="banner-item">
      <div class="banner-header">
        <span class="banner-label"><?= $banner['label'] ?></span>
        <span class="status <?= $banner['show'] ? 'on' : 'off' ?>"><?= $banner['show'] ? '表示中' : '非表示' ?></span>
      </div>
      <?php if ($banner['img']): ?>
        <div style="background:<?= htmlspecialchars($banner['bg']) ?>">
          <img class="banner-img" src="<?= htmlspecialchars($banner['img']) ?>" alt="">
        </div>
      <?php else: ?>
        <div class="no-img">画像未設定</div>
      <?php endif; ?>
    </div>
    <?php endforeach; ?>
  </div>
</body>
</html>
