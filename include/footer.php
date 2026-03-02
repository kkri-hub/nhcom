<footer>
	<div class="scroll-to-top"><img src="<?php img("scroll_to_top"); ?>" onclick="_.dom.scrollToTop();"></div>
	<div class="content-area-container">
		<div class="content-area">
			<div class="magazine-sns" nh-content-sp="padding">
				<div class="magazine">
					<div class="text">
						<div class="title"><?php t("registerMailMagazine"); ?></div>
						<div class="desc"><?php t("sendingNewProductsAndCampaign"); ?></div>
					</div>
					<div class="input">
						<form action="<?php echo (LANG == LANG_JA) ? URL_COLOR_ME_SECURE : URL_SHOPIFY_SUBSCRIBE; ?>" method="get">
						<?php if (LANG == LANG_JA) {  ?>
							<input type="hidden" name="type" value="INS">
							<input type="hidden" name="mode" value="mailmaga">
							<input type="hidden" name="shop_id" value="<?php echo COLOR_ME_SHOP_ID; ?>">
						<?php } ?>
							<input type="text" name="email" placeholder="<?php t("emailAddress"); ?>"><input type="submit" value="<?php t("subscription"); ?>" nh-red-bg>
						</form>
					</div>
				</div>
				<div class="sns">
					<ul>
						<li><a href="<?php href("instagram"); ?>" target="_blank"><?php logo("instagram"); ?></a></li>
						<li><a href="<?php href((LANG == LANG_JA ? "facebook" : "facebook_en")); ?>" target="_blank"><?php logo("facebook"); ?></a></li>
						<li><a href="<?php href("twitter"); ?>" target="_blank"><?php logo("twitter"); ?></a></li>
						<li class="line"><a href="https://page.line.me/319xrjfi?openQrModal=true"><?php logo("line"); ?></a></li>
						<li class="youtube"><a href="<?php href("youtube"); ?>" target="_blank"><?php logo("youtube"); ?></a></li>
					</ul>
				</div>
				<!--
				<div class="icons">
					<ul>
						<li><img src="<?php img("cashless.jpg"); ?>"></li>
					</ul>
				</div>
				-->
			</div>
			<div class="links">
				<ul class="link-categories">
					<li class="link-category" nh-content-sp="padding">
						<div class="link-category-container">
							<div class="title" nh-font="1" nh-gray-text="4"><?php t("customer2"); ?></div>
							<div class="list">
								<ul>
									<li><a href="<?php href("account"); ?>"><?php t("myPage"); ?></a></li>
									<li><a href="<?php href("guide"); ?>"><?php t("webGuide"); ?></a></li>
									<li class="faq"><a href="<?php href("guide_faq"); ?>"><?php t("faq"); ?></a></li>
									<li><a href="<?php href("inquiry"); ?>"><?php t("inquiry"); ?></a></li>
									<li class="space" item="home"><a href="<?php href("/"); ?>"><?php ts("▲", "backToHome"); ?></a></li>
								</ul>
							</div>
						</div>
					</li>
					<li class="link-category" nh-content-sp="padding">
						<div class="link-category-container">
							<div class="title" nh-font="1" nh-gray-text="4"><?php t("information2"); ?></div>
							<div class="list">
								<ul>
									<li><a href="<?php href("about"); ?>"><?php t("about"); ?></a></li>
									<li class="howto"><a href="<?php href("howto"); ?>"><?php t("howToChoose"); ?></a></li>
									<li lang="en"><a href="<?php href("company"); ?>#company"><?php t("companyInfo"); ?></a></li>
									<li lang="en"><a href="<?php href("history"); ?>"><?php t("companyHistory"); ?></a></li><!---->
									<li lang="en"><a href="<?php href("craftsmanship"); ?>"><?php t("craftsmanship"); ?></a></li><!---->
									<li><a href="<?php href("stores"); ?>"><?php ts("showroom", "/", "stores"); ?></a></li>
									<li class="concierge"><a href="<?php href("concierge"); ?>"><?php t("conciergeService"); ?></a></li>
									<li class="news"><a href="<?php href("news"); ?>"><?php t("news"); ?></a></li>
									<li class="blog"><a href="<?php href("blog"); ?>" target="_blank"><?php t("blog"); ?></a></li>
									<li class="bridal space"><a href="<?php href("bridal"); ?>" target="_blank"><?php ts("weddingGift", "/", "familyCelebration"); ?></a></li>
									<li class="grad"><a href="<?php href("graduation"); ?>"><?php t("graduationGift"); ?></a></li>
									<li class="organization"><a href="<?php href("organization"); ?>"><?php t("forOrg"); ?></a></li>
								</ul>
							</div>
						</div>
					</li>
					<li class="link-category" nh-content-sp="padding">
						<div class="link-category-container">
							<div class="title" nh-font="1" nh-gray-text="4"><?php t("others2"); ?></div>
							<div class="list">
								<ul>
									<li lang="ja"><a href="<?php href("craftsmanship"); ?>"><?php t("craftsmanship"); ?></a></li><!---->
									<li lang="ja"><a href="<?php href("company"); ?>#company"><?php t("companyInfo"); ?></a></li>
									<li lang="ja"><a href="<?php href("history"); ?>"><?php t("companyHistory"); ?></a></li><!---->
									<li lang="ja"><a href="<?php href("sdgs"); ?>"><?php t("sdgsActions"); ?></a></li><!---->
									<li class="recruit"><a href="<?php href("recruit"); ?>"><?php t("recruit"); ?></a></li>
									<li class="privacy-policy"><a href="<?php href("privacy"); ?>"><?php t("privacyPolicy"); ?></a></li>
									<li class="shipping-policy" lang="en"><a href="<?php href("shipping"); ?>"><?php t("shippingPolicy"); ?></a></li>
									<li class="privacy-policy" lang="en"><a href="<?php href("refund"); ?>"><?php t("refundPolicy"); ?></a></li>
									<li><a href="<?php href("legal"); ?>"><?php t("legal"); ?></a></li>
<!--								<li class="space"><a href="<?php if (LANG == LANG_EN) { echo HOME_URL; } else { href("english"); } ?>"><?php if (LANG == LANG_EN) { t("japanese"); } else { t("english"); } ?></a></li>-->
									<?php
										$langs = getOtherLangs();
										for ($i = 0, $size = sizeof($langs); $i < $size; $i++) {
											$lang = $langs[$i];
											echo	"<li ".($i == 0 ? "class='space'" : "").">".
														"<a href='".$lang["href"]."'>".$lang["label"]."</a>".
													"</li>";
										}
									?>
								</ul>
							</div>
						</div>
					</li>
				</ul>
			</div>
			<div class="footer">
				<div class="logo">
					<a href="<?php href("/"); ?>"><?php logo("nakata_hanger"); ?></a>
				</div>
				<div class="copyright">&copy; <?php echo date("Y")." ".getTxt("nakatahanger"); ?></div>
			</div>
		</div>
	</div>
</footer>