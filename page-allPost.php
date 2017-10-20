<?php
  /*
    Template Name: 전체 글
  */
?>
<?php get_header(); ?>
<div id="container">
	<article>
		<div id="title"><h1>전체 글</h1></div>
		<?php echo do_shortcode("[catlist comments=yes date=yes date_tag=span pagination=yes numberposts=20 pagination_prev='«' pagination_next='»']");?>
	</article><!-- content 끝 -->

	<aside>
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Left Sidebar") ) : ?>
		<?php endif; ?>
	</aside><!-- sidebar 끝 -->
</div><!-- body 끝 -->
<?php get_footer(); ?>
