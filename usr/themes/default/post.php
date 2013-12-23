<?php $this->need('header.php'); ?>
<div id="wrapper" role="main"><div class="wrap">
<section class="fix b-shadow i-art">
	<h2 class="title tac"><?php $this->title() ?></h2>
	<article id="detail" class="entry"><?php $this->content(); ?></article>
	<p class="meta" style="position:relative;"><span class="fr"><time datetime="<?php $this->date('Y-m-d'); ?>">发布时间: <?php $this->date('Y-m-d'); ?></time> / 标签: <?php $this->tag(); ?></span><?php $this->edit(); ?></p>
<div id="comments"><?php $this->comment_code(); ?>
</div>
</section>

    <?php $this->need('sidebar.php'); ?>
</div></div>
    <?php $this->need('footer.php'); ?>
