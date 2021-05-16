<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

<?php
function threadedComments($comments, $options)
{
    $commentClass = '';
    if ($comments->authorId) {
        if ($comments->authorId == $comments->ownerId) {
            $commentClass .= ' comment-by-author';
        } else {
            $commentClass .= ' comment-by-user';
        }
    }
    $commentLevelClass = $comments->levels > 0 ? ' comment-child' : ' comment-parent';
    if ($comments->url) {
        $author = '<a href="' . $comments->url . '"' . '" target="_blank"' . ' rel="external nofollow">' . $comments->author . '</a>';
    } else {
        $author = $comments->author;
    }
    ?>
    <li id="li-<?php $comments->theId(); ?>" class="comment-body<?php
                                                                if ($comments->levels > 0) {
                                                                    echo ' comment-child';
                                                                    $comments->levelsAlt(' comment-level-odd', ' comment-level-even');
                                                                } else {
                                                                    echo ' comment-parent';
                                                                }
                                                                $comments->alt(' comment-odd', ' comment-even');
                                                                echo $commentClass;
                                                                ?>">
        <div id="<?php $comments->theId(); ?>">
            <img class="avatar" src="<?php echo avatarHtml($comments); ?>"    />
            <div class="comment_main">
                 <div class="comment_author"><?php echo $author ?>  </div>
                 <div class="comment_excerpt">
            
                 <?php $comments->content(); ?>
                </div>
                
                <div class="comment_meta">
                    <span class="comment_time"><?php $comments->dateWord(); ?></span><span class="comment-reply cp-<?php $comments->theId(); ?> text-muted comment-reply-link"><?php $comments->reply('回复'); ?></span><span id="cancel-comment-reply" class="cancel-comment-reply cl-<?php $comments->theId(); ?> text-muted comment-reply-link" style="display:none" ><?php $comments->cancelReply('取消'); ?></span>
                </div>
            </div>
        </div>
        <?php if ($comments->children) { ?><div class="comment-children"><?php $comments->threadedComments($options); ?></div><?php } ?>
    </li>
<?php } ?>

<div id="comments" class="gen">
    <?php $this->comments()->to($comments); ?>

    <?php if ($this->allow('comment')) : ?>
        <div id="<?php $this->respondId(); ?>" class="respond">

            <form method="post" action="<?php $this->commentUrl() ?>" id="comment-form" role="form">
                <div class="comment-editor">
                    <textarea name="text" id="textarea" placeholder="撰写评论" class="textarea textarea_box OwO-textarea" required onkeydown="if((event.ctrlKey||event.metaKey)&&event.keyCode==13){document.getElementById('submitComment').click();return false};"><?php $this->remember('text'); ?></textarea>
                </div>

                <div class="comment-inputs">
                    <?php if ($this->user->hasLogin()) : ?>
                        <div class="comment_admin"><?php _e('尊敬的站长：'); ?><a class="admin_name" href="<?php $this->options->profileUrl(); ?>"><?php $this->user->screenName(); ?></a>. <a href="<?php $this->options->logoutUrl(); ?>" title="Logout"><?php _e('退出'); ?> &raquo;</a></div>
                    <?php else : ?>
                        <div class="comment_xin"><input type="text" name="author" id="comment-name" class="text" placeholder="<?php _e('名字'); ?>" value="<?php $this->remember('author'); ?>" required /></div>
                        <div class="comment_xin"><input type="email" name="mail" id="comment-mail" class="text" placeholder="<?php _e('邮箱'); ?>" value="<?php $this->remember('mail'); ?>" <?php if ($this->options->commentsRequireMail) : ?> required<?php endif; ?> /></div>
                        <div class="comment_xin"><input type="url" name="url" id="comment-url" class="text" placeholder="<?php _e('网址'); ?>" value="<?php $this->remember('url'); ?>" <?php if ($this->options->commentsRequireURL) : ?> required<?php endif; ?> /></div>
                        
                    <?php endif; ?>
                </div>

                <div class="comment-buttons">
                    <div class="rko"><div class="OwO">OωO</i></div></div>
                    <div class="right">
                        <button id="submitComment" type="submit" class="submit"><?php _e('发表评论'); ?></button>
                    </div>
                    
                </div>
            </form>
        </div>
    <?php else : ?>
            <div class="comments_off"><?php _e('评论已关闭'); ?></div>
        
    <?php endif; ?>
    <div class="comments_lie">
    <?php if ($comments->have()) : ?>
        <div class="comments_number"><span class="comments_number_box"><span>评论 <small>( <?php $this->commentsNum(_t('0'), _t('1'), _t('%d')); ?> )</small></span></span></div>

        <?php $comments->listComments(); ?>

        <div class="nav-page">
            <center><?php $comments->pageNav('<i class="iconfont icon-icon-test"></i>', '<i class="iconfont icon-icon-test1"></i>'); ?></center>
        </div>
    <?php endif; ?>
    </div>
</div>

<script type="text/javascript">
function showhidediv(id){var sbtitle=document.getElementById(id);if(sbtitle){if(sbtitle.style.display=='flex'){sbtitle.style.display='none';}else{sbtitle.style.display='flex';}}}
(function(){window.TypechoComment={dom:function(id){return document.getElementById(id)},pom:function(id){return document.getElementsByClassName(id)[0]},iom:function(id,dis){var alist=document.getElementsByClassName(id);if(alist){for(var idx=0;idx<alist.length;idx++){var mya=alist[idx];mya.style.display=dis}}},create:function(tag,attr){var el=document.createElement(tag);for(var key in attr){el.setAttribute(key,attr[key])}return el},reply:function(cid,coid){var comment=this.dom(cid),parent=comment.parentNode,response=this.dom("<?php echo $this->respondId(); ?>"),input=this.dom("comment-parent"),form="form"==response.tagName?response:response.getElementsByTagName("form")[0],textarea=response.getElementsByTagName("textarea")[0];if(null==input){input=this.create("input",{"type":"hidden","name":"parent","id":"comment-parent"});form.appendChild(input)}input.setAttribute("value",coid);if(null==this.dom("comment-form-place-holder")){var holder=this.create("div",{"id":"comment-form-place-holder"});response.parentNode.insertBefore(holder,response)}comment.appendChild(response);this.iom("comment-reply","");this.pom("cp-"+cid).style.display="none";this.iom("cancel-comment-reply","none");this.pom("cl-"+cid).style.display="";if(null!=textarea&&"text"==textarea.name){textarea.focus()}return false},cancelReply:function(){var response=this.dom("<?php echo $this->respondId(); ?>"),holder=this.dom("comment-form-place-holder"),input=this.dom("comment-parent");if(null!=input){input.parentNode.removeChild(input)}if(null==holder){return true}this.iom("comment-reply","");this.iom("cancel-comment-reply","none");holder.parentNode.insertBefore(response,holder);return false}}})();
</script>

<script>
    <?php if ($this->allow('comment')) : ?>
      var OwO_demo = new OwO({
        logo: 'OωO表情',
        container: document.getElementsByClassName('OwO')[0],
        target: document.getElementsByClassName('OwO-textarea')[0],
        api: 'https://cdn.jsdelivr.net/gh/zetheme/pigeon/OWO/OwO.json',
        position: 'down',
        width: '100%',
        maxHeight: '250px'
    });
    <?php endif; ?>


  $('#comment-form').submit(function(event){
      var commentdata=$(this).serializeArray();
      $.ajax({
          url:$(this).attr('action'),
          type:$(this).attr('method'),
          data:commentdata,
          beforeSend:function() {
              $('#submitComment').addClass('submit').text('提交中...');
          },
          error:function(request) {

          },
          success:function(data){
              $('#submitComment').addClass('submit').text('发布评论');
              var error=/<title>Error<\/title>/;
              if (error.test(data)){
                  var text=data.match(/<div(.*?)>(.*?)<\/div>/is);
                  var str='发生了未知错误';if (text!=null) str=text[2];
              } else {
                  $('.textarea_box').val('');$('.textarea_box').css('height','75px');
                  if ($('#cancel-comment-reply-link').css('display')!='none') $('#cancel-comment-reply-link').click();
                  var target='#comments',parent=true;
                  $.each(commentdata,function(i,field) {if (field.name=='parent') parent=false;});
                  if (!parent || !$('ol.page-navigator .prev').length){
                      var latest=-19260817;
                      $('#comments .comment-parent',data).each(function(){
                          var id=$(this).attr('id'),coid=parseInt(id.substring(8));
                          if (coid>latest) {latest=coid;target='#'+id;}
                      });
                      jQuery(document).ready(function($){
                          if ($('#comments .parent').length > 0) {
                              for (var i = 0; i < $('#comments .parent').length; i ++) {
                                  var parentLink = '<a class="mr-1" href="' + $('#comments .parent').eq(i).attr('href') + '">' + $('#comments .parent').eq(i).html() + '</a>';
                                  $('#comments .parent').eq(i).next().prepend(parentLink);
                              }
                              $('#comments .parent').remove();
                          };
                      });
                  }
                  $('.comment-body').html($('.comment-body',data).html()); 
                  $('.comments-title').html($('.comments-title',data).html()); 
                  $('.comments_lie').html($('.comments_lie',data).html());
              }
          }
      });
      return false;
  });
</script>
