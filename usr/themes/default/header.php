<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
<title><?php if(!$this->is('index')):?><?php $this->title(); ?> - <?php endif; ?><?php $this->options->title(); ?> - <?php $this->options->description(); ?></title>
<?php $this->header(); ?>
<link rel="stylesheet" href="<?php $this->options->siteurl() ?>/usr/themes/default/style.css" />
</head>
<body>
<header id="hd">
	<hgroup>
<h1 id="logo" role="banner"><a href="<?php $this->options->siteurl(); ?>"><?php $this->options->title() ?></a></h1>
		<p class="description"><?php $this->options->description() ?></p>
	</hgroup>
	<nav id="gnav">
		<b id="gn-bg" role="navigation"></b>

<?php $this->navbar(); ?>


		<!-- <div class="s-box">
			<form method="post">
				<p>
					<input type="text" name="s" class="s-keyword"  value="">
				</p>
				<input type="submit" value="搜 索" class="s-btn">
			</form>
		</div>  -->
	</nav>
</header>
