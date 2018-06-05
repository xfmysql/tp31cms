<?php
/**
* 工具页面
* @author  <[c@easycms.cc]>
*/
class ToolsAction extends CommonAction
{ 
	Public function index(){
		echo "tool page";
	}
	Public function delbd(){
		$urls = array(
		    'http://www.findtp.com/download-47.html',
		    'http://www.findtp.com/download-43.html',
		);
		$api = 'http://data.zz.baidu.com/del?site=www.findtp.com&token=SWl4kktPcc4PANga';
		$ch = curl_init();
		$options =  array(
		    CURLOPT_URL => $api,
		    CURLOPT_POST => true,
		    CURLOPT_RETURNTRANSFER => true,
		    CURLOPT_POSTFIELDS => implode("\n", $urls),
		    CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
		);
		curl_setopt_array($ch, $options);
		$result = curl_exec($ch);
		echo $result;
	}
}
