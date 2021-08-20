<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
function threadedComments($comments, $options) {
    $commentClass = 'commentlist';
    if ($comments->authorId) {
        if ($comments->authorId == $comments->ownerId) {
            $commentClass .= ' comment-by-author';
        } else {
            $commentClass .= ' comment-by-user';
        }
    }

    $commentLevelClass = $comments->levels > 0 ? ' comment-child' : ' comment-parent';

    if ($comments->url) {
        $author = '<a href="' . $comments->url . '" target="_blank"' . ' rel="external nofollow">' . $comments->author . '</a>';
    } else {
        $author = $comments->author;
    }
    
    $comment_body_class = '';
    if ($comments->levels > 0) {
        $comment_body_class = 'comment-child';
    } else {
        $comment_body_class = 'comment-parent';
    }
    ?>

    <li id="<?php $comments->theId(); ?>" class="comment byuser comment-author-admin bypostauthor depth-<?php echo $comments->levels+1; ?> comment-body <?php echo $comment_body_class; $comments->alt(' odd', ' even'); $comments->levelsAlt(' comment-level-odd', ' comment-level-even');?>">
        <div class="comment-meta">
            <div class="user-avatar">
                <img alt="commenter-avatar" src="<?php getAvatarByEmail($comments->mail,50); ?>" class="avatar photo" height="50" width="50">
            </div>
            <div class="user-info">
                <span class="comment-author"><?php echo $author; ?></span> <?php $comments->date('Y-m-d'); ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php $comments->reply('回复'); ?>
            </div>
        </div>
        <div class="comment-content" id="div-<?php $comments->theId(); ?>">
            <?php echo convertSmilies($comments->content); ?>    
        </div>
        <?php if ($comments->children) { ?><ul class="children"><?php $comments->threadedComments($options); ?></ul><?php } ?>
    </li>
<?php } ?>

<?php $this->comments()->to($comments); ?>
<div class="comment-area">
    <?php if ($comments->have()) : ?>
        <div class="comments">
            <h3 id="comments">评论 <?php $this->commentsNum('<small></small>', '<b>1</b>', '<b>%d</b>'); ?></h3>
            <ol class="commentlist"><?php $comments->listComments(array('before' =>  '','after'  =>  '')); ?></ol>
            <div class="comment-pagination">
                <?php $comments->pageNav('<','>',2,'...',array('wrapTag' => 'ul')); ?>
            </div>
            <?php if(!$this->allow('comment')): ?>
                <p class="text-center">文章评论已关闭！</p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    <?php if($this->allow('comment')){ ?>
	    <div id="<?php $this->respondId(); ?>" class="respond"> 
            <h3>发表评论 <?php $comments->cancelReply('<font color="#FF5151">取消</font>'); ?></h3>
		    <form action="<?php $this->commentUrl() ?>" method="post" id="commentform">
                <div class="comt-title">
                    <?php 
                        if($this->user->hasLogin()):
                            $_user_mail = $this->user->mail;
                        elseif($this->remember('mail',true)):
                            $_user_mail = $this->remember('mail',true);
                        else:
                            $_user_mail = '';
                        endif;
                        if($_user_mail){
                    ?>
                        <img alt="commenter-avatar" src="<?php getAvatarByEmail($_user_mail,50); ?>" class="avatar photo" height="50" width="50">
                    <?php } ?>
                    <?php 
    					$_commenter = $_alter = '';
						if($this->user->hasLogin()): 
							$_commenter = '<strong style="color: #007bff">' . $this->user->screenName.'</strong> 你好, ';
							$_alter = '<a href="' . $this->options->logoutUrl . '">退出</a>';
						elseif($this->remember('author',true) != "" && $this->remember('mail',true) != ""):
							$_commenter = '<strong style="color: #007bff">' . $this->remember('author',true).'</strong> 你好, ';
							$_alter = '<a href="javascript:;" class="show-commenter">换个马甲评论</a>';
						else :
							$_commenter = '你未评论过，数字qq邮箱自动获取头像。';
						endif; 
					?>
                    <p><?php echo $_commenter; ?><br><?php echo $_alter;?></p>
                </div>
                <div class="comt-box">
                    <?php if(!$this->user->hasLogin()): ?>
                        <div class="comt-comterinfo" id="comment-author-info"<?php if($this->remember('author',true) != "" && $this->remember('mail',true) != "") echo ' style="display:none"'; ?>>
                            <ul>
                                <li class="form-inline"><input class="ipt" type="text" name="author" id="author" value="<?php $this->remember('author'); ?>" tabindex="2" placeholder="昵称（必填）" required></li>
                                <li class="form-inline"><input class="ipt" type="text" name="mail" id="mail" value="<?php $this->remember('mail'); ?>" tabindex="3" placeholder="邮箱（必填）" <?php if ($this->options->commentsRequireMail): ?> required<?php endif; ?>></li>
                                <li class="form-inline"><input class="ipt" type="text" name="url" id="url" value="<?php $this->remember('url'); ?>" tabindex="4" placeholder="网址"></li>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <textarea placeholder="做文明人，讲文明话。" class="input-block-level comt-area ipt" name="text" id="comment" rows="3" tabindex="1" ></textarea>
                    <div class="comt-ctrl">
                        <div class="comt-tips"></div>
                        <span class="embedSmiley" style="margin-left:8px;"><a href="javascript:Smilies.showBox();">OωO</a></span>
                        <button type="submit" name="submit" id="submit" tabindex="5">提交评论</button>
                        <?php $security = $this->widget('Widget_Security'); ?>
                        <input type="hidden" name="_" value="<?php echo $security->getToken($this->request->getReferer())?>">
                    </div>
                    <?php $imgUrl = $this->options->themeUrl.'/static/smilies/'; ?>
                    <span id="smiley" style="display:none;">
                        <a href="javascript:Smilies.grin(':?:')"      ><img src="<?php echo $imgUrl; ?>icon_question.gif"  alt="" class="smiley" /></a>
                        <a href="javascript:Smilies.grin(':razz:')"   ><img src="<?php echo $imgUrl; ?>icon_razz.gif"      alt="" class="smiley" /></a>
                        <a href="javascript:Smilies.grin(':sad:')"    ><img src="<?php echo $imgUrl; ?>icon_sad.gif"       alt="" class="smiley" /></a>
                        <a href="javascript:Smilies.grin(':evil:')"   ><img src="<?php echo $imgUrl; ?>icon_evil.gif"      alt="" class="smiley" /></a>
                        <a href="javascript:Smilies.grin(':!:')"      ><img src="<?php echo $imgUrl; ?>icon_exclaim.gif"   alt="" class="smiley" /></a>
                        <a href="javascript:Smilies.grin(':smile:')"  ><img src="<?php echo $imgUrl; ?>icon_smile.gif"     alt="" class="smiley" /></a>
                        <a href="javascript:Smilies.grin(':oops:')"   ><img src="<?php echo $imgUrl; ?>icon_redface.gif"   alt="" class="smiley" /></a>
                        <a href="javascript:Smilies.grin(':grin:')"   ><img src="<?php echo $imgUrl; ?>icon_biggrin.gif"   alt="" class="smiley" /></a>
                        <a href="javascript:Smilies.grin(':eek:')"    ><img src="<?php echo $imgUrl; ?>icon_surprised.gif" alt="" class="smiley" /></a>
                        <a href="javascript:Smilies.grin(':shock:')"  ><img src="<?php echo $imgUrl; ?>icon_eek.gif"       alt="" class="smiley" /></a>
                        <a href="javascript:Smilies.grin(':???:')"    ><img src="<?php echo $imgUrl; ?>icon_confused.gif"  alt="" class="smiley" /></a>
                        <a href="javascript:Smilies.grin(':cool:')"   ><img src="<?php echo $imgUrl; ?>icon_cool.gif"      alt="" class="smiley" /></a>
                        <a href="javascript:Smilies.grin(':lol:')"    ><img src="<?php echo $imgUrl; ?>icon_lol.gif"       alt="" class="smiley" /></a>
                        <a href="javascript:Smilies.grin(':mad:')"    ><img src="<?php echo $imgUrl; ?>icon_mad.gif"       alt="" class="smiley" /></a>
                        <a href="javascript:Smilies.grin(':twisted:')"><img src="<?php echo $imgUrl; ?>icon_twisted.gif"   alt="" class="smiley" /></a>
                        <a href="javascript:Smilies.grin(':roll:')"   ><img src="<?php echo $imgUrl; ?>icon_rolleyes.gif"  alt="" class="smiley" /></a>
                        <a href="javascript:Smilies.grin(':wink:')"   ><img src="<?php echo $imgUrl; ?>icon_wink.gif"      alt="" class="smiley" /></a>
                        <a href="javascript:Smilies.grin(':idea:')"   ><img src="<?php echo $imgUrl; ?>icon_idea.gif"      alt="" class="smiley" /></a>
                        <a href="javascript:Smilies.grin(':arrow:')"  ><img src="<?php echo $imgUrl; ?>icon_arrow.gif"     alt="" class="smiley" /></a>
                        <a href="javascript:Smilies.grin(':neutral:')"><img src="<?php echo $imgUrl; ?>icon_neutral.gif"   alt="" class="smiley" /></a>
                        <a href="javascript:Smilies.grin(':cry:')"    ><img src="<?php echo $imgUrl; ?>icon_cry.gif"       alt="" class="smiley" /></a>
                        <a href="javascript:Smilies.grin(':mrgreen:')"><img src="<?php echo $imgUrl; ?>icon_mrgreen.gif"   alt="" class="smiley" /></a>
                    </span>
                </div>
            </form>
		</div>
<script>
	function showhidediv(id){  
		var sbtitle=document.getElementById(id);  
		if(sbtitle){  
			if(sbtitle.style.display=='block'){  
				sbtitle.style.display='none';  
			}else{  
				sbtitle.style.display='block';  
			}  
		}  
	}
	(function () {
		window.TypechoComment = {
			dom : function (id) {
				return document.getElementById(id);
			},
			create : function (tag, attr) {
				var el = document.createElement(tag);
				for (var key in attr) {
					el.setAttribute(key, attr[key]);
				}
				return el;
			},
			reply : function (cid, coid) {
				var comment = this.dom(cid), parent = comment.parentNode,
					response = this.dom('<?php echo $this->respondId(); ?>'),
					input = this.dom('comment-parent'),
					form = 'form' == response.tagName ? response : response.getElementsByTagName('form')[0],
					textarea = response.getElementsByTagName('textarea')[0];
				if (null == input) {
					input = this.create('input', {
						'type' : 'hidden',
						'name' : 'parent',
						'id'   : 'comment-parent'
					});
					form.appendChild(input);
				}
				input.setAttribute('value', coid);
				if (null == this.dom('comment-form-place-holder')) {
					var holder = this.create('div', {
						'id' : 'comment-form-place-holder'
					});
					response.parentNode.insertBefore(holder, response);
				}
				comment.appendChild(response);
				this.dom('cancel-comment-reply-link').style.display = '';
				if (null != textarea && 'text' == textarea.name) {
					textarea.focus();
				}
				return false;
			},
			cancelReply : function () {
				var response = this.dom('<?php echo $this->respondId(); ?>'),
				holder = this.dom('comment-form-place-holder'),
				input = this.dom('comment-parent');
				if (null != input) {
					input.parentNode.removeChild(input);
				}
				if (null == holder) {
					return true;
				}
				this.dom('cancel-comment-reply-link').style.display = 'none';
				holder.parentNode.insertBefore(response, holder);
				return false;
			}
		};
	})();
    Smilies = {
        dom : function(id) {
        return document.getElementById(id);
        },

        showBox : function () {
        this.dom('smiley').style.display = 'block';
        document.onclick = function() {
            Smilies.hideBox();
        }
    },

    hideBox : function () {
        this.dom('smiley').style.display = 'none';
    },

    grin : function (tag) { // 表情
        tag = ' ' + tag + ' '; myField = this.dom('comment');
        document.selection ? (myField.focus(), sel = document.selection.createRange(), sel.text = tag, myField.focus()) : this.insertTag(tag);
    },

    insertTag : function (tag) { // 插入评论中
        myField = Smilies.dom('comment');
        myField.selectionStart || myField.selectionStart == '0' ? (
            startPos = myField.selectionStart,
            endPos = myField.selectionEnd,
            cursorPos = startPos,
            myField.value = myField.value.substring(0, startPos)
                        + tag
                        + myField.value.substring(endPos, myField.value.length),
            cursorPos += tag.length,
            myField.focus(),
            myField.selectionStart = cursorPos,
            myField.selectionEnd = cursorPos
        ) : (
            myField.value += tag,
            myField.focus()
        );
        this.hideBox();
        }
    }
</script>
    <?php } ?>
</div>	