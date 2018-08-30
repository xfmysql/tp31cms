<?php
// +----------------------------------------------------------------------
// | MobileCms 移动应用软件后台管理系统
// +----------------------------------------------------------------------
// | provide by ：phonegap100.com
// 
// +----------------------------------------------------------------------
// | Author: htzhanglong@foxmail.com
// +----------------------------------------------------------------------

class KeywordAction extends BaseAction
{

	//分类列表
    function index()
    {
        $keyword_mod = M('keyword');
    	$result = $keyword_mod->order('id desc')->select();    	

    	$this->assign('keyword_list',$result);
		$big_menu = array('javascript:window.top.art.dialog({id:\'edit\',iframe:\'?m=Keyword&a=edit\', title:\''.L('add_keyword').'\', width:\'500\', height:\'200\', lock:true}, function(){var d = window.top.art.dialog({id:\'edit\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'edit\'}).close()});void(0);', L('add_keyword'));
		$this->assign('big_menu',$big_menu);
		$this->display();
    }


    function delete()
    {
        if((!isset($_GET['id']) || empty($_GET['id'])) && (!isset($_POST['id']) || empty($_POST['id']))) {
            $this->error('请选择要删除的！');
		}
		$keyword_mod = M('keyword');
		if (isset($_POST['id']) && is_array($_POST['id'])) {
		    $cate_ids = implode(',', $_POST['id']);
		    $keyword_mod->delete($cate_ids);
		} else {

		    $cate_id = intval($_GET['id']);
		    $keyword_mod->delete($cate_id);
		}
		$this->success(L('operation_success'));
    }

    function edit()
    {
    	if(isset($_POST['dosubmit'])){    
			
			if(isset($_POST['id']) && $_POST['id']>0 ){//edit 
				$keyword_mod = D('keyword');	
				$data = $keyword_mod->create();				
				if($data['name']==''){
					$this->error('编辑：名称不能为空');
				}
					
				$result = $keyword_mod->save($data);
				if(false !== $result){
					$this->success(L('operation_success'), '', '', 'edit');
				}else{
					$this->error(L('operation_failure'));
				}

			}else{//add save
				$keyword_mod = D('keyword');	
				if( false === $vo = $keyword_mod->create() ){
					$this->error( $keyword_mod->error() );
				}
				
				if($vo['name']==''){
					$this->error('名称不能为空');exit;
				}
				
				$result = $keyword_mod->where("name='".$vo['name']."'")->count();
				if($result != 0){
					$this->error('该名称已经存在');
				}
				
				//保存当前数据
				$keyword_id = $keyword_mod->add();
				$this->success(L('operation_success'), '', '', 'edit');
			}
    	}else{
    		
			if(isset($_GET['id']) ){//edit
				$cate_id = isset($_GET['id']) && intval($_GET['id']) ? intval($_GET['id']) :	$this->error(L('please_select').L('keyword'));
				$keyword_mod = M('keyword');
				$keyword_info = $keyword_mod->where('id='.$cate_id)->find();
				$this->assign('keyword_info',$keyword_info);
			}
			
			$this->assign('show_header', false);
			$this->display();
    	}

    }
}
?>