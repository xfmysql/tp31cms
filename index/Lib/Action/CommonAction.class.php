<?php
/**
* 前台公共类
* @author  <[c@easycms.cc]>
*/
class CommonAction extends Action
{
	Public function _initialize(){
		//if (ismobile()) {
        //    C('DEFAULT_THEME','mobile');
        //}
		//获取网站配置信息
		$setting_mod = M('setting');
		$setting = $setting_mod->select();
		foreach ( $setting as $val ) {
			$set[$val['name']] = stripslashes($val['data']);
		}
		$this->setting = $set; 
		//全局首页，显示推荐栏目，用户个人中心导航分类展示
		$catalogList=M('catalog')->where('isnav=1 and status=1 and pid=0')->order('sort asc')->select();
		foreach ($catalogList as $key=>$value) {
			$childList=M('catalog')->where('pid='.$value["id"])->order('sort asc')->select();
			$catalogList[$key]['childcount'] = count($childList);
			$catalogList[$key]['child'] = $childList;
		}
		$this->assign('catalogList',$catalogList);
		//全局首页，显示推荐栏目，用户个人中心导航分类展示
		$bottomList=M('catalog')->where('showbottom=1 and status=1 and pid=0')->order('sort asc')->select();
		foreach ($bottomList as $key=>$value) {
			$childList=M('catalog')->where('pid='.$value["id"])->order('sort asc')->select();
			$catalogList[$key]['childcount'] = count($childList);
			$catalogList[$key]['child'] = $childList;
		}
		$this->assign('bottomList',$bottomList);

		$article=M('article');
		$catalog = M('article_cate');
		//推荐文章
		$bestArticleList=$article->limit('6')->where(" status=1 and istop=1")->order('clicks desc')->select();
			$this->assign('bestArticleList',$bestArticleList);	
		//最新文章
		$newArticleList=$article->limit('6')->where(" status=1 ")->order('addtime desc')->select();	
		$this->assign('newArticleList',$newArticleList);
		//标签
	 	$keyword_mod = M('keyword');
	    $KeywordList = $keyword_mod->order('id desc')->select();    
		$this->assign('KeywordList',$KeywordList);

		//linkList
		$linkTxt=M('flink');
		$linkTxtList=$linkTxt->where("status=1")->select();
		//$linkImgList=$linkTxt->where("status=1 and img<>''")->select();
		$this->assign('linktxt',$linkTxtList);		
		//$this->assign('linkimg',$linkImgList);	
			




		//banner跳动的总数
		$allCount = M('download')->where(" state=1")->count();
		$this->assign('dataNum',$allCount);

		
		//分类目录
		$childCatalogList = $catalog->limit('6')->where('status=1 and pid=0')->order('sort_order desc')->select();
		$this->assign('childCatalogList',$childCatalogList);
		//最近点赞
		$commGoodlist=M('article')->limit('6')->where(" status=1 ")->order('approval desc')->select();
		$this->assign('commGoodlist',$commGoodlist);	
			
		
	}
	
	//空操作
	public function _empty(){
		$this->redirect(__ROOT__);
	}

	//解释一下，栏目表category中的catid为栏目id，catname为栏目名称，asmenu为栏目父级的id，当为顶级栏目时，asmenu为0 。
	public function now_here($catid,$ext=''){
	 $cat = M("article_cate");
	 $here = '';
	 $uplevels = $cat->field("id,name,pid")->where("id=$catid")->find();
	 if($uplevels['pid'] != 0)
		$here .= $this->get_up_levels($uplevels['pid']);
	 $here .= ' -> <a href="'.reurl($catid,'article').'">'.$uplevels['name']."</a>";
	 if($ext != '') $here .= ' -> '.$ext;
	 return $here;
	}
	protected function get_up_levels($id){
	 $cat = M("catalog");
	 $here = '';
	 $uplevels = $cat->field("id,name,pid")->where("id=$id")->find();
	  $here .= ' -> <a href="'.reurl($id,'article').'">'.$uplevels['name']."</a>";
	 if($uplevels['pid'] != 0){
	  $here = $this->get_up_levels($uplevels['pid']).$here;
	 }
	 return $here;
	}
	
	
	public function now_download_here($catid,$ext=''){
	 $catalog_mod = M("catalog");
	 $here = '';
	 $data = $catalog_mod->field("id,name,pid")->where("id=$catid")->find();
	 if($data['pid'] != 0)
		$here .= $this->get_download_up_levels($data['pid']);
	 $here .= ' -> <a href="'.reurl($catid,"downloadlist").'">'.$data['name']."</a>";
	 if($ext != '') $here .= ' -> '.$ext;
	 return $here;
	}
	protected function get_download_up_levels($id){
	 $cat = M("catalog");
	 $here = '';
	 $uplevels = $cat->field("id,name,pid")->where("id=$id")->find();
	  $here .= ' -> <a href="'.reurl($id,"downloadlist").'">'.$uplevels['name']."</a>";
	 if($uplevels['parentid'] != 0){
	  $here = $this->get_up_levels($uplevels['parentid']).$here;
	 }
	 return $here;
	}
		
}
