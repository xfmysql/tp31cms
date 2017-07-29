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
			$downloadList=M('download')->limit('12')->where(" state=1 and catalogid=".$value['id'])->order('addtime desc')->select();
			$hotCatalogList[$key]['child'] = $downloadList;

			$clicks = M('download')->where(" state=1 and catalogid=".$value['id'])->sum('clicks');
			$downs = M('download')->where(" state=1 and catalogid=".$value['id'])->sum('downloads');
			$hotCatalogList[$key]['clicks'] = $clicks;
			$hotCatalogList[$key]['downs'] = $downs;
			
		}
		$this->assign('hotCatalogList',$hotCatalogList);
		
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
