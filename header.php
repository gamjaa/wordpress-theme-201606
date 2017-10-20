<!doctype html>
<html lang="ko">
	<head>
		<meta charset="UTF-8">
		<?php
			$categories = get_the_category( $post->ID );
			if($cat==5) echo "<meta name=\"robots\" content=\"noindex, nofollow\">\n";
			else if($categories[0]-> term_id == 5) echo "<meta name=\"robots\" content=\"noindex, nofollow\">\n";
		?>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width">
		<title><?php bloginfo('name'); ?><?php wp_title('::'); ?></title>
		<meta name="title" content="<?php if(is_front_page()) echo "감자박스"; else the_title(); ?>">
		<meta name="keywords" content="<?php $posttags = get_the_tags(); if ($posttags) {   foreach($posttags as $tag) {     echo $tag->name . ', ';    } } ?>">
		<meta property="og:title" content="<?php if(is_front_page()) echo "감자박스"; else the_title(); ?>">
		<meta property="og:description" content="<?php if(is_front_page()) echo "포태토의 블로그"; else bloginfo('name'); ?>">
		<meta property="og:url" content="<?php the_permalink(); ?>">
		<link rel="canonical" href="<?php the_permalink(); ?>">
		<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
		<link rel="shortcut icon" href="/favicon.ico">
		<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?>" href="<?php bloginfo('rss2_url'); ?>">
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
		<header>
		<?php
				  wp_nav_menu( array(
					'theme_location' => 'main_menu',
					'fallback_cb' => false,
				  ));
		?>

		<!--<div id="titleImg"><?php echo get_avatar( 'potato93@daum.net', 256 ); ?></div>-->
		</header>
