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
		

		$count=M('article')->where($where)->count();
		import('ORG.Util.Page');
		$page=new page($count,20);		
		
		$page->setConfig('theme', '<nav class="navigation pagination" role="navigation"><div class="nav-links"><span class="prev">%upPage%</span><span>%downPage%</span><span>%prePage%</span> <span class="pages">第</span>%linkPage%<span class="pages">页</span><span class="next">%nextPage%</span><span>%end%</span></ul>');
		//$page->setConfig('link','list-'.$catsid.'-__PAGE__.'.C('URL_HTML_SUFFIX'));
		$page->setConfig('link','/index.php?m=search&a=index&q='.$put.'&p=__PAGE__.');
		
   		$show=$page->show();//返回分页信息
		$article=M('article')->where($where)->order('id desc')->limit($page->firstRow.','.$page->listRows)->select();
		
		$this->assign('put',$put);
		$this->assign('show',$show);//分页信息
		$this->assign('count',$count);//数据总数
		$this->assign('list',$article);//数据集
		$this->display('search');
		
	}
	
}