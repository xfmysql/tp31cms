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
    //缓存配置
 //   'DATA_CACHE_TYPE' => 'file', // 数据缓存方式 文件
//    'DATA_CACHE_TIME' => 0, // 数据缓存时间
 //   'DATA_CACHE_SUBDIR' => true,
 //   'DATA_PATH_LEVEL' => 2,
//	'URL_PATHINFO_DEPR' =>'-',  //参数之间的分割符号    	
    'DEFAULT_LANG' => 'zh-cn', // 默认语言	
	
	'DEFAULT_THEME' => 'amazeuiblog',
	'SHOW_PAGE_TRACE'=>false,

	/* URL配置 */
    'URL_CASE_INSENSITIVE' => true, //默认false 表示URL区分大小写 true则表示不区分大小写
    'URL_MODEL'            =>0, //URL模式，0=未优化
    'VAR_URL_PARAMS'       => '', // PATHINFO URL参数变量
    'URL_PATHINFO_DEPR'    => '/', //PATHINFO URL分割符

	/* 模版相关配置 */
    'TMPL_DEFAULT_THEME' => 'default',  //默认模版主题
    'URL_HTML_SUFFIX'	=>	'html',
    'TMPL_L_DELIM'		=>	'<{', //修改左定界符
    'TMPL_R_DELIM'		=>	'}>', //修改右定界符
    'TMPL_PARSE_STRING'	=>	array(
	    '__CSS__'		=>	__ROOT__.'/Public/Css',
	    '__JS__'		=>	__ROOT__.'/Public/Js',
	    '__IMAGES__'	=>	__ROOT__.'/Public/Images',
   	),
);
return array_merge($config,$array);
?>