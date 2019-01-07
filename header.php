<!doctype html>
<html lang="ko">
	<head>
		<meta charset="UTF-8">
		<?php
			$categories = get_the_category($post->ID);
			if ($cat == 5 || $categories[0]->term_id == 5) echo "<meta name=\"robots\" content=\"noindex, nofollow\">\n";
			global $post;
		?>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width">
		<title><?= get_bloginfo('name') ?><?php wp_title('::') ?></title>

		<?php if (is_single()) the_post(); ?>
		<meta name="title" content="<?php if (is_single()) the_title(); else { bloginfo('name'); wp_title('::'); } ?>">
		<meta name="description" content="<?= is_single() ? wp_strip_all_tags(get_the_excerpt()) : get_bloginfo('description'); ?>">
		<meta name="keywords" content="<?php $tags = get_the_tags(); if ($tags) foreach($tags as $tag) echo $tag->name.','; ?>">


		<meta property="og:title" content="<?php if (is_single()) the_title(); else { bloginfo('name'); wp_title('::'); } ?>">
		<meta property="og:description" content="<?= is_single() ? wp_strip_all_tags(get_the_excerpt()) : get_bloginfo('description'); ?>">
		<meta property="og:url" content="<?= get_the_permalink() ?>">
		<meta property="og:type" content="<?= is_single() ? 'article' : 'website' ?>">
		<meta name="twitter:card" content="summary">
		<meta name="twitter:creator" content="@_gamjaa">
		<meta name="twitter:site" content="@_gamjaa">

		<link rel="canonical" href="<?= get_the_permalink() ?>">
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
