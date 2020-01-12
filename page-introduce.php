<?php
  /*
    Template Name: 소개
  */
?>
<?php get_header(); ?>
<div id="container" style="display: block; width: calc(100% - 20px); max-width: 750px;">
	<article style="border-bottom: none;">
		<?php 
			the_post();
			the_content();
		?>
	</article>
</div>
<?php get_footer(); ?>
