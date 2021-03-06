<?php 
/**
* 前台2级列表页
* @author  <[c@easycms.cc]>
*/
class TabinfoAction extends CommonAction
{
	Public function index(){
		$tabid=I('id','','intval');
		$this->assign('d',$catsid);
		$tabinfo=M('tabinfo')->find($tabid);
		$this->assign('tabinfo',$tabinfo);
		$this->assign('set',$this->setting);
		//数据分页
		import('ORG.Util.Page');// 导入分页类
		if(C("DEFAULT_THEME")=='amazeuipet'){
			$sql="state=1 and id in(select downid from cms_tabrelation where attributeid=$tabid) ";
	   		$count=M('download')->where($sql)->count();//获取数据的总
	   		
	   		$page=new Page($count,20);
	   		$page->setConfig('theme', '<li class="am-pagination-prev">%upPage%</li>
	   			<li class="am-pagination-prev">%prePage%</li><li class="am-pagination-next">%nextPage%</li>
	   			<li>%linkPage%</li><li class="am-pagination-next">%downPage%</li>
	   			<li class="am-pagination-next">%end%</li>');
			//$page->setConfig('link',U("Index/List/index",'catsid='.$catsid.'&p='.__PAGE__));//分页变量名是p
			
			$page->setConfig('link',"/tab-".$catsid."-".__PAGE__.".html");//分页变量名是p

	   		$show=$page->show();
			$articles=M('download')->where($sql)->order('id desc')->limit($page->firstRow.','.$page->listRows)->select();

		}else {
			$sql="(pubtime is null or pubtime<CURRENT_TIMESTAMP() ) and id in(select articleid from cms_tabrelation where attributeid=$tabid) and status=1";
	   		$count=M('article')->where($sql)->count();//获取数据的总
	   		$page=new Page($count,20);
	   		$page->setConfig('theme', '<li class="am-pagination-prev">%upPage%</li>
	   			<li class="am-pagination-prev">%prePage%</li><li class="am-pagination-next">%nextPage%</li>
	   			<li>%linkPage%</li><li class="am-pagination-next">%downPage%</li>
	   			<li class="am-pagination-next">%end%</li>');
			//$page->setConfig('link',U("Index/List/index",'catsid='.$catsid.'&p='.__PAGE__));//分页变量名是p
			
			$page->setConfig('link',"/list-".$catsid."-".__PAGE__.".html");//分页变量名是p

	   		$show=$page->show();//返回分页信息 pubtime<CURRENT_TIMESTAMP()  and
			$articles=M('article')->where($sql)->order('addtime desc')->limit($page->firstRow.','.$page->listRows)->select();

		}
		$this->assign('show',$show);
		$this->assign('count',$count);
		$this->assign('list',$articles);
		//面包屑
		$this->assign('bread',$this->now_here($tabid));		
		$this->display('list');
		
	}	
	
}