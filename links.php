<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
/**
 * 友情链接
 *
 * @package custom
 *
 */$this->need('common/header.php');
?>


        <!--文章列表-->
        <div class="content content_top content_post">
            <article class="post">
                <div class="post_head">
                    <h1 class="post_name">友情链接</h1>
                </div>
                <?php Links_Plugin::output("SHOW_IMG"); ?>
            </article>
        </div>

        <?php $this->need('common/footer.php'); ?>