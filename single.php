<?= get_header() ?>
<div id="container">
	<div id="posts_wrapper">
		<article>
			<header>
				<h1><a href="<?= get_permalink() ?>" class="none_deco"><?= get_the_title() ?></a></h1>
				<span class="category"><?php the_category(', '); ?> | </span>
				<span class="date"><?= get_the_date(); ?> <?= get_the_time(); ?></span>
			</header>
			
			<?php
				the_content();
				
				the_tags('<span id="tag">태그 : ', ', ', '</span>');
			?>
		</article>

		<div id="comment">
			<?php comments_template(); ?>
		</div>
		
	</div>

	<nav>
		<?php dynamic_sidebar(); ?>

		<?php if (function_exists ('adinserter')) echo adinserter (2); ?>
	</nav>
</div>
<?= get_footer() ?>
