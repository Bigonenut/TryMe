<?php
/**
 * 简洁的一款主题
 * @package Tryme
 * @author 坚果
 * @version 1.0.0
 * @link http://memax.top/
 */
 if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('common/header.php');
?>


        <!--文章列表-->
        <div class="content content_top">
            <?php $this->need('common/left.php'); ?>
            <!--右边布局-->
            <div class="content_right">
                <?php $this->need('common/list.php'); ?>
            </div>
        </div>
        <?php $this->need('common/footer.php'); ?>