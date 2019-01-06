<?php
  /*
    Template Name: 소개
  */
?>
<?php get_header(); ?>
<article>
	<?php 
		the_post();
		the_content();
	?>
</article>
<?php get_footer(); ?>
