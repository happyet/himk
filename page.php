<?php $this->need('header.php'); ?>
<main id="main">
	<div class="container">
		<div id="content">
			<article class="post">
				<h2 class="title"><?php $this->title() ?></h2>
				<div class="entry">
					<?php $this->content(); ?>
				</div>
			</article>
			<?php $this->need('comments.php'); ?>
		</div><!--#content-->
		<?php $this->need('sidebar.php'); ?>
	</div>
</main>
<?php $this->need('footer.php'); ?>