<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
	<title><?php $this->archiveTitle(array('category'=>_t(' %s '),'search'=>_t(' %s '),'tag'=>_t(' %s '),'author'=>_t(' %s ')), '', ' - ');?> <?php $this->options->title();?> - <?php $this->options->description() ?></title>
    <link rel="stylesheet" type="text/css" media="screen" href="<?php $this->options->themeUrl('style.css'); ?>" />
	<?php if ($this->is('post')): ?>
		<link rel="stylesheet" type="text/css" media="screen" href="<?php $this->options->themeUrl('/static/thickbox/thickbox.css'); ?>" />
	<?php endif; ?>
	<script type="text/javascript" src="<?php $this->options->themeUrl('/static/js/jquery.min.js '); ?>"></script>
    <script type="text/javascript" src="<?php $this->options->themeUrl('/static/js/app.js'); ?>"></script>
    <?php $this->header(); ?>
</head>
<body>
<header id="header" class="header">
	<div class="container">
		<div class="brand">
			<?php if ($this->options->logoUrl): ?>
				<h1 class="site-title">
					<a href="<?php $this->options->siteUrl(); ?>" style="line-height:0"><img height="65" src="<?php $this->options->logoUrl() ?>" alt="<?php $this->options->title() ?>" /></a>
				</h1>
			<?php else: ?>
				<h1 class="site-title">
					<a href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title() ?></a>
				</h1>
				<?php if (! $this->options->logoUrl) ?><p class="description"><?php $this->options->description() ?></p>
			<?php endif; ?>
		</div>
		<nav class="site-menu">
			<ul class="menu">
				<?php echo $this->options->blogMenu ? $this->options->blogMenu : '<li><a href="'.$this->options->adminUrl.'">请到主题后台手动设置菜单<span>Login</span></a></li>'; ?>
			</ul>
		</nav>
	</div>
</header>