<meta charset="utf-8">
<?php if (!IS_REAL_SERVICE_ENVIRONMENT) echo "<meta name='robots' content='noindex'>"; ?>
<meta name="keywords" content="<?php echo $keywords; ?>">
<meta name="description" content="<?php echo $desc; ?>">
<meta property="og:title" content="<?php echo $title; ?>">
<meta property="og:description" content="<?php echo $desc; ?>">
<meta property="og:url" content="<?php echo getThisUrl(); ?>">
<meta property="og:image" content="<?php echo $ogImage; ?>">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@<?php echo TWITTER_ACCOUNT; ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
<?php
if (_isValid($thumbnail)) {
	echo	"<meta name='thumbnail' content='$thumbnail'>" .
		"<!--\n" .
		"<PageMap>\n" .
		"<DataObject type='thumbnail'>\n" .
		"<Attribute name='src' value='$thumbnail'>\n" .
		"<Attribute name='width' value='120'>\n" .
		"<Attribute name='height' value='120'>\n" .
		"</DataObject>\n" .
		"</PageMap>\n" .
		"-->";
}
?>
<title><?php echo $title; ?></title>
<link rel="canonical" href="<?php echo getCanonicalUrl(); ?>">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=EB+Garamond:400,400i">
<link rel="stylesheet" href="https://fonts.googleapis.com/earlyaccess/sawarabimincho.css">
<link rel="stylesheet" type="text/css" href="<?php url("common/common.css"); ?>">
<link rel="stylesheet" type="text/css" media="(max-width:<?php echo MAX_SP_VIEW_WIDTH; ?>px)" href="<?php url("common/common-s.css"); ?>">
<link rel="stylesheet" type="text/css" media="(min-width:<?php echo MIN_PC_VIEW_WIDTH; ?>px)" href="<?php url("common/common-l.css"); ?>">
<link rel="stylesheet" type="text/css" media="(max-width:<?php echo MAX_SP_VIEW_WIDTH; ?>px)" href="<?php firstLangUrl("$css-s.css"); ?>">
<link rel="stylesheet" type="text/css" media="(min-width:<?php echo MIN_PC_VIEW_WIDTH; ?>px)" href="<?php firstLangUrl("$css-l.css"); ?>">
<link rel="stylesheet" type="text/css" media="all and (-ms-high-contrast:none)" href="<?php url("common/common-ie.css"); ?>">
<script type="text/javascript" src="<?php url("lib/jquery-3.3.1.min.js"); ?>"></script>
<script type="text/javascript" src="<?php url("lib/iscroll.min.js"); ?>"></script>
<script type="text/javascript" src="<?php url("lib/drawer.min.js"); ?>"></script>
<script type="text/javascript" src="<?php url("lib/_.js"); ?>"></script>
<script type="text/javascript" src="<?php url("common/nh.js"); ?>"></script>
<?php if (IS_REAL_SERVICE_ENVIRONMENT) { ?>
	<?php /* 2023.06.07
	<!-- Google Tag Manager -->
	<?php if (LANG == LANG_JA) { ?>
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-K3THFN8');</script>
	<?php } else { ?>
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-5B9LF6S');</script>
	<?php } ?>
	<!-- End Google Tag Manager -->
	*/ ?>

	<!-- GA4 -->
	<?php if (LANG == LANG_JA) { ?>
		<script async src="https://www.googletagmanager.com/gtag/js?id=G-BZ2QV9ZNJL"></script>
		<script>
			window.dataLayer = window.dataLayer || [];

			function gtag() {
				dataLayer.push(arguments);
			}
			gtag('js', new Date());
			gtag('config', 'G-BZ2QV9ZNJL');
		</script>
	<?php } else { ?>
		<script async src="https://www.googletagmanager.com/gtag/js?id=G-Z9X1TR0FRR"></script>
		<script>
			window.dataLayer = window.dataLayer || [];

			function gtag() {
				dataLayer.push(arguments);
			}
			gtag('js', new Date());
			gtag('config', 'G-Z9X1TR0FRR');
		</script>
	<?php } ?>
	<!-- End GA4 -->
	
	<?php /* ?>
	<!-- Google Analytics -->
	<?php if (LANG == LANG_JA) { ?>
		<script>
			(function(i, s, o, g, r, a, m) {
				i['GoogleAnalyticsObject'] = r;
				i[r] = i[r] || function() {
					(i[r].q = i[r].q || []).push(arguments)
				}, i[r].l = 1 * new Date();
				a = s.createElement(o),
					m = s.getElementsByTagName(o)[0];
				a.async = 1;
				a.src = g;
				m.parentNode.insertBefore(a, m)
			})(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

			ga('create', 'UA-19747195-1', 'auto', {
				'allowLinker': true
			});
			ga('require', 'linker');
			ga('linker:autoLink', ['nakatahanger-shop.com']);
			ga('send', 'pageview');
		</script>
	<?php } else { ?>
		<script>
			(function(i, s, o, g, r, a, m) {
				i['GoogleAnalyticsObject'] = r;
				i[r] = i[r] || function() {
					(i[r].q = i[r].q || []).push(arguments)
				}, i[r].l = 1 * new Date();
				a = s.createElement(o),
					m = s.getElementsByTagName(o)[0];
				a.async = 1;
				a.src = g;
				m.parentNode.insertBefore(a, m)
			})(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

			ga('create', 'UA-19747195-2', 'auto', {
				'allowLinker': true,
				'cookiePath': '/en/'
			});
			ga('require', 'linker');
			ga('linker:autoLink', ['shop.nakatahanger.com']);
			ga('send', 'pageview');
		</script>
	<?php } ?>
	<!-- End Google Analytics -->
	<?php */ ?>

	<!-- Clarity  -->
	<?php if (LANG == LANG_JA) { ?>
		<script type="text/javascript">
    (function(c,l,a,r,i,t,y){
        c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
        t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
        y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
    })(window, document, "clarity", "script", "n85eea7obi");
		</script>
	<?php } else { ?>
		<script type="text/javascript">
    (function(c,l,a,r,i,t,y){
        c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
        t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
        y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
    })(window, document, "clarity", "script", "n8mo5fm614");
		</script>
	<?php } ?>
	<!-- End Clarity -->

	<?php /*if (LANG == LANG_JA) { ?>
		<!-- Global site tag (gtag.js) - Google Ads: 877227036 -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=AW-877227036"></script>
		<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());
		gtag('config', 'AW-877227036');
		</script>
	<?php }*/ ?>

	<?php if (LANG == LANG_JA) { ?>
		<meta name="facebook-domain-verification" content="grgmyb69enp1mt0mipe5rxswf4wsme" />
	<?php } else if (LANG == LANG_EN) { ?>
		<!-- Facebook Pixel Code -->
		<script>
			! function(f, b, e, v, n, t, s) {
				if (f.fbq) return;
				n = f.fbq = function() {
					n.callMethod ?
						n.callMethod.apply(n, arguments) : n.queue.push(arguments)
				};
				if (!f._fbq) f._fbq = n;
				n.push = n;
				n.loaded = !0;
				n.version = '2.0';
				n.queue = [];
				t = b.createElement(e);
				t.async = !0;
				t.src = v;
				s = b.getElementsByTagName(e)[0];
				s.parentNode.insertBefore(t, s)
			}(window, document, 'script',
				'https://connect.facebook.net/en_US/fbevents.js');
			fbq('init', '667579320496156');
			fbq('track', 'PageView');
		</script>
		<noscript>
			<img height="1" width="1" src="https://www.facebook.com/tr?id=667579320496156&ev=PageView
		&noscript=1" />
		</noscript>
		<!-- End Facebook Pixel Code -->
	<?php } ?>
<?php } ?>