<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/**
 * Author: 坚果
 * CreateTime: 2021/04/03 21:02
 * 短代码解析
 */
class Shortcode{
    public static $frag = false;
    public static function parseContent($data, $widget, $last)
    {
        $text = empty($last) ? $data : $last;
        if ($widget instanceof Widget_Archive) {

            $text = self::parsePhotoSet($text);
            $text = self::parseFancyBox($text, $widget->parameter->__get('type') == 'feed');
            $text = self::parseBiaoQing($text);
        }
        return $text;
    }





    /**
     * 相册解析
     * 
     * @return string
     */
    static public function parsePhotoSet($content)
    {
        $reg = '/\[photos(.*?)\/photos\]/s';
        $new = preg_replace_callback($reg, array('Shortcode', 'parsePhotoSetCallBack'), $content);
        $reg='/<p>\[photos.*?\](.*?)\[\/photos\]<\/p>/s';
        $rp='';
        if($setting['largePhotoSet']) {
            $rp = '<div class="photos large">${1}</div>';
        }else{
            $rp = '<div class="photos">${1}</div>';
        }
        $new=preg_replace($reg, $rp, $new);
        return $new;
    }

    /**
     * 相册解析（去除br p）
     * 
     * @return string
     */
    private static function parsePhotoSetCallBack($match)
    {
        return '[photos'. str_replace(['<br>', '<p>', '</p>'], '', $match[1]) .'/photos]';
    }

    /**
     * 解析 fancybox
     * @return string
     * @param photoMode
     */
    static private $photoMode = false;
    static public function parseFancyBox($content, $photoMode = false)
    {
        $reg = '/<img.*?src="(.*?)".*?alt="(.*?)".*?>/s';
        self::$photoMode = $photoMode;
        $new = preg_replace_callback($reg, array('Shortcode', 'parseFancyBoxCallback'), $content);
        return $new;
    }

    /**
     * 图片解析
     * 
     * @return string
     */
    private static function parseFancyBoxCallback($match)
    {
        $src_ori = $match[1];
        $src = $src_ori;
        $classList = '';
        $attrAddOnA = '';
        $attrAddOnFigure = '';
        $matches;
        if (strpos($src_ori, 'vwid') != false) {
            preg_match("/vwid=(\d{0,5})/i", $src_ori, $matches);
            $width = floatval($matches[1]);
            preg_match("/vhei=(\d{0,5})/i", $src_ori, $matches);
            $height = floatval($matches[1]);
            $ratio = $height / $width * 100;
            $flex_grow = $width * 50 / $height;
            $attrAddOnA = 'style="padding-top: '.$ratio.'%"';
            $attrAddOnFigure = 'class="size-parsed" style="flex-grow: '.$flex_grow.'; width: '.$width.'px"';
        }
        if ($match[2] != '' && $setting['parseFigcaption'])
        $placeholder = '';
        if(!self::$photoMode) {
            $src = '';
            $classList = 'lazy';
            if ($setting['bluredLazyload'])
            $placeholder = '<img class="blured-placeholder remove-after" src="'.self::genBluredPlaceholderSrc($src_ori).'">';
            $attrAddOnA .= ' class="lazyload-container lightbox" ';
        }
        $img = $placeholder.'<img class="'.$classList.'"  src="'.$src_ori.'" alt="'.$match[2].'">';
        if (!self::$photoMode) {
            return '<figure '.$attrAddOnFigure.' ><a '.$attrAddOnA.' no-pjax data-fancybox="gallery" data-caption="'.$match[2].'" href="'.$src_ori.'">'.$img.' </a></figure>';
        }
    }



    /**
     *  解析 owo 表情
     */
    public static function parseBiaoQing($content) {
        $content = preg_replace_callback('/\:\:\(\s*(呵呵|哈哈|吐舌|太开心|笑眼|花心|小乖|乖|捂嘴笑|滑稽|你懂的|不高兴|怒|汗|黑线|泪|真棒|喷|惊哭|阴险|鄙视|酷|啊|狂汗|what|疑问|酸爽|呀咩爹|委屈|惊讶|睡觉|笑尿|挖鼻|吐|犀利|小红脸|懒得理|勉强|爱心|心碎|玫瑰|礼物|彩虹|太阳|星星月亮|钱币|茶杯|蛋糕|大拇指|胜利|haha|OK|沙发|手纸|香蕉|便便|药丸|红领巾|蜡烛|音乐|灯泡|开心|钱|咦|呼|冷|生气|弱|吐血)\s*\)/is',
            array('feature', 'parsePaopaoBiaoqingCallback'), $content);
        $content = preg_replace_callback('/\:\@\(\s*(高兴|小怒|脸红|内伤|装大款|赞一个|害羞|汗|吐血倒地|深思|不高兴|无语|亲亲|口水|尴尬|中指|想一想|哭泣|便便|献花|皱眉|傻笑|狂汗|吐|喷水|看不见|鼓掌|阴暗|长草|献黄瓜|邪恶|期待|得意|吐舌|喷血|无所谓|观察|暗地观察|肿包|中枪|大囧|呲牙|抠鼻|不说话|咽气|欢呼|锁眉|蜡烛|坐等|击掌|惊喜|喜极而泣|抽烟|不出所料|愤怒|无奈|黑线|投降|看热闹|扇耳光|小眼睛|中刀)\s*\)/is',
            array('feature', 'parseAruBiaoqingCallback'), $content);
        $content = preg_replace_callback('/\:\&\(\s*(.*?)\s*\)/is',
            array('feature', 'parseQuyinBiaoqingCallback'), $content);

        return $content;
    }

}

class feature{
       //表情解析
       public static function parseContent($text, $widget, $lastResult)
       {
           $text = empty($lastResult) ? $text : $lastResult;
           if ($widget instanceof Widget_Abstract_Comments) {
               $text = Shortcode::parseBiaoQing($text);
           }
           return $text;
       }
   
       /**
        * 泡泡表情回调函数
        *
        * @return string
        */
       public static function parsePaopaoBiaoqingCallback($match)
       {
           return '<img class="biaoqing paopao" src="' . ('https://cdn.jsdelivr.net/gh/zetheme/pigeon/OWO/biaoqing/paopao/') . str_replace('%', '', urlencode($match[1])) . '_2x.png" height="30" width="30">';
       }
   
       /**
        * 阿鲁表情回调函数
        *
        * @return string
        */
       public static function parseAruBiaoqingCallback($match): string
       {
           return '<img class="biaoqing alu" src="' . ('https://cdn.jsdelivr.net/gh/zetheme/pigeon/OWO/biaoqing/aru/') . str_replace('%', '', urlencode($match[1])) . '_2x.png">';
       }
   
       /**
        * 蛆音娘表情回调函数
        *
        * @return string
        */
       public static function parseQuyinBiaoqingCallback($match): string
       {
           return '<img class="biaoqing quyin" src="' . ('https://cdn.jsdelivr.net/gh/zetheme/pigeon/OWO/biaoqing/quyin/') . str_replace('%', '', urlencode($match[1])) . '.png">';
       }
}