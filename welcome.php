<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
/**
 * 欢迎页面
 *
 * @package index
 *
 */
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset=utf-8>
        <meta content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=0" name=viewport>
        <title><?php $this->archiveTitle(array(
                  'category'  =>  _t('分类 %s 下的文章'),
                  'search'    =>  _t('包含关键字 %s 的文章'),
                  'tag'       =>  _t('标签 %s 下的文章'),
                  'date'      =>  _t('在 %s 发布的文章'),
                  'author'    =>  _t('作者 %s 发布的文章')
                  ), '', ' | '); ?><?php $this->options->title(); if ($this->is('index') && $this->options->subTitle): ?> | <?php $this->options->subTitle(); endif; ?></title>
        <link rel=stylesheet href="<?php $this->options->themeUrl('style.css'); ?>">
    </head>
    <body>

        <div class="welcome" style="background-attachment: fixed;background: url(<?php $this->options->欢迎页面背景(); ?>) no-repeat;">
            <div class="welcome_box">
                <div class="welcome_frame">
                    <div class="welcome_tx">
                        <img src="<?php $this->options->博主头像(); ?>">
                    </div>
                    <div class="welcome_qm"><?php $this->options->欢迎页面个性签名(); ?></div>

                    <div class="welcome_btn"><a href="<?php $this->options->siteUrl(); ?>">进入首页</a></div>
                </div>
            </div>
        </div>

    </body>
</html>