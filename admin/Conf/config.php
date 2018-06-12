<?php
/*
// | MobileCms 移动应用软件后台管理系统
// +----------------------------------------------------------------------
// | provide by ：phonegap100.com
// 
// +----------------------------------------------------------------------
// | Author: htzhanglong@foxmail.com
// +----------------------------------------------------------------------
*/
if (!defined('THINK_PATH'))	exit();

$config = require("config.inc.php");
$array = array( 	
    'URL_MODEL' => 0,
	//DEFAULT_LANG' => 'zh-cn',
    'LANG_SWITCH_ON' => true,
    'DEFAULT_LANG' => 'zh-cn', // 默认语言	
  'DEFAULT_THEME' => 'default',
    'LANG_AUTO_DETECT' => true, // 自动侦测语言
 	//'APP_AUTOLOAD_PATH'=>'@.TagLib',//	
	'IGNORE_PRIV_LIST'=>array(
		array(
			'module_name'=>'Admin',
			'action_list'=>array('ajaxCheckUsername')
		),
		array(
			'module_name'=>'Public',
			'action_list'=>array()
		),
		array(
			'module_name'=>'Index',
			'action_list'=>array()
		),array(
			'module_name'=>'Cache',
			'action_list'=>array()
		),
	),
  //'URL_CASE_INSENSITIVE' =>true,    
    'APP_AUTOLOAD_PATH' => '@.TagLib', //自动加载项目类库
	'TMPL_ACTION_ERROR'     => 'Public:error',
    'TMPL_ACTION_SUCCESS'   => 'Public:success',
	'APP_STATUS' => 'debug',
	'SHOW_PAGE_TRACE' =>false, // 显示页面Trace信息
//thumb
'thumbwidth' => 250,
'thumbheight' => 250,
'usethumb' => true,

);
return array_merge($config,$array);
?>