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
		$orderby = " id desc";
		$this->assign('status',"-1");
		$this->assign('istop',"-1");
		$this->assign('ishomepage',"-1");
		if (isset($_GET['status']) && trim($_GET['status'])) {
			if($_GET['status']=="0") $where = " status=0";
		    else if($_GET['status']=="1") $where = " status=1";
			 else if($_GET['status']=="2") $where = " status=2";
			else $where = " 1=1";
		    $this->assign('status',$_GET['status']);
		}
		
		if (isset($_GET['cate_id']) && intval($_GET['cate_id'])) {
			if(intval($_GET['cate_id'])==-1){
				$where .= " AND pid=0";	
			}else if(intval($_GET['cate_id'])>0){
		    	$where .= " AND pid=".$_GET['cate_id'];
		    }// if ==0 query all
		    $this->assign('cate_id', $_GET['cate_id']);
		}
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

		if (isset($_GET['istop']) ) {
			if($_GET['istop']=="0") $where .= " and istop=0";
		    else if($_GET['istop']=="1") $where .= " and  istop=1"; 
		    $this->assign('istop',$_GET['istop']);
		}
		if (isset($_GET['ishomepage']) ) {
			if($_GET['ishomepage']=="0") $where .= " and  ishomepage=0";
		    else if($_GET['ishomepage']=="1")  $where .= " and  ishomepage=1"; 
		    $this->assign('ishomepage',$_GET['ishomepage']);
		}

		if (isset($_GET['ordby']) && trim($_GET['ordby'])) {
		    if($_GET['ordby']=="1") $orderby = " id asc";
			else $orderby = " id desc";
		    $this->assign('ordby',$_GET['ordby']);
		}
		 

		import("ORG.Util.Page");
		$count = $article_mod->where($where)->count();
		$p = new Page($count,20);
		$article_list = $article_mod->where($where)->limit($p->firstRow.','.$p->listRows)->order($orderby)->select();

		$key = 1;
		foreach($article_list as $k=>$val){
			$article_list[$k]['key'] = ++$p->firstRow;
			$article_list[$k]['cate_name'] = $article_cate_mod->field('name')->where('id='.$val['pid'])->find();
		}
		$result = $article_cate_mod->where(" model=".C("Model_Article"))->order('sort asc')->select();
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
				$this->error('请选择资讯分类'.$data['icourltxt'].';');
			}
			if ($_FILES['icourl']['name']!='') {
			    $icourls = $this->uploadByInfo("");//[0]=原图，[1]=缩略图	
			    if(C('usethumb')){		    
				    $data['icourl'] = $icourls[1];
				}else $data['icourl'] = $icourls[0];
			}	
			else if($_POST['icourltxt']){
				 $data['icourl'] = $_POST['icourltxt'];
			}
			$result = $article_mod->save($data);
			if(false !== $result){
				if($_POST['tabinfos']!=''){
					$tabrelation_mod = D("tabrelation");
					$tabrelation_mod->where("articleid=".$data["id"])->delete();
					$tabinfo_mod = D("tabinfo");

					$reldata = array();
					$arr = explode(',',$_POST['tabinfos']);
					$arr = array_unique($arr);
					 foreach($arr as $r){
					 	$tabid = $tabinfo_mod->where("name='".$r."'")->getField("id");	
						$reldata['attributeid']= $tabid;						
						$reldata['addtime']= date('Y-m-d H:i:s',time());
						$reldata['articleid']=$data["id"];
						$tabrelation_mod->add($reldata);									
					}
				}else{
					$tabrelation_mod = D("tabrelation");
					$tabrelation_mod->where("articleid=".$data["id"])->delete();
				}
				if($_POST['keywords']!=''){
					$keywordrelation_mod = D("keywordrelation");
					$keywordrelation_mod->where("articleid=".$data["id"])->delete();
					$keyword_mod = D("keyword");

					$reldata = array();
					$arr = explode(',',$_POST['keywords']);
					$arr = array_unique($arr);
					 foreach($arr as $r){
					 	$keyid = $keyword_mod->where("name='".$r."'")->getField("id");	
						$reldata['attributeid']= $keyid;						
						$reldata['addtime']= date('Y-m-d H:i:s',time());
						$reldata['articleid']=$data["id"];
						$keywordrelation_mod->add($reldata);									
					}
				}else{
					$keywordrelation_mod = D("keywordrelation");
					$keywordrelation_mod->where("articleid=".$data["id"])->delete();
				}
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

			$tabinfo_mod = D('tabinfo');
			$sql = 'select t.*  from cms_tabinfo t join cms_tabrelation r on t.id=r.attributeid where r.articleid='.$article_id.' order by r.id asc,r.addtime asc';
		    $tabinfo_list = $tabinfo_mod->query($sql);

		    $tabinfos='';
		    foreach ($tabinfo_list as  $value) {
		    	$tabinfos.=$value["name"].",";
		    }
			$this->assign('tabinfos',substr($tabinfos, 0, -1));
		   
			$sql = 'select *  from cms_tabinfo  order by id desc limit 20 ';
	    	$tabinfo_list = $tabinfo_mod->query($sql);
			$this->assign('tabinfo_list',$tabinfo_list);
			//关键词
			$keyword_mod = D('keyword');
			$sql = 'select t.*  from cms_keyword t join cms_keywordrelation r on t.id=r.attributeid where r.articleid='.$article_id.' order by r.id asc,r.addtime asc';
		    $keyword_list = $keyword_mod->query($sql);

		    $keyword='';
		    foreach ($keyword_list as  $value) {
		    	$keyword.=$value["name"].",";
		    }
			$this->assign('keywords',substr($keyword, 0, -1));
			
			$sql = 'select * from cms_keyword  order by id desc limit 20 ';
	    	$keyword_list = $keyword_mod->query($sql);
			$this->assign('keyword_list',$keyword_list);

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

			if($data['pid']==0){
				$this->error('请选择资讯分类');
			}
			if ($_FILES['icourl']['name']!='') {
				$upload_url = $this->upload("article");//封面
				$data['icourl'] = $upload_url;
			}else if($_POST['icourltxt']){
				 $data['icourl'] = $_POST['icourltxt'];
			}
			$data['addtime']=date('Y-m-d H:i:s',time());
			$data['edittime']=date('Y-m-d H:i:s',time());
			$newid = $article_mod->add($data);

			if($newid>0){
				if($_POST['tabinfos']!=''){
					$tabinfo_mod = D("tabinfo");		
					$tabrelation_mod = D("tabrelation");					
					$reldata = array();
					$arr = explode(',',$_POST['tabinfos']);
					$arr = array_unique($arr);
					 foreach($arr as $r){
					 	$tabid = $tabinfo_mod->where("name='".$r."'")->getField("id");	
						$reldata['attributeid']= $tabid;						
						$reldata['addtime']= date('Y-m-d H:i:s',time());
						$reldata['articleid']=$data["id"];
						$tabrelation_mod->add($reldata);									
					}
					if($_POST['keywords']!=''){
						$keywords_mod = D("keyword");
						$keywordrelation_mod = D("keywordrelation");
						$reldata = array();
						$arr = explode(',',$_POST['keywords']);
						$arr = array_unique($arr);
						 foreach($arr as $r){
						 	$keyid = $keywords_mod->where("name='".$r."'")->getField("id");	
							$reldata['attributeid']= $keyid;						
							$reldata['addtime']= date('Y-m-d H:i:s',time());
							$reldata['articleid']=$data["id"];
							$keywordrelation_mod->add($reldata);									
						}
					}
				}
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
	    	$tabinfo_mod = D('tabinfo');
			$sql = 'select *  from cms_tabinfo  order by id desc limit 20 ';
	    	$tabinfo_list = $tabinfo_mod->query($sql);
			$this->assign('tabinfo_list',$tabinfo_list);

			$keyword_mod = D('keyword');
			$sql = 'select *  from cms_keyword  order by id desc limit 20 ';
	    	$keyword_list = $keyword_mod->query($sql);
			$this->assign('keyword_list',$keyword_list);

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
		 $data["status"] = $values[$type];
		$this->ajaxReturn($data);
	}

}
?>