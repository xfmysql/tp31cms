<?php 
/**
* 前台2级列表页
* @author  <[c@easycms.cc]>
*/
class DownlistAction extends CommonAction
{
	Public function index(){
		$catsid=I('catsid','','intval');
		$this->assign('catsid',$catsid);
		$cats=M('catalog')->find($catsid);
		
		//数据分页
		import('ORG.Util.Page');// 导入分页类
		$sql = "";
		$bread = "";
		if(!isset($catsid) || $catsid==0){
			$sql = "state=1";
			$bread = "->分类";
			
		}
		else{
			$sql = "catalogid in(select id from cms_catalog where id=$catsid or pid=$catsid) and state=1";
			$bread = $this->now_download_here($catsid);
			//$catalog_name=$cats['name'];
		}
		
		
   		//数据分页
		import('ORG.Util.Page');// 导入分页类

		
		//获取数据的总
   		$count=M('download')->where($sql)->count();

   		$page=new Page($count,20);
		if($count>20){
			$page->setConfig('theme', '<span class="prev">%upPage%</span><span>%downPage%</span><span>%prePage%</span> <span class="pages">第</span>%linkPage%<span class="pages">页</span><span class="next">%nextPage%</span><span>%end%</span>');
			//'downlist-'.$catsid.'-__PAGE__.'.C('URL_HTML_SUFFIX'));
			$page->setConfig('link',U("Index/Downlist/index",array('catsid'=>$catsid)));
			$show=$page->show();//返回分页信息
			$this->assign('show',$show);
		}
		
		$downloadurl_mod = D('download_url');
		$downloads=M('download')->where($sql)->order('id desc')->limit($page->firstRow.','.$page->listRows)->select();
		
		foreach($downloads as $k=>$val){
			$downloads[$k]['durl'] = $downloadurl_mod->field('durl')->where('id='.$val['id'])->find();
		}
		$this->assign('set',$this->setting);
		$this->assign('list_catalog',$cats);
		$this->assign('count',$count);
		$clicks = M('download')->where(" state=1 and catalogid=".$catsid)->sum('clicks');
		$this->assign('clicks',$clicks);

		
		
		$this->assign('list',$downloads);		
		//面包屑
		$this->assign('bread',$bread);
		
		$this->display('downlist');
		
	}	
	
}