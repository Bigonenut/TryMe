<?php
/**
 * Author: 坚果
 * CreateTime: 2021/3/29 14:45
 * 隐私评论 相册 回复可见
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class core{








    
    /**
     * 输入内容之前做一些有趣的替换+输出文章内容
     *
     * @param $obj
     * @param $status
     * @return string
     */
    public static function postContent($obj, $status)
    {
        $content = $obj->content;

        $isImagePost = self::isImageCategory($obj->categories);


        if ($isImagePost) {//照片文章
            $content = self::postImagePost($content, $obj);
        } else {//普通文章
            if ($obj->hidden == true && trim($obj->fields->lock) != "") {//加密文章且没有访问权限
                echo '<p class="text-muted protected"><i class="glyphicon glyphicon-eye-open"></i>&nbsp;&nbsp;' . ("密码提示") . '：' . $obj->fields->lock . '</p>';
            }

            $db = Typecho_Db::get();
            $sql = $db->select()->from('table.comments')
                ->where('cid = ?', $obj->cid)
                ->where('status = ?', 'approved')
                ->where('mail = ?', $obj->remember('mail', true))
                ->limit(1);
            $result = $db->fetchAll($sql);//查看评论中是否有该游客的信息

            //文章中部分内容隐藏功能（回复后可见）
            if ($status || $result) {
                $content = preg_replace("/\[hide\](.*?)\[\/hide\]/sm", '<div class="reply2view">$1</div>', $content);
            } else {
                $content = preg_replace("/\[hide\](.*?)\[\/hide\]/sm", '<div class="reply2view">' . ("此处内容需要评论回复后（审核通过）方可阅读。") . '</div>', $content);
            }


        }
        return trim($content);
    }

    /**
     * 判断是否是相册分类
     * @param $data
     * @return bool
     */
    public static function isImageCategory($data)
    {
        //print_r($data);
        if (is_array($data)) {
            for ($i = 0; $i < count($data); $i++) {
                if ($data[$i]["slug"] == "image") {
                    return true;
                }
            }
        }
        return false;

    }

    /**
     * @param $content
     * @param $obj
     * @return string
     */
    public static function postImagePost($content, $obj)
    {
        if ($obj->hidden === true) {//输入密码访问
            return $content;
        } else {
            return core::parseContentToImage($content,"album");
        }
    }

       /**
     * 解析文章内容为图片列表（相册）
     * @param $content
     * @return string
     */
    public static function parseContentToImage($content,$type)
    {
        preg_match_all('/<img.*?src="(.*?)"(.*?)(alt="(.*?)")??(.*?)\/?>/', $content, $matches);
        $html = "";
            $html .= "<div class='photos_album'>";
        if (is_array($matches)) {
//            print_r($matches);
            if (count($matches[0]) == 0) {
                $html .= '<small class="text-muted letterspacing indexWords">相册无图片</small>';
            } else {
                for ($i = 0; $i < count($matches[0]); $i++) {
                    $info = trim($matches[0][$i]);
                    preg_match('/src="(.*?)"/', $info, $info);
                    $infos = trim($matches[5][$i]);
                    preg_match('/alt="(.*?)"/', $infos, $infos);
                    if (is_array($info) && count($info) >= 2) {
//                        print_r($info);
                        $info = @$info[1];
                    } else {
                        $info = "";
                    }
                    if (is_array($infos) && count($infos) >= 2) {
                        $infos = @$infos[1];
                    } else {
                        $infos = "";
                    }
                        $html .= <<<EOF
<div class="album_list"><a class="lazyload-container" data-fancybox="gallery" href="{$info}">{$matches[0][$i]}</a><figcaption>{$infos}</figcaption></div>


EOF;
                  
                }
            }
        }
        $html .= "</div>";

        return $html;
}


    /**
     * 输出文章摘要
     * @param $content
     * @param $limit 字数限制
     * @return string
     */
    public static function excerpt($content, $limit)
    {

        if ($limit == 0) {
            return "";
        } else {
            $content = self::returnExceptShortCodeContent($content);
            if (trim($content) == "") {
                return ("暂时无可提供的摘要");
            } else {
                return Typecho_Common::subStr(strip_tags($content), 0, $limit, "...");
            }
        }
    }


    /**
     * 获取匹配短代码的正则表达式
     * @param null $tagnames
     * @return string
     * @link https://github.com/WordPress/WordPress/blob/master/wp-includes/shortcodes.php#L254
     */
    public static function get_shortcode_regex($tagnames = null)
    {
        global $shortcode_tags;
        if (empty($tagnames)) {
            $tagnames = array_keys($shortcode_tags);
        }
        $tagregexp = join('|', array_map('preg_quote', $tagnames));
        // WARNING! Do not change this regex without changing do_shortcode_tag() and strip_shortcode_tag()
        // Also, see shortcode_unautop() and shortcode.js.
        // phpcs:disable Squiz.Strings.ConcatenationSpacing.PaddingFound -- don't remove regex indentation
        return
            '\\['                                // Opening bracket
            . '(\\[?)'                           // 1: Optional second opening bracket for escaping shortcodes: [[tag]]
            . "($tagregexp)"                     // 2: Shortcode name
            . '(?![\\w-])'                       // Not followed by word character or hyphen
            . '('                                // 3: Unroll the loop: Inside the opening shortcode tag
            . '[^\\]\\/]*'                   // Not a closing bracket or forward slash
            . '(?:'
            . '\\/(?!\\])'               // A forward slash not followed by a closing bracket
            . '[^\\]\\/]*'               // Not a closing bracket or forward slash
            . ')*?'
            . ')'
            . '(?:'
            . '(\\/)'                        // 4: Self closing tag ...
            . '\\]'                          // ... and closing bracket
            . '|'
            . '\\]'                          // Closing bracket
            . '(?:'
            . '('                        // 5: Unroll the loop: Optionally, anything between the opening and closing shortcode tags
            . '[^\\[]*+'             // Not an opening bracket
            . '(?:'
            . '\\[(?!\\/\\2\\])' // An opening bracket not followed by the closing shortcode tag
            . '[^\\[]*+'         // Not an opening bracket
            . ')*+'
            . ')'
            . '\\[\\/\\2\\]'             // Closing shortcode tag
            . ')?'
            . ')'
            . '(\\]?)';                          // 6: Optional second closing brocket for escaping shortcodes: [[tag]]
        // phpcs:enable
    }

    public static function returnExceptShortCodeContent($content)
    {

        //排除QR
        //排除倒计时
        if (strpos($content, '[QR') !== false) {
            $pattern = self::get_shortcode_regex(array('QR'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        //排除图集
        if (strpos($content, '[album') !== false) {
            $pattern = self::get_shortcode_regex(array('album'));
            $content = preg_replace("/$pattern/", '', $content);
        }

        //排除倒计时
        if (strpos($content, '[countdown') !== false) {
            $pattern = self::get_shortcode_regex(array('countdown'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        //排除摘要的collapse 公式
        if (strpos($content, '[collapse') !== false) {
            $pattern = self::get_shortcode_regex(array('collapse'));
            $content = preg_replace("/$pattern/", '', $content);
        }

        if (strpos($content, '[tag') !== false) {
            $pattern = self::get_shortcode_regex(array('tag'));
            $content = preg_replace("/$pattern/", '', $content);
        }

        if (strpos($content, '[tabs') !== false) {
            $pattern = self::get_shortcode_regex(array('tabs'));
            $content = preg_replace("/$pattern/", '', $content);
        }

        //排除摘要中的块级公式
        $content = preg_replace('/\$\$[\s\S]*\$\$/sm', '', $content);
        //排除摘要的vplayer
        if (strpos($content, '[vplayer') !== false) {
            $pattern = self::get_shortcode_regex(array('vplayer'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        //排除摘要中的短代码
        if (strpos($content, '[hplayer') !== false) {
            $pattern = self::get_shortcode_regex(array('hplayer'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '[post') !== false) {
            $pattern = self::get_shortcode_regex(array('post'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '[scode') !== false) {
            $pattern = self::get_shortcode_regex(array('scode'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '[button') !== false) {
            $pattern = self::get_shortcode_regex(array('button'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        //排除回复可见的短代码
        if (strpos($content, '[hide') !== false) {
            $pattern = self::get_shortcode_regex(array('hide'));
            $content = preg_replace("/$pattern/", '', $content);
        }

        //排除文档助手
        if (strpos($content, '>') !== false) {
            $content = preg_replace("/(@|√|!|x|i)&gt;/", '', $content);
        }

        //排除login
        if (strpos($content, '[login') !== false) {
            $pattern = self::get_shortcode_regex(array('login'));
            $content = preg_replace("/$pattern/", '', $content);
        }

        return $content;
    }
}