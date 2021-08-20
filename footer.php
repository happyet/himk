<footer class="footer">
	<div class="container">
    	<a title="登录后台" href="<?php $this->options->adminUrl(); ?>" style="margin-right:auto"><img src="<?php $this->options->themeUrl('/static/images/login.png'); ?>" alt="登录" /></a>
		<p><a href="<?php $this->options->siteUrl('sitemap.xml'); ?>">SiteMap</a><br>Powered by <a href="https://www.typecho.org">Typecho)))</a>&nbsp;Theme by <a href="https://lms.im">LMS.im</a></p>
	</div>
</footer>
<div class="goTop"><span id="top">上</span></div>
<?php $this->footer(); ?>
<?php if ($this->is('post')): ?>
<script type="text/javascript">
/* <![CDATA[ */
var thickboxL10n = {
	next: "下一页 &gt;",
	prev: "&lt; 上一页",
	image: "图像",
	of: "的",
	close: "关闭",
	loadingAnimation: "<?php $this->options->themeUrl('/static/thickbox/loadingAnimation.gif');?>",
	noiframes: "这个功能需要 iframe 的支持，您可能禁止了 iframe 的显示或是您的浏览器不支持。"
};
try{convertEntities(thickboxL10n);}catch(e){};
/* ]]> */
</script>
<script type="text/javascript" src="<?php $this->options->themeUrl('/static/thickbox/thickbox.js'); ?>"></script>
<?php endif; ?>
</body>
</html>