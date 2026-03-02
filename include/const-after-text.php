<?php

//////////////////////////////////////////////////////////////////////////////////////////

if (LANG == LANG_JA) {
	define("URL_NAME", getProductUrl(COLOR_ME_PRODUCT_ID_NAME_ENGRAVING_CURRENT));
} else {
	define("URL_NAME", SHOPIFY_HOST . "/en/products/name-engraving");
}

//////////////////////////////////////////////////////////////////////////////////////////

if (LANG == LANG_JA) {
	define("BANNER_NAME_IMG", "banner-name-engraving.jpg");
} else {
	define("BANNER_NAME_IMG", "banner-name-engraving-en.jpg");
}
define("BANNER_NAME_TEXT_MAIN", getTxt("nameEngraving2"));
define("BANNER_NAME_TEXT_SUB", getTxt("aboutNameEngraving"));

define("BANNER_GIFT_IMG", "banner-gift.jpg");
define("BANNER_GIFT_TEXT_MAIN", getTxt("gift2"));
define("BANNER_GIFT_TEXT_SUB", getTxt("gift"));

define("BANNER_STORES_IMG", "banner-stores.jpg");
define("BANNER_STORES_TEXT_MAIN", getTxt("showroom2"));
define("BANNER_STORES_TEXT_SUB", getSpacedTxt("showroom", "/", "stores"));

define("BANNER_ABOUT_IMG", "banner-about.jpg");
define("BANNER_ABOUT_TEXT_MAIN", getTxt("about2"));
define("BANNER_ABOUT_TEXT_SUB", getTxt("about"));

define("BANNER_CRAFTSMANSHIP_IMG", "banner-craftsmanship.jpg");
define("BANNER_CRAFTSMANSHIP_TEXT_MAIN", getTxt("craftsmanship2"));
define("BANNER_CRAFTSMANSHIP_TEXT_SUB", getTxt("craftsmanship"));

define("BANNER_COMPANY_IMG", "banner-company.jpg");
define("BANNER_COMPANY_TEXT_MAIN", getTxt("company2"));
define("BANNER_COMPANY_TEXT_SUB", getTxt("companyInfo"));

define("BANNER_HISTORY_IMG", "banner-history.jpg");
define("BANNER_HISTORY_TEXT_MAIN", getTxt("companyHistory2"));
define("BANNER_HISTORY_TEXT_SUB", getTxt("companyHistory"));

define("BANNER_HOWTO_IMG", "banner-howto.jpg");
define("BANNER_HOWTO_TEXT_MAIN", getTxt("howToChoose2"));
define("BANNER_HOWTO_TEXT_SUB", getTxt("howToChoose"));

define("BANNER_CONCIERGE_IMG", "banner-concierge.jpg");
define("BANNER_CONCIERGE_TEXT_MAIN", getTxt("concierge2"));
define("BANNER_CONCIERGE_TEXT_SUB", getTxt("conciergeService"));

define("BANNER_BLOG_IMG", "banner-blog.jpg");
define("BANNER_BLOG_TEXT_MAIN", getTxt("blog2"));
define("BANNER_BLOG_TEXT_SUB", getTxt("blog"));

define("BANNER_SDGS_IMG", "banner-sdgs.jpg");
define("BANNER_SDGS_TEXT_MAIN", "SDGs");
define("BANNER_SDGS_TEXT_SUB", "SDGs の取り組み");

define("BANNER_SHIMASAKI_IMG", "banner-shimasaki.jpg");
define("BANNER_SHIMASAKI_TEXT_MAIN", "Sponsored");
define("BANNER_SHIMASAKI_TEXT_SUB", "私達は嶋﨑玖・珀選手を応援しています");
define("URL_SHIMASAKI", getFeatureUrl("2021-02-01"));

define("BANNER_SEIKEI_IMG", "banner-seikei.jpg");
define("BANNER_SEIKEI_TEXT_MAIN", "世界一のハンガーを作る");
define("BANNER_SEIKEI_TEXT_SUB", "成型編");
define("URL_SEIKEI", getFeatureUrl("2021-03-19"));

define("BANNER_TOSO_IMG", "banner-toso.jpg");
define("BANNER_TOSO_TEXT_MAIN", "世界一のハンガーを彩る");
define("BANNER_TOSO_TEXT_SUB", "塗装編");
define("URL_TOSO", getFeatureUrl("2021-10-27"));

define("BANNER_KUMITATE_IMG", "banner-kumitate.jpg");
define("BANNER_KUMITATE_TEXT_MAIN", "世界一のハンガーを届ける");
define("BANNER_KUMITATE_TEXT_SUB", "組立編");
define("URL_KUMITATE", getFeatureUrl("2022-03-15"));

define("BANNER_GIFT_WRAPPING_IMG", "banner-gift-wrapping-en.jpg");
define("BANNER_GIFT_WRAPPING_TEXT_MAIN", "Gift wrapping");
define("URL_GIFT_WRAPPING", getNewsUrl(3767));

define("BANNER_MENS_HANGER_SET_IMG", "feature-20200404-banner.jpg");
define("BANNER_MENS_HANGER_SET_TEXT_MAIN", "Men's Hanger Set");
define("BANNER_MENS_HANGER_SET_TEXT_SUB", "The best introduction model of NAKATA HANGER");
define("URL_MENS_HANGER_SET", getFeatureUrl("2023-06-09"));

define("BANNER_HANGER_SIZE_IMG", "feature-hanger-size-banner.jpg");
define("BANNER_HANGER_SIZE_TEXT_MAIN", "How to measure your hanger size");
define("BANNER_HANGER_SIZE_TEXT_SUB", "Choose the right size hanger for yourself!");
define("URL_HANGER_SIZE", getFeatureUrl("hanger-size"));

define("BANNER_TRUNKSHOW2025HK_IMG", "feature-trunkshow2025hk-banner.jpg");
define("BANNER_TRUNKSHOW2025HK_TEXT_MAIN", "Trunk Show<br>in HongKong");
define("BANNER_TRUNKSHOW2025HK_TEXT_SUB", "Thu.27th & Fri.28th November");
define("URL_TRUNKSHOW2025HK", getFeatureUrl("trunkshow2025hk"));

define("BANNER_SET02-2025SS_IMG", "feature-set02_2025ss-banner.webp");
define("BANNER_SET02-2025SS_TEXT_MAIN", "Meet the SET-02");
define("BANNER_SET02-2025SS_TEXT_SUB", "Your Everyday Essential");
define("URL_SET02-2025SS", getFeatureUrl("set02-2025ss"));

define("BANNER_WAJIMA2025_IMG", "feature-wajima2025-banner.webp");
define("BANNER_WAJIMA2025_TEXT_MAIN", "Wajima Lacquered Hanger");
define("BANNER_WAJIMA2025_TEXT_SUB", "The Timeless Tradition");
define("URL_WAJIMA2025", getFeatureUrl("wajima2025"));

//////////////////////////////////////////////////////////////////////////////////////////

?>