<?php
// +----------------------------------------------------------------------
// | MobileCms 移动应用软件后台管理系统
// +----------------------------------------------------------------------
// | provide by ：phonegap100.com
// 
// +----------------------------------------------------------------------
// | Author: htzhanglong@foxmail.com
// +----------------------------------------------------------------------

class TabinfoAction extends BaseAction
{

	//分类列表
    function index()
    {
        $datamod = M('tabinfo');
    	$result = $datamod->order('id desc')->select();    	

    	$this->assign('data_list',$result);
		$big_menu = array('javascript:window.top.art.dialog({id:\'edit\',iframe:\'?m=Tabinfo&a=edit\', title:\''.L('add_tabinfo').'\', width:\'500\', height:\'200\', lock:true}, function(){var d = window.top.art.dialog({id:\'edit\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'edit\'}).close()});void(0);', L('add_tabinfo'));
		$this->assign('big_menu',$big_menu);
		$this->display();
    }


    function delete()
    {
        if((!isset($_GET['id']) || empty($_GET['id'])) && (!isset($_POST['id']) || empty($_POST['id']))) {
            $this->error('请选择要删除的！');
		}
		$datamod = M('tabinfo');
		if (isset($_POST['id']) && is_array($_POST['id'])) {
		    $cate_ids = implode(',', $_POST['id']);
		    $datamod->delete($cate_ids);
		} else {

		    $cate_id = intval($_GET['id']);
		    $datamod->delete($cate_id);
		}
		$this->success(L('operation_success'));
    }

    function edit()
    {
    	if(isset($_POST['dosubmit'])){    
			
			if(isset($_POST['id']) && $_POST['id']>0 ){//edit 
				$datamod = D('tabinfo');	
				$data = $datamod->create();				
				if($data['name']==''){
					$this->error('编辑：名称不能为空');
				}
					
				$result = $datamod->save($data);
				if(false !== $result){
					$this->success(L('operation_success'), '', '', 'edit');
				}else{
					$this->error(L('operation_failure'));
				}

			}else{//add save
				$datamod = D('tabinfo');	
				if( false === $vo = $datamod->create() ){
					$this->error( $datamod->error() );
				}
				
				if($vo['name']==''){
					$this->error('add 名称不能为空'.$vo['name']);exit;
				}
				
				$result = $datamod->where("name='".$vo['name']."'")->count();
				if($result != 0){
					$this->error('该名称已经存在');
				}
				
				//保存当前数据
				$newid = $datamod->add();
				$this->success(L('operation_success'), '', '', 'edit');
			}
    	}else{
    		
			if(isset($_GET['id']) ){//edit
				$cate_id = isset($_GET['id']) && intval($_GET['id']) ? intval($_GET['id']) :	$this->error(L('please_select').L('tabinfo'));
				$datamod = M('tabinfo');
				$datainfo = $datamod->where('id='.$cate_id)->find();
				$this->assign('data_info',$datainfo);
			}
			
			$this->assign('show_header', false);
			$this->display();
    	}

    }
}
?>