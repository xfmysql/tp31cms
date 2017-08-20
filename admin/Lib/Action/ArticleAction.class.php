<?php
// +----------------------------------------------------------------------
// | MobileCms 移动应用软件后台管理系统
// +----------------------------------------------------------------------
// | provide by ：phonegap100.com
// 
// +----------------------------------------------------------------------
// | Author: htzhanglong@foxmail.com
// +----------------------------------------------------------------------

class ArticleAction extends BaseAction
{
	public function index()
	{
		$article_mod = D('article');
		$article_cate_mod = D('catalog');

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
		    $where .= " AND cate_id=".$_GET['cate_id'];
		    $this->assign('cate_id', $_GET['cate_id']);
		}
		if (isset($_GET['cate_id']) && $_GET['cate_id']=='0') {
		    $where .= " AND cate_id=0";
		    $this->assign('cate_id', $_GET['cate_id']);
		}
		import("ORG.Util.Page");
		$count = $article_mod->where($where)->count();
		$p = new Page($count,20);
		$article_list = $article_mod->where($where)->limit($p->firstRow.','.$p->listRows)->order('addtime DESC,sort desc')->select();

		$key = 1;
		foreach($article_list as $k=>$val){
			$article_list[$k]['key'] = ++$p->firstRow;
			$article_list[$k]['cate_name'] = $article_cate_mod->field('name')->where('id='.$val['pid'])->find();
		}
		$result = $article_cate_mod->where(" model=".C("Model_Article"))->order('sort desc')->select();
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
		$this->assign('article_list',$article_list);
		$this->display();
	}

	function edit()
	{
		if(isset($_POST['dosubmit'])){
			$article_mod = D('article');	
			$data = $article_mod->create();
			if($data['pid']==0){
				$this->error('请选择资讯分类');
			}
			if ($_FILES['icourl']['name']!='') {
			    $upload_url = $this->upload("article");
			    $data['icourl'] = $upload_url;
			}			
			$data['edittime']=date('Y-m-d H:i:s',time());
			$result = $article_mod->save($data);
			if(false !== $result){
				$this->success(L('operation_success'),U('Article/index'));
			}else{
				$this->error(L('operation_failure'));
			}
		}else{
			$article_mod = D('article');
			if( isset($_GET['id']) ){
				$article_id = isset($_GET['id']) && intval($_GET['id']) ? intval($_GET['id']) : $this->error(L('please_select'));
			}
			$article_cate_mod = D('catalog');
		    $result = $article_cate_mod->where(" model=".C("Model_Article") )->order('sort ASC')->select();
		    $cate_list = array();
		    foreach ($result as $val) {
		    	if ($val['pid']==0) {
		    	    $cate_list['parent'][$val['id']] = $val;
		    	} else {
		    	    $cate_list['sub'][$val['pid']][] = $val;
		    	}
		    }
			$article_info = $article_mod->where('id='.$article_id)->find();		
	    	$this->assign('cate_list',$cate_list);
			$this->assign('article',$article_info);
			$this->display();
		}


	}

	function add()
	{
		if(isset($_POST['dosubmit'])){
			
			$article_mod = D('article');		
			if($_POST['title']==''){
				$this->error(L('input').L('title'));
			}
			if(false === $data = $article_mod->create()){
				$this->error($article_mod->error());
			}
			if ($_FILES['icourl']['name']!='') {
				$upload_url = $this->upload("article");
				$data['icourl'] = $upload_url;
			}
			$data['addtime']=date('Y-m-d H:i:s',time());
			$result = $article_mod->add($data);
			if($result){//记录文章数量
				//$cate = M('catalog')->field('id,pid')->where("id=".$data['cate_id'])->find();
				///if( $cate['pid']!=0 ){
				//	M('catalog')->where("id=".$cate['id'])->setInc('article_nums');
				//}
				$this->success('添加成功');
			}else{
				$this->error('添加失败');
			}
		}else{
			$article_cate_mod = D('catalog');
	    	$result = $article_cate_mod->where(" model=".C("Model_Article"))->order('sort ASC')->select();
	    	$cate_list = array();
	    	foreach ($result as $val) {
	    	    if ($val['pid']==0) {
	    	        $cate_list['parent'][$val['id']] = $val;
	    	    } else {
	    	        $cate_list['sub'][$val['pid']][] = $val;
	    	    }
	    	}
	    	$this->assign('cate_list',$cate_list);
	    	$this->display();
		}
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
		$article_mod = D('article');
		if((!isset($_GET['id']) || empty($_GET['id'])) && (!isset($_POST['id']) || empty($_POST['id']))) {
            $this->error('请选择要删除的资讯！');
		}
		if( isset($_POST['id'])&&is_array($_POST['id']) ){
			$cate_ids = implode(',',$_POST['id']);
			foreach( $_POST['id'] as $val ){
				$article = $article_mod->field("id,cate_id,info")->where("id=".$val)->find();
				$cate = M('catalog')->field('id,pid')->where("id=".$article['cate_id'])->find();
				if( $cate['pid']!=0 ){
					M('catalog')->where("id=".$cate['pid'])->setDec('article_nums');
					M('catalog')->where("id=".$article['cate_id'])->setDec('article_nums');
				}else{
					M('catalog')->where("id=".$article['cate_id'])->setDec('article_nums');
				}
				$this->_deletepic($article['info']);
			}
			$article_mod->delete($cate_ids);
		}else{
			$cate_id = intval($_GET['id']);
			$article = $article_mod->field("id,cate_id,info")->where("id=".$cate_id)->find();
			M('catalog')->where("id=".$article['cate_id'])->setDec('article_nums');
		    $article_mod->where('id='.$cate_id)->delete();
			$this->_deletepic($article['info']);
		}
		$this->success(L('operation_success'));
    }



	function sort_order()
    {
    	$article_mod = D('article');
		if (isset($_POST['listorders'])) {
            foreach ($_POST['listorders'] as $id=>$sort_order) {
            	$data['ordid'] = $sort_order;
                $article_mod->where('id='.$id)->save($data);
            }
            $this->success(L('operation_success'));
        }
        $this->error(L('operation_failure'));
    }

    //修改状态
	function status()
	{
		$article_mod = D('article');
		$id 	= intval($_REQUEST['id']);
		$type 	= trim($_REQUEST['type']);
		$sql 	= "update ".C('DB_PREFIX')."article set $type=($type+1)%2 where id='$id'";
		$res 	= $article_mod->execute($sql);
		$values = $article_mod->field("id,".$type)->where('id='.$id)->find();
		$this->ajaxReturn($values[$type]);
	}

}
?>