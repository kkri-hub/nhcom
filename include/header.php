<style>
	/*
@media only screen and (max-width: <?php echo MAX_SP_VIEW_WIDTH; ?>px) {
	header .menu-container {
		padding-bottom: 60px;
	}
	[nh-margin="header"] {
		margin-top: 53px;
	}
}
@media only screen and (min-width: <?php echo MIN_PC_VIEW_WIDTH; ?>px) {
	[nh-margin="header"] {
		margin-top: 148px;
	}
}
*/
</style>

<style>
	/*
#header-news {
	top: 0;
	width: 100%;
	position: fixed;
	z-index: 200;
	transition: transform 600ms cubic-bezier(0.19, 1.00, 0.22, 1.00);
}
[scrolled="false"] #header-news {
	transform: translateY(0px);
}
*/
	/*
@media only screen and (max-width: <?php echo MAX_SP_VIEW_WIDTH; ?>px) {
	header {
		transition: transform 600ms cubic-bezier(0.19, 1.00, 0.22, 1.00);
	}

	header .menu-container {
		padding-bottom: 110px;
	}

	[nh-margin="header"] {
		margin-top: 103px;
	}
}
@media only screen and (min-width: <?php echo MIN_PC_VIEW_WIDTH; ?>px) {
	[nh-margin="header"] {
		margin-top: 198px;
	}
}
*/
</style>

<?php
$sp_menuPaddingBottom = 60;
$sp_marginHeader = 53;

$pc_marginHeader = 148;

$showHeaderNews = false;
$headerNewsHeight = 0;
if ((LANG == LANG_JA && (SHOW_HEADER_NEWS_1 || SHOW_HEADER_NEWS_2)) ||
	(LANG == LANG_EN && (EN_SHOW_HEADER_NEWS_1 || EN_SHOW_HEADER_NEWS_2))
) {
	$showHeaderNews = true;
	$headerNewsHeight = 50;
}
?>
<style>
	/****************************************************************************************/
	#header-news {
		height: <?php echo $headerNewsHeight ?>px;
		/*	background-color: <?php // echo HEADER_NEWS_BACKGROUND_COLOR; 
								?>;*/
		transform: translateY(-<?php echo $headerNewsHeight ?>px);
	}

	/********************************************/
	<?php if ($showHeaderNews) { ?>body:not([header-news="false"])[scrolled-header-news="false"] header {
		transform: translateY(<?php echo $headerNewsHeight ?>px);
	}

	<?php } ?>
	/****************************************************************************************/
	@media only screen and (max-width: <?php echo MAX_SP_VIEW_WIDTH; ?>px) {
		header .menu-container {
			padding-bottom: <?php echo $sp_menuPaddingBottom + $headerNewsHeight; ?>px;
		}

		[nh-margin="header"] {
			margin-top: <?php echo $sp_marginHeader + $headerNewsHeight; ?>px;
		}

		body[header-news="false"] header .menu-container {
			padding-bottom: <?php echo $sp_menuPaddingBottom; ?>px;
		}

		body[header-news="false"] [nh-margin="header"] {
			margin-top: <?php echo $sp_marginHeader; ?>px;
		}

		<?php if ($showHeaderNews) { ?>body:not([header-news="false"]) header {
			transition: transform 600ms cubic-bezier(0.19, 1.00, 0.22, 1.00);
		}

		<?php } ?>
	}

	/********************************************/
	@media only screen and (min-width: <?php echo MIN_PC_VIEW_WIDTH; ?>px) {
		[nh-margin="header"] {
			margin-top: <?php echo $pc_marginHeader + $headerNewsHeight; ?>px;
		}

		body[header-news="false"] [nh-margin="header"] {
			margin-top: <?php echo $pc_marginHeader; ?>px;
		}
	}

	/****************************************************************************************/
	/*
@media only screen and (max-width: <?php echo MAX_SP_VIEW_WIDTH; ?>px) {
	header .menu-container {
		padding-bottom: <?php // echo $sp["menuPaddingBottom"]; 
						?>px;
	}
	[nh-margin="header"] {
		margin-top: <?php // echo $sp["marginHeader"]; 
					?>px;
	}
	<?php /* if (SHOW_HEADER_NEWS) { ?>
		header {
			transition: transform 600ms cubic-bezier(0.19, 1.00, 0.22, 1.00);
		}
	<?php } */ ?>
}
*/
	/********************************************/
	/*
@media only screen and (min-width: <?php echo MIN_PC_VIEW_WIDTH; ?>px) {
	[nh-margin="header"] {
		margin-top: <?php // echo $pc["marginHeader"]; 
					?>px;
	}
}
*/
	/****************************************************************************************/
</style>

<?php
/*
if ($showHeaderNews) {
	$imgPc = _isValidString(HEADER_NEWS_IMAGE_PC) ? "<img device='pc' src='".getImg(HEADER_NEWS_IMAGE_PC)."'>" : "";
	$imgSp = _isValidString(HEADER_NEWS_IMAGE_SP) ? "<img device='sp' src='".getImg(HEADER_NEWS_IMAGE_SP)."'>" : "";
	$content = $imgPc.$imgSp;

	$hasLink = "false";
	if (SHOW_HEADER_NEWS_AS_LINK && _isValidString(HEADER_NEWS_URL)) {
		$hasLink = "true";
		$content = "<a href='".HEADER_NEWS_URL."'>$content</a>";
	}
	echo	"<div id='header-news' has-link='$hasLink'>$content</div>";
}
*/

if ($showHeaderNews) {
	if (LANG == LANG_JA) {
		$showHeaderNews1			= SHOW_HEADER_NEWS_1;
		$showHeaderNews1AsLink		= SHOW_HEADER_NEWS_1_AS_LINK;
		$headerNews1ImageSp1		= HEADER_NEWS_1_IMAGE_SP_1;
		$headerNews1ImageSp2		= HEADER_NEWS_1_IMAGE_SP_2;
		$headerNews1ImagePc1		= HEADER_NEWS_1_IMAGE_PC_1;
		$headerNews1ImagePc2		= HEADER_NEWS_1_IMAGE_PC_2;
		$headerNews1BackgroundColor	= HEADER_NEWS_1_BACKGROUND_COLOR;
		$headerNews1Url				= HEADER_NEWS_1_URL;

		$showHeaderNews2			= SHOW_HEADER_NEWS_2;
		$showHeaderNews2AsLink		= SHOW_HEADER_NEWS_2_AS_LINK;
		$headerNews2ImageSp1		= HEADER_NEWS_2_IMAGE_SP_1;
		$headerNews2ImageSp2		= HEADER_NEWS_2_IMAGE_SP_2;
		$headerNews2ImagePc1		= HEADER_NEWS_2_IMAGE_PC_1;
		$headerNews2ImagePc2		= HEADER_NEWS_2_IMAGE_PC_2;
		$headerNews2BackgroundColor	= HEADER_NEWS_2_BACKGROUND_COLOR;
		$headerNews2Url				= HEADER_NEWS_2_URL;
	} else if (LANG == LANG_EN) {
		$showHeaderNews1			= EN_SHOW_HEADER_NEWS_1;
		$showHeaderNews1AsLink		= EN_SHOW_HEADER_NEWS_1_AS_LINK;
		$headerNews1ImageSp1		= EN_HEADER_NEWS_1_IMAGE_SP_1;
		$headerNews1ImageSp2		= EN_HEADER_NEWS_1_IMAGE_SP_2;
		$headerNews1ImagePc1		= EN_HEADER_NEWS_1_IMAGE_PC_1;
		$headerNews1ImagePc2		= EN_HEADER_NEWS_1_IMAGE_PC_2;
		$headerNews1BackgroundColor	= EN_HEADER_NEWS_1_BACKGROUND_COLOR;
		$headerNews1Url				= EN_HEADER_NEWS_1_URL;

		$showHeaderNews2			= EN_SHOW_HEADER_NEWS_2;
		$showHeaderNews2AsLink		= EN_SHOW_HEADER_NEWS_2_AS_LINK;
		$headerNews2ImageSp1		= EN_HEADER_NEWS_2_IMAGE_SP_1;
		$headerNews2ImageSp2		= EN_HEADER_NEWS_2_IMAGE_SP_2;
		$headerNews2ImagePc1		= EN_HEADER_NEWS_2_IMAGE_PC_1;
		$headerNews2ImagePc2		= EN_HEADER_NEWS_2_IMAGE_PC_2;
		$headerNews2BackgroundColor	= EN_HEADER_NEWS_2_BACKGROUND_COLOR;
		$headerNews2Url				= EN_HEADER_NEWS_2_URL;
	}

	$headers;
	$numOfHeaders = ($showHeaderNews1 && $showHeaderNews2) ? 2 : 1;

	if ($numOfHeaders == 1) {
		if ($showHeaderNews1) {
			$imgPc = $headerNews1ImagePc1;
			$imgSp = $headerNews1ImageSp1;
			$bgColor = $headerNews1BackgroundColor;
			$url = $headerNews1Url;
			$hasLink = ($showHeaderNews1AsLink && _isValidString($url));
		} else {
			$imgPc = $headerNews2ImagePc1;
			$imgSp = $headerNews2ImageSp1;
			$bgColor = $headerNews2BackgroundColor;
			$url = $headerNews2Url;
			$hasLink = ($showHeaderNews2AsLink && _isValidString($url));
		}
		$contents =	"<img device='pc' src='" . getImg($imgPc) . "'>" .
			"<img device='sp' src='" . getImg($imgSp) . "'>";
		if ($hasLink) {
			$contents = "<a href='$url' style='background-color:$bgColor;'>$contents</a>";
		} else {
			$contents = "<div style='background-color:$bgColor;'>$contents</div>";
		}
	} else {
		$imgs1 =	"<img device='pc' src='" . getImg($headerNews1ImagePc2) . "'>" .
			"<img device='sp' src='" . getImg($headerNews1ImageSp2) . "'>";
		$imgs2 =	"<img device='pc' src='" . getImg($headerNews2ImagePc2) . "'>" .
			"<img device='sp' src='" . getImg($headerNews2ImageSp2) . "'>";

		if ($showHeaderNews1AsLink && _isValidString($headerNews1Url)) {
			$contents1 = "<a href='" . $headerNews1Url . "' style='background-color:" . $headerNews1BackgroundColor . ";'>$imgs1</a>";
		} else {
			$contents1 = "<div style='background-color:" . $headerNews1BackgroundColor . ";'>$imgs1</div>";
		}

		if ($showHeaderNews2AsLink && _isValidString($headerNews2Url)) {
			$contents2 = "<a href='" . $headerNews2Url . "' style='background-color:" . $headerNews2BackgroundColor . ";'>$imgs2</a>";
		} else {
			$contents2 = "<div style='background-color:" . $headerNews2BackgroundColor . ";'>$imgs2</div>";
		}

		$contents = $contents1 . $contents2;
	}

	echo "<div id='header-news' num-of-headers='$numOfHeaders'>$contents</div>";
}
?>

<header class="drawer" full-view="true" menu-opened="false" nh-gray-border="3" sp-search-opened="false">
	<div class="logo-area" nh-gray-border="2">
		<div class="icons left">
			<div class="icon drawer-toggle"><?php icon("menu"); ?></div>
		</div>
		<div class="logo"><a href="<?php href("/"); ?>"><?php logo("nakata_hanger"); ?></a></div>
		<div class="icons right">
			<div class="icon" onclick="nh.header.onClickSpSearch();"><?php icon("search"); ?></div>
			<div class="icon"><a href="<?php href("cart"); ?>"><?php icon("cart"); ?></a></div>
		</div>
	</div>
	<div class="search-area" device="sp" nh-content-sp="padding" nh-gray-border="2">
		<form action="<?php href("product_search"); ?>" method="get" onsubmit="return nh.header.onSubmitSearch(this);">
			<input type="text" name="word" onblur="nh.header.onBlurSpSearch(this);">
			<input type="submit" value="検索" nh-gray-border="4">
		</form>
	</div>
	<nav class="menus drawer-nav" ontransitionend="nh.header.onDrawerTransitionEnd();">
		<div class="menu-container">
			<div class="main-menu">
				<ul>
					<li class="main-list left has-submenu" item="products" nh-gray-border="3" onmouseenter="nh.header.setPcThisSubmenuHeight(this);">
						<div class="main-item" opened="false" space="bottom" onclick="nh.header.onClickPlusMinus(this, false);">
							<div class="text" nh-gray-bg-ba="4"><?php t("products"); ?></div>
							<div class="icon"><?php icon("plus_minus"); ?></div>
						</div>
						<div class="submenu" closed-menu ontransitionend="nh.header.onMenuOpenCloseTransitionEnd();" features="<?php echo SHOW_PRODUCT_SUBMENU_FEATURES ? "true" : "false"; ?>">
							<div class="submenu-container" nh-gray-border="2-l">
								<div class="main-area">
									<div class="top-area" selected="men" nh-red-bg-before>
										<div class="group" men-women="men">
											<div class="group-container">
												<div class="title" nh-gray-border="3" onclick="nh.header.onClickMenWomen(event);">
													<div class="text" nh-font="1-s"><?php t("men2"); ?></div>
												</div>
												<div class="list" space="top">
													<ul>
														<li><a href="<?php href("men"); ?>"><?php t("productListForMen"); ?></a></li>
														<li><a href="<?php href("men_jacket"); ?>"><?php t("jacketHanger"); ?></a></li>
														<li><a href="<?php href("men_shirt"); ?>"><?php t("shirtHanger"); ?></a></li>
														<li><a href="<?php href("men_bottom"); ?>"><?php t("bottomHanger"); ?></a></li>
														<li><a href="<?php href("men_necktie_belt"); ?>"><?php t("necktieBeltHanger"); ?></a></li>
													</ul>
												</div>
											</div>
										</div>
										<div class="group" men-women="women" nh-gray-border="3">
											<div class="group-container">
												<div class="title" nh-gray-border="3" onclick="nh.header.onClickMenWomen(event);">
													<div class="text" nh-font="1-s"><?php t("women2"); ?></div>
												</div>
												<div class="list" space="top">
													<ul>
														<li><a href="<?php href("women"); ?>"><?php t("productListForWomen"); ?></a></li>
														<li><a href="<?php href("women_jacket"); ?>"><?php t("jacketHanger"); ?></a></li>
														<li><a href="<?php href("women_shirt"); ?>"><?php t("shirtHanger"); ?></a></li>
														<li><a href="<?php href("women_bottom"); ?>"><?php t("bottomHanger"); ?></a></li>
														<li><a href="<?php href("women_stole_belt"); ?>"><?php t("stoleBeltHanger"); ?></a></li>
													</ul>
												</div>
											</div>
										</div>
										<div class="group has-closed-menu" item="others" nh-gray-border="3">
											<div class="group-container">
												<div class="title" opened="false" space="bottom" onclick="nh.header.onClickPlusMinus(this, true, true);">
													<div class="text"><?php t("others"); ?></div>
													<div class="icon"><?php icon("plus_minus"); ?></div>
												</div>
												<div class="list" closed-menu space="bottom" ontransitionend="nh.header.onMenuOpenCloseTransitionEnd();">
													<ul nh-gray-border="2">
														<li space="top"><a href="<?php href("brush_shoehorn"); ?>"><?php t("clothBrush", "dotSlash", "shoehorn"); ?></a></li>
														<li><a href="<?php href("rack_stand"); ?>"><?php t("hangerRack", "dotSlash", "stand"); ?></a></li>
														<li><a href="<?php href("kimono"); ?>"><?php t("kimonoHanger"); ?></a></li>
														<li><a href="<?php href("kids"); ?>"><?php t("kidsHanger"); ?></a></li>
														<li><a href="<?php href("pet"); ?>"><?php t("petHanger"); ?></a></li>
														<li><a href="<?php href("outlet"); ?>"><?php t("outletHanger"); ?></a></li>
														<li padding-space="bottom" lang="ja"><a href="<?php echo getPageUrl(2996447); ?>">予約販売</a></li>
														<?php /* <li padding-space="bottom"><a href="<?php href("others_others"); ?>"><?php t("otherAccessories"); ?></a></li> */ ?>
													</ul>
												</div>
											</div>
										</div>
										<div class="group has-closed-menu" item="series" nh-gray-border="3">
											<div class="group-container">
												<div class="title" opened="false" space="bottom" onclick="nh.header.onClickPlusMinus(this, true, false);">
													<div class="text"><?php t("bySeries"); ?></div>
													<div class="icon"><?php icon("plus_minus"); ?></div>
												</div>
												<div class="list" space="bottom" closed-menu ontransitionend="nh.header.onMenuOpenCloseTransitionEnd();">
													<ul nh-gray-border="2">
														<li space="top"><a href="<?php href("nh"); ?>"><?php t("nhSeries"); ?></a></li>
														<li><a href="<?php href("aut"); ?>"><?php t("autSeries"); ?></a></li>
														<li><a href="<?php href("set"); ?>"><?php t("setSeries"); ?></a></li>
														<li lang="en"><a href="<?php href("gift"); ?>">Gift</a></li>
													</ul>
												</div>
											</div>
											<div class="group-container" item="options">
												<div class="title">
													<div class="text"><?php t("option"); ?></div>
												</div>
												<div class="list">
													<ul>
														<li>
															<a href="<?php href("name"); ?>">
																<?php t("nameEngraving"); ?>
																<?php
																if (SHOW_NAME_ENGRAVING_CAMPAIGN) {
																	echo "<span class='campaign' device='sp'>" . NAME_ENGRAVING_CAMPAIGN_TEXT . "</span>";
																}
																?>
															</a>
															<?php
															if (SHOW_NAME_ENGRAVING_CAMPAIGN) {
																echo "<div class='campaign' device='pc'>" . NAME_ENGRAVING_CAMPAIGN_TEXT . "</div>";
															}
															?>
														</li>
														<?php /* <li><a href="<?php href("sample"); ?>"><?php t("sampleLending"); ?></a></li> */ ?>
														<li><a href="<?php echo getProductUrl(143768508); ?>">ロゴ入れ</a></li>
													</ul>
												</div>
											</div>
										</div>
									</div>
									<div class="bottom-area"></div>
								</div>
								<?php
								if (SHOW_PRODUCT_SUBMENU_FEATURES) {
									global $productSubmenuFeatures;
									echoSubmenuFeatures($productSubmenuFeatures);
								}
								?>
							</div>
						</div>
					</li>
					<li class="main-list left has-submenu" item="gift" nh-gray-border="3" space="bottom" onmouseenter="nh.header.setPcThisSubmenuHeight(this);">
						<div class="main-item" opened="false" space="top-bottom" onclick="nh.header.onClickPlusMinus(this, false);">
							<div class="text" nh-gray-bg-ba="4"><?php t("gift"); ?></div>
							<div class="icon"><?php icon("plus_minus"); ?></div>
						</div>
						<div class="submenu" features="<?php echo SHOW_GIFT_SUBMENU_FEATURES ? "true" : "false"; ?>">
							<div class="submenu-container" nh-gray-border="2-l">
								<div class="left-area" nh-gray-border="3" closed-menu ontransitionend="nh.header.onMenuOpenCloseTransitionEnd();">
									<div class="left-area-container">
										<div class="main">
											<div class="main-container">
												<div class="title"><?php t("gift2"); ?></div>
												<div class="list">
													<ul nh-gray-border="2">
														<li space="top"><a href="<?php href("gift", array("link" => "menu_banner_gift")); ?>"><?php t("productListForGift"); ?></a></li>
														<li><a href="<?php href("gift_men"); ?>"><?php t("giftForMen"); ?></a></li>
														<li><a href="<?php href("gift_women"); ?>"><?php t("giftForWomen"); ?></a></li>
														<li space="bottom"><a href="<?php href("gift_pair"); ?>"><?php t("giftForBoth"); ?></a></li>
													</ul>
												</div>
											</div>
										</div>
										<?php
										if (SHOW_GIFT_SUBMENU_FEATURES) {
											global $giftSubmenuFeatures;
											echoSubmenuFeatures($giftSubmenuFeatures);
										}
										?>
									</div>
								</div>
								<div class="right-area" space="top-bottom" nh-gray-border="3">
									<ul>
										<li>
											<a href="<?php href("bridal", array("link" => "menu_banner_bridal")); ?>" target="_blank">
												<div class="title"><?php ts("weddingGift", "/", "familyCelebration"); ?></div>
												<div class="desc"><?php ts("nakatahanger", "bridal"); ?><br><span class="smaller"><?php ts("asterist", "movingToSpecialSite"); ?></span></div>
												<div class="img" style="background-image:url('<?php img("bridal"); ?>');"></div>
											</a>
										</li>
										<li>
											<a href="<?php href("graduation", array("link" => "menu_banner_grad")); ?>">
												<div class="title"><?php t("graduationGift"); ?></div>
												<div class="desc"><?php echo getTxt("reiwa") . getReiwa(getSchoolYear());
																	t("schoolYear", "gradGift"); ?></div>
												<div class="img" style="background-image:url('<?php img("graduation"); ?>');"></div>
											</a>
										</li>
										<li>
											<a href="<?php href("organization"); ?>">
												<div class="title"><?php t("forOrg"); ?></div>
												<div class="desc"><?php t("consideringOrgGift"); ?></div>
												<div class="img" style="background-image:url('<?php img("organization"); ?>');"></div>
											</a>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</li>
					<li class="main-list left">
						<div class="main-item">
							<div class="text" nh-gray-bg-ba="4"><a href="<?php href("stores"); ?>"><?php ts("showroom", "/", "stores"); ?></a></div>
						</div>
					</li>
					<li class="main-list left">
						<div class="main-item">
							<div class="text" nh-gray-bg-ba="4"><a href="<?php href("news"); ?>"><?php t("news"); ?></a></div>
						</div>
					</li>
					<li class="main-list right has-submenu" item="about" onmouseenter="nh.header.setPcThisSubmenuHeight(this);">
						<div class="main-item" opened="false" onclick="nh.header.onClickPlusMinus(this, false);">
							<div class="text" nh-gray-bg-ba="4"><?php t("about"); ?></div>
							<div class="icon"><?php icon("plus_minus"); ?></div>
						</div>
						<div class="submenu" features="<?php echo SHOW_ABOUT_SUBMENU_FEATURES ? "true" : "false"; ?>">
							<div class="submenu-container" nh-gray-border="2-l">
								<div closed-menu ontransitionend="nh.header.onMenuOpenCloseTransitionEnd();">
									<div class="layout" nh-gray-border="2">
										<div space="top">
											<a href="<?php href("about"); ?>">
												<div class="title"><?php t("about"); ?></div>
												<div class="img" style="background-image:url('<?php img("menu-about.jpg"); ?>');"></div>
											</a>
											<a href="<?php href("craftsmanship"); ?>">
												<div class="title"><?php t("craftsmanship"); ?></div>
												<div class="img" style="background-image:url('<?php img("menu-craftsmanship.jpg"); ?>');"></div>
											</a>
										</div>
										<div>
											<a href="<?php href("company"); ?>">
												<div class="title"><?php t("companyInfo"); ?></div>
												<div class="img" style="background-image:url('<?php img("menu-company.jpg"); ?>');"></div>
											</a>
											<a href="<?php href("history"); ?>">
												<div class="title"><?php t("companyHistory"); ?></div>
												<div class="img" style="background-image:url('<?php img("menu-history.jpg"); ?>');"></div>
											</a>
										</div>
										<div padding-space="bottom">
											<a href="<?php href("sdgs"); ?>">
												<div class="title"><?php t("sdgsActions"); ?></div>
												<div class="img" style="background-image:url('<?php img("menu-sdgs.jpg"); ?>');"></div>
											</a>
											<a href="<?php href("about/#history"); ?>">
												<div class="title"><?php t("nhBrandHistory"); ?></div>
												<div class="img" style="background-image:url('<?php img("menu-brand-history.jpg"); ?>'); border:1px #afb0b1 solid"></div>
											</a>
										</div>
										<?php
										if (SHOW_ABOUT_SUBMENU_FEATURES) {
											global $aboutSubmenuFeatures;
											echo "<div class='features-container' nh-gray-border='3'>";
											echoSubmenuFeatures($aboutSubmenuFeatures);
											echo "</div>";
										}
										?>
									</div>
								</div>
							</div>
						</div>
					</li>
					<li class="main-list right" item="howto" nh-gray-border="3" space="bottom">
						<div class="main-item" space="bottom">
							<div class="text" nh-gray-bg-ba="4"><a href="<?php href("howto"); ?>"><?php t("howToChoose"); ?></a></div>
						</div>
					</li>
					<li class="main-list right" item="inquiry">
						<div class="main-item">
							<div class="icon" nh-gray-bg-ba="4"><a href="<?php href("inquiry"); ?>"><?php icon("email"); ?></a></div>
						</div>
					</li>
				</ul>
			</div>
			<div class="secondary-menu">
				<div class="content-area">
					<ul>
						<li class="secondary-list" item="search" focus="false">
							<div class="container">
								<form action="<?php href("product_search"); ?>" method="get" onsubmit="return nh.header.onSubmitSearch(this);">
									<input type="text" name="word" onblur="nh.header.onBlurPcSearch(this);">
									<input type="submit" value="検索">
								</form>
								<div class="icon" onclick="nh.header.onClickPcSearch(this);"><?php icon("search"); ?></div>
							</div>
						</li>
						<li class="secondary-list" item="account">
							<div class="text"><a href="<?php href("account"); ?>"><?php t("myPage"); ?></a></div>
							<div class="icon"><a href="<?php href("account"); ?>"><?php icon("user"); ?></a></div>
						</li>
						<li class="secondary-list" item="cart">
							<div class="icon"><a href="<?php href("cart"); ?>"><?php icon("cart"); ?></a></div>
						</li>
						<li class="secondary-list">
							<div class="text"><a href="<?php href("guide"); ?>"><?php t("webGuide"); ?></a></div>
						<?php /*
						</li>
						<li class="secondary-list" item="inquiry">
							<div class="text"><a href="<?php href("inquiry"); ?>"><?php t("inquiry"); ?></a></div>
						</li>
<!--					<li class="secondary-list" item="recruit">
							<div class="text"><a href="<?php href("recruit"); ?>"><?php t("recruit"); ?></a></div>
						</li>-->
<!--					<li class="secondary-list" item="lang">
							<div class="text">
								<a href="<?php if (LANG == LANG_EN) {
												echo HOME_URL;
											} else {
												href("english");
											} ?>">
									<?php if (LANG == LANG_EN) {
										t("japanese");
									} else {
										t("english");
									} ?>
								</a>
							</div>-->
						*/ ?>
						</li><?php
							if (LANG == LANG_JA) {
								echo	'<li class="secondary-list" item="recruit">'.
											'<div class="text"><a href="'.getHref("recruit").'">'.getTxt("recruit").'</a></div>'.
										'</li>'.
										'<li class="secondary-list" item="lang">'.
											'<div class="text"><a href="'.getHref("english").'">'.getTxt("english").'</a></div>'.
										'</li>';
							} else {
								$langs = getOtherLangs();
								foreach ($langs as $l) {
									echo	"<li class='secondary-list' item='lang'>".
												"<div class='text'>".
													"<a href='".$l["href"]."'>".$l["label"]."</a>".
												"</div>".
											"</li>";
								}
							}
						?>
					</ul>
				</div>
			</div>
		</div>
	</nav>
</header>