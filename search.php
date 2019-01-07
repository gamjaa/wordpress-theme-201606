<?php get_header(); ?>
<div id="container">
	<div id="posts_wrapper">
		<?php
			get_search_form();
			global $wp_query;
			$total_results = $wp_query->found_posts;
		?>		
		<small>검색 결과 총 <?= $total_results ?>건</small>

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<article id="<?= get_the_ID() ?>">
			<header>
				<h1><a href="<?= get_permalink() ?>" class="none_deco"><?= get_the_title() ?></a></h1>
				<span class="category"><?php the_category(', '); ?> | </span>
				<span class="date"><?= get_the_date(); ?> <?= get_the_time(); ?></span>

				<?php if (has_post_thumbnail()) : ?>
					<a href="<?= get_permalink() ?>" title="<?= get_the_title() ?>" class="thumb">
						<img src="<?php the_post_thumbnail_url('medium_large'); ?>"/>
					</a>
				<?php endif; ?>
			</header>

			<a href="<?= get_permalink() ?>" title="계속 읽기" class="none_deco"><?php the_excerpt(); ?></a>

			<a href="<?= get_permalink() ?>" class="more none_deco">계속 읽기</a>
		</article>
		<?php endwhile; endif; ?>

		<div id="pagination">
			<?php
			  global $wp_query;
			  $big = 999999999;
			  echo paginate_links( array(
				'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format' => '?paged=%#%',
				'current' => max( 1, get_query_var('paged') ),
				'total' => $wp_query->max_num_pages,
				'type' => 'list',
				'prev_text'          => __('«'),
				'next_text'          => __('»'),
			  ) );
			?>
		</div>
	</div>

	<nav>
		<?php dynamic_sidebar(); ?>
	</nav>
</div>
<?php get_footer(); ?>
