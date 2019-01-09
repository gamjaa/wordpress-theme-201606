<!doctype html>
<html lang="ko">
	<head>
		<meta charset="UTF-8">
		<?= is_allow_robots() ? '' : "<meta name='robots' content='noindex,follow' />\n" ?>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width">
		<title><?= get_bloginfo('name') ?><?php wp_title('::') ?></title>

		<?php if (is_single()) the_post(); ?>
		<meta name="title" content="<?php if (is_single()) the_title(); else { bloginfo('name'); wp_title('::'); } ?>">
		<meta name="description" content="<?= is_single() ? wp_strip_all_tags(get_the_excerpt()) : get_bloginfo('description'); ?>">
		<meta name="keywords" content="<?= is_single() ? tags2keywords() : '' ?>">

		<meta property="og:title" content="<?php if (is_single()) the_title(); else { bloginfo('name'); wp_title('::'); } ?>">
		<meta property="og:description" content="<?= is_single() ? wp_strip_all_tags(get_the_excerpt()) : get_bloginfo('description'); ?>">
		<meta property="og:url" content="<?= is_single() ? get_the_permalink() : '' ?>">
		<meta property="og:type" content="<?= is_single() ? 'article' : 'website' ?>">
		<meta property="og:image" content="<?= is_single() && has_post_thumbnail() ? get_the_post_thumbnail_url() : get_site_icon_url() ?>">
		<meta name="twitter:card" content="summary">
		<meta name="twitter:creator" content="@_gamjaa">
		<meta name="twitter:site" content="@_gamjaa">

		<link rel="canonical" href="<?= is_single() ? get_the_permalink() : '' ?>">
		<link rel="stylesheet" href="<?= get_bloginfo('stylesheet_url') ?>">
		<link rel="alternate" type="application/rss+xml" title="<?= get_bloginfo('name') ?>" href="<?= get_bloginfo('rss2_url') ?>">
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
			$categories = get_the_category($post->ID);
			if ($cat != 5 && $categories[0]->term_id != 5) {
				return true;
			}
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