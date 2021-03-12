<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/**
 * VAPTCHA手势验证码（V3）
 * 
 * @package VAPTCHA3
 * @author Mr_Fang
 * @version 1.0.0
 * @link https://fang.blog.miri.site
 */
class VAPTCHA3_Plugin implements Typecho_Plugin_Interface{
    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     * 
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate()
    {
        Typecho_Plugin::factory('Widget_Archive')->header = array(__CLASS__, 'header');
        Typecho_Plugin::factory('Widget_Archive')->footer = array(__CLASS__, 'footer');
        
        return _t('插件已启用，请配置相关参数');
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
    public static function config(Typecho_Widget_Helper_Form $form)
    {
        $vid = new Typecho_Widget_Helper_Form_Element_Text('vid', NULL, '', _t('VID'), _t("用于初始化验证码的验证单元id"));
        $form->addInput($vid);
        $type_id = new Typecho_Widget_Helper_Form_Element_Text('type_id', NULL, 'click', _t("展现类型"), _t("验证码的展现类型（click-点击式、invisible-隐藏式）"));
        $form->addInput($type_id);
        $container = new Typecho_Widget_Helper_Form_Element_Text('container', NULL, '', _t("容器"), _t("可为Element或者selector（例如：.vaptchaContainer）"));
        $form->addInput($container);
        $button = new Typecho_Widget_Helper_Form_Element_Text('button', NULL, '', _t("按钮ID"), _t("此按钮在验证前将被禁用，验证通过后将允许点击（无需填写#）"));
        $form->addInput($button);
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
     * 插件实现方法
     * 
     * @access public
     * @return void
     */
     
    public static function header(){
        $VaptchaStyle = "
            <style>
            .vaptcha-init-main {
                display: table;
                width: 100%;
                height: 100%;
                background-color: #eeeeee;
            }
            .vaptcha-init-loading {
                display: table-cell;
                vertical-align: middle;
                text-align: center;
            }
            
            .vaptcha-init-loading > a {
                display: inline-block;
                width: 18px;
                height: 18px;
                border: none;
            }
            
            .vaptcha-init-loading > a img {
                vertical-align: middle;
            }
            
            .vaptcha-init-loading .vaptcha-text {
                font-family: sans-serif;
                font-size: 12px;
                color: #cccccc;
                vertical-align: middle;
            }
            </style>
        ";
        echo $VaptchaStyle;
    }
    
    public static function footer(){
        $options = Typecho_Widget::widget('Widget_Options')->plugin('VAPTCHA3');
        $VaptchaJS = "
            <script src=\"https://v.vaptcha.com/v3.js\"></script>
            <script>
                document.getElementById(\"".$options->button."\").setAttribute(\"disabled\", true);
                vaptcha({
                    vid: '".$options->vid."',
                    type: '".$options->type_id."',
                    container: '".$options->container."'
                }).then(function (vaptchaObj) {
                    vaptchaObj.renderTokenInput()
                    vaptchaObj.render()
                    vaptchaObj.listen('pass', function() {
                        document.getElementById(\"".$options->button."\").removeAttribute(\"disabled\");
                    })
                })
            </script>
        ";
        echo $VaptchaJS;
    }
}
