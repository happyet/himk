<aside id="sidebar">
	<section class="widget">
		<div class="about-author">
			<img src="<?php echo $this->options->blogFace ? $this->options->blogFace : getAvatarByEmail($this->author->mail,100,false); ?>" class="avatar" alt="author" width="100" height="100" />
			
			<div class="author-description">
				<h2><?php $this->author(); ?></h2>
				<p><?php echo $this->options->blogDec ? $this->options->blogDec : '色即是空，色不异空。'; ?></p>
			</div>
			<div class="social">
				<?php
					$wb = $this->options->Weibo ? $this->options->Weibo : '';
					$wx = $this->options->tencentWX ? $this->options->tencentWX : '';
					$qq = $this->options->tencentQQ ? $this->options->tencentQQ : '';
					if($wx) echo '<span class="wx">微信<img src="'.$wx.'" alt="wechat"></span>';
					if($qq) echo '<span><a target="_blank" href="//wpa.qq.com/msgrd?v=3&uin='.$qq.'&site=qq&menu=yes">Q我</a></span>';
					if($wb) echo '<span><a target="_blank" href="'.$wb.'">微博</a></span>';
					echo '<span><a href="'.$this->options->feedUrl.'" title="订阅博客">订阅</a></span>';
				?>
			</div>
		</div>
		<?php Typecho_Widget::widget('Widget_Stat')->to($stat); ?>
		<div class="blog-stats">
			<div class="stats-item">
				<span class="title">文章</span>
				<span class="nums"><?php $stat->publishedPostsNum() ?></span>
			</div>
			<div class="stats-item">
				<span class="title">分类</span>
				<span class="nums"><?php $stat->categoriesNum() ?></span>
			</div>
			<div class="stats-item">
				<span class="title">评论</span>
				<span class="nums"><?php $stat->publishedCommentsNum() ?></span>
			</div>
			<div class="stats-item">
				<span class="title">页面</span>
				<span class="nums"><?php echo $stat->publishedPagesNum; ?></span>
			</div>
		</div>
	</section>

	<form id="search" method="post" action="<?php $this->options->siteUrl(); ?>" role="search">
		<input type="text" id="s" name="s" class="text" placeholder="<?php _e('输入关键字搜索'); ?>" />
		<button type="submit" class="submit"><?php _e('搜'); ?></button>
	</form>

	<?php if (!empty($this->options->sidebarBlock) && in_array('ShowHotComs', $this->options->sidebarBlock)): ?>
	<section class="widget">
		<h3 class="widget-title"><?php _E('网友血条'); ?></h3>
		<ul class="hot-commenter">
			<?php
			    $db = Typecho_Db::get();
				$sql = $db->select('COUNT(author) AS cnt','author', 'url', 'mail')
					->from('table.comments')
					->where('status = ?', 'approved')
					->where('type = ?', 'comment')
					->where('authorId = ?', '0')
					->group('author')
					->order('cnt', Typecho_Db::SORT_DESC)
					->limit('5');
				$result = $db->fetchAll($sql);
				  if($result){
					  $maxNum = $result[0]['cnt'];
					foreach ($result as $one){
						$width = round(($one['cnt']*100 /$maxNum ),2);//这里是血条长度的计算公式
						echo '<li>';
						echo '<img class="avatar" src="'.getAvatarByEmail($one['mail'],45,false).'">';
						echo '<div class="blood"><a href="'.$one['url'].'" target="_blank" rel="nofollow">'.$one['author'].' <small>'.$one['cnt'].' 点</small></a>';
						echo '<div class="active-bg"><div class="active-degree" style="width:'.$width.'%"></div></div></li>';
					}
				  }else{
					  echo "还没有人评论过！";
				  }
			?>
		</ul>
	</section>
	<?php endif; ?>
	<?php if (!empty($this->options->sidebarBlock) && in_array('ShowCategory', $this->options->sidebarBlock)): ?>
		<section class="widget">
			<h3 class="widget-title"><?php _e('分类栏目'); ?></h3>
			<?php $this->widget('Widget_Metas_Category_List')->to($category); $lestLevels = 0;?>
			<ul class="widget-list">
				<?php while ($category->next()): ?>
					<?php if ($category->levels === 0){
						if ($lestLevels > $category->levels) echo '</ul>';?>
							<li class="category-level-<?php echo $category->levels; ?>">
								<a href="<?php $category->permalink(); ?>" title="<?php $category->name(); ?>">
									<?php $category->name(); ?> <em class="category-count">(<?php $category->count(); ?>)</em>
								</a>
							</li>
					<?php }else{ 
						if ($lestLevels < $category->levels && $lestLevels===0 ) echo '<ul>';?>
					
						<li class="category-level-<?php echo $category->levels; ?>">
							<a href="<?php $category->permalink(); ?>" title="<?php $category->name(); ?>">
								<span class="category-name"><?php $category->name(); ?></span>
								<span class="category-count">(<?php $category->count(); ?>)</span>
							</a>
						</li>     
					<?php } $lestLevels = $category->levels;?>
				<?php endwhile; ?>
			</ul>
		</section>
    <?php endif; ?>
	<?php if (!empty($this->options->sidebarBlock) && in_array('ShowRecentPosts', $this->options->sidebarBlock)): ?>
		<section class="widget">
			<h3 class="widget-title"><?php _e('最新文章'); ?></h3>
			<ul class="widget-list">
				<?php $this->widget('Widget_Contents_Post_Recent','pageSize=5')
				->parse('<li><a href="{permalink}">{title}<span>{year}-{month}-{day}</span></a></li>'); ?>
			</ul>
		</section>
	<?php endif; ?>
	<?php if (!empty($this->options->sidebarBlock) && in_array('ShowRecentComments', $this->options->sidebarBlock)): ?>
		<section class="widget">
			<h3 class="widget-title"><?php _e('最近回复'); ?></h3>
			<ul class="widget-list recent-comments">
			<?php $this->widget('Widget_Comments_Recent','ignoreAuthor=true&pageSize=5')->to($comments); ?>
			<?php while($comments->next()): ?>
				<li>
					<img class="avatar" src="<?php getAvatarByEmail($comments->mail,45); ?>">
					<div class="rc-content">
						<a href="<?php $comments->permalink(); ?>">
							<span><?php $comments->author(false); ?> <?php $comments->date('y-m-d'); ?></span>
							<?php echo convertSmilies($comments->content); ?>
						</a>
					</div>
				</li>
			<?php endwhile; ?>
			</ul>
		</section>
    <?php endif; ?>
	<?php if (!empty($this->options->sidebarBlock) && in_array('ShowTags', $this->options->sidebarBlock)): ?>
		<section class="widget">
			<h3 class="widget-title"><?php _e('标签云'); ?></h3>
			<div class="tags-cloud">
				<?php $this->widget('Widget_Metas_Tag_Cloud', array('sort' => 'count', 'ignoreZeroCount' => true, 'desc' => true, 'limit' => 50))->to($tags); ?>  
				<?php while($tags->next()): ?>  
					<a rel="tag" href="<?php $tags->permalink(); ?>"><?php $tags->name(); ?>(<?php $tags->count(); ?>)</a>
				<?php endwhile; ?>
			</div>
		</section>
	<?php endif; ?>
	<?php if (!empty($this->options->sidebarBlock) && in_array('ShowArchive', $this->options->sidebarBlock)): ?>
		<section class="widget">
			<h3 class="widget-title"><?php _e('归档'); ?></h3>
			<ul class="widget-list">
				<?php $this->widget('Widget_Contents_Post_Date', 'type=month&format=F Y')
				->parse('<li><a href="{permalink}">{date}</a></li>'); ?>
			</ul>
		</section>
    <?php endif; ?>
</aside>