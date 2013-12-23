<?php
/**
 * html5+css3制作的皮肤，兼容主流浏览器，因为各个浏览器对css3支持程度不同，所以显示效果有部分差异。显示效果chrome/safari>firefox3+>oprea>ie9>ie8>ie7>ie6
 * 
 * @package qtlight K Blue Theme 
 * @author Kairyou
 * @modified by qingtian
 * @version 1.0.5
 * @link http://www.fantxi.com/blog/
 * @note:使用此模版，请保留底部版权及链接。基于本模版修改，请标明及保留链接。
 */
$this->need('header.php');
?>
<div id="wrapper" role="main"><div class="wrap">
<section class="fix b-shadow i-art">

        <ul class="fix log-list">
	<?php while($this->next()): ?>
	<li class="art-item">
		<h3 class="tit tac"><a href="<?php $this->permalink() ?>"><?php $this->title() ?></a></h3>
			<p class="tac time">
				<time  datetime="<?php $this->date('Y-m-d'); ?>">发布时间: <?php $this->date('Y-m-d'); ?></time>
				/ 标签： <?php $this->tag(); ?>
<?php $this->edit(); ?>
			</p>
			<article class="entry"><?php $this->content(); ?></article>
	</li>
	<?php endwhile; ?>
 	</ul>

        <p class="page-navigator"><?php $this->pagenav(); ?></p>

</section>
<?php $this->need('sidebar.php'); ?>
</div></div>
<?php $this->need('footer.php'); ?>