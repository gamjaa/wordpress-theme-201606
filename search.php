<?php get_header(); ?>
<div id="container">
	<article>
		<?php printf( __( '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\'<b>%s</b>\'에 대한 검색 결과 :'), get_search_query() );?>
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<div id="title"><h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
		<span class="category">
			<?php the_category(', '); ?> |
		</span>
		<span class="date">
			<?php echo get_the_date(); ?> <?php echo get_the_time(); ?>
		</span>
		</div>
		<div id="content">
			<?php
			$tags = get_the_tags();
			if($tags) foreach ($tags as $tag) if($tag->name == "광고포함") echo
			'
			<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
			<!-- 반응형 -->
			<ins class="adsbygoogle"
				 style="display:block"
				 data-ad-client="ca-pub-9422978281782094"
				 data-ad-slot="1450533311"
				 data-ad-format="auto"></ins>
			<script>
			(adsbygoogle = window.adsbygoogle || []).push({});
			</script>
			';
			?>
			<?php the_content(); ?>
			<?php
			$tags = get_the_tags();
			if($tags) foreach ($tags as $tag) if($tag->name == "광고포함") echo
			'
			<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
			<!-- 반응형 -->
			<ins class="adsbygoogle"
				 style="display:block"
				 data-ad-client="ca-pub-9422978281782094"
				 data-ad-slot="1450533311"
				 data-ad-format="auto"></ins>
			<script>
			(adsbygoogle = window.adsbygoogle || []).push({});
			</script>
			';
			?>
			<?php the_tags('<span id="tag">태그 : ', ', ', '</span>'); ?>
		</div>
		<div id="comment">
			<?php comments_popup_link( "댓글 달기", "댓글 <b>한 개</b>가 달려있습니다.", "댓글 <b>%개</b>가 달려있습니다.", comment_link, "" ); ?>
		</div>

		<?php endwhile; else: ?><?php endif; ?>
		<div id="pageNum">
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
	</article>

	<aside>
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Left Sidebar") ) : ?>
		<?php endif; ?>
	</aside><!-- sidebar 끝 -->
</div>
<?php get_footer(); ?>
