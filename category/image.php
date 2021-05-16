<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('common/header.php'); ?>

        <!--文章列表-->
        <div class="content content_top content_post">
            <article class="post">
                <div class="classify_head">
                    <div class="classify_name"><?php $this->archiveTitle(array(
                        'category'  =>  _t('分类：%s'),
                        'search'    =>  _t('搜索：%s'),
                        'tag'       =>  _t('标签：%s')
                    ), '', ''); ?></div>
                    <div class="classify_count">该目录下共有 <?php echo $this->getTotal() ;?> 篇文章</div>
                </div>
                <div class="classify_list">
    <?php while($this->next()): ?>
    <div class="posture_list index_ajax">
        <div class="posture_show">
            <a href="<?php $this->permalink() ?>">
            <div class="posture_box">
            <div class="posture_frame">
            <?php if($this->fields->banner && $this->fields->banner!=''){ ?>
                <img class="lazy" src="<?php $this->fields->banner(); ?>">
            <?php } else { ?>
                <img class="lazy" src="<?php echo getPostImg($this); ?>">
            <?php } ?>
            </div>
            <div class="posture_basic">
                    <i class="iconfont icontupian"></i>
            </div>
           </div>
            <div class="posture_title"><?php $this->title() ?></div>
           </a>
        </div>
    </div>
    <?php endwhile; ?>
                </div>

            </article>
        </div>
<?php $this->need('common/footer.php'); ?>