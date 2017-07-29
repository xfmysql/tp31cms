<?php
// +----------------------------------------------------------------------
// | MobileCms 移动应用软件后台管理系统
// +----------------------------------------------------------------------
// | provide by ：phonegap100.com
// 
// +----------------------------------------------------------------------
// | Author: htzhanglong@foxmail.com
// +----------------------------------------------------------------------

class ResumeAction extends BaseAction
{
	function index()
	{
		$ad_mod = D('resume');
		import("ORG.Util.Page");
		$count = $ad_mod->count();
		$p = new Page($count,20);
		$ad_list = $ad_mod->limit($p->firstRow.','.$p->listRows)->order('id desc')->select();

		/*$key = 1;
		foreach($ad_list as $k=>$val){
			$ad_list[$k]['key'] = ++$p->firstRow;
			$adboard_name = $adboard_mod->field('name')->where('id='.$val['board_id'])->find();
			$ad_list[$k]['adboard_name'] = $adboard_name['name'];
		}
		*/
		$page = $p->show();
		$this->assign('page',$page);
		$this->assign('ad_list',$ad_list);

		$ad_type_arr = array('0'=>'男','1'=>'女');
		$xueli_type_arr = array('0'=>'初中以下','1'=>'初中','2'=>'高中','3'=>'大专','4'=>'本科','5'=>'本科以上');
        $this->assign('ad_type_arr', $ad_type_arr);
		$this->assign('xueli_type_arr', $xueli_type_arr);
		/*
		$ad_type_arr = array('image'=>'图片','code'=>'代码','flash'=>'Flash','text'=>'文字');
        $this->assign('ad_type_arr', $ad_type_arr);
        $big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=Ad&a=add\', title:\'新增广告\', width:\'600\', height:\'400\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', '新增广告');
        $this->assign('big_menu',$big_menu);
		*/
		$this->display();
	}

function delete()
    {
		$ad_mod = D('resume');
		if((!isset($_GET['id']) || empty($_GET['id'])) && (!isset($_POST['id']) || empty($_POST['id']))) {
            $this->error('请选择要删除的链接！');
		}
		if( isset($_POST['id'])&&is_array($_POST['id']) ){
			$ids = implode(',',$_POST['id']);
			$ad_mod->delete($ids);
		}else{
			$id = intval($_GET['id']);
		    $ad_mod->where('id='.$id)->delete();
		}
		$this->success(L('operation_success'));
    }


	function edit()
	{
		if(isset($_POST['dosubmit'])){
			$ad_mod = D('resume');
			
	    	$data = array();
	    	$id = isset($_POST['id']) && intval($_POST['id']) ? intval($_POST['id']) : $this->error('参数错误');
			$status = isset($_POST['status']) && intval($_POST['status']) ? intval($_POST['status']) : $this->error('状态错误'.$_POST['status']);
	    	$data = $ad_mod->create();
		    
			$result = $ad_mod->where("id=".$data['id'])->save($data);
			if(false !== $result){
				$this->success(L('operation_success'), '', '', 'edit');
			}else{
				$this->error(L('operation_failure'));
			}

		}else{
			$ad_mod = D('resume');
			
			if( isset($_GET['id']) ){
				$id = isset($_GET['id']) && intval($_GET['id']) ? intval($_GET['id']) : $this->error('请选择要编辑的链接');
			}
			$ad_info = $ad_mod->where('id='.$id)->find();
			$ad_info['addtime'] = date('Y-m-d H:i:s', $ad_info['addtime']);
	        $ad_info['birthday'] = date('Y-m-d H:i:s', $ad_info['birthday']);	       
	        
			$ad_type_arr = array('0'=>'男','1'=>'女');
		$xueli_type_arr = array('0'=>'初中以下','1'=>'初中','2'=>'高中','3'=>'大专','4'=>'本科','5'=>'本科以上');
$this->assign('ad_type_arr', $ad_type_arr);
		$this->assign('xueli_type_arr', $xueli_type_arr);
	        //$ad_info['code']=stripslashes($ad_info['code']);	       
			$this->assign('ad_info',$ad_info);

            //print_r($ad_info);exit;


			$this->display();
		}
	}

	

	public function _upload()
    {
    	import("ORG.Net.UploadFile");
        $upload = new UploadFile();
        $upload->savePath = './data/advert/';
        //设置上传文件规则
        $upload->saveRule = uniqid;
        if (!$upload->upload()) {
            //捕获上传异常
            $this->error($upload->getErrorMsg());
        } else {
            //取得成功上传的文件信息
            $uploadList = $upload->getUploadFileInfo();
        }
        return $uploadList[0]['savename'];
    }

    function ordid()
    {
    	$ad_mod = D('ad');
		if (isset($_POST['listorders'])) {
            foreach ($_POST['listorders'] as $id=>$sort_order) {
            	$data['ordid'] = $sort_order;
                $ad_mod->where('id='.$id)->save($data);
            }
            $this->success(L('operation_success'));
        }
        $this->error(L('operation_failure'));
    }

    //获取广告位类型
    private function get_type_list()
    {
        $type_files = glob(ROOT_PATH . '/data/adboard/*.config.php');
        $type_list = array();
        foreach ($type_files as $file) {
            $basefile = basename($file);
            $key = str_replace('.config.php', '', $basefile);
            $type_list[$key] = include_once($file);
        }
        return $type_list;
    }
}
?>