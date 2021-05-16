<footer id="footer">
    <div class="content">
        <div class="footer_info">
            <div class="copyright">
                <span><?php $this->options->网站版权(); ?></span> 
            </div>
            <div class="copyleft"> 
                <span>Theme <a target="_blank" href="/">Tryme</a>.</span>
                <span><a href="http://beian.miit.gov.cn/" target="_blank" rel="nofollow"><?php $this->options->备案号(); ?></a></span> 
            </div>

        </div>
    </div>
</footer>

<!--工具栏-->
<div class="tool">
    <li class="tool_taiyang"><a href="javascript:switchNightMode()" ><button><i class="iconfont icon-contrast"></i></button></a></li>
    <li id="top_to" class="tool_top"><a href="javascript:"><button><i class="iconfont icon-top1"></i></button></a></li>
</div>

    <!--搜索框-->
    <div id="sousou">
    <div class="reward_mask">
       <div onclick="search_show()" class="reward_bg"></div>
       <div class="sousou_frame animated fadeInUp" style="animation-duration: 0.5s; transform: translate3d(0, -2px, 0);">
        <form method="post" action="">
            <div><input type="text" name="s" class="text" size="32" placeholder="请输入搜索内容..." /> <button type="submit" class="submit" value="Search"><i class="iconfont icon-sousuo1"></i></button></div>
        </form>
       </div>
    </div>
    </div>
    <!--手机菜单-->
    <div class="mobile">
        <div class="mobile_info">
           <div class="mobile_img">
               <img src="<?php echo avatarHtml($this->author); ?>">
           </div>
           <div class="mobile_name"><?php $this->options->title() ?><sapn class="h_spot"></sapn></div>
        </div>
        
        <div class="mobile_meun">
            <ul class="mobile_ul">
                <li class="mobile_li"><a href="<?php $this->options->siteUrl(); ?>">首页</a></li>
                            <?php $this->widget('Widget_Metas_Category_List')->to($category); ?>

                <li class="mobile_li mobile_level"> <i class="iconfont icon-dian"></i><a href="javascript:;">分类</a>
                <?php $this->widget('Widget_Metas_Category_List')->to($category);?>
                <ul class="mobile_level_ul mobile_level_none" style="display: none;">
                <?php while ($category->next()):?>
                <li class="mobile_level_li"><a href="<?php $category->permalink();?>"><?php $category->name();?></a></li>
                <?php endwhile; ?>
                </ul>
                </li>

                <?php $this->widget('Widget_Contents_Page_List')
                                   ->parse('<li class="mobile_li"><a href="{permalink}">{title}</a></li>'); ?>
                
        
            </ul>
        </div>
     </div>
     <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox/dist/jquery.fancybox.min.js"></script>
     <script type="text/javascript" src="<?php $this->options->themeUrl('app.js'); ?>"></script>
     <div onclick="mobile_show()" class="sap_mask mobile_mask"></div>
    <script>          
        function search_show(){
      $("#sousou").fadeToggle(0);
    };
    k73('.mobile_level', '.mobile_level_none')
function k73(idParent, idSon) {
let parent = $(idParent);
let son = $(idSon);
son.hide();
parent.on('click', function (event) {
    if ($(this).find(son).is(':hidden')) {
        $(this).find(son).slideDown(300);
    } else {
        $(this).find(son).slideUp(300);
    }
});
};
function mobile_show(){
$('.mobile').toggleClass('mobile_open');
$('.mobile_mask').toggleClass('sap_open');
};
    </script>
</body>
</html>