<?php
/**
* 前台首页
* @author  <[c@easycms.cc]>
*/
class IndexAction extends CommonAction
{ 
	Public function index(){
		$this->assign('set',$this->setting);
		//ad
		$ad_mod = D('ad');
		$adList = $ad_mod->limit('5')->where("  type='image'")->order('ordid ASC')->select();
		$this->assign('adList',$adList);	
		
		//显示推荐栏目 
		$hotCatalogList=M('catalog')->where('istuijian=1 and status=1')->order('sort asc')->select();
		foreach ($hotCatalogList as $key=>$value) {
			$archiveList=M('download')->limit('12')->where(" state=1 and catalogid=".$value['id'])->order('addtime desc')->select();
			$hotCatalogList[$key]['child'] = $archiveList;

			$clicks = M('download')->where(" state=1 and catalogid=".$value['id'])->sum('clicks');
			$hotCatalogList[$key]['clicks'] = $clicks;
			
		}
		$this->assign('hotCatalogList',$hotCatalogList);
		
		
		//$Model = M('article_cate');// join
		//$joinArticle= $Model->table('cms_article_cate c')->join('cms_article a on c.id = //a.cate_id')->field('a.*')->where('a.status=1')->order('a.add_time asc')->select();
		//print_r($joinArticle);
		
		//linkList
		$linkTxt=M('flink');
		$linkTxtList=$linkTxt->where("status=1 and img=''")->select();
		$linkImgList=$linkTxt->where("status=1 and img<>''")->select();
		$this->assign('linktxt',$linkTxtList);		
		$this->assign('linkimg',$linkImgList);	
		
	
		//显示模板	
		$this->display('index');
	}
	
}
