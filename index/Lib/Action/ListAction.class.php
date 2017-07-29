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
		$cats=M('article_cate')->find($catsid);
		$this->assign('catName',$cats['name']);
		$this->assign('set',$this->setting);
		//数据分页
		import('ORG.Util.Page');// 导入分页类
   		$count=M('article')->where("cate_id in(select id from cms_article_cate where id=$catsid or pid=$catsid) and status=1")->count();//获取数据的总
   		$page=new Page($count,20);
   		$page->setConfig('theme', '<nav class="navigation pagination" role="navigation"><div class="nav-links"><span class="prev">%upPage%</span><span>%downPage%</span><span>%prePage%</span> <span class="pages">第</span>%linkPage%<span class="pages">页</span><span class="next">%nextPage%</span><span>%end%</span></ul>');
		$page->setConfig('link','list-'.$catsid.'-__PAGE__.'.C('URL_HTML_SUFFIX'));
   		$show=$page->show();//返回分页信息
		$articles=M('article')->where("cate_id in(select id from cms_article_cate where id=$catsid or pid=$catsid) and status=1")->order('id desc')->limit($page->firstRow.','.$page->listRows)->select();
		$this->assign('show',$show);
		$this->assign('count',$count);
		$this->assign('list',$articles);
		
		
			
		//侧栏的数据分配
		$sidebar1=M('Article')->where("cate_id=$catsid and is_hot=1 and status=1 and img<>'' ")->order('id desc')->limit('5')->select();
		$sidebar2=M('Article')->where("cate_id=$catsid and is_hot=1 and status=1")->order('ordid desc')->limit('5')->select();
		//$sidebar3=M('Article')->where("cate_id=$catsid and is_hot=1 and status=1")->order('rand()')->limit('5')->select();
		$sidebar4=M('article_cate')->where("pid>0 and status=1 and isshow=1")->order('sort_order desc')->limit('10')->select();
		//赞多到少
		$this->assign('sidebar1',$sidebar1);
		//赞少到多
		$this->assign('sidebar2',$sidebar2);
		//随机5篇
		//$this->assign('sidebar3',$sidebar3);
		$this->assign('sidebar4',$sidebar4);

		//面包屑
		$this->assign('bread',$this->now_here($catsid));

		
		$this->display('list');
		
	}	
	
}