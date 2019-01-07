<?php
  /*
    Template Name: 소개
  */
?>
<?php get_header(); ?>
<div id="container" style="display: block">
	<?php 
		the_post();
		the_content();
	?>
</div>
<?php get_footer(); ?>
