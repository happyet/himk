<?php $this->need('header.php'); ?>
<main id="main">
	<div class="container">
		<div id="content" style="width:100%;">
            <article class="post" style="min-height: 500px">
                <h2 class="title" style="padding:30px 0;text-align:center">404 - <?php _e('页面没找到'); ?></h2>
                <div class="entry">
                    <form id="search" method="post" action="<?php $this->options->siteUrl(); ?>" role="search" style="margin:0 auto;max-width:300px">
                        <input type="text" id="s" name="s" class="text" placeholder="<?php _e('输入关键字搜索'); ?>" />
                        <button type="submit" class="submit"><?php _e('搜'); ?></button>
                    </form>
                </div>
            </article>
        </div>
    </div>
</main>
<?php $this->need('footer.php'); ?>