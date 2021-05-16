<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;?>

<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Cache-Control" content="no-transform" />
	<meta http-equiv="Cache-Control" content="no-siteapp" />
	<link rel="stylesheet" href="<?php $this->options->themeUrl('style.css'); ?>" />
</head>
<body class="body404">
    <p>页面走丢啦！</p>
    <div class="error404">
    <span>4</span>
    <span class="middle"></span>
    <span>4</span>
    </div>
    <div class="back">
		<a href="javascript:history.go(-1)" class="">上一页</a>
        <a id="gohome" href="<?php $this->options ->siteUrl(); ?>">返回主页</a>
	</div>
</body>
