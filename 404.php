<?php
  /*
    Template Name: 에러 페이지
  */
?>
<?php get_header(); ?>
<article>
<div id="container">
	<div id="err">
		<div class="smile">;(</div>
		<div class="msg">
			<span class="impact">삭제</span>됐거나, <span class="impact">이동</span>된 페이지입니다.<br>
			<a href="javascript:history.back(-1)" class="impact">이전 페이지</a>로 돌아가시거나, <span class="impact">검색</span>해보세요!<br>
			<?php get_search_form(); ?>
		</div>
	</div>
</div>
</article>
<?php get_footer(); ?>