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
		
		//文章=ishomepage
		$articlelist=M('article')->limit(12)->where(" (pubtime is null or pubtime<CURRENT_TIMESTAMP()) and  status=1 and ishomepage=1 ")->order('addtime desc')->select();
		$this->assign('articlelist',$articlelist);	
			
		if(C("DEFAULT_THEME")=='amazeuipet'){
			//下载=显示ishomepage的下载栏目
			$downCatalogList=M('catalog')->where('ishomepage=1 and model=3 and status=1')->order('sort asc')->select();
			foreach ($downCatalogList as $key=>$value) {
				$downloadList=M('download')->limit('12')->where(" state=1 and catalogid=".$value['id'])->order('addtime desc')->select();
				$downCatalogList[$key]['child'] = $downloadList;

				$clicks = M('download')->where(" state=1 and catalogid=".$value['id'])->sum('clicks');
				$downs = M('download')->where(" state=1 and catalogid=".$value['id'])->sum('downloads');
				$downCatalogList[$key]['clicks'] = $clicks;
				$downCatalogList[$key]['downs'] = $downs;
				
			}
			$this->assign('downCatalogList',$downCatalogList);
			
			$newDownList=M('download')->limit('12')->where('state=1')->order('addtime desc')->select();
			$this->assign('newDownList',$newDownList);
			
		}else {
			
		}
		//join
		//$Model = M('article_cate');// join
		//$joinArticle= $Model->table('cms_article_cate c')->join('cms_article a on c.id = //a.cate_id')->field('a.*')->where('a.status=1')->order('a.add_time asc')->select();
		//print_r($joinArticle);
		
		//？？？不知道是什么
		//$articleCatalogList=M('catalog')->where('isnav=1 and status=1')->order('sort asc')->select();
		//foreach ($hotCatalogList as $key=>$value) {
			//$archiveList=M('download')->limit('12')->where(" state=1 and catalogid=".$value['id'])->order('addtime desc')->select();
			//$articleCatalogList[$key]['child'] = $archiveList;

			//$clicks = M('download')->where(" state=1 and catalogid=".$value['id'])->sum('clicks');
			//$articleCatalogList[$key]['clicks'] = $clicks;			
		//}
		//$this->assign('articleCatalogList',$articleCatalogList);
		
		$article = D('article');
		//推荐文章 
		$bestArticleList=$article->limit('6')->where(" (pubtime is null or pubtime<CURRENT_TIMESTAMP()) and  status=1 and istop=1")->order('clicks desc')->select();
			$this->assign('bestArticleList',$bestArticleList);	
		//最新文章
		$newArticleList=$article->limit('6')->where(" (pubtime is null or pubtime<CURRENT_TIMESTAMP()) and    status=1 ")->order('addtime desc')->select();	
		$this->assign('newArticleList',$newArticleList);

		//只要主页友情链接
		$linkTxt=M('flink');
		$linkTxtList=$linkTxt->where("status=1")->select();
		//$linkImgList=$linkTxt->where("status=1 and img<>''")->select();
		$this->assign('linktxt',$linkTxtList);		
		//$this->assign('linkimg',$linkImgList);	
		//显示模板	
		$this->display('index');
		
	}
	
}
