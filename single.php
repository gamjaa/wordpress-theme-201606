<?= get_header() ?>
<div id="container">
	<div id="posts_wrapper">
		<article class="post">
			<header>
				<h1><a href="<?= get_permalink() ?>" class="none_deco"><?= get_the_title() ?></a></h1>
				<span class="category"><?php the_category(', '); ?> | </span>
				<span class="date"><?= get_the_date(); ?> <?= get_the_time(); ?></span>
			</header>
			
			<?php
				$is_include_ads = get_post_meta($post->ID, 'include_ads');
				
				the_content();
				
				// 콘텐츠 끝 광고
				if ($is_include_ads) {
			?>
					<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
					<ins class="adsbygoogle"
						style="display:block; text-align:center;"
						data-ad-layout="in-article"
						data-ad-format="fluid"
						data-ad-client="ca-pub-9422978281782094"
						data-ad-slot="4457132838"></ins>
					<script>
						(adsbygoogle = window.adsbygoogle || []).push({});
					</script>
			<?php
				}
				
				the_tags('<span id="tag">태그 : ', ', ', '</span>');
			?>
		</article>

		<div id="comment">
			<?php comments_template(); ?>
		</div>
		
	</div>

	<nav>
		<?php 
			dynamic_sidebar('sidebar');

			// 사이드 바 광고
			if ($is_include_ads) {
		?>
				<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
				<ins class="adsbygoogle"
					style="display:block"
					data-ad-client="ca-pub-9422978281782094"
					data-ad-slot="1450533311"
					data-ad-format="auto"
					data-full-width-responsive="true"></ins>
				<script>
					(adsbygoogle = window.adsbygoogle || []).push({});
				</script>
		<?php
			}
		?>
	</nav>
</div>
<?php
	// 콘텐츠 중간 광고(너비 880px 이하)
	if ($is_include_ads) {
		$content_ad_code = base64_encode('
		<div>
			<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
			<ins class="adsbygoogle mobile_ad"
				style="text-align:center;"
				data-ad-layout="in-article"
				data-ad-format="fluid"
				data-ad-client="ca-pub-9422978281782094"
				data-ad-slot="4371113752"></ins>
			<script>
				(adsbygoogle = window.adsbygoogle || []).push({});
			</script>
		</div>');
?>
		<script>
			const contentAdEl = document.createElement('div');
			contentAdEl.style = 'margin-top: 20px; margin-bottom: 20px;';
			contentAdEl.innerHTML = window.atob('<?= $content_ad_code ?>');
			const pEl = document.querySelectorAll('article > p')[1];

			if (window.innerWidth <= 880) {
				pEl.parentNode.insertBefore(contentAdEl, pEl.nextSibling);
				(adsbygoogle = window.adsbygoogle || []).push({});
			} else {
				const resizeListener = () => {
					if (window.innerWidth <= 880) {
						pEl.parentNode.insertBefore(contentAdEl, pEl.nextSibling);
						(adsbygoogle = window.adsbygoogle || []).push({});
						
						window.removeEventListener('resize', resizeListener);
					}
				};
				window.addEventListener('resize', resizeListener);
			}
		</script>
<?php
	}
?>
<?= get_footer() ?>
