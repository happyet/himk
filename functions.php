<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
function themeConfig($form) {
    $logoUrl = new Typecho_Widget_Helper_Form_Element_Text('logoUrl', NULL, NULL, _t('站点LOGO地址'), _t('在这里填入一个图片URL地址, 替换网站标题显示图片LOGO，高度限制60px'));
    $form->addInput($logoUrl);
    $blogFace = new Typecho_Widget_Helper_Form_Element_Text('blogFace', NULL, NULL, _t('右侧头像'), _t('在这里填入一个图片URL地址, 留空为作者头像'));
    $form->addInput($blogFace);
    $blogDec = new Typecho_Widget_Helper_Form_Element_Text('blogDec', NULL, NULL, _t('一句话'), _t('显示在右侧头像作者名字下面的一句话，简明精要。'));
    $form->addInput($blogDec);
    $blogMenu = new Typecho_Widget_Helper_Form_Element_textarea('blogMenu', NULL, NULL, _t('自定义导航菜单'), _t('按照固定格式添加修改：&lt;li&gt;&lt;a href="导航链接"&gt;导航中文名称&lt;span&gt;导航英文名称&lt;/span&gt;&lt;/a&gt;&lt;/li&gt;'));
    $form->addInput($blogMenu);

    $tencentQQ = new Typecho_Widget_Helper_Form_Element_Text('tencentQQ', NULL, NULL, _t('QQ:'), _t('你的QQ号码'));
    $form->addInput($tencentQQ);
    $tencentWX = new Typecho_Widget_Helper_Form_Element_Text('tencentWX', NULL, NULL, _t('微信二维码:'), _t('你的微信二维码图片地址'));
    $form->addInput($tencentWX);
    $Weibo = new Typecho_Widget_Helper_Form_Element_Text('Weibo', NULL, NULL, _t('微博:'), _t('你的微博地址'));
    $form->addInput($Weibo);

    $sidebarBlock = new Typecho_Widget_Helper_Form_Element_Checkbox('sidebarBlock', 
    array('ShowRecentPosts' => _t('显示最新文章'),
    'ShowRecentComments' => _t('显示最近回复'),
    'ShowHotComs' => _t('显示网友血条'),
    'ShowCategory' => _t('显示分类'),
    'ShowTags' => _t('显示标签云'),
    'ShowArchive' => _t('显示归档'),
    'ShowOther' => _t('显示其它杂项')),
    array('ShowRecentPosts', 'ShowRecentComments', 'ShowHotComs', 'ShowCategory', 'ShowTags','ShowArchive', 'ShowOther'), _t('侧边栏显示'));
    
    $form->addInput($sidebarBlock->multiMode());
}
/* 通过邮箱生成头像地址 */
function getAvatarByEmail($mail,$size=100,$show=true){
	$options = Typecho_Widget::widget('Widget_Options');
	$gravatarsUrl = '//cravatar.cn/avatar/';
	$rating = Helper::options()->commentsAvatarRating;
	$mailLower = strtolower($mail);
	$md5MailLower = md5($mailLower);
	$qqMail = str_replace('@qq.com', '', $mailLower);
	if (strstr($mailLower, "qq.com") && is_numeric($qqMail) && strlen($qqMail) < 11 && strlen($qqMail) > 4) {
		$qqapi = 'http://ptlogin2.qq.com/getface?&imgtype=1&uin='.$qqMail;
		$qquser = file_get_contents($qqapi);
		$str1 = explode('sdk&k=', $qquser);
		$str2 = explode('&s=', $str1[1]);
		$k = $str2[0];
		$avatar_link = '//q1.qlogo.cn/g?b=qq&k='.$k.'&s=100';
	} else {
		$avatar_link = $gravatarsUrl . $md5MailLower . '?s='.$size.'&r='.$rating.'&d=mm';
	}
  if($show){
    echo $avatar_link;
  }else{
    return $avatar_link;
  }
}
function themeInit($self){
  if (strpos($self->request->getRequestUri(), 'sitemap.xml') !== false) {
    $self->response->setStatus(200);
    $self->setThemeFile("sitemap.php");
  }
}
global $smilies_trans, $smilies_tag, $smilies_replace;

// setting at first time
if (!isset($smilies_trans)) {
  $smilies_trans = array(
  ':?:'        => 'icon_question.gif',
  ':razz:'     => 'icon_razz.gif',
  ':sad:'      => 'icon_sad.gif',
  ':evil:'     => 'icon_evil.gif',
  ':!:'        => 'icon_exclaim.gif',
  ':smile:'    => 'icon_smile.gif',
  ':oops:'     => 'icon_redface.gif',
  ':grin:'     => 'icon_biggrin.gif',
  ':eek:'      => 'icon_surprised.gif',
  ':shock:'    => 'icon_eek.gif',
  ':???:'      => 'icon_confused.gif',
  ':cool:'     => 'icon_cool.gif',
  ':lol:'      => 'icon_lol.gif',
  ':mad:'      => 'icon_mad.gif',
  ':twisted:'  => 'icon_twisted.gif',
  ':roll:'     => 'icon_rolleyes.gif',
  ':wink:'     => 'icon_wink.gif',
  ':idea:'     => 'icon_idea.gif',
  ':arrow:'    => 'icon_arrow.gif',
  ':neutral:'  => 'icon_neutral.gif',
  ':cry:'      => 'icon_cry.gif',
  ':mrgreen:'  => 'icon_mrgreen.gif',
  '8-)'        => 'icon_cool.gif',
  '8-O'        => 'icon_eek.gif',
  ':-('        => 'icon_sad.gif',
  ':-)'        => 'icon_smile.gif',
  ':-?'        => 'icon_confused.gif',
  ':-D'        => 'icon_biggrin.gif',
  ':-P'        => 'icon_razz.gif',
  ':-o'        => 'icon_surprised.gif',
  ':-x'        => 'icon_mad.gif',
  ':-|'        => 'icon_neutral.gif',
  ';-)'        => 'icon_wink.gif',
  '8)'         => 'icon_cool.gif',
  '8O'         => 'icon_eek.gif',
  ':('         => 'icon_sad.gif',
  ':)'         => 'icon_smile.gif',
  ':?'         => 'icon_confused.gif',
  ':D'         => 'icon_biggrin.gif',
  ':P'         => 'icon_razz.gif',
  ':o'         => 'icon_surprised.gif',
  ':x'         => 'icon_mad.gif',
  ':|'         => 'icon_neutral.gif',
  ';)'         => 'icon_wink.gif',
  );

// generates $smilies_tag & $smilies_replace arrays
$imgUrl = Helper::options()->themeUrl.'/static/smilies/';
foreach($smilies_trans as $smiley => $img) {
    $smilies_tag[] = $smiley;
    $smilies_replace[] = "<img src=\"$imgUrl$img\" alt=\"\" class=\"smiley\" />";
}
}


function convertSmilies($text){
global $smilies_tag, $smilies_replace;
$output = '';

// HTML loop taken from texturize function, could possible be consolidated
$textarr = preg_split("/(<.*>)/U", $text, -1, PREG_SPLIT_DELIM_CAPTURE); 
$stop = count($textarr);
for ($i = 0; $i < $stop; $i++) {
  $content = $textarr[$i];
  if ((strlen($content) > 0) && ('<' != $content{0})) { 
    $content = str_replace($smilies_tag, $smilies_replace, $content);
  }
  $output .= $content;
}
return $output;
}