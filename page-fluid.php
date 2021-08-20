<?php

/**
 * 单栏宽屏页面
 * 
 * @package custom 
 * 
 **/

$this->need('header.php'); ?>
<main id="main">
	<div class="container">
		<div id="content" style="width:100%;">
			<article class="post" style="min-height:450px;">
				<h2 class="title"><?php $this->title() ?></h2>
				<div class="entry">
					<?php $this->content(); ?>
				</div>
			</article>
			<?php $this->need('comments.php'); ?>
		</div><!--#content-->
	</div>
</main>
<?php $this->need('footer.php'); ?>