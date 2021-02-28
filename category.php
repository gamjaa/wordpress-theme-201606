<?= get_header() ?>
<div id="container">
	<div id="posts_wrapper">
		<article>
			<?php
				$paged = get_query_var('paged', 1);
				$query = new WP_Query(array(
					'cat' => $cat,
					'posts_per_page' => 20,
					'paged' => $paged
				));
			?>
			<header>
				<h1><?= get_cat_name($cat) ?> <small>(총 <?= $query->found_posts ?>개)</small></h1>
			</header>

			<ul id="catlist">
			<?php
				while ($query->have_posts()) :
					$query->the_post();
			?>
				<li>
					<a href="<?= get_permalink() ?>" class="none_deco"><?= get_the_title() ?></a>
					(<?= get_comments_number() ?>)
					<span><?= get_the_date() ?></span>
				</li>
			<?php
				endwhile;
			?>
			</ul>
		</article>

		<div id="pagination">
			<?php
				$big = 999999999;
				echo paginate_links( array(
				'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format' => '?paged=%#%',
				'current' => max( 1, get_query_var('paged') ),
				'total' => $query->max_num_pages,
				'type' => 'list',
				'prev_text'          => __('«'),
				'next_text'          => __('»'),
				) );
			?>
		</div>
	</div>

	<nav>
		<?php dynamic_sidebar('sidebar'); ?>
	</nav>
</div>
<?= get_footer() ?>
