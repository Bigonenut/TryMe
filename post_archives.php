<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
/**
 * 文章归档
 *
 * @package custom
 *
 */$this->need('common/header.php');
?>
        <!--文章列表-->
        <div class="content content_top content_post">
            <article class="post post_li">
                
            <?php $archives = archives($this); $index = 0; foreach ($archives as $year => $posts): ?>
                <li class="tl-header">
                    <div class="btn btn-sm btn-info btn-rounded m-t-none"><?php echo $year; ?></div>
                </li>
                <?php foreach($posts as $created => $post ): ?>
                <div class="tl-body">    
                    <li class="tl-item">
                    <div class="tl-wrap b-info">
                        <span class="tl-date"><?php echo date('m-d', $created); ?></span>
                        <div class="tl-content panel padder h5 l-h bg-info">
                        <span class="arrow arrow-info left pull-up" aria-hidden="true"></span>
                            <a href="<?php echo $post['permalink']; ?>" class="text-lt"><?php echo $post['title']; ?></a>
                        </div>
                    </div>
                   </li>
               </div>
               <?php endforeach; ?>
               <?php endforeach; ?>
            </article>
        </div>
        <?php $this->need('common/footer.php'); ?>