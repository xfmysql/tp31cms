<?php 
/**
* 前台2级列表页
* @author  <[c@easycms.cc]>
*/
class ListAction extends CommonAction
{
	Public function index(){
		$catsid=I('catsid','','intval');
		$this->assign('catsid',$catsid);
		$cats=M('catalog')->find($catsid);
		$this->assign('catName',$cats['name']);
		$this->assign('set',$this->setting);
		//数据分页
		import('ORG.Util.Page');// 导入分页类
		$sql =" (pubtime is null or pubtime<CURRENT_TIMESTAMP() ) and pid in(select id from cms_catalog where id=$catsid or pid=$catsid) and status=1";
   		$count=M('article')->where($sql)->count();//获取数据的总
   		$page=new Page($count,16);
   		$page->setConfig('theme', '<li class="am-pagination-prev">%upPage%</li>
   			<li class="am-pagination-prev">%prePage%</li><li class="am-pagination-next">%nextPage%</li>
   			<li>%linkPage%</li><li class="am-pagination-next">%downPage%</li>
   			<li class="am-pagination-next">%end%</li>');
		//$page->setConfig('link',U("Index/List/index",'catsid='.$catsid.'&p='.__PAGE__));//分页变量名是p
		
		$page->setConfig('link',"/list-".$catsid."-".__PAGE__.".html");//分页变量名是p

   		$show=$page->show();//返回分页信息
		$articles=M('article')->where($sql)->order('addtime desc')->limit($page->firstRow.','.$page->listRows)->select();
		$this->assign('catalog',$cats);
		$this->assign('show',$show);
		$this->assign('count',$count);
		$this->assign('list',$articles);	
		
		
		$article_mod = D('article');
		//推荐文章 
		$bestArticleList=$article_mod->limit('6')->where(" (pubtime is null or pubtime<CURRENT_TIMESTAMP()) and  status=1 and istop=1 and pid=".$catsid)->order('clicks desc')->select();
		$this->assign('bestArticleList',$bestArticleList);	
		//最新文章
		$newArticleList=$article_mod->limit('6')->where(" (pubtime is null or pubtime<CURRENT_TIMESTAMP()) and status=1 and pid=".$catsid)->order('addtime desc')->select();	
		$this->assign('newArticleList',$newArticleList);

		//面包屑
		$this->assign('bread',$this->now_here($catsid));
		
		$this->display('list');
		
	}	
	
}