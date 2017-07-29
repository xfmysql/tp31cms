<?php
// +----------------------------------------------------------------------
// | MobileCms 移动应用软件后台管理系统
// +----------------------------------------------------------------------
// | provide by ：phonegap100.com
// 
// +----------------------------------------------------------------------
// | Author: htzhanglong@foxmail.com
// +----------------------------------------------------------------------

class ProjectAction extends BaseAction
{

	//分类列表
    function index()
    {
        $project_mod = M('project');       
    	$result = $project_mod->order('addtime desc')->select();		
    	$project_list = array();
    	foreach ($result as $val) {//统计子内容数量
    	     $project_list[] = $val;
    	}

    	$this->assign('project_list',$result);
		$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=Project&a=add\', title:\''.L('add_cate').'\', width:\'500\', height:\'400\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'edit\'}).close()});void(0);', L('add_project'));
		$this->assign('big_menu',$big_menu);
		$this->display();
    }

    //添加分类数据
    function add()
    {
		
    	if(isset($_POST['dosubmit'])){
			$project_mod = M('project');
	        if( false === $vo = $project_mod->create() ){
		        $this->error( $project_mod->error() );
		    }
		    if($vo['name']==''){
		    	$this->error('分类名称不能为空');exit;
		    }
		    $result = $project_mod->where("name='".$vo['name']."' AND parentid='".$vo['catalogid']."'")->count();
		    if($result != 0){
		        $this->error('该名称已经存在');
		    }
			$vo['addtime']=time();
			//保存当前数据
		    $project_id = $project_mod->add($vo);
		    $this->success(L('operation_success'), '', '', 'add');
    	}else{
    		$catalog_mod = M('catalog');
	    	$result = $catalog_mod->order('sort ASC')->select();
	    	$catalog_list = array();
	    	foreach ($result as $val) {
	    	    if ($val['parentid']==0) {
	    	        $catalog_list['parent'][$val['id']] = $val;
	    	    } else {
	    	        $catalog_list['sub'][$val['parentid']][] = $val;
	    	    }
	    	}
			$language_mod = M('language');
			$language_list = $language_mod->order('id ASC')->select();

	    	$this->assign('catalog_list',$catalog_list);
			$this->assign('language_list',$language_list);
	    	$this->assign('show_header', false);
	        $this->display();
    	}

    }

    function delete()
    {
        if((!isset($_GET['id']) || empty($_GET['id'])) && (!isset($_POST['id']) || empty($_POST['id']))) {
            $this->error('请选择要删除的分类！');
		}
		$project_mod = M('project');
		if (isset($_POST['id']) && is_array($_POST['id'])) {
		    $cate_ids = implode(',', $_POST['id']);
		    $project_mod->delete($cate_ids);
		} else {

		    $cate_id = intval($_GET['id']);
		    $project_mod->delete($cate_id);
		}
		$this->success(L('operation_success'));
    }

    function edit()
    {
    	if(isset($_POST['dosubmit'])){
    		$project_mod = M('project');			
			$old_cate = $project_mod->where('id='.$_POST['id'])->find();
			//同一个分类下名称不能重复
			if ($_POST['name']!=$old_cate['name']) {
				if ($this->_cate_exists($_POST['name'], $_POST['pid'], $_POST['id'])) {
					$this->error('分类名称重复！');exit;
				}
			}
			//获取此分类和他的所有下级分类id
			$vids = array();
			$children[] = $old_cate['id'];
			$vr = $project_mod->where('parentid='.$old_cate['id'])->select();
			foreach ($vr as $val) {
				$children[] = $val['id'];
			}
			if (in_array($_POST['pid'], $children)) {
				$this->error('所选择的上级分类不能是当前分类或者当前分类的下级分类！');
			}
			$vo = $project_mod->create();
			$result = $project_mod->save();
			if(false !== $result){
				$this->success(L('operation_success'), '', '', 'edit');
			}else{
				$this->error(L('operation_failure'));
			}			
	    	
    	}else{
			$catalog_mod = M('catalog');
	    	$result = $catalog_mod->order('sort ASC')->select();
	    	$catalog_list = array();
	    	foreach ($result as $val) {
	    	    if ($val['parentid']==0) {
	    	        $catalog_list['parent'][$val['id']] = $val;
	    	    } else {
	    	        $catalog_list['sub'][$val['parentid']][] = $val;
	    	    }
	    	}
			$language_mod = M('language');
			$language_list = $language_mod->order('id ASC')->select();

	    	

    		$project_mod = M('project');
			if(isset($_GET['id']) ){//edit
				$cate_id = isset($_GET['id']) && intval($_GET['id']) ? intval($_GET['id']) : $this->error(L('please_select').L('article_name'));
				$project_info = $project_mod->where('id='.$cate_id)->find();
			}			
	    	$this->assign('catalog_list',$catalog_list);
			$this->assign('language_list',$language_list);
			$this->assign('project_info',$project_info);
			$this->assign('show_header', false);
			$this->display();
    	}

    }


    private function _cate_exists($name, $pid, $id=0)
    {
    	$where = "name='".$name."' AND pid='".$pid."'";
    	if( $id&&intval($id) ){
    		$where .= " AND id<>'".$id."'";
    	}
        $result = M('article_cate')->where($where)->count();
        //echo(M('article_cate')->getLastSql());exit;
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    function sort_order()
    {
    	$article_cate_mod = M('article_cate');
		if (isset($_POST['listorders'])) {
            foreach ($_POST['listorders'] as $id=>$sort_order) {
            	$data['sort_order'] = $sort_order;
                $article_cate_mod->where('id='.$id)->save($data);
            }
            $this->success(L('operation_success'));
        }
        $this->error(L('operation_failure'));
    }
    //修改状态
	function status()
	{
		$article_cate_mod = D('article_cate');
		$flink_mod = D('flink');
		$id 	= intval($_REQUEST['id']);
		$type 	= trim($_REQUEST['type']);
		$sql 	= "update ".C('DB_PREFIX')."article_cate set $type=($type+1)%2 where id='$id'";
		$res 	= $article_cate_mod->execute($sql);
		$values = $article_cate_mod->where('id='.$id)->find();
		$this->ajaxReturn($values[$type]);
	}
}
?>