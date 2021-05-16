<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
require_once 'libs/core.php';
require_once 'libs/Shortcode.php';


function themeConfig($form) {

    $logourl = new Typecho_Widget_Helper_Form_Element_Text('网站logo', NULL, NULL, _t('网站logo'), _t('请输入LOGO地址'));
    $form->addInput($logourl);

    $touxiang = new Typecho_Widget_Helper_Form_Element_Text('博主头像', NULL, NULL, _t('博主头像'), _t('请输入头像地址'));
    $form->addInput($touxiang);

    $hybj = new Typecho_Widget_Helper_Form_Element_Text('欢迎页面背景', NULL, NULL, _t('欢迎页面背景'), _t('请输入欢迎页面背景地址'));
    $form->addInput($hybj);

    $hyqm = new Typecho_Widget_Helper_Form_Element_Text('欢迎页面个性签名', NULL, NULL, _t('欢迎页面个性签名'), _t('请输入欢迎页面个性签名'));
    $form->addInput($hyqm);

	$subTitle = new Typecho_Widget_Helper_Form_Element_Text('subTitle', NULL, NULL, _t('自定义站点副标题'), _t('浏览器副标题，仅在当前页面为首页时显示，显示格式为：<b>标题 - 副标题</b>，留空则不显示副标题'));
    $form->addInput($subTitle);
    
    $beian = new Typecho_Widget_Helper_Form_Element_Text('备案号', NULL, NULL, _t('网站备案号'), _t('请输入网站备案号'));
    $form->addInput($beian);

    $banquan = new Typecho_Widget_Helper_Form_Element_Text('网站版权', NULL, NULL, _t('网站版权'), _t('请输入网站版权信息'));
    $form->addInput($banquan);

    $dashangsro = new Typecho_Widget_Helper_Form_Element_Text('打赏二维码', NULL,NULL, _t('二维码地址'), _t('请输入微信或支付宝二维码地址'));
    $form->addInput($dashangsro);


    $twitter = new Typecho_Widget_Helper_Form_Element_Text('twitter', NULL, NULL, _t('twitter'), _t('在这里填入你的twitter链接'));
    $form->addInput($twitter);
    $weibo = new Typecho_Widget_Helper_Form_Element_Text('weibo', NULL, NULL, _t('微博'), _t('在这里填入你的微博链接'));
    $form->addInput($weibo);
    $github = new Typecho_Widget_Helper_Form_Element_Text('github', NULL, NULL, _t('Github'), _t('在这里填入你的Github链接'));
    $form->addInput($github);
    $telegram = new Typecho_Widget_Helper_Form_Element_Text('telegram', NULL, NULL, _t('telegram'), _t('在这里填入你的telegram链接'));
    $form->addInput($telegram);
    $mastodon = new Typecho_Widget_Helper_Form_Element_Text('mastodon', NULL, NULL, _t('mastodon'), _t('在这里填入你的mastodon链接'));
    $form->addInput($mastodon);
    $bilibili = new Typecho_Widget_Helper_Form_Element_Text('bilibili', NULL, NULL, _t('bilibili'), _t('在这里填入你的bilibili链接'));
    $form->addInput($bilibili);
    $rss = new Typecho_Widget_Helper_Form_Element_Text('rss', NULL, NULL, _t('rss'), _t('在这里填入你的RSS链接'));
    $form->addInput($rss);
    $douban = new Typecho_Widget_Helper_Form_Element_Text('douban', NULL, NULL, _t('douban'), _t('在这里填入你的豆瓣链接'));
    $form->addInput($douban);
    $zhihu = new Typecho_Widget_Helper_Form_Element_Text('zhihu', NULL, NULL, _t('zhihu'), _t('在这里填入你的知乎链接'));
    $form->addInput($zhihu);

}


function themeFields(Typecho_Widget_Helper_Layout $layout) {
	$banner = new Typecho_Widget_Helper_Form_Element_Text('banner', NULL, NULL,_t('文章头图'), _t('输入一个图片 url，作为缩略图显示在文章列表，没有则不显示'));
    $layout->addItem($banner);
}

function themeInit($archive){

    if($archive->is('category', 'image')){
        $archive->parameter->pageSize = 9; 
    }

    Helper::options()->commentsAntiSpam = false; //关闭反垃圾
    Helper::options()->commentsCheckReferer = false; //关闭检查评论来源URL与文章链接是否一致判断(否则会无法评论)
    Helper::options()->commentsMaxNestingLevels = '999'; //最大嵌套层数
    Helper::options()->commentsPageDisplay = 'first'; //强制评论第一页
    Helper::options()->commentsOrder = 'DESC'; //将最新的评论展示在前
    Helper::options()->commentsHTMLTagAllowed = '<a href=""> <img src=""> <img src="" class=""> <code> <del>';
    Helper::options()->commentsMarkdown = true;

}
Typecho_Plugin::factory('Widget_Abstract_Comments')->contentEx = array('feature','parseContent');//评论表情
Typecho_Plugin::factory('Widget_Abstract_Contents')->contentEx = array('Shortcode','parseContent');//文章短代码解析
Typecho_Plugin::factory('Widget_Abstract_Contents')->excerptEx = array('Shortcode','parseContent');//首页去除短代码

	/**
     * 内容归档
     * @return array
     */
	function archives($widget, $excerpt = false) {
		$db = Typecho_Db::get();
		$rows = $db->fetchAll($db->select()
		                    ->from('table.contents')
		                    ->order('table.contents.created', Typecho_Db::SORT_DESC)
		                    ->where('table.contents.type = ?', 'post')
		                    ->where('table.contents.status = ?', 'publish')
		                    ->where('table.contents.created < ?', time()));
		$stat = array();
		foreach ($rows as $row) {
			$row = $widget->filter($row);
			$arr = array(
			                'title' => $row['title'],
			                'permalink' => $row['permalink'],
			                'commentsNum' => $row['commentsNum'],
			                'views' => $row['views'],
			            );
			if($excerpt) {
				$arr['excerpt'] = substr($row['content'], 30);
			}
			$stat[date('Y 年 n 月', $row['created'])][$row['created']] = $arr;
		}
		return $stat;
	}

        //文章内第一张照片做封面图
        function getPostImg($archive){
            $img = array();
            preg_match_all("/<img.*?src=\"(.*?)\".*?\/?>/i", $archive->content, $img);
            if (count($img) > 0 && count($img[0]) > 0) {
                return $img[1][0];
            }
        }

       //评论头像
    function getAvator($email,$size){
      
        $cdnUrl = $options->CDNURL;
            $str = explode('@', $email);
            if (@$str[1] == 'qq.com' && @ctype_digit($str[0]) && @strlen($str[0]) >=5
                && @strlen($str[0])<=11) {
                $avatorSrc = 'https://q.qlogo.cn/g?b=qq&nk='.$str[0].'&s=100';
            }else{
                $avatorSrc = getGravator($email,$cdnUrl,$size);
            }
        return $avatorSrc;
    }
    function avatarHtml($obj){
        $email = $obj->mail;
        $avatorSrc = getAvator($email,65);
        return ''.$avatorSrc.'';
    }
    function getGravator($email,$host,$size){
    
        $default = '';
        if (strlen($options->defaultAvator) > 0){
            $default = $options->defaultAvator;
        }
        $url = '/';
        $rating = Helper::options()->commentsAvatarRating;
        $hash = md5(strtolower($email));
        $avatar = '//sdn.geekzu.org/avatar' . $url . $hash . '?s=' . $size . '&r=' . $rating . '&d=mm';
        return $avatar;
    }


/**
 * 文章内容自定义
 */
function image_class_replace($content)
{ 
  $content = preg_replace('#<a(.*?) href="([^"]*/)?(([^"/]*)\.[^"]*)"(.*?)>#',
        '<a$1 href="$2$3"$5 target="_blank">', $content);
    return $content;
}