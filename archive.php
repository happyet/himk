<?php $this->need('header.php'); ?>
<main id="main">
	<div class="container">
		<div id="content">
			<div class="post-lists">
				<div class="pagetitle">
					<h3><?php $this->archiveTitle(array(
					'category'  =>  _t('%s'),
					'search'    =>  _t('搜索 %s'),
					'tag'       =>  _t('标签 %s'),
					'author'    =>  _t('作者 %s')
					), '', ''); ?></h3>
				</div>
				<?php while($this->next()): ?>
					<article class="post">
						<h2 class="title"><a href="<?php $this->permalink() ?>"><?php $this->title() ?></a></h2>
						<div class="post-meta">
							<img src="<?php getAvatarByEmail($this->author->mail); ?>">
							<a itemprop="name" href="<?php $this->author->permalink(); ?>" rel="author"><span><?php $this->author(); ?></span></a>
							<span class="post-time"><?php $this->date(); ?></span>
						</div>
						<div class="entry xentry">
							<?php
							if (false !== strpos($this->text, '<!--more-->')) {
								echo str_replace('<p></br></p>', '', $this->excerpt);
							} else {
								$str = preg_replace('/<script>.*?<\/script>/is', '', $this->excerpt);
								echo '<p>'.Typecho_Common::subStr(strip_tags($str), 0, '120', '...').'</p>';
							} ?>
						</div>
						<div class="post-meta">
							<p>
								<?php $this->category(' / ');?>
								<span class="comments-link"><a href="<?php $this->permalink() ?>#comments" title="查看评论"><?php $this->commentsNum('评论 0', '评论 1', '评论 %d'); ?></a></span>
								<span class="read-more"><a href="<?php $this->permalink() ?>" title="详细阅读 <?php $this->title() ?>" rel="bookmark" class="title">全文阅读</a></span>
							</p>
						</div>
						<div id="comment-<?php $this->cid(); ?>" class="entry-comments plus"></div>
					</article>       		
				<?php endwhile; ?>
			</div>	
			<nav class="navigation">
				<?php $this->pageNav(); ?>
			</nav>
		</div>
		<?php $this->need('sidebar.php'); ?>
	</div>
</main>
<?php $this->need('footer.php'); ?>