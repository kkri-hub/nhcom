<?php
$sp_menuPaddingBottom = 60; // スマートフォン用メニューのパディング（下）
$sp_marginHeader = 53;     // スマートフォン用ヘッダー上部マージン
$pc_marginHeader = 148;    // PC用ヘッダー上部マージン
$showHeaderNews = false;
$headerNewsHeight = 0; // ヘッダーニュースの高さの初期値

if (
	(defined('LANG_JA') && LANG == LANG_JA && (defined('SHOW_HEADER_NEWS_1') && SHOW_HEADER_NEWS_1 || defined('SHOW_HEADER_NEWS_2') && SHOW_HEADER_NEWS_2)) ||
	(defined('LANG_EN') && LANG == LANG_EN && (defined('EN_SHOW_HEADER_NEWS_1') && EN_SHOW_HEADER_NEWS_1 || defined('EN_SHOW_HEADER_NEWS_2') && EN_SHOW_HEADER_NEWS_2))
) {
	$showHeaderNews = true;
	$headerNewsHeight = 50;
}

?>
<style>
	/* ======================================================================== */
	/* Header News Section Styles */
	/* ======================================================================== */
	#header-news {
		height:
			<?php echo $headerNewsHeight; ?>
			px;
		/* background-color: <?php // echo $headerNewsBackgroundColor; ?>
		;
		*/
		/* ヘッダーニュースが最初隠れていて、表示時に translateY(0) になる想定 */
		transform: translateY(-<?php echo $headerNewsHeight; ?>px);
		/* 初期状態で隠す */
		/* transition: transform 600ms cubic-bezier(0.19, 1.00, 0.22, 1.00); */
		/* 必要であればトランジションを追加 */
		/* その他のスタイリング（背景色、文字色など） */
	}

	/* ヘッダーニュースが表示されている場合に、ヘッダー全体を下に移動させる */
	<?php if ($showHeaderNews) { ?>
		body:not([header-news="false"])[scrolled-header-news="false"] header {
			transform: translateY(<?php echo $headerNewsHeight; ?>px);
		}

	<?php } ?>

	/* ======================================================================== */
	/* Responsive Styles for Header and Content Margin */
	/* ======================================================================== */

	/* --- Mobile View (max-width: 768px) --- */
	@media only screen and (max-width:
		<?php echo (defined('MAX_SP_VIEW_WIDTH') ? MAX_SP_VIEW_WIDTH : 768); ?>
		px) {
		header .menu-container {
			/* SPメニューのパディング調整。ヘッダーニュースの有無で変動 */
			padding-bottom:
				<?php echo $sp_menuPaddingBottom + $headerNewsHeight; ?>
				px;
		}

		/* ヘッダーの下にコンテンツがくる際のマージン調整 */
		[nh-margin="header"] {
			margin-top:
				<?php echo $sp_marginHeader + $headerNewsHeight; ?>
				px;
		}

		/* ヘッダーニュースがない場合のSP向け調整 */
		body[header-news="false"] header .menu-container {
			padding-bottom:
				<?php echo $sp_menuPaddingBottom; ?>
				px;
		}

		body[header-news="false"] [nh-margin="header"] {
			margin-top:
				<?php echo $sp_marginHeader; ?>
				px;
		}

		/* ヘッダーニュースが表示されている場合のヘッダーアニメーション */
		<?php if ($showHeaderNews) { ?>
			body:not([header-news="false"]) header {
				transition: transform 600ms cubic-bezier(0.19, 1.00, 0.22, 1.00);
			}

		<?php } ?>
	}

	/* --- PC View (min-width: 769px) --- */
	@media only screen and (min-width:
		<?php echo (defined('MIN_PC_VIEW_WIDTH') ? MIN_PC_VIEW_WIDTH : 769); ?>
		px) {

		/* ヘッダーの下にコンテンツがくる際のマージン調整 */
		[nh-margin="header"] {
			margin-top:
				<?php echo $pc_marginHeader + $headerNewsHeight; ?>
				px;
		}

		/* ヘッダーニュースがない場合のPC向け調整 */
		body[header-news="false"] [nh-margin="header"] {
			margin-top:
				<?php echo $pc_marginHeader; ?>
				px;
		}
	}

	/* ======================================================================== */
	/* Global Navigation (Header Menus) Styles */
	/* ======================================================================== */
	header {
		border-bottom: white 1px solid;
		font-weight: 600;
	}

	header .main-list.left {
		margin-right: 0;
	}

	ul.main-menu-pc {
		margin-inline: auto;
		width: 98%;
		max-width: var(--w_max);
		height: fit-content;
		display: flex;
		justify-content: space-between;
		align-items: center;
		letter-spacing: 0.1em;
	}

	ul.main-menu-pc li {
		margin-right: 0;
		flex: 1 1 12%;
		font-size: clamp(11px, calc(2.0788863109048723px + 1.160092807424594vw), 16px);
	}

	ul.main-menu-sp {
		max-height: calc(100dvh - 53px);
		padding-bottom: 20px;
		display: grid;
		row-gap: 1%;
		grid-template-columns: repeat(6, 1fr);
		grid-template-rows: auto 1fr 1fr auto auto auto 1fr;
		grid-template-areas:
			"title title title title title title"
			"icon1 icon1 icon2 icon2 icon3 icon3"
			"icon4 icon4 icon5 icon5 icon6 icon6"
			"cv cv cv cv cv cv"
			"banner1 banner1 banner1 banner1 banner1 banner1"
			"banner2 banner2 banner2 banner2 banner2 banner2"
			"line line line copy copy copy";
		background-color: #de8199;
		color: #fff;
		text-align: center;
		list-style: none;
		margin: 0;
		box-sizing: border-box;
	}

	ul.main-menu-sp>li {
		padding: 10px 5px;
		display: flex;
		flex-direction: column;
		justify-content: center;
		align-items: center;
		cursor: pointer;
		transition: opacity 0.3s ease;
	}

	ul.main-menu-sp>li:hover {
		opacity: 0.7;
	}

	ul.main-menu-sp>li a {
		text-decoration: none;
		color: inherit;
		display: flex;
		flex-direction: column;
		align-items: center;
		width: 100%;
		height: 100%;
	}

	ul.main-menu-sp>li p {
		margin: 0;
		font-size: 11px;
		line-height: 1.4;
		letter-spacing: 0.05em;
	}

	.menu-icon .main-item img {
		width: 40px;
	}

	ul.main-menu-sp .main-item {
		color: white;
		display: flex;
		flex-direction: column;
		align-items: center;
		gap: 5px;
	}

	ul.main-menu-sp .title {
		grid-area: title;
		margin-bottom: 5%;
		padding-top: 20px;
	}

	ul.main-menu-sp .menu-icon {
		padding: 15px 5px;
	}

	ul.main-menu-sp .icon1 {
		grid-area: icon1;
	}

	ul.main-menu-sp .icon2 {
		grid-area: icon2;
	}

	ul.main-menu-sp .icon3 {
		grid-area: icon3;
	}

	ul.main-menu-sp .icon4 {
		grid-area: icon4;
	}

	ul.main-menu-sp .icon5 {
		grid-area: icon5;
	}

	ul.main-menu-sp .icon6 {
		grid-area: icon6;
		margin-bottom: 5%;
	}

	ul.main-menu-sp .cv {
		grid-area: cv;
		margin-bottom: 8%;
		padding-inline: 10%;
	}

	ul.main-menu-sp .cv a {
		width: 100%;
		height: 100%;
	}

	ul.main-menu-sp .banner1 {
		grid-area: banner1;
	}

	ul.main-menu-sp .banner2 {
		grid-area: banner2;
	}

	ul.main-menu-sp .line-btn {
		grid-area: line;
	}

	ul.main-menu-sp .copy-btn {
		grid-area: copy;
	}

	.main-item:hover {
		opacity: .5;
	}

	nav.menus {
		background-color: rgba(222, 129, 153, 0.95);
	}

	header.drawer-open~#main .float-button__wrap,
	header[menu-opened="true"]~#main .float-button__wrap {
		display: none !important;
	}

	/* ======================================================================== */
	/* Button Styles */
	/* ======================================================================== */
	button {
		margin: 0 auto;
	}

	header .estimate-btn {
		margin: 0;
		white-space: nowrap;
		height: 45px;
		justify-content: center;
	}

	.banner .main-item {
		flex-direction: row;
	}
</style>

<body>

	<header class="drawer" device='pc'>
		<ul class="main-menu-pc">
			<li class="main-list left" nh-gray-border="3">
				<div class="logo"><a href="<?php href("/"); ?>"><?php logo("nakata_hanger"); ?></a></div>
			</li>
			<li class="main-list left" nh-gray-border="3"><a href="<?php href("graduation/"); ?>">
					<div class="main-item" opened="false">卒業記念TOP</div>
				</a></li>
			<li class="main-list left" nh-gray-border="3"><a href="<?php href("graduation/products/"); ?>">
					<div class="main-item" opened="false">商品</div>
				</a>
			</li>
			<li class="main-list left" nh-gray-border="3"><a href="<?php href("graduation/flow/"); ?>">
					<div class="main-item" opened="false">ご注文の流れ</div>
				</a>
			</li>
			<li class="main-list left" nh-gray-border="3"><a href="<?php href("graduation/faq/"); ?>">
					<div class="main-item" opened="false">よくあるご質問</div>
				</a>
			</li>
			<li class="main-list left" nh-gray-border="3"><a href="<?php href("graduation/voices/"); ?>">
					<div class="main-item" opened="false">お客様の声</div>
				</a>
			</li>
			<!-- <li class="main-list left" nh-gray-border="3">
				<?php include_grad_cta_button(); ?>
			</li> -->
		</ul>
	</header>

	<header class="drawer" device='sp' full-view="true" menu-opened="false" nh-gray-border="3" sp-search-opened="false">
		<div class="logo-area" nh-gray-border="2">
			<div class="icons left">
				<div class="icon drawer-toggle"><?php icon("menu"); ?></div>
			</div>
			<div class="logo" device='sp'><a href="<?php href("/"); ?>"><?php logo("nakata_hanger"); ?></a></div>
		</div>
		<nav class="menus drawer-nav" ontransitionend="nh.header.onDrawerTransitionEnd();">
			<div class="menu-container">
				<ul class="main-menu-sp">
					<li class="title"> <a href="<?php href("graduation/"); ?>">
							<div class="main-item" opened="false"><img class=""
									src="<?php img("grad-submenu-title.png"); ?>" alt="卒業記念ハンガー"></div>
						</a></li>
					<li class="icon1 menu-icon"><a href="<?php href("graduation/"); ?>">
							<div class="main-item" opened="false">
								<p class="image"><img src="<?php img("grad-menu-icon1.svg"); ?>"></p>
								<p>ホーム</p>
							</div>
						</a></li>
					<li class="icon2 menu-icon"><a href="<?php href("graduation/products/"); ?>">
							<div class="main-item" opened="false">
								<p class="image"><img src="<?php img("grad-menu-icon2.svg"); ?>"></p>
								<p>商品</p>
							</div>
						</a></li>
					<li class="icon3 menu-icon"><a href="<?php href("graduation/flow/"); ?>">
							<div class="main-item" opened="false">
								<p class="image"><img src="<?php img("grad-menu-icon3.svg"); ?>"></p>
								<p>注文の流れ</p>
							</div>
						</a></li>
					<li class="icon4 menu-icon"><a href="<?php href("graduation/faq/"); ?>">
							<div class="main-item" opened="false">
								<p class="image"><img src="<?php img("grad-menu-icon4.svg"); ?>"></p>
								<p>FAQ</p>
							</div>
						</a></li>
					<li class="icon5 menu-icon"><a href="<?php href("graduation/voices/"); ?>">
							<div class="main-item" opened="false">
								<p class="image"><img id="voices-icon" src="<?php img("grad-menu-icon5.svg"); ?>"></p>
								<p>お客様の声</p>
							</div>
						</a></li>
					<li class="icon6 menu-icon"><a href="https://www.instagram.com/nakata_hanger_graduation/">
							<div class="main-item" opened="false">
								<p class="image"><img id="insta-icon" src="<?php img("grad-menu-icon6.svg"); ?>"></p>
								<p>Instagram</p>
							</div>
						</a></li>
					<li class="cv">
						<?php include_grad_cta_button(); ?>
					</li>
					<li class="banner1 banner">
						<div class="main-item" opened="false">
							<a href="<?php href("graduation/hayawari/"); ?>">早割についてはこちら</a>
							<!-- <img style="box-shadow: 0px 0px 15px 0 #333;" src="<?php img("grad-news-hayawari.png"); ?>"> -->
						</div>
					</li>
					<li class="banner2 banner">
						<div class="main-item" opened="false">
							<a href="<?php href("graduation/products#repeat"); ?>">リピート割についてはこちら</a>
							<!-- <img style="box-shadow: 0px 0px 15px 0 #333;" src="<?php img("grad-news-hayawari.png"); ?>"> -->
						</div>
					</li>
					<!-- <li class="banner2"><a href="">
							<div class="main-item" opened="false"><img style="box-shadow: 0px 0px 15px 0 #333;"
									src="<?php img("grad-news-repeat.jpg"); ?>"></div>
						</a></li> -->
					<!-- <li class="line-btn"><a
							href="https://social-plugins.line.me/lineit/share?url=https://www.nakatahanger.com/graduation/">
							<img class="share-logo" src="<?php img("logo_line_white.png"); ?>">
							<span>でシェア</span>
						</a></li>
					<li class="copy-btn"><button id="copy-url-btn" onclick="copyUrl()">URLコピー</button></li> -->
				</ul>
			</div>
		</nav>
	</header>

	<!-- <script>
		// URLコピー機能
		function copyUrl() {
			const element = document.createElement('input');
			element.value = location.href;
			document.body.appendChild(element);
			element.select();
			document.execCommand('copy');
			document.body.removeChild(element);
			// フラッシュメッセージ表示
			// jQuery依存なので、jQueryがロードされている前提
			$('.success-msg').fadeIn("slow", function () {
				$(this).delay(1000).fadeOut("slow");
			});
		}
	</script> -->
</body>