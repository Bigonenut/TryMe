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
                    <?php $this->need('common/list.php'); ?>
                </div>

            </article>
        </div>

        <?php $this->need('common/footer.php'); ?>