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
   		$count=M('article')->where("pid in(select id from cms_catalog where id=$catsid or pid=$catsid) and status=1")->count();//获取数据的总
   		$page=new Page($count,3);
   		$page->setConfig('theme', '<nav class="navigation pagination" role="navigation"><div class="nav-links"><span class="prev">%upPage%</span><span>%downPage%</span><span>%prePage%</span> <span class="pages">第</span>%linkPage%<span class="pages">页</span><span class="next">%nextPage%</span><span>%end%</span></ul>');
		$page->setConfig('link',U("Index/List/index",'catsid='.$catsid.'&page='.__PAGE__));
		//$page->setConfig('link','list-'.$catsid.'-__PAGE__.'.C('URL_HTML_SUFFIX'));
   		$show=$page->show();//返回分页信息
		$articles=M('article')->where("pid in(select id from cms_catalog where id=$catsid or pid=$catsid) and status=1")->order('id desc')->limit($page->firstRow.','.$page->listRows)->select();
		$this->assign('show',$show);
		$this->assign('count',$count);
		$this->assign('list',$articles);
		
		

		//面包屑
		$this->assign('bread',$this->now_here($catsid));

		
		$this->display('list');
		
	}	
	
}