<?php 
/**
* 前台2级列表页
* @author  <[c@easycms.cc]>
*/
class AlbumnAction extends CommonAction
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

   			//</span><span>%downPage%</span><span>%prePage%</span> <span class="pages">第</span>%linkPage%<span class="pages">页</span><span class="next">%nextPage%</span><span>%end%</span></ul>
		$page->setConfig('link',U("Index/List/index",'catsid='.$catsid.'&p='.__PAGE__));//分页变量名是p
		
   		$show=$page->show();//返回分页信息
		$articles=M('article')->where("pid in(select id from cms_catalog where id=$catsid or pid=$catsid) and status=1")->
		order('id desc')->limit($page->firstRow.','.$page->listRows)->select();
		$this->assign('show',$show);
		$this->assign('count',$count);
		$this->assign('list',$articles);
		
		

		//面包屑
		$this->assign('bread',$this->now_here($catsid));
		//本人登录的栏目下的导航
		$catalogList=M('catalog')->where('isnav=1 and status=1 and pid='.$catsid)->order('sort asc')->select();
		foreach ($catalogList as $key=>$value) {
			$childList=M('catalog')->where('pid='.$value["id"])->order('sort asc')->select();
			$catalogList[$key]['childcount'] = count($childList);
			$catalogList[$key]['child'] = $childList;
		}
		$this->assign('catalogList',$catalogList);
		$this->display('list');


		
	}	
	
}