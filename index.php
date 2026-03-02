<?php
require_once("include/nh.php");
require_once("include/update/instagram.php");

if (LANG == LANG_JA) {
	require_once("include/update/features.php");
	require_once("include/update/top-image.php");
	require_once("include/update/top-video.php");
}

//////////////////////////////////////////////////////////////////////////////////////////

define("NUM_OF_NEWS", 3);

define("RANKING_NUM_OF_VISIBLE_PRODUCTS_PC", 4);
define("RANKING_NUM_OF_VISIBLE_PRODUCTS_SP", 2);

define("RANKING_SLIDE_MS_PC", 450);
define("RANKING_SLIDE_MS_SP", 300);

//////////////////////////////////////////////////////////////////////////////////////////

function getPreviewNewsId()
{
	if (isNkkIp() || isLocalHost()) {
		$url = _url();
		$query = $url["query"];
		if (array_key_exists("p", $query) && array_key_exists("preview", $query)) {
			if ($query["preview"] == "true" && ctype_digit($query["p"])) {
				return $query["p"];
			}
		}
	}
	return null;
}

function redirectIfNewsPreview()
{
	$previewNewsId = getPreviewNewsId();
	if (_isValid($previewNewsId)) {
		_redirect(getNewsUrl($previewNewsId));
	}
}

//////////////////////////////////////////////////////////////////////////////////////////

function getRanking()
{
	$ranking = array();
	$products = getCmsProducts();
	/*	foreach ($products["ranking"] as $productId) {
		array_push($ranking, $products["products"][$productId]);
	}*/

	// TODO: Delete
	$pids = array(69751649, 69751651, 69751624, 71039851, 69751618, 69751656, 69751700, 109092272);
	$ranking = array();
	foreach ($pids as $productId) {
		array_push($ranking, $products["products"][$productId]);
	}
	//

	return $ranking;
}

function getRankingInfo($ranking)
{
	if (_isValid($ranking)) {
		$numOfProducts = sizeof($ranking);

		$res = array(
			"numOfProducts" => $numOfProducts,
			"devices" => array(),
		);

		foreach (array("pc", "sp") as $device) {
			$numOfVisibleProducts = constant("RANKING_NUM_OF_VISIBLE_PRODUCTS_" . strtoupper($device));
			if ($numOfVisibleProducts > $numOfProducts)
				$numOfVisibleProducts = $numOfProducts;

			$hasSlider = ($numOfProducts > $numOfVisibleProducts);
			$numToSlide = 1;
			$nuOfPages = 1;

			if ($hasSlider) {
				if ($numOfProducts % $numOfVisibleProducts == 0) {
					$numToSlide = $numOfVisibleProducts;
					$numOfPages = $numOfProducts / $numOfVisibleProducts;
				}
			}

			$res["devices"][$device] = array(
				"numOfVisibleProducts" => $numOfVisibleProducts,
				"hasSlider" => $hasSlider,
				"numToSlide" => $numToSlide,
				"numOfPages" => $numOfPages,
			);
		}

		return $res;
	}
}

//////////////////////////////////////////////////////////////////////////////////////////

redirectIfNewsPreview();

$topText = "true";
if (SHOW_TOP_VIDEO || SHOW_TOP_TEXT) {
	$topText = "true";
} else if (IMAGE_LINK || !SHOW_TOP_TEXT) {
	$topText = "false";
}

$news = getNews(NUM_OF_NEWS);

$ranking = getRanking();
$rankingInfo = getRankingInfo($ranking);

$instagramPosts = getInstagramPosts(4);

?>
<!DOCTYPE html>
<html>

<head>
	<?php
	echoHead(array("title" => $texts["aHomeForYourClothes"], "titleNhPrefix" => true, "desc" => $texts["metaDescTop"]));
	//includeCss("lib/swiper.min.css");
	//includeJs("lib/swiper.min.js");
	?>
	<link rel="stylesheet" type="text/css" media="(max-width:<?php echo MAX_SP_VIEW_WIDTH; ?>px)"
		href="<?php echo HOME_URL; ?>index-s.css?<?php echo getNcParam(); ?>">
	<link rel="stylesheet" type="text/css" media="(min-width:<?php echo MIN_PC_VIEW_WIDTH; ?>px)"
		href="<?php echo HOME_URL; ?>index-l.css?<?php echo getNcParam(); ?>">
	<link rel="stylesheet" type="text/css" href="<?php url("lib/swiper.min.css", false); ?>">
	<script type="text/javascript" src="<?php url("lib/swiper.min.js", false); ?>"></script>
	<style>
		/****************************************************************************************/
		h2:before,
		h2:after {
			content: "";
			margin-top: 12px;
			width: 11px;
			height: 1px;
			background-color: #333;
			position: absolute;
		}

		h2:before {
			margin-left: -17px;
		}

		h2:after {
			margin-left: 6px;
		}

		/****************************************************************************************/
		#top {
			height: 100vh;
			position: relative;
			overflow: hidden;
		}

		#top .image {
			top: 0;
			left: 0;
			right: 0;
			height: 100%;
			background-position: center 0;
			background-size: cover;
			background-repeat: no-repeat;
			position: absolute;
		}

		/*
#top .image_sp {
	top: 0;
	left: 0;
	right: 0;
	height: 100%;
	background-image: url("<?php img("top_sp"); ?>");
	background-position: center 0;
	background-size: cover;
	background-repeat: no-repeat;
	position: absolute;
}
*/
		/*******************************************/
		#top video {
			top: 0;
			left: 0;
			right: 0;
			width: auto;
			height: auto;
			min-width: 100%;
			min-height: 100%;
			position: absolute;
			z-index: -2;
		}

		<?php if (_isValid(TOP_VIDEO_DARKNESS)) { ?>
			#top .video_darkness {
				top: 0;
				bottom: 0;
				left: 0;
				right: 0;
				background-color: rgba(0, 0, 0,
						<?php echo TOP_VIDEO_DARKNESS; ?>
					);
				position: absolute;
				z-index: -1;
			}

		<?php } ?>

		/*******************************************/
		#top .text {
			top: 0;
			bottom: 0;
			left: 0;
			right: 0;
			text-align: center;
			display: flex;
			justify-content: center;
			align-items: center;
			position: absolute;
		}

		#top .text[nh-faded-up="false"] {
			transform: translateY(15px);
		}

		<?php
		if (IMAGE_LINK) {
			echo "#top .text { display:none; }";
		} else if (!SHOW_TOP_TEXT) {
			echo "#top .text .text-container { display:none; }";
		}
		?>
		#top .scroll {
			text-align: center;
			position: absolute;
			cursor: pointer;
		}

		#top .scroll .scroll-text {
			padding-left: 3px;
		}

		#top .scroll .icon {
			margin-top: 6px;
			width: 19px;
			height: 19px;
			display: inline-block;
			position: relative;
			animation: vertical-move-continuously 1200ms infinite;
		}

		/****************************************************************************************/
		#top-news .top-news-container {
			border-width: 1px;
			border-style: solid;
			display: flex;
		}

		#top-news .top-news-container>* {
			display: flex;
			align-items: center;
		}

		#top-news .content {
			border-left-width: 1px;
			border-left-style: solid;
		}

		#top-news .content a {
			font-size: 1.4rem;
		}

		/****************************************************************************************/
		#banner a {
			width: 100%;
			display: block;
			position: relative;
			overflow: hidden;
		}

		#banner a:hover {
			text-decoration: none;
		}

		#banner a .image {
			width: 100%;
			height: 100%;
			background-size: cover;
			background-position: center;
			background-repeat: no-repeat;
			position: absolute;
			transition: transform 1500ms ease;
			<?php
			//		if (SHOW_TOP_PAGE_BANNER) {
			//			echo	"background-image: url('".getImg(TOP_PAGE_BANNER_IMAGE)."');".
			//					TOP_PAGE_BANNER_STYLE_SP;
			//		}
			?>
		}

		#banner a:hover .image {
			transform: scale(1.13);
		}

		#banner a .black {
			width: 100%;
			height: 100%;
			background-color: black;
			position: absolute;
			opacity: 0.3;
			transition: opacity 1500ms ease;
		}

		#banner a:hover .black {
			opacity: 0.1;
		}

		#banner a .text-container {
			height: 100%;
			color: white;
			display: flex;
			justify-content: center;
			align-items: center;
			position: relative;
			z-index: 1;
		}

		#banner a .text-container .text {
			text-align: center;
		}

		/****************************************************************************************/
		#about .image {
			background-image: url("<?php img("about"); ?>");
			background-size: cover;
			background-position: right;
		}

		/****************************************************************************************/
		<?php if (FEATURE_TYPE == 1) { ?>
			#feature[type="1"] .image-1 {
				background-image: url("<?php echoUpdateImgUrl($feature["topImage1"]); ?>");
				background-position: center;
			}

			<?php
			if (_isValidString($feature["topStyle"])) {
				echo $feature["topStyle"];
			}
			?>
			#feature[type="1"] .image-2 {
				background-image: url("<?php echoUpdateImgUrl($feature["topImage2"]); ?>");
				background-size: cover;
				background-position: center;
			}

			/*******************************************/
		<?php } else if (FEATURE_TYPE == 2) { ?>
				#feature[type="2"] .video {
				<?php if (array_key_exists("videoMaxWidth", $feature))
					echo "max-width: " . $feature["videoMaxWidth"] . ";"; ?>
					position: relative;
				}

				#feature[type="2"] .video video {
					width: 100%;
					object-fit: cover;
					display: block;
				}

				#feature[type="2"] .video .icon {
					top: 0;
					width: 100%;
					height: 100%;
					background-color: rgba(0, 0, 0, 0.2);
					display: flex;
					justify-content: center;
					align-items: center;
					position: absolute;
					cursor: pointer;
					transition: all 600ms cubic-bezier(0.19, 1.00, 0.22, 1.00);
				}

				#feature[type="2"] .video .icon:hover {
					background-color: rgba(0, 0, 0, 0.3);
				}

				#feature[type="2"] .video[playing="false"] .icon {
					opacity: 1;
				}

				#feature[type="2"] .video[playing="true"] .icon {
					opacity: 0;
				}

				#feature[type="2"] .video .icon img {
					opacity: 0.7;
					transition: opacity 600ms cubic-bezier(0.19, 1.00, 0.22, 1.00);
				}

				#feature[type="2"] .video .icon:hover img {
					opacity: 0.8;
				}

				#feature[type="2"] .text-container {
					text-align: center;
				}

				#feature[type="2"] .title {
					text-align: center;
				}

				#feature[type="2"] .subtitle {
					text-align: center;
				}

				#feature[type="2"] .text {
					text-align: left;
				}

				#feature[type="2"] .image {
					background-image: url("<?php echoUpdateImgUrl($feature["topImage"]); ?>");
					background-position: center;
					background-size: cover;
				}

		<?php } ?>

		/****************************************************************************************/
		#series .content .logo .icon svg {
			width: 100%;
			height: 100%;
		}

		/****************************************************************************************/
		#ranking .carousel {
			position: relative;
		}

		#ranking .swiper-pagination,
		#ranking .swiper-button-next,
		#ranking .swiper-button-prev {
			display: none;
		}

		/*******************************************/
		#ranking .swiper-slider-container {
			position: relative;
		}

		#ranking .swiper-container {
			width: 85%;
		}

		#ranking .swiper-wrapper {
			height: auto;
		}

		#ranking .swiper-slide {
			height: auto;
			background-color: white;
		}

		#ranking .swiper-slide:hover {
			text-decoration: none;
		}

		#ranking .swiper-slide [number] {
			border-width: 1px;
			border-style: solid;
			border-radius: 50%;
			display: flex;
			justify-content: center;
			align-items: center;
			position: absolute;
		}

		#ranking .swiper-slide [number="1"] {
			color: white;
			background-color: #c1aa79;
			border-color: #c1aa79 !important;
		}

		#ranking .swiper-slide [number="2"] {
			color: white;
			background-color: #afb0b1;
			border-color: #afb0b1 !important;
		}

		#ranking .swiper-slide [number="3"] {
			color: white;
			background-color: #bba495;
			border-color: #bba495 !important;
		}

		#ranking .swiper-slide .image {
			background-size: contain;
			background-position: center;
			background-repeat: no-repeat;
		}

		#ranking .swiper-slide .text {
			text-align: center;
		}

		#ranking .swiper-slide .text .category {
			border-top-width: 1px;
			border-top-style: solid;
		}

		#ranking .swiper-slide [has-category="false"] .category {
			/*	border-color: transparent;*/
		}

		#ranking .swiper-slide .text .text-container {
			text-align: left;
			display: inline-block;
		}

		/*******************************************/
		#ranking [slider] {
			top: 0;
			height: 100%;
			width: 7.5%;
			display: flex;
			justify-content: center;
			align-items: center;
			position: absolute;
			cursor: pointer;
		}

		#ranking [slider="right"] {
			right: 0;
		}

		/*******************************************/
		#ranking .pager {
			margin: 7px auto 0 auto;
		}

		#ranking .pager .table {
			width: 100%;
			display: table;
		}

		#ranking .pager [page] {
			text-align: center;
			display: table-cell;
		}

		#ranking .pager .button {
			width: 90%;
			display: inline-block;
			cursor: pointer;
			transition: background-color 600ms cubic-bezier(0.19, 1.00, 0.22, 1.00);
		}

		/****************************************************************************************/
		#gift .image {
			background-image: url("<?php img("gift"); ?>");
			background-size: cover;
			background-position: center;
		}

		#gift .desc {
			text-align: center;
		}

		#gift .desc p {
			text-align: left;
			display: inline-block;
		}

		/*******************************************/
		#gift .categories a:hover {
			text-decoration: none;
		}

		#gift .categories ul {
			display: flex;
			justify-content: space-between;
		}

		#gift .categories li {
			display: inline-block;
		}

		#gift .category-image-container {
			overflow: hidden;
		}

		#gift .category-image {
			height: 100%;
			background-size: cover;
			background-position: center;
			transition: transform 2200ms cubic-bezier(0.19, 1.00, 0.22, 1.00);
		}

		#gift .categories a:hover .category-image {
			transform: scale(1.13);
		}

		#gift .categories .text {
			display: flex;
			justify-content: center;
			align-items: center;
			transition-duration: 2200ms;
		}

		#gift .categories .text .text-container {
			padding-top: 4px;
			text-align: center;
			display: inline-block;
		}

		#gift .categories .text .name {
			font-weight: bold;
		}

		/****************************************************************************************/
		#instagram .posts {
			display: flex;
			justify-content: space-between;
		}

		/****************************************************************************************/
		#banners [nh-banner]:not(:first-child) {
			margin-top: 90px;
		}

		/****************************************************************************************/
		<?php
		if (_isValidString(TOP_TEXT_COLOR)) {
			echo "#top .text {\n" .
				"\tcolor: " . TOP_TEXT_COLOR . ";\n" .
				"}\n";
			echo "#top [icon] :before {\n" .
				"\tbackground-color: " . TOP_TEXT_COLOR . ";\n" .
				"}\n";
		}
		?>
		@media only screen and (min-width:<?php echo MIN_PC_VIEW_WIDTH; ?>px) {

			#news li {
				width: 32%;
			}

			<?php
			if (_isValidString(TOP_TEXT_COLOR)) {
				echo "[full-view='true'] .logo-area .logo svg,\n" .
					"[full-view='true'] .main-item .icon svg,\n" .
					"[full-view='true'] .secondary-list svg {\n" .
					"\tfill: " . TOP_TEXT_COLOR . ";\n" .
					"}\n";
				echo "[full-view='true'] .main-item .text,\n" .
					"[full-view='true'] .main-item .text a,\n" .
					"[full-view='true'] .secondary-list a {\n" .
					"\tcolor: " . TOP_TEXT_COLOR . ";\n" .
					"}\n";
				echo "[full-view='true'] .main-item .text:after,\n" .
					"[full-view='true'] .main-item .icon:after {\n" .
					"\tbackground-color: " . TOP_TEXT_COLOR . " !important;\n" .
					"}\n";
				echo "[full-view='true'] .secondary-list .text {\n" .
					"\tborder-color: " . TOP_TEXT_COLOR . ";\n" .
					"}\n";
				echo "[full-view='true'] .secondary-list[item='search'][focus='true'] .container {\n" .
					"\tborder-color: transparent;\n" .
					"}\n";
			}
			if (SHOW_TOP_PAGE_BANNER) {
				//	echo	"#banner a .image {\n".
				//			TOP_PAGE_BANNER_STYLE_PC."\n";
				//			"}\n";
			}
			?>
		}

		/****************************************************************************************/
		@media only screen and (min-width:<?php echo MIN_PC_VIEW_WIDTH; ?>px) {

			#top .image {
				background-image: url("<?php img(TOP_IMAGE_PC); ?>");
			}

			<?php if (IMAGE_LINK)
				echo "#top .image { cursor:pointer; };"; ?>
		}

		/*******************************************/
		@media only screen and (max-width:<?php echo MAX_SP_VIEW_WIDTH; ?>px) {

			#top .image {
				background-image: url("<?php img(TOP_IMAGE_SP); ?>");
			}
		}

		/****************************************************************************************/
		/*body[lang]:not([lang="ja"]) #top-news > *,*/
		body[lang]:not([lang="ja"]) #top .text .sub-copy,
		body[lang]:not([lang="ja"]) #feature-banners .button,
		body[lang]:not([lang="ja"]) #about h2+.sub,
		/*body[lang]:not([lang="ja"]) #feature,*/
		/*body[lang]:not([lang="ja"]) #series,*/
		body[lang]:not([lang="ja"]) #ranking,
		body[lang]:not([lang="ja"]) #gift,
		body[lang]:not([lang="ja"]) #banners [nh-banner]:nth-child(n+2),
		/*body[lang]:not([lang="ja"]) #news,*/
		body[lang]:not([lang="ja"]) #blog {
			display: none;
		}

		body[lang]:not([lang="ja"]) #top .text h1 {
			font-style: italic;
		}

		body[lang]:not([lang="ja"]) #top .text .message {
			margin-top: 48px;
		}

		body[lang]:not([lang="ja"]) [nh-banners] .text .sub {
			display: block !important;
		}

		[nh-banner] .text .main,
		[nh-banners] .text .main {
			line-height: 1;
		}

		/****************************************************************************************/
	</style>
	<script>
		//////////////////////////////////////////////////////////////////////////////////////////
		<?php if (SHOW_TOP_VIDEO) { ?>
			var setVideo = function () {
				var video = document.querySelector("#top video");
				video.style.left = "-" + ((video.offsetWidth - window.innerWidth) / 2) + "px";
				video.style.top = "-" + ((video.offsetHeight - window.innerHeight) / 2) + "px";
			};
			window.addEventListener("resize", setVideo);
			window.addEventListener("load", setVideo);
		<?php } ?>
		//////////////////////////////////////////////////////////////////////////////////////////
		var f = {
			headerHeight: 53,
			top: {
				text: null,
			},
			onLoad: function () {
				this.init();
				<?php echoInitInstagram($instagramPosts, "i"); ?>
				//		_.event.onScroll(this.onScroll.bind(this));
				//		this.onScroll();
			},
			init: function () {
				this.setIOS();
				this.top.text = _.get1("#top .text");
				this.carousel.init();
			},
			setIOS: function () {
				var ua = navigator.userAgent.toLowerCase();
				if (_.str.contains(ua, "iphone") || _.str.contains(ua, "ipad") || _.str.contains(ua, "ipod")) {
					document.body.setAttribute("ios", "true");
				}
			},
			onScroll: function () {
				if (document.body.scrollTop <= window.innerHeight) {
					this.top.text.style.transform = "translateY(" + document.body.scrollTop + "px)";
				}
			},
			onClickScroll: function () {
				_.dom.scroll(window.innerHeight - this.headerHeight);
			},
			carousel: {
				swiper: {
					pc: null,
					sp: null,
				},
				init: function () {
					this.setCarousel();
				},
				setCarousel: function () {
					<?php
					if (_isValid($ranking)) {
						foreach (array("pc", "sp") as $device) {
							$info = $rankingInfo["devices"][$device];
							?>
							this.swiper["<?php echo $device; ?>"] = new Swiper(".swiper-container-<?php echo $device; ?>", {
								slidesPerView: <?php echo $info["numOfVisibleProducts"]; ?>,
								slidesPerGroup: <?php echo $info["numToSlide"]; ?>,
								spaceBetween: 3,
								speed: <?php echo constant("RANKING_SLIDE_MS_" . strtoupper($device)); ?>,
								loop: <?php echo $info["hasSlider"] ? "true" : "false"; ?>,
								pagination: {
									el: ".swiper-pagination-<?php echo $device; ?>",
									clickable: true,
								},
								navigation: {
									nextEl: ".swiper-button-next-<?php echo $device; ?>",
									prevEl: ".swiper-button-prev-<?php echo $device; ?>",
								},
							});
							this.swiper["<?php echo $device; ?>"].on("slideChange", function () {
								this.onSlide("<?php echo $device; ?>");
							}.bind(this));
							<?php
						}
					}
					?>
				},
				updatePager: function (device) {
					var swiperContainer = this.swiper[device].$el[0];
					//			var index = parseInt(_.get1In(swiperContainer, ".swiper-wrapper .swiper-slide-active").getAttribute("data-swiper-slide-index"));
					//			var page = (index / this.swiper[device].params.slidesPerGroup) + 1;
					var pagerElement = _.get1In(swiperContainer, ".swiper-pagination-bullet-active");
					var index = _.dom.getIndex(pagerElement);
					var carousel = _.dom.getParentByAttr(swiperContainer, "device");
					_.get1In(carousel, ".pager [selected]").removeAttribute("selected");
					_.get1In(carousel, ".pager [page='" + (index + 1) + "']").setAttribute("selected", "");
				},
				onClickLeftSlider: function (device) {
					this.swiper[device].navigation.prevEl.click();
				},
				onClickRightSlider: function (device) {
					this.swiper[device].navigation.nextEl.click();
				},
				onClickPager: function (e, device, page) {
					var parentElement = _.dom.getParentByAttr(e, "page");
					if (!parentElement.hasAttribute("selected")) {
						this.swiper[device].pagination.$el[0].children[page - 1].click();
					}
				},
				onSlide: function (device) {
					this.updatePager(device);
				},
			},
		};
		//////////////////////////////////////////////////////////////////////////////////////////
	</script>
</head>

<body lang="<?php echoLang(); ?>" ios="false">
	<?php echoHeader(); ?>

	<section id="top">
		<?php
		if (SHOW_TOP_VIDEO) {
			echo "<video video='top' src='" . getVideo(TOP_VIDEO) . "' " . (_isValid(TOP_VIDEO_THUMBNAIL) ? "poster='" . getVideo(TOP_VIDEO_THUMBNAIL) . "'" : "") . " playsinline autoplay muted loop></video>";
			if (_isValid(TOP_VIDEO_DARKNESS))
				echo "<div class='video_darkness'></div>";
		} else {
			echo "<div class='image' " . (IMAGE_LINK ? "onclick='location.href=\"" . IMAGE_LINK_URL . "\"'" : "") . "></div>";
		}
		?>
		<div class="text" nh-faded-up="false">
			<div class="text-container" nh-gray-border="3">

				<h1><?php t("aHomeForYourClothes"); ?></h1>
				<div class="sub-copy" nh-font="2"><?php t("aHomeForYourClothes2"); ?></div>
				<div class="message" nh-font="1">
					<p><?php t("aHomeForYourClothesMessage"); ?></p>
				</div>

			</div>

			<div class="scroll" onclick="f.onClickScroll();">
				<div class="scroll-text">SCROLL</div>
				<div class="icon"><?php icon("down"); ?></div>
			</div>

		</div>
	</section>

	<?php if (_isValid($news)) { ?>
		<section id="top-news" nh-content-sp="padding" header-view>
			<div class="top-news-container" nh-gray-border="4">
				<h1 nh-font="2"><?php t("news2"); ?></h1>
				<div class="content" nh-gray-border="4">
					<a href="<?php echo getHref("news") . "/" . $news[0]["id"]; ?>"
						title="<?php echo $news[0]["title"]; ?>"><?php echo formatDate($news[0]["postedAt"]) . "&nbsp;&nbsp;" . $news[0]["title"]; ?></a>
				</div>
			</div>
		</section>
	<?php } ?>

	<style>
		#trunkshow2024 [nh-banner] .image {
			background-position: center 31%;
		}

		#trunkshow2024 [nh-banner] .text-container {
			color: #333;
		}

		#trunkshow2024 [nh-banner] .text {
			background-color: rgba(255, 255, 255, 0.5);
		}

		#trunkshow2024 [nh-banner] .text .main {
			letter-spacing: 0.15rem;
		}

		#trunkshow2024 [nh-banner] .text .sub {
			font-family: "EB Garamond", "游明朝", YuMincho, "ヒラギノ明朝 ProN W3", "Hiragino Mincho ProN", "Sawarabi Mincho", "HG明朝E", "ＭＳ Ｐ明朝", "ＭＳ 明朝", serif;
			font-weight: bold;
			display: block !important;
		}

		/*******************************************/
		@media only screen and (min-width:<?php echo MIN_PC_VIEW_WIDTH; ?>px) {

			#trunkshow2024 [nh-banner] .text {
				padding: 25px 60px 15px;
			}

			#trunkshow2024 [nh-banner] .text .main {
				font-size: 4.5rem;
			}

			#trunkshow2024 [nh-banner] .text .main div {
				margin-bottom: 5px;
				font-size: 1.4rem;
				letter-spacing: -0.05rem;
			}

			#trunkshow2024 [nh-banner] .text .sub {
				margin-top: 15px;
				font-size: 2.4rem;
				line-height: 3.5rem;
			}

		}

		/*******************************************/
		@media only screen and (max-width:<?php echo MAX_SP_VIEW_WIDTH; ?>px) {

			#trunkshow2024 [nh-banner] .text {
				padding: 10px 20px 10px;
			}

			#trunkshow2024 [nh-banner] .text .main div {
				font-size: 1.3rem;
				letter-spacing: -0.05rem;
			}

			#trunkshow2024 [nh-banner] .text .sub {
				margin-top: 5px;
				font-size: 1.5rem;
				line-height: 2rem;
				letter-spacing: -0.05rem;
			}

		}
	</style>
	<!-- <section id="trunkshow2024" nh-margin-section="top">
		<div class="content-area-container">
			<div class="content-area" nh-content-sp="padding">
			<?php banner("trunkshow_2024_ny"); ?>
			</div>
		</div>
	</section> -->

	<?php if (_isValid($news)) { ?>
		<section id="news" nh-margin-section="top">
			<div class="content-area-container">
				<div class="content-area" nh-content-sp="padding">
					<h1><?php t("news2"); ?></h1>
					<ul nh-news>
						<?php
						for ($i = 0, $len = sizeof($news); $i < $len; $i++) {
							echo "<li nh-gray-border='2' nh-fade-up-follow='news' nh-faded-up='false'>" . getNewsHtml($news[$i]) . "</li>";
						}
						?>
					</ul>
					<div class="button"><a href="<?php href("news"); ?>" nh-button><?php t("readMore"); ?></a></div>
				</div>
			</div>
		</section>
	<?php } ?>

	<?php /* ?>
<style>
#info-en {
text-align: center;
}
#info-en .info:nth-child(n+2) {
margin-top: 60px;
}
#info-en .info .container {
max-width: 764px;
border-style: solid;
border-width: 1px;
text-align: left;
display: inline-block;
}
#info-en .info .title {
font-weight: bold;
text-decoration: underline;
}
#info-en .info .body {
}
#info-en .info .body > *:nth-child(n+2) {
margin-top: 12px;
}
@media only screen and (min-width: <?php echo MIN_PC_VIEW_WIDTH; ?>px) {
#info-en {
margin-top: 100px;
}
#info-en .info .container {
padding: 20px 40px;
}
#info-en .info .title {
font-size: 1.8rem;
}
#info-en .info .body {
margin-top: 20px;
line-height: 2.3rem;
}
}
@media only screen and (max-width: <?php echo MAX_SP_VIEW_WIDTH; ?>px) {
#info-en {
margin-top: 60px;
}
#info-en .info .container {
padding: 15px 15px;
}
#info-en .info .body {
margin-top: 15px;
line-height: 2.2rem;
}
}
</style>
<section id="info-en" lang="en">
<div class="content-area-container">
<div class="content-area" nh-content-sp="padding">
<div class="info" style="display:none;">
<div class="container" nh-gray-border="3">
<div class="title">Notice of summer holiday</div>
<div class="body">
<div>Thank you for using our online shop.  Our company will be closed during the following period.</div>
<div style="font-weight:bold; text-align:center;">August 13th (Thu) - 16th (Sun)</div>
<div>For orders and inquiries received during the holiday, we will respond from August 17th.</div>
<div>* Orders will be accepted as usual during the holiday too.<br>* Tokyo Aoyama Showroom will also be closed during the holiday.</div>
<div>Thank you for your understanding.</div>
</div>
</div>
</div>
<div class="info">
<div class="container" nh-gray-border="3">
<div class="title">About shipping to the United States and China</div>
<div class="body">
<div>Due to the global spread of Covid-19, we have been unable to ship to the United States and China by EMS.  If you are ordering from these countries, please contact us directly to find out alternative shipping methods and charges.<br>We apologize for any inconvenience this may cause and thank you for your understanding.</div>
<div>Contact us from <a href="<?php href("inquiry"); ?>" style="color:blue; text-decoration:underline;">here</a>.</div>
</div>
</div>
</div>
</div>
</div>
</section>
<?php */ ?>

	<?php if (LANG == LANG_EN) { ?>

		<style>
			#feature-banner {
				margin-top: 130px;
			}

			#feature-banner [nh-banner] .text .main {
				line-height: 45px;
			}

			#feature-banner [nh-banner] .text .sub {
				display: block !important;
			}

			#feature-banner .main {
				font-size: 3.6rem;
			}
		</style>
		<section id="feature-banner">
			<div class="content-area-container">
				<div class="content-area" nh-content-sp="padding">
					<?php banners("wajima2025", "hanger_size", "set02-2025ss"); ?>
				</div>
			</div>
		</section>

		<style>
			#featured-products {
				margin-top: 130px;
			}

			body:not([within-page-1]) #featured-products {
				opacity: 0;
			}

			#featured-products .product-container {
				display: flex;
			}

			#featured-products .product {
				padding: 5px;
				border: 1px solid transparent;
			}

			#featured-products .product:hover {
				border-color: #dfdfdf;
			}

			#featured-products .product img {
				width: 100%;
			}

			#featured-products .product .text {
				text-align: center;
			}

			#featured-products .product .text>* {
				display: inline-block;
			}

			#featured-products .product .name {
				margin-right: 15px;
				font-weight: bold;
			}

			#featured-products .product .category {
				font-size: 1.4rem;
			}

			@media only screen and (min-width:<?php echo MIN_PC_VIEW_WIDTH; ?>px) {
				#featured-products h1 {
					font-size: 4.5rem;
				}
			}

			@media only screen and (max-width:<?php echo MAX_SP_VIEW_WIDTH; ?>px) {
				#featured-products h1 {
					font-size: 3.3rem;
				}

				#featured-products .product-container {
					flex-wrap: wrap;
				}

				#featured-products .product {
					margin-bottom: 20px;
					width: 50%;
				}
			}
		</style>
		<section id="featured-products">
			<div class="content-area-container">
				<div class="content-area">
					<h1>Featured Products</h1>
					<?php
					$products = array(
						array("name" => "AUT-05", "category" => "Men's Suit Hanger", "color" => "Mars Brown", "image" => "AUT-05.webp", "url" => "aut-05-mens-suit-hanger-mars-brown"),
						array("name" => "SET-01", "category" => "Men's Suit Hanger", "color" => "Smoked Brown", "image" => "SET-01.webp", "url" => "set-01-mens-suit-hangers-5-pieces-smoked-brown"),
						array("name" => "WJ-03A", "category" => "Wajima Lacquered Hanger", "color" => "Lapis Lazuli", "image" => "wj03a.webp", "url" => "wj-03a-wajima-lacquered-hanger-lapis-lazuli"),
						array("name" => "Barca", "category" => "Handy Clothes Brush", "color" => "Ocean Blue", "image" => "barca.webp", "url" => "barca-mobile-clothes-brush-ocean-blue"),
						// array("name" => "Clothes Brush", "category" => "Horse Hair", "color" => "Mars Brown", "image" => "horsebrush.webp", "url" => "clothes-brush-horse-hair-mars-brown"),
						// array("name" => "John Pole Hanger", "category" => "Coat Rack", "color" => "Smoked Brown", "image" => "John_Pole_Hanger.jpg", "url" => "pole-hanger-john-pole-hanger"),
						// array("name" => "WJ-01A", "category" => 'Wajima Lacquered Hanger', "color" => "RISE Red", "image" => "125571332_700x700.jpg", "url" => "wj-01a-wajima-lacquering-technique-hanger-vermilion"),
						// array("name"=>"Giorno", "category"=>"Valet Stand", "color"=>"Smoked Brown", "image"=>"126474434.jpg", "url"=>"valet-hanger-stand-giorno-smoked-brown"),
						// array("name" => "FJ-01A", "category" => 'Fuji Hanger "RISE"', "color" => "RISE Blue", "image" => "FJ-01A.jpg", "url" => "fj-01a?variant=41932751601843"),
						// array("name"=>"FJ-02A", "category"=>'Fuji Hanger "RISE"', "color"=>"RISE Red", "image"=>"166395582_0b0b8919-b9a3-4811-ae81-08c449ee4401.jpg", "url"=>"fj-02a?variant=41932755271859"),
					);
					echo "<div class='product-container'>";
					foreach ($products as $product) {
						echo "<a class='product' href='https://shop.nakatahanger.com/en/products/" . $product["url"] . "'>" .
							//"<div><img src='https://cdn.shopify.com/s/files/1/0298/1924/0501/products/" . $product["image"] . "' " . (array_key_exists("imgStyle", $product) ? "style='" . $product["imgStyle"] . ";'" : "") . "></div>" .
							"<div><img src='" . getImg($product["image"]) . "' " . (array_key_exists("imgStyle", $product) ? "style='" . $product["imgStyle"] . ";'" : "") . "></div>" .
							"<div class='text'>" .
							"<div class='name'>" . $product["name"] . "</div>" .
							"<div class='category'>" . $product["category"] . "</div>" .
							"</div>" .
							"</a>";
					}
					echo "</div>";
					?>
				</div>
			</div>
		</section>
	<?php } ?>

	<section id="feature-banners" nh-margin-section="top">
		<div class="content-area-container">
			<div class="content-area" nh-content-sp="padding">
				<?php echoFeatureBanners($features, $topFeatureDates, true, "top-banner-link"); ?>
				<div class="button" nh-fade-up-follow="feature-banner" nh-faded-up="false">
					<a href="<?php href("features"); ?>?link=top_banner_features" nh-button>
						<?php t("viewAll"); ?></a>
				</div>
			</div>
		</div>
	</section>

	<?php /* if (SHOW_TOP_PAGE_BANNER) { ?>
<section id="banner" nh-margin-section="top">
<div class="content-area-container">
<div class="content-area" nh-content-sp="padding">
<div class="banner" nh-faded-up="false" nh-fade-up-follow="feature">
<a href="<?php echo getFeatureUrl("2018-11-26"); ?>" nh-link>
<div class="image" style="background-image:url('<?php img("feature-20181126-1.jpg"); ?>'); background-position:0 top;"></div>
<div class="black"></div>
<div class="text-container">
<div class="text" nh-font="1">
<div class="text-1">Winter Gift</div>
<div class="text-2">冬の贈りもの</div>
</div>
</div>
</a>
</div>
<div class="banner" nh-fade-up-follow="feature">
<a href="<?php echo TOP_PAGE_BANNER_URL; ?>" nh-link>
<div class="image" style="background-image:url('<?php img(TOP_PAGE_BANNER_IMAGE); ?>'); background-position:77% 0;"></div>
<div class="black"></div>
<div class="text-container">
<div class="text" nh-font="1">
<div class="text-1">Outerwear Hangers</div>
<div class="text-2">アウター用ハンガー特集</div>
</div>
</div>
</a>
</div>
<div class="banner" nh-fade-up-follow="feature">
<a href="<?php echo getFeatureUrl("2018-11-25"); ?>" nh-link>
<div class="image" style="background-image:url('<?php img("feature-20181125-1.jpg"); ?>'); background-position:78% 68%; background-size:185%;"></div>
<div class="black"></div>
<div class="text-container">
<div class="text">
<div class="text-1" nh-font="1">Christmas Gift 2018</div>
<div class="text-2" nh-font="1">心躍る季節ならではの彩りを</div>
<div class="text-3">（販売終了しました）</div>
</div>
</div>
</a>
</div>
</div>
</div>
</section>
<?php } */ ?>

	<section id="about" nh-margin-section="top" nh-faded-up="false">
		<div class="content-area-container">
			<div class="content-area" nh-gray-border-ba="4">
				<div class="title">
					<h1><?php t("about2"); ?></h1>
				</div>
				<div class="image"></div>
				<div class="text">
					<div class="desc">
						<h2 nh-font="1" nh-gray-bg-ba="3"><?php t("aHomeForYourClothes"); ?></h2>
						<div class="sub" nh-font="2"><?php t("aHomeForYourClothes2"); ?></div>
					</div>
					<div class="button" nh-content-sp="padding"><a href="<?php href("about"); ?>?link=top_banner_about"
							nh-button><?php t("readMore"); ?></a></div>
				</div>
			</div>
		</div>
	</section>

	<?php if (LANG == LANG_EN) { ?>
		<style>
			.horizontal-line {
				flex-grow: 1;
				height: 2px;
				background-color: #000;
			}

			.horizontal-line-section {
				border: none;
				height: 1px;
				background-color: #000;
				margin: 10px 0;
			}
		</style>
		<section id="media" nh-margin-section="top" nh-faded-up="false" nh-content-sp="padding">
			<div class="content-area-container">
				<div class="content-area" nh-gray-border-ba="4">
					<div class="title" style="display: flex; align-items: baseline;">
						<hr class="horizontal-line" device='sp'>
						<h1>Our Recognition</h1>
						<hr class="horizontal-line">
					</div>
					<div id="logo_box">
						<p class="logo_box_img">
							<a href="https://www.nytimes.com/2023/11/17/fashion/nakata-clothing-hangers-japan.html"
								target="_blank">
								<img src="<?php img("logo_nytimes.png"); ?>" style="width:100%;">
							</a>
						</p>
						<p class="logo_box_img">
							<a href="https://robbreport.com/style/menswear/review-nakata-valet-stand-1235365817/"
								target="_blank">
								<img src="<?php img("logo_robbreport.png"); ?>" style="width:60%;">
							</a>
						</p>
					</div>
					<hr class="horizontal-line-section">
				</div>
			</div>
		</section>
	<?php } ?>

	<section id="instagram" nh-margin-section="top" nh-content-sp="padding">
		<div class="content-area-container">
			<div class="content-area">
				<div class="text">
					<h1>#NAKATAHANGER Gallery</h1>
					<div class="desc"><?php t("instagramDesc"); ?></div>
				</div>
				<div class="posts">
					<?php
					for ($i = 0; $i < 4; $i++) {
						echo "<div nh-fade-up-follow='instagram' nh-faded-up='false'>" . getInstagramHtml($instagramPosts[$i], $i) . "</div>";
					}
					?>
				</div>
				<div class="button"><a href="<?php href("instagram_page"); ?>?link=top_banner_ugc"
						nh-button><?php t("viewAll"); ?></a></div>
			</div>
		</div>
	</section>

	<?php if (SHOW_FEATURE) { ?>
		<section id="feature" type="<?php echo FEATURE_TYPE; ?>" nh-margin-section="top" nh-gray-bg="1">
			<div class="content-area-container">
				<div class="content-area">
					<h1><?php t("feature2"); ?></h1>
					<?php if (FEATURE_TYPE == 1) { ?>
						<div class="image-1" nh-faded-up="false"></div>
						<div class="text-1">
							<div>
								<h2 nh-font="1" nh-gray-bg-ba="3" style="font-weight:900;"><?php echo $feature["text1-1"]; ?>
								</h2>
								<div class="sub" nh-font="2"><?php echo $feature["text1-2"]; ?></div>
							</div>
						</div>
						<div class="image-2" nh-content-sp="margin" nh-faded-up="false"></div>
						<div class="text-button" nh-content-sp="padding" nh-margin-text="top">
							<div class="text-2"><?php echo $feature["text2"]; ?></div>
							<div class="button">
								<?php if (array_key_exists("url", $feature) && _isValidString($feature["url"])) { ?>
									<a href="<?php echo $feature["url"]; ?>" nh-button
										nh-gray-bg-hover="2"><?php t("readMore"); ?></a>
								<?php } ?>
							</div>
						</div>
					<?php } else if (FEATURE_TYPE == 2) { ?>
							<div class="layout" nh-content-sp="padding">
								<div class="column">
									<div class="video-container">
										<div class="video" playing="false">
											<video src="<?php echo getVideo($feature["video"]); ?>" playsinline muted <?php if (array_key_exists("thumbnail", $feature))
												   echo "poster='" . getImg($feature["thumbnail"]) . "'"; ?> onloadedmetadata="nh.video.onLoad(this);"
												onplay="nh.video.onPlay(this);" onpause="nh.video.onPause(this);"></video>
											<div class="icon" onclick="nh.video.onClick(this);"><img
													src="<?php img("play-64.png"); ?>"></div>
										</div>
									</div>
									<div class="text-image-container">
										<div class="text-container" nh-font="1">
											<div>
												<div class="title"><?php echo $feature["title"]; ?></div>
												<div class="subtitle"><?php echo $feature["subtitle"]; ?></div>
												<div class="text"><?php echo $feature["text"]; ?></div>
											</div>
										</div>
										<div class="image-container">
											<div class="image"></div>
										</div>
									</div>
								</div>
								<div class="button">
									<div class="button">
										<a href="<?php echo $feature["url"]; ?>" nh-button
											nh-gray-bg-hover="2"><?php t("readMore"); ?></a>
									</div>
								</div>
							</div>
					<?php } ?>
				</div>
			</div>
		</section>
	<?php } ?>

	<section id="series" nh-margin-section="top">
		<h1><?php t("products2"); ?></h1>
		<div class="series">
			<?php foreach (array("nh", "aut", "set") as $s) { ?>
				<div class="a-series" item="<?php echo $s; ?>" nh-faded-up="false">
					<!--			<div class="image" style="background-image:url('<?php img("series_$s"); ?>');"></div>-->
					<div class="image" url='<?php echo getImg("series_$s"); ?>'></div>
					<div class="content-area-container" nh-content-sp="padding">
						<div class="content-area">
							<div class="content">
								<div class="content-container">
									<div class="logo">
										<div class="icon"><?php logo($s); ?></div>
										<div class="logo-series" nh-font="2"><?php t("series2"); ?></div>
									</div>
									<div class="desc" nh-lh="desc">
										<p><?php t("seriesDesc" . _capitalize($s)); ?></p>
									</div>
									<div class="button"><a href="<?php href($s); ?>?link=top_banner_<?php echo $s; ?>"
											nh-button><?php t("viewAll"); ?></a></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
	</section>

	<?php if (_isValid($ranking) && sizeof($ranking) != 0) { ?>
		<section id="ranking" nh-margin-section="top" nh-gray-bg="1">
			<h1><?php t("ranking2"); ?></h1>
			<?php
			$list = "";
			for ($i = 0, $len = sizeof($ranking); $i < $len; $i++) {
				$product = $ranking[$i];
				$category = _isValid($product["custom"]["category"]) ? $product["custom"]["category"] : "";
				$list .= "<a class='swiper-slide' href='" . getProductUrl($product["id"]) . "'>" .
					"<div number='" . ($i + 1) . "' nh-gray-text='4' nh-gray-border='3'>" . ($i + 1) . "</div>" .
					//							"<div class='image' style='background-image:url(\"".$product["image_url"]."\");'></div>".
					"<div class='image' url='" . $product["image_url"] . "'></div>" .
					"<div class='text' has-category='" . (_isValidString($category) ? "true" : "false") . "'>" .
					"<div class='name' nh-gray-border='3'>" .
					"<div class='text-container'>" . $product["custom"]["name"] . "</div>" .
					"</div>" .
					"<div class='category' nh-gray-border='3'>" .
					"<div class='text-container'>$category</div>" .
					"</div>" .
					"</div>" .
					"</a>";
			}

			foreach (array("pc", "sp") as $device) {
				$info = $rankingInfo["devices"][$device];
				echo "<div class='carousel' device='$device'>" .
					"<div class='swiper-slider-container'>" .
					"<div class='swiper-container swiper-container-$device'>" .
					"<div class='swiper-wrapper'>$list</div>" .
					"<div class='swiper-pagination swiper-pagination-$device'></div>" .
					"<div class='swiper-button-next swiper-button-next-$device'></div>" .
					"<div class='swiper-button-prev swiper-button-prev-$device'></div>" .
					"</div>";
				if ($info["hasSlider"]) {
					foreach (array("left", "right") as $side) {
						echo "<div slider='$side' onclick='f.carousel.onClick" . _capitalize($side) . "Slider(\"$device\");'>" .
							"<div class='icon'>" . getIcon($side, "nh-gray-bg-ba='3'") . "</div>" .
							"</div>";
					}
				}
				echo "</div>";
				if ($info["numOfPages"] > 1) {
					echo "<div class='pager'>";
					echo "<div class='table'>";
					for ($i = 0; $i < $info["numOfPages"]; $i++) {
						$selected = ($i == 0) ? "selected" : "";
						echo "<div page='" . ($i + 1) . "' $selected>" .
							"<div class='button' nh-gray-bg='2' onclick='f.carousel.onClickPager(this, \"$device\", " . ($i + 1) . ");'></div>" .
							"</div>";
					}
					echo "</div>";
					echo "</div>";
				}
				echo "</div>";
			}
			?>
		</section>
	<?php } ?>

	<section id="gift" nh-margin-section="top" nh-faded-up="false">
		<div class="content-area-container">
			<div class="content-area">
				<h1><?php t("gift2"); ?></h1>
				<div class="image"></div>
				<div class="desc" nh-content-sp="padding" nh-desc>
					<p><?php t("giftDesc1"); ?></p>
					<p><?php t("giftDesc2"); ?></p>
				</div>
				<div class="button" nh-content-sp="padding"><a
						href="<?php href("gift", array("link" => "top_banner_gift")); ?>"
						nh-button><?php t("viewAll"); ?></a></div>
				<div class="categories" nh-content-sp="padding">
					<ul>
						<li nh-fade-up-follow="gift" nh-faded-up="false">
							<a href="<?php href("bridal", array("link" => "top_banner_bridal")); ?>" target="_blank"
								nh-gray-bg-hover="2">
								<div class="category-image-container">
									<div class="category-image"
										style="background-image:url('<?php img("bridal"); ?>');"></div>
								</div>
								<div class="text" nh-gray-bg="1" nh-gray-bg-hover nh-link>
									<div class="text-container">
										<div class="name"><?php ts("weddingGift", "/", "familyCelebration"); ?></div>
										<div class="notice"><?php ts("asterist", "movingToSpecialSite"); ?></div>
									</div>
								</div>
							</a>
						</li>
						<li nh-fade-up-follow="gift" nh-faded-up="false">
							<a href="<?php href("graduation", array("link" => "top_banner_grad")); ?>"
								nh-gray-bg-hover="2">
								<div class="category-image-container">
									<div class="category-image"
										style="background-image:url('<?php img("graduation"); ?>');"></div>
								</div>
								<div class="text" nh-gray-bg="1" nh-gray-bg-hover nh-link>
									<div class="text-container">
										<div class="name"><?php t("graduationGift"); ?></div>
									</div>
								</div>
							</a>
						</li>
						<li nh-fade-up-follow="gift" nh-faded-up="false">
							<a href="<?php href("organization"); ?>?link=top_banner_org" nh-gray-bg-hover="2">
								<div class="category-image-container">
									<div class="category-image"
										style="background-image:url('<?php img("organization"); ?>');"></div>
								</div>
								<div class="text" nh-gray-bg="1" nh-gray-bg-hover nh-link>
									<div class="text-container">
										<div class="name"><?php t("forOrg"); ?></div>
									</div>
								</div>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</section>

	<section id="banners" nh-margin-section="top">
		<div class="content-area-container">
			<div class="content-area" nh-content-sp="padding">
				<?php
				banner("stores", null, array("link" => "top_banner_stores"));
				banner("howto", null, array("link" => "top_banner_choose"));
				banner("concierge", null, array("link" => "top_banner_concierge"));
				banner("sdgs");
				//			banner("shimasaki");
				?>
			</div>
		</div>
	</section>

	<section id="blog" nh-margin-section="top">
		<div class="content-area-container">
			<div class="content-area" nh-content-sp="padding">
				<?php banner("blog", "target='_blank'"); ?>
			</div>
		</div>
	</section>

	<?php if (LANG == LANG_EN) { ?>
		<style>
			#other-sites {
				text-align: center;
			}

			#other-sites .link {
				padding: 15px 15px 7px 15px;
				display: inline-block;
				position: relative;
			}

			#other-sites .link img {
				width: 100%;
			}

			@media only screen and (min-width:<?php echo MIN_PC_VIEW_WIDTH; ?>px) {
				#other-sites {
					margin-top: 200px;
				}

				#other-sites .link {
					width: 275px;
				}

				#other-sites+[nh-margin-section="top"] {
					margin-top: 200px;
				}
			}

			@media only screen and (max-width:<?php echo MAX_SP_VIEW_WIDTH; ?>px) {
				#other-sites {
					margin-top: 105px;
				}

				#other-sites .link {
					width: 200px;
				}

				#other-sites+[nh-margin-section="top"] {
					margin-top: 105px;
				}

				footer {
					margin-top: 105px;
				}
			}
		</style>
		<section id="other-sites">
			<div class="content-area-container">
				<div class="content-area" nh-content-sp="padding">
					<div class="link">
						<a href="https://amzn.to/2SP6Mum" target="_blank" nh-hover><img
								src="<?php img("amazon-com.png"); ?>"></a>
					</div>
				</div>
			</div>
		</section>
	<?php } ?>

	<?php if (LANG == LANG_JA)
		echoCorporateLink(); ?>

	<div nh-margin-section="top"><?php echoFooter(); ?></div>
</body>

</html>