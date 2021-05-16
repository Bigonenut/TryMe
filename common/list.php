<?php while($this->next()): ?>
<article class="index_list">
    <div class="index_list_left">
        <div class="index_list_img">
            <img src="<?php $this->fields->banner(); ?>">
        </div>
    </div>

    <div class="index_list_right">
        <h2 class="index_list_name"><a href="<?php $this->permalink() ?>"><?php $this->title() ?></a></h2>

        <div class="index_list_excerpt">
        <?php $this->excerpt(90); ?>        
        </div>

        <div class="index_list_foot">
            <time datetime="<?php $this->date('c'); ?>"><i class="iconfont icon-shijian"></i><?php $this->date('m-d'); ?></time>
            <span><i class="iconfont icon-wenjian"></i><?php $this->category(' , '); ?></span>
            <span><i class="iconfont icon-pinglun"></i><?php $this->commentsNum('%d'); ?></span>
        </div>
    </div>
</article>
<?php endwhile; ?>

<?php $this->pageNav('<i class="iconfont icon-icon-test"></i>', '<i class="iconfont icon-icon-test1"></i>', 3, '...', array('wrapTag' => 'ul', 'wrapClass' => 'page-navigator', 'itemTag' => 'li', 'textTag' => 'span', 'currentClass' => 'current', 'prevClass' => 'prev', 'nextClass' => 'next')); ?>