<?php if (is_single()) the_post(); ?>
<!doctype html>
<html lang="ko">
	<head>
		<meta charset="UTF-8">
		<?= is_allow_robots() ? '' : "<meta name='robots' content='noindex,follow' />\n" ?>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<meta name="title" content="<?php if (is_single()) the_title(); else { wp_title('-', true, 'right'); bloginfo('name'); } ?>">
		<meta name="description" content="<?= esc_attr(is_single() ? wp_strip_all_tags(get_the_excerpt()) : get_bloginfo('description')); ?>">
		<meta name="keywords" content="<?= esc_attr(is_single() ? tags2keywords() : '') ?>">
		<meta property="og:title" content="<?php if (is_single()) the_title(); else { wp_title('-', true, 'right'); bloginfo('name'); } ?>">
		<meta property="og:description" content="<?= esc_attr(is_single() ? wp_strip_all_tags(get_the_excerpt()) : get_bloginfo('description')); ?>">
		<meta property="og:url" content="<?= esc_url(is_single() ? get_the_permalink() : '') ?>">
		<meta property="og:type" content="<?= is_single() ? 'article' : 'website' ?>">
		<meta property="og:image" content="<?= esc_url(is_single() ? 
			(get_post_meta($post->ID, 'disable_auto_thumb') ? 
				get_the_post_thumbnail_url($post) : get_template_directory_uri().'/thumb.php?post_id='.get_the_ID())
				: (get_option( 'gamjaa_post_options' )['auto_thumb_default'] ?: get_site_icon_url())) ?>">
		<meta property="og:site_name" content="<?= esc_attr(get_bloginfo('name')) ?>">
		<meta name="twitter:card" content="summary_large_image">
		<meta name="twitter:creator" content="@_gamjaa">
		<meta name="twitter:site" content="@_gamjaa">

		<link rel="canonical" href="<?= esc_url(is_single() ? get_the_permalink() : '') ?>">
		<?php wp_site_icon() ?>
		
		<?php wp_head() ?>
	</head>
	<body <?php body_class(); ?>>
		<header>
			<div class="site-branding">
				<?php
				if ( has_custom_logo() ) {
					the_custom_logo();
				} else {
					$site_title = get_bloginfo( 'name' );
					$site_url = esc_url( home_url( '/' ) );
					if ( is_front_page() && is_home() ) {
						echo '<h1 class="site-title"><a href="' . $site_url . '" rel="home">' . $site_title . '</a></h1>';
					} else {
						echo '<p class="site-title"><a href="' . $site_url . '" rel="home">' . $site_title . '</a></p>';
					}
				}
				?>
			</div>
			<nav class="main-navigation">
				<?php
					wp_nav_menu( array(
						'theme_location' => 'main_menu',
						'menu_class'     => 'main-menu',
						'fallback_cb'    => false,
					) );
				?>
			</nav>
		</header>

