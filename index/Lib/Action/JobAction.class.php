<?php
/**
* 简历投递
* @author  <[c@easycms.cc]>
*/
class JobAction extends CommonAction
{
	
	
	Public function index(){
		
		echo I('get.catsid'); 

		$this->assign('set',$this->setting);
		$catsid=I('catsid','','intval');//分类
		$catalog = D('article_cate');
//查这个岗位
		$article=M('Article')->where("id=".$article_id)->find();
		$childCatalogs = $catalog->limit('10')->where('pid='.$catsid." or pid=(select pid from cms_article_cate where id=".$catsid." and pid<>0)")->select();		
		$this->assign('childCatalogs',$childCatalogs);

//网站导航
		$catalog = D('article_cate');
		$footNav = $catalog->where('pid=0 and status=1')->order('sort_order desc')->select();
		$this->assign('footNav',$footNav);

$this->display("job");

	}
	Public function add()
	{
		if ($_SESSION['verify'] != md5($_POST['verify']))
		{
			$this->error("verify code error");
			die;
		}
		$ResumeModel = D('resume');	
		$data = array();
		$data = $ResumeModel->create();
		
	    $name = isset($_POST['xingming']) && trim($_POST['xingming']) ? trim($_POST['xingming']) : $this->error('请输入姓名');
		$name = isset($_POST['xingming']) && trim($_POST['xingming']) ? trim($_POST['xingming']) : $this->error('请输入姓名');
		$name = isset($_POST['xingming']) && trim($_POST['xingming']) ? trim($_POST['xingming']) : $this->error('请输入姓名');
		$name = isset($_POST['xingming']) && trim($_POST['xingming']) ? trim($_POST['xingming']) : $this->error('请输入姓名');
		$name = isset($_POST['xingming']) && trim($_POST['xingming']) ? trim($_POST['xingming']) : $this->error('请输入姓名');
		$name = isset($_POST['xingming']) && trim($_POST['xingming']) ? trim($_POST['xingming']) : $this->error('请输入姓名');
		$name = isset($_POST['xingming']) && trim($_POST['xingming']) ? trim($_POST['xingming']) : $this->error('请输入姓名');

		$data['addtime']=date('Y-m-d H:i:s',time());
		$data['status']=1;//未读
		$result = $ResumeModel->add($data);
		$this->error('简历投递成功',U('job/index'));
		
	}

	//验证码
    public function verify(){
    	import("ORG.Util.Image");
        Image::buildImageVerify(4,1,'gif','50','24');
    }
}
?>