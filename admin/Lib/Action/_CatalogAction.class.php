<?php
// +----------------------------------------------------------------------
// | MobileCms 移动应用软件后台管理系统
// +----------------------------------------------------------------------
// | provide by ：phonegap100.com
// 
// +----------------------------------------------------------------------
// | Author: htzhanglong@foxmail.com
// +----------------------------------------------------------------------

class CatalogAction extends BaseAction
{

	//分类列表
    function index()
    {
        $catalog_mod = M('catalog');
        //$catalog_mod = D('catalog');
    	$result = $catalog_mod->order('sort asc')->select();
    	$catalog_list = array();
    	foreach ($result as $val) {//统计子内容数量
    	    if ($val['parentid']==0) {
    	        $catalog_list['parent'][$val['id']] = $val;
    	    } else {    	    	
    	        $catalog_list['sub'][$val['parentid']][] = $val;
    	    }
    	}

    	$this->assign('catalog_list',$catalog_list);
		$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=Catalog&a=add\', title:\''.L('add_cate').'\', width:\'500\', height:\'400\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'edit\'}).close()});void(0);', L('add_cate'));
		$this->assign('big_menu',$big_menu);
		$this->display();
    }

    //添加分类数据
    function add()
    {
		$catalog_mod = M('catalog');
    	if(isset($_POST['dosubmit'])){
			
	        if( false === $vo = $catalog_mod->create() ){
		        $this->error( $catalog_mod->error() );
		    }
		    if($vo['name']==''){
		    	$this->error('分类名称不能为空');exit;
		    }
		    $result = $catalog_mod->where("name='".$vo['name']."' AND parentid='".$vo['pid']."'")->count();
		    if($result != 0){
		        $this->error('该分类已经存在');
		    }
			$vo['addtime']=time();
			//保存当前数据
		    $catalog_id = $catalog_mod->add($vo);
		    $this->success(L('operation_success'), '', '', 'add');
    	}else{
    		
	    	$result = $catalog_mod->where('parentid=0')->order('sort ASC')->select();//只显示顶级类目，显示只支持2级。
	    	$catalog_list = array();
	    	foreach ($result as $val) {
	    	    if ($val['parentid']==0) {
	    	        $catalog_list['parent'][$val['id']] = $val;
	    	    } else {
	    	        $catalog_list['sub'][$val['parentid']][] = $val;
	    	    }
	    	}
	    	$this->assign('catalog_list',$catalog_list);
	    	$this->assign('show_header', false);
	        $this->display();
    	}

    }

    function delete()
    {
        if((!isset($_GET['id']) || empty($_GET['id'])) && (!isset($_POST['id']) || empty($_POST['id']))) {
            $this->error('请选择要删除的分类！');
		}
		$catalog_mod = M('catalog');
		if (isset($_POST['id']) && is_array($_POST['id'])) {
		    $cate_ids = implode(',', $_POST['id']);
		    $catalog_mod->delete($cate_ids);
		} else {

		    $cate_id = intval($_GET['id']);
		    $catalog_mod->delete($cate_id);
		}
		$this->success(L('operation_success'));
    }

    function edit()
    {
    	if(isset($_POST['dosubmit'])){
    		$catalog_mod = M('catalog');			
			
			$old_cate = $catalog_mod->where('id='.$_POST['id'])->find();
			//同一个分类下名称不能重复
			if ($_POST['name']!=$old_cate['name']) {
				if ($this->_cate_exists($_POST['name'], $_POST['pid'], $_POST['id'])) {
					$this->error('分类名称重复！');exit;
				}
			}
			
			//获取此分类和他的所有下级分类id
			$vids = array();
			$children[] = $old_cate['id'];
			$vr = $catalog_mod->where('parentid='.$old_cate['id'])->select();
			foreach ($vr as $val) {
				$children[] = $val['id'];
			}
			if (in_array($_POST['pid'], $children)) {
				$this->error('所选择的上级分类不能是当前分类或者当前分类的下级分类！');
			}
			$vo = $catalog_mod->create();
			$result = $catalog_mod->save();
			if(false !== $result){
				$this->success(L('operation_success'), '', '', 'edit');
			}else{
				$this->error(L('operation_failure'));
			}

				    	
    	}else{
    		$catalog_mod = M('catalog');
			if(isset($_GET['id']) ){
				$cate_id = isset($_GET['id']) && intval($_GET['id']) ? intval($_GET['id']) : $this->error(L('please_select').L('article_name'));
				$catalog_info = $catalog_mod->where('id='.$cate_id)->find();

				$result = $catalog_mod->where('parentid=0 and id<>'.$_GET['id'])->order('sort ASC')->select();
				$cate_list = array();
				foreach ($result as $val) {
					if ($val['pid']==0) {
						$cate_list['parent'][$val['id']] = $val;
					} else {
						$cate_list['sub'][$val['parentid']][] = $val;
					}
				}
				$this->assign('cate_list', $cate_list);
				$this->assign('catalog_info',$catalog_info);
				$this->assign('show_header', false);
				$this->display();

			}			
			else
				$this->error('id为空！');exit;
			
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