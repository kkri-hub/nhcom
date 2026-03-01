<?php
// Production: load NAKATA HANGER common framework
// Local: use stub functions for preview
$nhPath = dirname(__DIR__, 2) . "/include/nh.php";
if (file_exists($nhPath)) {
  require_once($nhPath);
  define('NH_LOCAL', false);
} else {
  define('NH_LOCAL', true);
  define('LANG', 'ja');
  define('LANG_JA', 'ja');
  function echoHead($p) {}
  function echoHeader() { echo '<div style="background:#333;color:#fff;padding:12px 20px;font-size:13px;text-align:center;">[ NAKATA HANGER Header - production only ]</div>'; }
  function echoFooter() { echo '<div style="background:#333;color:#fff;padding:24px 20px;font-size:13px;text-align:center;">[ NAKATA HANGER Footer - production only ]</div>'; }
  function echoLang() { echo 'ja'; }
  function getNcParam() { echo time(); }
  function echoCorporateLink() {}
}
?>
<!DOCTYPE html>
<html>

<head>
  <?php
  echoHead(array(
    "title" => "春のギフト特集",
    "titleNhPrefix" => true,
    "desc" => "卒業・入学・就職祝いに。NAKATA HANGERの春のギフトコレクション。大切な人へ、毎日使える上質な贈り物を。名入れ対応。"
  ));
  ?>
  <?php if (NH_LOCAL): ?>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
  <title>春のギフト特集 | NAKATA HANGER</title>
  <?php endif; ?>
  <meta property="og:title" content="春のギフト特集 | NAKATA HANGER">
  <meta property="og:description" content="卒業・入学・就職祝いに。大切な人へ、毎日使える上質な贈り物を。名入れ対応。">
  <meta property="og:url" content="https://www.nakatahanger.com/features/spring2026/">
  <meta property="og:image" content="https://www.nakatahanger.com/features/spring2026/images/hero.jpg">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="春のギフト特集 | NAKATA HANGER">
  <meta name="twitter:description" content="卒業・入学・就職祝いに。大切な人へ、毎日使える上質な贈り物を。">
  <meta name="twitter:image" content="https://www.nakatahanger.com/features/spring2026/images/hero.jpg">

  <!-- Features common CSS -->
  <link rel='stylesheet' type='text/css' href='../common.css?<?php echo getNcParam(); ?>'>
  <link rel='stylesheet' type='text/css' media='(max-width:768px)' href='../common-s.css?<?php echo getNcParam(); ?>'>
  <link rel='stylesheet' type='text/css' media='(min-width:769px)' href='../common-l.css?<?php echo getNcParam(); ?>'>

  <!-- Page CSS (inline via PHP to bypass static file routing) -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=Noto+Sans+JP:wght@200;300;400;500&family=Playfair+Display:wght@400;500;600;700&family=Zen+Old+Mincho:wght@400;500;600;700&display=swap">
  <style>
    <?php include(__DIR__ . "/style.css"); ?>

    #main {
      line-height: 1.8;
      color: #1A1A1A;
    }
  </style>
</head>

<body lang="<?php echoLang(); ?>" ios="false">
  <?php echoHeader(); ?>

  <main id="main">

  <!-- ===== 1. HERO ===== -->
  <div id="top" class="hub-hero" nh-margin="header">
    <h1>春に、想いを贈る。</h1>
    <p class="subtitle">新しい門出に、ずっと寄り添う贈り物を。</p>
    <div class="gold-line"></div>
    <a href="#scene" class="btn-outline">門出の一本を選ぶ</a>
    <div class="scroll-indicator">
      <span></span>
    </div>
  </div>

  <!-- ===== 2. WHY ===== -->
  <section id="why" class="section fade-in">
    <div class="petals" aria-hidden="true">
      <span class="petal"></span>
      <span class="petal"></span>
      <span class="petal"></span>
      <span class="petal"></span>
      <span class="petal"></span>
      <span class="petal"></span>
    </div>
    <div class="section-head">
      <h2>春に贈る、ずっと残る想い。</h2>
      <div class="gold-line"></div>
    </div>
    <div class="why-content-with-image">
      <div class="why-image">
        <img src="images/flower-vs-hanger.jpg" alt="花束とハンガーの対比 - 春のギフト" loading="lazy" decoding="async">
      </div>
      <div class="why-text-content">
        <p class="why-text">花は美しく、やがて散る。<br>でもこの一本は、何年も何十年も、そばに寄り添う。</p>
        <p class="why-text">毎朝の習慣に、あなたの想いを添えて。</p>
      </div>
    </div>
  </section>

  <!-- ===== 3. CRAFT ===== -->
  <section id="craft" class="section fade-in">
    <div class="section-head">
      <p class="label">Gift Quality</p>
      <h2>想いを託せる、確かなものづくり。</h2>
      <div class="gold-line"></div>
    </div>
    <div class="craft-image-wrapper">
      <img src="images/craft.jpg" alt="職人の手でハンガーを磨く様子" class="craft-image" loading="lazy" decoding="async">
    </div>
    <div class="craft-content">
      <p class="craft-text">肩の丸みに沿う曲線。<br>生地を傷めない木の質感。<br>一本一本、削り出されるかたち。</p>
      <p class="craft-text">見えない部分にこそ、<br>長く使える理由がある。</p>
    </div>
  </section>

  <!-- ===== 4. SCENE ===== -->
  <section id="scene" class="section fade-in">
    <div class="petals" aria-hidden="true">
      <span class="petal"></span>
      <span class="petal"></span>
      <span class="petal"></span>
      <span class="petal"></span>
      <span class="petal"></span>
      <span class="petal"></span>
    </div>
    <div class="section-head">
      <p class="label">Spring Gift Scene</p>
      <h2>春の門出に、心を込めた贈り物を。</h2>
      <div class="gold-line"></div>
    </div>
    <div class="grid-3">
      <div class="scene-card">
        <div class="card-image"><img src="images/grad.jpg" alt="卒業のギフトシーン - お疲れさまの気持ちをかたちにしたハンガー" loading="lazy" decoding="async"></div>
        <p class="scene-label">Graduation</p>
        <p class="scene-ja">卒業</p>
        <h3>頑張ったね、ありがとう。<br>その想いを、かたちに。</h3>
        <p class="scene-reason">新しい習慣のはじまりに。</p>
        <div class="scene-products">
          <p class="scene-products-title">おすすめギフト</p>
          <a href="https://www.nakatahanger-shop.com/?pid=104968106" target="_blank" rel="noopener" class="scene-product">
            <img src="https://img17.shop-pro.jp/PA01267/924/product/104968106.jpg?cmsp_timestamp=20190516140034" alt="メンズスーツハンガー GFT-05M" class="scene-product-img" loading="lazy" decoding="async">
            <span class="scene-product-name">メンズスーツハンガー GFT-05M</span>
            <span class="scene-product-price">¥3,850</span>
          </a>
          <a href="https://www.nakatahanger-shop.com/?pid=69751671" target="_blank" rel="noopener" class="scene-product">
            <img src="https://img17.shop-pro.jp/PA01267/924/product/69751671.jpg?cmsp_timestamp=20190516131320" alt="レディススーツハンガー GFT-05S" class="scene-product-img" loading="lazy" decoding="async">
            <span class="scene-product-name">レディススーツハンガー GFT-05S</span>
            <span class="scene-product-price">¥3,850</span>
          </a>
        </div>
      </div>
      <div class="scene-card">
        <div class="card-image"><img src="images/new.jpg" alt="入学のギフトシーン - 新しい世界へ踏み出す人への応援ハンガー" loading="lazy" decoding="async"></div>
        <p class="scene-label">Entrance</p>
        <p class="scene-ja">入学</p>
        <h3>新しい世界へ。<br>応援の気持ちを込めて。</h3>
        <p class="scene-reason">最初の一着を、正しく迎えるために。</p>
        <div class="scene-products">
          <p class="scene-products-title">おすすめギフト</p>
          <a href="https://www.nakatahanger-shop.com/?pid=173741685" target="_blank" rel="noopener" class="scene-product">
            <img src="https://img17.shop-pro.jp/PA01267/924/product/173741685.jpg?cmsp_timestamp=20230324161338" alt="メンズスーツハンガー GFT-101" class="scene-product-img" loading="lazy" decoding="async">
            <span class="scene-product-name">メンズスーツハンガー GFT-101</span>
            <span class="scene-product-price">¥5,500</span>
          </a>
          <a href="https://www.nakatahanger-shop.com/?pid=173737988" target="_blank" rel="noopener" class="scene-product">
            <img src="https://img17.shop-pro.jp/PA01267/924/product/173737988.jpg?cmsp_timestamp=20230324143617" alt="メンズハンガー 2種類セット GFT-112" class="scene-product-img" loading="lazy" decoding="async">
            <span class="scene-product-name">メンズハンガー 2種類セット GFT-112</span>
            <span class="scene-product-price">¥8,030</span>
          </a>
        </div>
      </div>
      <div class="scene-card">
        <div class="card-image"><img src="images/prom.jpg" alt="お世話になった方へのギフトシーン - 感謝を上質な一本に託したハンガー" loading="lazy" decoding="async"></div>
        <p class="scene-label">Thanks / Promotion</p>
        <p class="scene-ja">お世話になった方へ / 昇進</p>
        <h3>いつもありがとう。<br>感謝を、上質な一本に。</h3>
        <p class="scene-reason">これまでの時間に、敬意を込めて。</p>
        <div class="scene-products">
          <p class="scene-products-title">おすすめギフト</p>
          <a href="https://www.nakatahanger-shop.com/?pid=117401959" target="_blank" rel="noopener" class="scene-product">
            <img src="https://img17.shop-pro.jp/PA01267/924/product/117401959.jpg?cmsp_timestamp=20260204104023" alt="メンズハンガー＆洋服ブラシセット GFT-02" class="scene-product-img" loading="lazy" decoding="async">
            <span class="scene-product-name">メンズハンガー＆洋服ブラシセット GFT-02</span>
            <span class="scene-product-price">¥24,200</span>
          </a>
          <a href="https://www.nakatahanger-shop.com/?pid=69751665" target="_blank" rel="noopener" class="scene-product">
            <img src="https://img17.shop-pro.jp/PA01267/924/product/69751665.jpg?cmsp_timestamp=20220401135604" alt="メンズハンガー 2種類セット GFT-03M" class="scene-product-img" loading="lazy" decoding="async">
            <span class="scene-product-name">メンズハンガー 2種類セット GFT-03M</span>
            <span class="scene-product-price">¥13,750</span>
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- ===== 5. ENGRAVING ===== -->
  <section id="engraving" class="section fade-in">
    <div class="petals" aria-hidden="true">
      <span class="petal"></span>
      <span class="petal"></span>
      <span class="petal"></span>
      <span class="petal"></span>
      <span class="petal"></span>
      <span class="petal"></span>
    </div>
    <div class="section-head">
      <p class="label">Engraving</p>
      <h2>名前を刻む。想いを、残す。</h2>
      <div class="gold-line"></div>
    </div>
    <div class="engraving-image-wrapper">
      <img src="images/name.jpg" alt="名入れされたハンガーのクローズアップ" class="engraving-image" loading="lazy" decoding="async">
    </div>
    <div class="engraving-content">
      <p class="engraving-text">新しい門出を迎えるあの人へ、<br>名前を刻んだ一本を。</p>
      <p class="engraving-text">毎朝手に取るたび、<br>贈り主の想いが、そっと甦る。</p>
      <a href="https://www.nakatahanger-shop.com/?pid=69751712" target="_blank" rel="noopener" class="engraving-link">刻印オプションについて詳しく &rsaquo;</a>
    </div>
  </section>

  <!-- ===== 6. PRICE ===== -->
  <section id="price" class="section fade-in">
    <div class="section-head">
      <p class="label">Gift Price</p>
      <h2>想いに合わせて選ぶ、春のギフト。</h2>
      <div class="gold-line"></div>
    </div>
    <div class="grid-3">
      <div class="price-card">
        <p class="price-label">ちょっとした感謝に</p>
        <p class="price-amount">¥3,000<span>〜5,000</span></p>
        <p class="price-desc">気軽に贈れる心のこもった一本</p>
        <a href="https://www.nakatahanger-shop.com/?pid=69751671" target="_blank" rel="noopener" class="price-featured">
          <img src="https://img17.shop-pro.jp/PA01267/924/product/69751671.jpg?cmsp_timestamp=20190516131320" alt="レディススーツハンガー GFT-05S" loading="lazy" decoding="async">
          <span class="price-featured-name">レディススーツハンガー GFT-05S<span class="price-featured-price">¥3,850</span></span>
        </a>
        <div class="scene-products">
          <p class="scene-products-title">その他のおすすめ</p>
          <a href="https://www.nakatahanger-shop.com/?pid=69751689" target="_blank" rel="noopener" class="scene-product">
            <img src="https://img17.shop-pro.jp/PA01267/924/product/69751689.jpg?cmsp_timestamp=20210601175513" alt="ストールハンガー" class="scene-product-img" loading="lazy" decoding="async">
            <span class="scene-product-name">ストールハンガー</span>
            <span class="scene-product-price">¥3,300</span>
          </a>
          <a href="https://www.nakatahanger-shop.com/?pid=104968106" target="_blank" rel="noopener" class="scene-product">
            <img src="https://img17.shop-pro.jp/PA01267/924/product/104968106.jpg?cmsp_timestamp=20190516140034" alt="メンズスーツハンガー GFT-05M" class="scene-product-img" loading="lazy" decoding="async">
            <span class="scene-product-name">メンズスーツハンガー GFT-05M</span>
            <span class="scene-product-price">¥3,850</span>
          </a>
          <a href="https://www.nakatahanger-shop.com/?pid=173741685" target="_blank" rel="noopener" class="scene-product">
            <img src="https://img17.shop-pro.jp/PA01267/924/product/173741685.jpg?cmsp_timestamp=20230324161338" alt="メンズスーツハンガー GFT-101" class="scene-product-img" loading="lazy" decoding="async">
            <span class="scene-product-name">メンズスーツハンガー GFT-101</span>
            <span class="scene-product-price">¥5,500</span>
          </a>
        </div>
      </div>
      <div class="price-card">
        <p class="price-label">大切な人へ</p>
        <p class="price-amount">¥5,000<span>〜10,000</span></p>
        <p class="price-desc">春の門出を祝う、定番ギフト</p>
        <a href="https://www.nakatahanger-shop.com/?pid=105321434" target="_blank" rel="noopener" class="price-featured">
          <img src="https://img17.shop-pro.jp/PA01267/924/product/105321434.jpg?cmsp_timestamp=20161214111722" alt="メンズスーツハンガー AUT-05SM" loading="lazy" decoding="async">
          <span class="price-featured-name">メンズスーツハンガー AUT-05SM<span class="price-featured-price">¥6,050</span></span>
        </a>
        <div class="scene-products">
          <p class="scene-products-title">その他のおすすめ</p>
          <a href="https://www.nakatahanger-shop.com/?pid=109092272" target="_blank" rel="noopener" class="scene-product">
            <img src="https://img17.shop-pro.jp/PA01267/924/product/109092272.jpg?cmsp_timestamp=20190516121545" alt="メンズジャケットハンガー AUT-05M" class="scene-product-img" loading="lazy" decoding="async">
            <span class="scene-product-name">メンズジャケットハンガー AUT-05M</span>
            <span class="scene-product-price">¥6,050</span>
          </a>
          <a href="https://www.nakatahanger-shop.com/?pid=106704067" target="_blank" rel="noopener" class="scene-product">
            <img src="https://img17.shop-pro.jp/PA01267/924/product/106704067.jpg?cmsp_timestamp=20190516131121" alt="メンズ&レディスハンガー 2種類セット BRD-06A" class="scene-product-img" loading="lazy" decoding="async">
            <span class="scene-product-name">メンズ&レディスセット BRD-06A</span>
            <span class="scene-product-price">¥6,050</span>
          </a>
          <a href="https://www.nakatahanger-shop.com/?pid=139831864" target="_blank" rel="noopener" class="scene-product">
            <img src="https://img17.shop-pro.jp/PA01267/924/product/139831864.jpg?cmsp_timestamp=20190516131530" alt="メンズ&レディスハンガー 2種類セット GFT-06M" class="scene-product-img" loading="lazy" decoding="async">
            <span class="scene-product-name">メンズ&レディスセット GFT-06M</span>
            <span class="scene-product-price">¥7,150</span>
          </a>
        </div>
      </div>
      <div class="price-card">
        <p class="price-label">特別な想いを込めて</p>
        <p class="price-amount">¥10,000<span>〜</span></p>
        <p class="price-desc">お世話になった方へ、上質な感謝</p>
        <a href="https://www.nakatahanger-shop.com/?pid=166395582" target="_blank" rel="noopener" class="price-featured">
          <img src="https://img17.shop-pro.jp/PA01267/924/product/166395582.jpg?cmsp_timestamp=20240117143939" alt="富士山ハンガー RISE（赤富士）" loading="lazy" decoding="async">
          <span class="price-featured-name">富士山ハンガー「RISE」赤富士<span class="price-featured-price">¥22,000</span></span>
        </a>
        <div class="scene-products">
          <p class="scene-products-title">その他のおすすめ</p>
          <a href="https://www.nakatahanger-shop.com/?pid=115356349" target="_blank" rel="noopener" class="scene-product">
            <img src="https://img17.shop-pro.jp/PA01267/924/product/115356349.jpg?cmsp_timestamp=20190516130748" alt="メンズ&レディスハンガー 2種類セット AUT-05MG" class="scene-product-img" loading="lazy" decoding="async">
            <span class="scene-product-name">メンズ&レディスセット AUT-05MG</span>
            <span class="scene-product-price">¥11,550</span>
          </a>
          <a href="https://www.nakatahanger-shop.com/?pid=69751665" target="_blank" rel="noopener" class="scene-product">
            <img src="https://img17.shop-pro.jp/PA01267/924/product/69751665.jpg?cmsp_timestamp=20220401135604" alt="メンズハンガー 2種類セット GFT-03M" class="scene-product-img" loading="lazy" decoding="async">
            <span class="scene-product-name">メンズハンガー 2種類セット GFT-03M</span>
            <span class="scene-product-price">¥13,750</span>
          </a>
          <a href="https://www.nakatahanger-shop.com/?pid=117401959" target="_blank" rel="noopener" class="scene-product">
            <img src="https://img17.shop-pro.jp/PA01267/924/product/117401959.jpg?cmsp_timestamp=20260204104023" alt="メンズハンガー＆洋服ブラシセット GFT-02" class="scene-product-img" loading="lazy" decoding="async">
            <span class="scene-product-name">メンズハンガー&ブラシセット GFT-02</span>
            <span class="scene-product-price">¥24,200</span>
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- ===== 7. FINAL CTA ===== -->
  <section id="cta" class="section section-cta fade-in">
    <div class="cta-content">
      <h2 class="cta-heading">この春、大切な人へ。<br>想いが届く贈り物を。</h2>
      <div class="gold-line"></div>
      <a href="https://www.nakatahanger.com/products/category/gift" target="_blank" rel="noopener" class="btn-primary">門出の一本を選ぶ</a>
    </div>
  </section>

  </main>

  <!-- Animations -->
  <script><?php include(__DIR__ . "/animations.js"); ?></script>

  <div nh-margin-section="top"><?php echoFooter(); ?></div>
</body>

</html>
