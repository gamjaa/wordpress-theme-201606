<?php if (is_single()) the_post(); ?>
<!doctype html>
<html lang="ko">
	<head>
		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=G-MSPCPW3CW1"></script>
		<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());
		gtag('config', 'G-MSPCPW3CW1');
		</script>
		<meta charset="UTF-8">
		<?= is_allow_robots() ? '' : "<meta name='robots' content='noindex,follow' />\n" ?>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title><?= get_bloginfo('name') ?><?php wp_title('::') ?></title>

		<meta name="title" content="<?php if (is_single()) the_title(); else { bloginfo('name'); wp_title('::'); } ?>">
		<meta name="description" content="<?= is_single() ? wp_strip_all_tags(get_the_excerpt()) : get_bloginfo('description'); ?>">
		<meta name="keywords" content="<?= is_single() ? tags2keywords() : '' ?>">
		<meta property="og:title" content="<?php if (is_single()) the_title(); else { bloginfo('name'); wp_title('::'); } ?>">
		<meta property="og:description" content="<?= is_single() ? wp_strip_all_tags(get_the_excerpt()) : get_bloginfo('description'); ?>">
		<meta property="og:url" content="<?= get_the_permalink() ?>">
		<meta property="og:type" content="<?= is_single() ? 'article' : 'website' ?>">
		<meta property="og:image" content="<?= is_single() ? 
			(get_post_meta($post->ID, 'disable_auto_thumb') ? 
				get_the_post_thumbnail_url($post) : get_template_directory_uri().'/thumb.php?post_id='.get_the_ID())
				: (get_option( 'gamjaa_post_options' )['auto_thumb_default'] ?: get_site_icon_url()) ?>">
		<meta property="og:site_name" content="<?= get_bloginfo('name') ?>">
		<meta name="twitter:card" content="summary_large_image">
		<meta name="twitter:creator" content="@_gamjaa">
		<meta name="twitter:site" content="@_gamjaa">

		<link rel="canonical" href="<?= get_the_permalink() ?>">
		<link rel="stylesheet" href="<?= get_bloginfo('stylesheet_url') ?>?ver=20210308">
		<?php wp_site_icon() ?>
		
		<?php wp_head() ?>
	</head>
	<body <?php body_class(); ?>>
		<header>
			<?php
				wp_nav_menu( array(
				'theme_location' => 'main_menu',
				'fallback_cb' => false,
				));
			?>
		</header>

<?php
	function is_allow_robots() {
		if ((is_home() || is_page()) && !is_paged()) {
			return true;
		}

		if (is_single()) {
			global $post;
			$categories = get_the_category($post->ID);
			// 카테고리가 일상으로만 설정돼있으면 로봇 차단
			if (count($categories) == 1 && $categories[0]->term_id == 5) {
				return false;
			}

			return true;
		}

		return false;
	}

	function tags2keywords() {
		$tags = get_the_tags();
		$keywords = '';
		foreach ($tags as $tag) {
			$keywords .= $tag->name . ',';
		}
		return $keywords;
	}
?>