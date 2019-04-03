<?php
/**
 * 看板娘插件
 * 
 * @package Live2D 
 * @author fghrsh
 * @link https://www.fghrsh.net/post/123.html
 * @version 1.0.0
 */
class Live2D_Plugin implements Typecho_Plugin_Interface {

    /**
     *  页面包含的语言
     */
    private static $_hasLanguage = array();

     /**
     * 激活插件方法,如果激活失败,直接抛出异常
     * 
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate() {
        Typecho_Plugin::factory('Widget_Archive')->header = array(__CLASS__, 'header');
        Typecho_Plugin::factory('Widget_Archive')->footer = array(__CLASS__, 'footer');
    }

    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     * 
     * @static
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function deactivate(){}

    /**
     * 获取插件配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form){
        $model = new Typecho_Widget_Helper_Form_Element_Select('model', array(
            '1-1' => 'Pio', '2-1' => 'Tia', '3-1' => '22娘', '4-1' => '33娘', '5-1' => 'Shizuku',
            '6-2' => 'Nepnep', '6-7' => 'Noir', '6-11' => 'Blanc'), '1-1', _t('角色模型'));
        $form->addInput($model);

        $size = new Typecho_Widget_Helper_Form_Element_Text('size', NULL, '280x250', 
            _t('看板娘尺寸'), _t('例如 "280x250", "600x535"'));
        $form->addInput($size);
    }

    /**
     * 个人用户的配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form){}

    /**
     *为header添加css文件
     *@return void
     */
    public static function header() {
        echo '<style>
        canvas#live2d{right:0;bottom:0;z-index:999;position:fixed;pointer-events:none}
    </style>';
    }

    /**
     *为footer添加js文件
     *@return void
     */
    public static function footer() {
        $opts = Helper::options()->plugin('Live2D');
        list($width, $height) = explode('x', $opts->size);
        echo '<canvas id="live2d" width="'.$width.'" height="'.$height.'"></canvas>
    <script src="//live2d-cdn.fghrsh.net/assets/1.4.2/live2d.min.js"></script>
    <script type="text/javascript">
        loadlive2d("live2d", "//live2d.fghrsh.net/api/get/?id='.$opts->model.'");
    </script>';
    }
}
