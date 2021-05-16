
<?php $this->need('common/header.php'); ?>
        <!--文章列表-->
        <div class="content content_top content_post">
            <article class="post">
                <div class="post_head">
                    <h1 class="post_name"><?php $this->title() ?></h1>
                    <div class="post_info">
                        <time datetime="<?php $this->date('c'); ?>">发布于 <?php $this->date('m-d'); ?></time> | <span><?php $this->tags(' ', true, ''); ?></span>
                    </div>
                </div>
                <?php if($this->fields->banner && $this->fields->banner!=''){ ?>
                <div class="post_img">
                    <img src="<?php $this->fields->banner(); ?>">
                </div>
                <?php } ?>
                <div class="song">
                <?php echo core::postContent($this,$this->user->hasLogin());?>
                </div>

                <div class="post_tool">
                    <div class="post_tool_zan">
                        <button onclick="dashang()" class="zan_btn ">打赏</button>
                    </div>
    
                    <div class="post_share">
                    <a class="weibo" href="//service.weibo.com/share/share.php?url=<?php $this->permalink() ?>&type=button&language=zh_cn&title=<?php $this->title() ?>" target="_blank" ><i class="iconfont icon-weibo"></i></a>
                 <a class="ttww"  href="https://twitter.com/intent/tweet?url=<?php $this->permalink() ?>" target="_blank" ><i class="iconfont icon-ttww"></i></a>
                 <a class="kongjiang" href="https://connect.qq.com/widget/shareqq/index.html?url=<?php $this->permalink() ?>&amp;title=<?php $this->title() ?>" target="_blank" ><i class="iconfont icon-QQ"></i></a>
                     <a class="weixin" onclick="weixin()" href="javascript:;"><i class="iconfont icon-weixin"></i></a>
                    </div>
                </div>

                <div class="post_next">

                </div>



            </article>
            
            <?php $this->need('common/comments.php'); ?>
            
        </div>

                   <!--微信分享-->
                   <div id="weixin_box">
                    <div class="weixin_mask">
                       <div onclick="weixin()" class="sap_mask sap_open"></div>
                       <div class="weixin_qr animated fadeInUp" style="animation-duration: 0.5s; transform: translate3d(0, -2px, 0);">
                           <div class="weixin_qr_name">微信扫一扫 分享朋友圈</div>
                           <img src="//api.qrserver.com/v1/create-qr-code/?size=200x200&margin=10&data=<?php $this->permalink() ?>">
                           <div onclick="weixin()" class="weixin_qr_off"><i class="iconfont icon-guanbi"></i></div>
                       </div>
                    </div>
                    </div>

                    <!--打赏-->
                    <div id="dashang_box">
                        <div class="weixin_mask">
                            <div onclick="dashang()" class="sap_mask sap_open"></div>
                            <div class="dashang_frame animated fadeInUp" style="animation-duration: 0.5s; transform: translate3d(0, -2px, 0);" >
                                <div class="dashang_name">欢迎打赏</div>
                                <img src="<?php $this->options->打赏二维码(); ?>">
                                <div onclick="dashang()" class="dashang_off"><i class="iconfont icon-guanbi"></i></div>
                            </div>
                        </div>
                    </div>
                    <script>  
                
                    function weixin(){
                  $("#weixin_box").fadeToggle(0);
                }
                function dashang(){
                  $("#dashang_box").fadeToggle(0);
                }
                $.each($("div.song figure:not(.size-parsed)"), function(t, n) {
			var a = new Image;
			a.onload = function() {
				var t = parseFloat(a.width),
					e = parseFloat(a.height);
				$(n).addClass("size-parsed"), $(n).css("width", t + "px"), $(n).css("flex-grow", 50 * t / e), $(n).find("a").css("padding-top", e / t * 100 + "%")
			}, a.src = $(n).find("img").attr("src")
		});
                           </script>

 <?php $this->need('common/footer.php'); ?>