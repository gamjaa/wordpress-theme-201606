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
				$tags = get_the_tags();
				$is_contain_ad = false;
				foreach ($tags as $tag)
					if ($tag->name == "광고포함")
						$is_contain_ad = true;

				if ($is_contain_ad)
					echo '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
					<!-- 반응형 -->
					<ins class="adsbygoogle"
						style="display:block"
						data-ad-client="ca-pub-9422978281782094"
						data-ad-slot="1450533311"
						data-ad-format="auto"></ins>
					<script>
					(adsbygoogle = window.adsbygoogle || []).push({});
					</script>';
					
				the_content();
				
				the_tags('<span id="tag">태그 : ', ', ', '</span>');
			?>
		</article>

		<div id="comment">
			<?php comments_template(); ?>
		</div>
		
		<?php
			if ($is_contain_ad)
				echo '<ins class="adsbygoogle"
				style="display:block"
				data-ad-client="ca-pub-9422978281782094"
				data-ad-slot="1450533311"
				data-ad-format="auto"></ins>
				<script>
				(adsbygoogle = window.adsbygoogle || []).push({});
				</script>';
		?>
	</div>

	<nav>
		<?php dynamic_sidebar(); ?>
	</nav>
</div>
<?= get_footer() ?>
