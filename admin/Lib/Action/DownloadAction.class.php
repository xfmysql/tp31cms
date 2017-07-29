<?php
// +----------------------------------------------------------------------
// | MobileCms 移动应用软件后台管理系统
// +----------------------------------------------------------------------
// | provide by ：phonegap100.com
// 
// +----------------------------------------------------------------------
// | Author: htzhanglong@foxmail.com
// +----------------------------------------------------------------------

class DownloadAction extends BaseAction
{
	public function index()
	{
		$download_mod = D('download');
		$catalog_mod = D('catalog');
$project_mod = D('project');
		//搜索
		$where = '1=1';
		if (isset($_GET['keyword']) && trim($_GET['keyword'])) {
		    $where .= " AND title LIKE '%".$_GET['keyword']."%'";
		    $this->assign('keyword', $_GET['keyword']);
		}
		if (isset($_GET['time_start']) && trim($_GET['time_start'])) {
		    $time_start = $_GET['time_start'];
		    $where .= " AND add_time>='".$time_start."'";
		    $this->assign('time_start', $_GET['time_start']);
		}
		if (isset($_GET['time_end']) && trim($_GET['time_end'])) {
		    $time_end = $_GET['time_end'];
		    $where .= " AND add_time<='".$time_end."'";
		    $this->assign('time_end', $_GET['time_end']);
		}
		if (isset($_GET['cate_id']) && intval($_GET['cate_id'])) {
		    $where .= " AND catalogid=".$_GET['cate_id'];
		    $this->assign('catalogid', $_GET['cate_id']);
		}
		if (isset($_GET['cate_id']) && $_GET['cate_id']=='0') {//查全部
		    //$where .= " AND catalogid=0";
		    $this->assign('catalogid', $_GET['cate_id']);
		}
		import("ORG.Util.Page");
		$count = $download_mod->where($where)->count();
		$p = new Page($count,20);
		$download_list = $download_mod->where($where)->limit($p->firstRow.','.$p->listRows)->order('addtime DESC')->select();

		$key = 1;
		foreach($download_list as $k=>$val){
			$download_list[$k]['key'] = ++$p->firstRow;
			$download_list[$k]['catalog'] = $catalog_mod->field('name')->where('id='.$val['catalogid'])->find();
			$download_list[$k]['project'] = $project_mod->field('name')->where('id='.$val['projectid'])->find();
		}
		$result = $catalog_mod->order('sort ASC')->select();
    	$cate_list = array();
    	foreach ($result as $val) {
    	    if ($val['pid']==0) {
    	        $cate_list['parent'][$val['id']] = $val;
    	    } else {
    	        $cate_list['sub'][$val['pid']][] = $val;
    	    }
    	}
		//网站信息/应用资讯
		$page = $p->show();
		$this->assign('page',$page);
    	$this->assign('cate_list', $cate_list);
		$this->assign('download_list',$download_list);
		$this->display();
	}

	function edit()
	{
		if(isset($_POST['dosubmit'])){
			
			$download_mod = D('download');	
			$data = $download_mod->create();
			if($data['catalogid']==0){
				$this->error(L('lselectcatalog'));
			}
			if ($_FILES['imgurl']['name']!='') {
			    $upload_list = $this->_upload();
			    $data['imgurl'] = $upload_list['0']['savename'];
			}
			if(isset($data['ishot1']) && $data['ishot1']=='1'){
				$data['ishot1']='1';
			}else
				$data['ishot1']='0';
			if(isset($data['ishot2']) && $data['ishot2']=='1'){
				$data['ishot2']='1';
			}else
				$data['ishot2']='0';
			if(isset($data['ishot3']) && $data['ishot3']=='1'){
				$data['ishot3']='1';
			}else
				$data['ishot3']='0';

			if(isset($data['ishot4']) && $data['ishot4']=='1'){
				$data['ishot4']='1';
			}else
				$data['ishot4']='0';

			$result = $download_mod->save($data);
			if(false !== $result){				
				if($_POST['durl'] && is_array($_POST['durl'])){
				  $download_url_mod = D('download_url');	
				  $download_url_mod->delete($data['id']);
				  // $download_mod->where('id='.$cate_id)->delete();					
				   foreach($_POST['durl'] as $url){						  
						$urldata['id']=$data['id'];
						$arr = explode(',',$url);
						if($arr[1]!=''){
							$urldata['sitename']= $arr[0];						
							$urldata['durl']= $arr[1];
							$urldata['sort']= $arr[2];
							$result = $download_url_mod->add($urldata);						
						  }
				   }
				   $download_relation = D('projectrelation');
				   $download_relation->where('articleid='.$data["id"])->delete(); 
				   foreach($_POST as $key=>$val) {
					
					if(strpos($key,"project_") === 0){
						//echo $key.'=='.$val;
						$relation['attributeid']= $val;						
						$relation['articleid']= $data['id'];
						$relation['addtime']= time();
						$insertCount = $download_relation->add($relation);									
					
					}
				}

				}				
				$this->success(L('operation_success'),U('Download/index'));
			}else{
				$this->error(L('operation_failure'));
			}
		}else{
			
			$download_mod = D('download');
			if( isset($_GET['id']) ){
				$download_id = isset($_GET['id']) && intval($_GET['id']) ? intval($_GET['id']) : $this->error(L('please_select'));
			}
			$download_info = $download_mod->where('id='.$download_id)->find();	
			$download_relation = D('projectrelation');
			$downrelationlist = $download_relation->where('articleid='.$download_id)->select();
			$download_info["project"] = $downrelationlist;
			

			$cate_list = $this->_catalog_list();		
			$project_list = $this->_project_list();
			$language_list = $this->_language_list();
			$url_list = $this->_url_list($download_id);

			$this->assign('show_header', false);
	    	$this->assign('cate_list',$cate_list);			
			$this->assign('project_list',$project_list);
			$this->assign('language_list',$language_list);
			$this->assign('url_list',$url_list);
			$this->assign('download',$download_info);			
			$this->display();
		}


	}
	function startWith($str, $needle) {

		return strpos($str, $needle) === 0;

	}
	function add()
	{
		
		if(isset($_POST['dosubmit'])){
			$download_mod = D('download');		
			if($_POST['title']==''){
				$this->error(L('input').L('download_title'));
			}
			if(false === $data = $download_mod->create()){
				$this->error($download_mod->error());
			}
			if ($_FILES['imgurl']['name']!='') {
				$upload_list = $this->_upload();
				$data['imgurl'] = $upload_list['0']['savename'];
			}
			$data['addtime']=time();
			if(isset($data['ishot1']) && $data['ishot1']=='1'){
				$data['ishot1']='1';
			}else
				$data['ishot1']='0';
			if(isset($data['ishot2']) && $data['ishot2']=='1'){
				$data['ishot2']='1';
			}else
				$data['ishot2']='0';
			if(isset($data['ishot3']) && $data['ishot3']=='1'){
				$data['ishot3']='1';
			}else
				$data['ishot3']='0';

			if(isset($data['ishot4']) && $data['ishot4']=='1'){
				$data['ishot4']='1';
			}else
				$data['ishot4']='0';

			$result = $download_mod->add($data);
			if($result){//返回主键id			
				if($_POST['durl'] && is_array($_POST['durl'])){
				 $download_url_mod = D('download_url');					
				 foreach($_POST['durl'] as $url){		
					 $urldata = array();
						$urldata['id']=$data['id'];
						$arr = explode(',',$url);
						
						if($arr[1]!=''){
							$urldata['sitename']= $arr[0];						
							$urldata['durl']= $arr[1];
							$urldata['sort']= $arr[2];							
							$r = $download_url_mod->add($urldata);									
						  }
				   }
				foreach($_POST as $key=>$val) {
					$download_relation = D('projectrelation');
					if(strpos($key,"project_") === 0){
						//echo $key.'=='.$val;
						$relation['attributeid']= $val;						
						$relation['articleid']= $data['id'];
						$relation['addtime']= time();		
						$insertCount = $download_relation->add($relation);									
					
					}
				}
/*
				$cate = M('download_cate')->field('id,pid')->where("id=".$data['cate_id'])->find();
				if( $cate['pid']!=0 ){
					M('download_cate')->where("id=".$cate['pid'])->setInc('download_nums');
					M('download_cate')->where("id=".$data['cate_id'])->setInc('download_nums');
				}else{
					M('download_cate')->where("id=".$data['cate_id'])->setInc('download_nums');
				}
				*/
				}
				$this->success('添加成功');
			}else{
				$this->error('添加失败');
			}
		}else{
			$cate_list = $this->_catalog_list();		
			$project_list = $this->_project_list();
			$language_list = $this->_language_list();
			$url_list = $this->_url_list();

			$this->assign('show_header', false);
	    	$this->assign('cate_list',$cate_list);			
			$this->assign('project_list',$project_list);
			$this->assign('language_list',$language_list);
			$this->assign('url_list',$url_list);
			$this->assign('download',$download_info);	
	    	
	    	$this->display();
		}
	}

	public function _catalog_list()
	{
		$cate_list = array();
			
			$download_cate_mod = D('catalog');
		    $result = $download_cate_mod->order('sort ASC')->select();
		   
		    foreach ($result as $val) {
		    	if ($val['pid']==0) {
		    	    $cate_list['parent'][$val['id']] = $val;
		    	} else {
		    	    $cate_list['sub'][$val['pid']][] = $val;
		    	}
		    }
			return $cate_list;
	}

	public function _project_list()
	{
		
			$download_cate_mod = D('project');
		    $result = $download_cate_mod->order('addtime ASC')->select();
		   
			return $result;
	}

	public function _language_list()
	{
		$cate_list = array();
			
			$download_cate_mod = D('language');
		    $result = $download_cate_mod->order('id ASC')->select();
		   
		    foreach ($result as $val) {
		    	if ($val['parentid']==0) {
		    	    $cate_list['parent'][$val['id']] = $val;
		    	} else {
		    	    $cate_list['sub'][$val['parentid']][] = $val;
		    	}
		    }
			return $cate_list;
	}
	public function _url_list($download_id)
	{
		$url_list = array();			
		$url_mod = D('download_url');
		$result = $url_mod->where(' id='.$download_id)->order('sort ASC')->select();	 
		foreach ($result as $val) {
			$url_list[] = $val;
		}
		return $url_list;
	}
	public function _deletepic($old_content)
	{
		
		
		if(isset($old_content)){
			
			$oldPic=array();
			$match=array();
			preg_match_all("/<img.+src=\"?(.+\.(jpg|gif|bmp|bnp|png))\"?.+>/i",$old_content,$match);
			//$myfile = fopen(DATA_PATH."/log.txt", "a");		
			
			if(!empty($match[1])){				
				 foreach($match[1] as $key=>$value){	
					 //$txt = $value.",\n";
					//fwrite($myfile, $txt);
					unlink($value);					
				 }
				 
			}
			//fclose($myfile);
		}
	}

	function delete()
    {
		$download_mod = D('download');
		$download_url_mod = D('download_url');
		if((!isset($_GET['id']) || empty($_GET['id'])) && (!isset($_POST['id']) || empty($_POST['id']))) {
            $this->error('请选择要删除的资讯！');
		}
		if( isset($_POST['id'])&&is_array($_POST['id']) ){
			$cate_ids = implode(',',$_POST['id']);
			foreach( $_POST['id'] as $val ){
				$download = $download_mod->field("id,cate_id,info")->where("id=".$val)->find();
				$cate = M('download_cate')->field('id,pid')->where("id=".$download['cate_id'])->find();
				if( $cate['pid']!=0 ){
					M('download_cate')->where("id=".$cate['pid'])->setDec('download_nums');
					M('download_cate')->where("id=".$download['cate_id'])->setDec('download_nums');
				}else{
					M('download_cate')->where("id=".$download['cate_id'])->setDec('download_nums');
				}
				$this->_deletepic($download['info']);
			}
			$download_mod->delete($cate_ids);
			$download_url_mod->delete($cate_ids);
		}else{
			$cate_id = intval($_GET['id']);
			$download = $download_mod->field("id,cate_id,info")->where("id=".$cate_id)->find();
			M('download_cate')->where("id=".$download['cate_id'])->setDec('download_nums');
		    $download_mod->where('id='.$cate_id)->delete();
			$this->_deletepic($download['info']);
		}
		$this->success(L('operation_success'));
    }


    public function _upload()
    {
    	import("ORG.Net.UploadFile");
        $upload = new UploadFile();
        //设置上传文件大小
        $upload->maxSize = 3292200;
        //$upload->allowExts = explode(',', 'jpg,gif,png,jpeg');
        $upload->savePath = './data/news/';

        $upload->saveRule = uniqid;
        if (!$upload->upload()) {
            //捕获上传异常
            $this->error($upload->getErrorMsg());
        } else {
            //取得成功上传的文件信息
            $uploadList = $upload->getUploadFileInfo();
        }
        return $uploadList;
    }

	function sort_order()
    {
    	$download_mod = D('download');
		if (isset($_POST['listorders'])) {
            foreach ($_POST['listorders'] as $id=>$sort_order) {
            	$data['ordid'] = $sort_order;
                $download_mod->where('id='.$id)->save($data);
            }
            $this->success(L('operation_success'));
        }
        $this->error(L('operation_failure'));
    }

    //修改状态
	function status()
	{
		$download_mod = D('download');
		$id 	= intval($_REQUEST['id']);
		$type 	= trim($_REQUEST['type']);
		$sql 	= "update ".C('DB_PREFIX')."download set $type=($type+1)%2 where id='$id'";
		$res 	= $download_mod->execute($sql);
		$values = $download_mod->field("id,".$type)->where('id='.$id)->find();
		$this->ajaxReturn($values[$type]);
	}

}
?>