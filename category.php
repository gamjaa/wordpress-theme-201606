<?php get_header(); ?>
<div id="container">
	<article>
		<div id="title"><h1><?php echo get_cat_name($cat); ?></h1></div>
                        <div id="content">
		<?php echo do_shortcode("[catlist categorypage='yes'  comments=yes date=yes date_tag=span pagination=yes numberposts=20 pagination_prev='«' pagination_next='»']");?>
                        </div>
	</article><!-- content 끝 -->

	<aside>
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Left Sidebar") ) : ?>
		<?php endif; ?>
	</aside><!-- sidebar 끝 -->
</div><!-- body 끝 -->
<?php get_footer(); ?>
