<?php
// +----------------------------------------------------------------------
// | MobileCms 移动应用软件后台管理系统
// +----------------------------------------------------------------------
// | provide by ：phonegap100.com
// 
// +----------------------------------------------------------------------
// | Author: htzhanglong@foxmail.com
// +----------------------------------------------------------------------

class LanguageAction extends BaseAction
{

	//分类列表
    function index()
    {
        $language_mod = M('language');
    	$result = $language_mod->order('id desc')->select();    	

    	$this->assign('language_list',$result);
		$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=Language&a=add\', title:\''.L('add_lanuage').'\', width:\'500\', height:\'200\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'edit\'}).close()});void(0);', L('add_lanuage'));
		$this->assign('big_menu',$big_menu);
		$this->display();
    }

 //添加分类数据
    function add()
    {
		
    	if(isset($_POST['dosubmit'])){
			$language_mod = D('language');	
			if( false === $vo = $language_mod->create() ){
				$this->error( $language_mod->error() );
			}
			
			if($vo['name']==''){
				$this->error('名称不能为空');exit;
			}
			
			$result = $language_mod->where("name='".$vo['name']."'")->count();
			if($result != 0){
				$this->error('该名称已经存在');
			}
			
			//保存当前数据
			$language_id = $language_mod->add();
			$this->success(L('operation_success'), '', '', 'add');
    	}else{
			$this->assign('show_header', false);
	        $this->display();
    	}

    }

    function delete()
    {
        if((!isset($_GET['id']) || empty($_GET['id'])) && (!isset($_POST['id']) || empty($_POST['id']))) {
            $this->error('请选择要删除的分类！');
		}
		$language_mod = M('language');
		if (isset($_POST['id']) && is_array($_POST['id'])) {
		    $cate_ids = implode(',', $_POST['id']);
		    $language_mod->delete($cate_ids);
		} else {

		    $cate_id = intval($_GET['id']);
		    $language_mod->delete($cate_id);
		}
		$this->success(L('operation_success'));
    }

    function edit()
    {
    	if(isset($_POST['dosubmit'])){ 
			
			$language_mod = D('language');	
			$data = $language_mod->create();				
			if($data['name']==''){
				$this->error('编辑：名称不能为空');
			}
				
			$result = $language_mod->save($data);
			if(false !== $result){
				$this->success(L('operation_success'), '', '', 'edit');
			}else{
				$this->error(L('operation_failure'));
			}

    	}else{
    		
			if(isset($_GET['id']) ){//edit
				$cate_id = isset($_GET['id']) && intval($_GET['id']) ? intval($_GET['id']) :	$this->error(L('please_select').L('language'));
				$language_mod = M('language');
				$language_info = $language_mod->where('id='.$cate_id)->find();
				$this->assign('language_info',$language_info);
			}
			
			$this->assign('show_header', false);
			$this->display();
    	}

    }
}
?>