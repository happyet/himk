<?php $this->need('header.php'); ?>
<main id="main">
	<div class="container">
		<div id="content">
			<article class="post">
				<h2 class="title"><?php $this->title() ?></h2>
				<div class="post-meta">
					<img src="<?php getAvatarByEmail($this->author->mail); ?>">
					<a itemprop="name" href="<?php $this->author->permalink(); ?>" rel="author"><span><?php $this->author(); ?></span></a>
					<span class="post-time"><?php $this->date(); ?></span>
					<span class="comments-link"><a href="<?php $this->permalink() ?>#comments" title="查看评论"><?php $this->commentsNum('评论 0', '评论 1', '评论 %d'); ?></a></span>
				</div>
				<div class="entry">
					<?php $this->content(); ?>
				</div>
				<div class="post-meta">
					<p>标签：<?php $this->tags(', ', true, 'none'); ?></p>
				</div>
			</article>
			<nav class="navigation post-navi">
				<div class="prev">上一篇<?php $this->theNext(); ?></div>
				<div class="next">下一篇<?php $this->thePrev(); ?></div>
			</nav>
			<?php $this->need('comments.php'); ?>
		</div>
		<?php $this->need('sidebar.php'); ?>
	</div>
</main>
<?php $this->need('footer.php'); ?>