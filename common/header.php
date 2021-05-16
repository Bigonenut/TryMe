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
        <link rel=stylesheet href="https://at.alicdn.com/t/font_2544780_n667vku64d.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/zetheme/pigeon/css/animate.min.css">
        <link rel="stylesheet" href="//cdn.jsdelivr.net/gh/fancyapps/fancybox/dist/jquery.fancybox.min.css" />
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery@3/dist/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/gh/zetheme/pigeon/OWO/OwO.js"></script>
        <?php $this->header('commentReply=&'); ?>
    </head>
    <body>
        <header id="header">
            <div class="navbar">
                <div class="content">
                    <!--logo-->
                    <div class="logo">
                        <a href="<?php $this->options->siteUrl(); ?>"><img src="<?php $this->options->网站logo(); ?>"></a>
                    </div>

                    <!--菜单工具-->
                    <div class="meun_tool">
                        <div class="search_btn" onclick="mobile_show()"><i class="iconfont icon-caidan1"></i></div>
                        <div class="search_bnt" onclick="search_show()" ><i class="iconfont icon-sousuo1"></i></div>
                    </div>
                    <!--菜单-->
                    <div class="meun">
                        <nav class="meun_list">
                            <ul class="meun_ul">
                                <li class="meun_li"><a href="<?php $this->options->siteUrl(); ?>">首页</a></li>
                                <?php $this->widget('Widget_Metas_Category_List')->to($category);?>
                            <li class="meun_li level"><a href="javascript:;">分类</a>

                            <ul class="level_ul">
                            <?php while ($category->next()):?>
                                <li class="level_li"><a href="<?php $category->permalink();?>"><?php $category->name();?></a></li>
                                <?php endwhile; ?>
                            </ul>

                            </li>


                                <?php $this->widget('Widget_Contents_Page_List')
                                   ->parse('<li class="meun_li"><a href="{permalink}">{title}</a></li>'); ?>
                            </ul>
                        </nav>
                    </div>

                </div>
            </div>
        </header>