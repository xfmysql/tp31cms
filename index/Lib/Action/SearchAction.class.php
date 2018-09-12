<?php
/**
* 前台搜索
* @author  <[s@easycms.cc]>
*/
class SearchAction extends CommonAction
{
	Public function index(){
		
		$this->assign('set',$this->setting);
		$put=I('q');
		if(trim($put)==''){
			$this->error('搜索内容不能为空！');
			die;
		}
		$where['title'] = array('like','%'.$put.'%');
		$where['info'] = array('like','%'.$put.'%');
		$where['status'] = 1;
		
		

		$count=M('article')->where("(pubtime is null or pubtime<CURRENT_TIMESTAMP()) ")->where($where)->count();
		import('ORG.Util.Page');
		$page=new page($count,10);		
		
		$page->setConfig('theme', '<li class="am-pagination-prev">%upPage%</li>
   			<li class="am-pagination-prev">%prePage%</li><li class="am-pagination-next">%nextPage%</li>
   			<li>%linkPage%</li><li class="am-pagination-next">%downPage%</li>
   			<li class="am-pagination-next">%end%</li>');

		//$page->setConfig('link','list-'.$catsid.'-__PAGE__.'.C('URL_HTML_SUFFIX'));
		$page->setConfig('link','/index.php?m=search&a=index&q='.$put.'&p=__PAGE__.');
		
   		$show=$page->show();//返回分页信息
		$article=M('article')->where("(pubtime is null or pubtime<CURRENT_TIMESTAMP()) ")->where($where)->order('id desc')->limit($page->firstRow.','.$page->listRows)->select();
		
		$this->assign('put',$put);
		$this->assign('show',$show);//分页信息
		$this->assign('count',$count);//数据总数
		$this->assign('list',$article);//数据集
		$this->display('search');
		
	}
	
}