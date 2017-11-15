<?php
/**
 * 修改用户锁定状态
 * @param  [number] $status   [状态值]
 * @param  [number] $id       [id]
 * @param  string $callback [返回值]
 * @return [string]          [组合链接]
 */
function showStatus($status, $id, $callback="") {
	switch ($status) {
		case 0 :
			$info = '<a href="__URL__/changeState/user_id/'.$id.'/islock/0/navTabId/listusers" target="ajaxTodo" callback="'.$callback.'">锁定</a>';
			break;
		case 1 :
			$info = '<a href="__URL__/changeState/user_id/'.$id.'/islock/1/navTabId/listusers" target="ajaxTodo" callback="'.$callback.'">恢复</a>';
			break;
	}
	return $info;

}

function changeInstall($status, $id, $callback="") {
	switch ($status) {
		case 0 :
			$info = '<a href="__URL__/changeInstall/plugin_id/'.$id.'/isinstalled/0/navTabId/listplugin" target="ajaxTodo" callback="'.$callback.'">安装</a>';
			break;
		case 1 :
			$info = '<a href="__URL__/changeInstall/plugin_id/'.$id.'/isinstalled/1/navTabId/listplugin" target="ajaxTodo" callback="'.$callback.'">卸载</a>';
			break;
	}
	return $info;

}


function showReason($status, $id, $callback=""){
	switch ($status) {
		case 0 :
			$info = '<a href="__URL__/changeState/link_id/'.$id.'/isverify/0/navTabId/listlink" target="ajaxTodo" callback="'.$callback.'">恢复显示</a>';
			break;
		case 1 :
			$info = '<a href="__URL__/changeState/link_id/'.$id.'/isverify/1/navTabId/listlink" target="ajaxTodo" callback="'.$callback.'">禁止显示</a>';
			break;
	}
	return $info;
}

function rubbish($status, $id, $callback=""){
	switch ($status) {
		case 1 :
			$info = '<a href="__URL__/changeState/article_id/'.$id.'/islock/1/navTabId/listarticle1" target="ajaxTodo" callback="'.$callback.'">恢复显示</a>';
			break;
		case 0 :
			$info = '<a href="__URL__/changeState/article_id/'.$id.'/islock/0/navTabId/listarticle" target="ajaxTodo" callback="'.$callback.'">加入回收站</a>';
			break;
	}
	return $info;
}

function crubbish($status, $id, $callback=""){
	switch ($status) {
		case 1 :
			$info = '<a href="__URL__/changeState/commend_id/'.$id.'/islock/1/navTabId/listcomment1" target="ajaxTodo" callback="'.$callback.'">恢复显示</a>';
			break;
		case 0 :
			$info = '<a href="__URL__/changeState/commend_id/'.$id.'/islock/0/navTabId/listcomment" target="ajaxTodo" callback="'.$callback.'">加入回收站</a>';
			break;
	}
	return $info;
}


function imgs($status,$id){
	$info1="../Public/../default/Images/test.jpeg";
	preg_match("/<img(.*)src=\"([^\"]+)\"[^>]+>/isU",$status,$matches);
	if(!empty($matches)){
              return  $img = $matches[2];
    }else{
              return  $info1;
    }
}

function photos($status){
	if(!$status==null){
              return  './Uploads/Picture/Avatar'.'/'.'avatar_'.$status;
    }else{
                return  './Uploads/Picture/Avatar'.'/'.'nophoto.gif';
    }
}


function SaveSetting($arr){
	$setfile=C('settingfile_path');
	$a=include './App/Conf/setting.config.php';
	$c=array_merge($a,$arr);
	$settingstr="<?php\n\r return ".var_export($c,TRUE)."\n\r?>";
	file_put_contents($setfile,$settingstr);
}


/**
 *自定义的删除函数,可以删除文件和递归删除文件夹
 */
 function my_del($path)
{
	if(is_dir($path))
	{
			$file_list= scandir($path);
			foreach ($file_list as $file)
			{
				if( $file!='.' && $file!='..')
				{
					my_del($path.'/'.$file);
				}
			}
			@rmdir($path);  //这种方法不用判断文件夹是否为空,	因为不管开始时文件夹是否为空,到达这里的时候,都是空的		
	}
	else
	{
		@unlink($path);    //这两个地方最好还是要用@屏蔽一下warning错误,看着闹心
	}

}

/**
 * 格式化字节大小
 * @param  number $size      字节数
 * @param  string $delimiter 数字和单位分隔符
 * @return string            格式化后的带单位的大小
 */
function format_bytes($size, $delimiter = '') {
    $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
    for ($i = 0; $size >= 1024 && $i < 5; $i++) $size /= 1024;
    return round($size, 2) . $delimiter . $units[$i];
}

/**
 * [移动端访问自动切换主题模板]
 * @return boolen [是否为手机访问]
 */
function ismobile() {
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
        return true;
    
    //此条摘自TPM智能切换模板引擎，判断是否为客户端
    if(isset ($_SERVER['HTTP_CLIENT']) &&'PhoneClient'==$_SERVER['HTTP_CLIENT'])
        return true;
    //如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset ($_SERVER['HTTP_VIA']))
        //找不到为flase,否则为true
        return stristr($_SERVER['HTTP_VIA'], 'wap') ? true : false;
    //判断手机发送的客户端标志,兼容性有待提高
    if (isset ($_SERVER['HTTP_USER_AGENT'])) {
        $clientkeywords = array(
            'nokia','sony','ericsson','mot','samsung','htc','sgh','lg','sharp','sie-','philips','panasonic','alcatel','lenovo','iphone','ipod','blackberry','meizu','android','netfront','symbian','ucweb','windowsce','palm','operamini','operamobi','openwave','nexusone','cldc','midp','wap','mobile'
        );
        //从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
            return true;
        }
    }
    //协议法，因为有可能不准确，放到最后判断
    if (isset ($_SERVER['HTTP_ACCEPT'])) {
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
            return true;
        }
    }
    return false;
 }
 //获取分类名称
function getCatalog($cid = 0)
	{
		$catelog=M('article_cate')->where("id=".$cid)->find();
		return $catelog["name"];
	}
	function getCatalogByAlias($alias="")
	{
		$catelog=M('catalog')->where("alias='".$alias."'")->find();
		return $catelog;
	}
	//获取网址,type:1=首页，2=list,3=正文
	function reurl($id,$alias)
	{	
		$urlmodel = C('URL_MODEL');
		if($urlmodel==0){ //默认url模式
			return defaultURL($id,$alias);
		}else {//伪静态url
			switch ($alias)
			{
				case "homepage":
				  return $set["site_domain"];
				  break;
				case "articlelist":
				  return "/list-".$id.".html";
				  break;
				case "article":
				  return "/article-".$id.".html";
				  break;
				case "downloadlist":
				  return $id=='0'?"/downlist.html":"/downlist-".$id.".html";
				case "download":
				  return "/download-".$id.".html";
				  break;
				case "search":
				  return "/search.html";
				  break;
				default:
					return $set["site_domain"];
			}
		}
	}
	function defaultURL($id,$alias,$set)
	{
		//获取网站配置信息
		$setting_mod = M('setting');
		$setting = $setting_mod->select();
		foreach ( $setting as $val ) {
			$set[$val['name']] = stripslashes($val['data']);
		}
		switch ($alias)
		{
			case "homepage":
			  return $set["site_domain"];
			  break;
			case "articlelist":
			  return U("Index/List/index",array('catsid'=>$id));
			  break;
			case "article":
			  return U("Index/Article/index",array('id'=>$id));
			case "downloadlist":
			  return U("Index/Downlist/index",array('catsid'=>$id));
			case "download":
			  return U("Index/Download/index",array('id'=>$id));
			  break;
			  case "albumn":
			  return U("Index/Albumn/index",array('catsid'=>$id));
			  break;
			case "search":
			  return U("Index/Search/index",0);
			  break;
			default:
		  		return $set["site_domain"];
		}
		
	}
		 //获取网址,type:1=首页，2=list,3=正文
function IsImageURL($imgurl = ''){
	$imgs_arr = array( "png" ,"jpg" , "jpeg" ,  "gif" );//图片的后缀 ，自己可以添加
	$ext = strtolower(end(explode(".",$imgurl)));
	if( !empty($ext) && in_array($ext , $imgs_arr))
	{
		return '1';
	}
	return "0";
}
function GetSubCatalogList($pid)
{
	$subcatalogList=M('article_cate')->where(' status=1 and pid='.$pid)->order('sort_order desc')->select();
	return $subcatalogList;
}

function GetSubDownloadCatalogList($pid,$limit)
{
	$subcatalogList=M('catalog')->limit($limit)->where(' status=1 and pid='.$pid)->order('sort asc')->select();
	return $subcatalogList;
}

//br回车并去掉html
function catDescript($title)
{
	$arr = explode("<br",$title);
	$nohtml = '';
	if(isset($arr)){		
		$nohtml =strip_tags($arr[0]);
	}
	return $nohtml;
}