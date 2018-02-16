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
   		$page=new Page($count,20);
   		$page->setConfig('theme', '<li class="am-pagination-prev">%upPage%</li>
   			<li class="am-pagination-prev">%prePage%</li><li class="am-pagination-next">%nextPage%</li>
   			<li>%linkPage%</li><li class="am-pagination-next">%downPage%</li>
   			<li class="am-pagination-next">%end%</li>');
		//$page->setConfig('link',U("Index/List/index",'catsid='.$catsid.'&p='.__PAGE__));//分页变量名是p
		
		$page->setConfig('link',"/list-".$catsid."-".__PAGE__.".html");//分页变量名是p

   		$show=$page->show();//返回分页信息
		$articles=M('article')->where("pid in(select id from cms_catalog where id=$catsid or pid=$catsid) and status=1")->
		order('addtime desc')->limit($page->firstRow.','.$page->listRows)->select();
		$this->assign('show',$show);
		$this->assign('count',$count);
		$this->assign('list',$articles);
		
		

		//面包屑
		$this->assign('bread',$this->now_here($catsid));

		
		$this->display('list');
		
	}	
	
}