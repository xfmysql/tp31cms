<?php
/**
* 前台软件发布
* @author  <[c@easycms.cc]>
*/
class DownloadAction extends CommonAction
{
	
	Public function index(){				
		$this->assign('set',$this->setting);		
		
		$id=I('id','','intval');	
		$article = M('download')->where("id=".$id)->find();		
		if(!empty($article)){
			M('download')->execute("update __TABLE__  set clicks=clicks+1 where id=$id");
		}else{
			header("HTTP/1.1 404 Not Found");
			exit();
		}
		$this->assign('article',$article);
		$download_relation = D('projectrelation');
		$downrelationlist = $download_relation->where('articleid='.$id)->select();
		$download_info["project"] = $downrelationlist;

		//$catalog = D('catalog')->where("state=1 and id=".$article['catalogid'])->find();
		//$this->assign('catalog',$catalog);	

		//$project = D('project')->where("state=1 and id=".$article['projectid'])->find();
		//$this->assign('project',$project);

		//$language = D('language')->where("id=".$article['languageid'])->find();
		//$this->assign('language',$language);
		//down list
		$softlist=M('download_url')->limit(10)->where(" id=".$article['id'])->order('downloads desc')->select();
		$this->assign('softlist',$softlist);//分类
		
		//同类最新
		$newlist=M('download')->limit(5)->where(" catalogid=".$article['catalogid']." and state=1 and id<>".$article['id'])->order('addtime desc')->select();
		$this->assign('newlist',$newlist);
		//排行
		$clickslist=M('download')->limit(5)->where(" catalogid=".$article['catalogid']." and state=1 and id<>".$article['id'])->order('clicks desc')->select();
		$this->assign('clickslist',$clickslist);
		//行业
		$project_mod = D('project');
		$projectlist = $project_mod->where(" id in(select attributeid from cms_projectrelation where articleid=".$article['catalogid'].")")->order('addtime ASC')->select();
		$this->assign('projectlist',$projectlist);
		

//上一篇下一篇
		$prearticle=M('download')->where(" catalogid=".$article['catalogid']." and state=1 and id<".$$id)->find();	
		$nextarticle=M('download')->where(" catalogid=".$article['catalogid']." and state=1 and id>".$$id)->find();	
		$this->assign('prearticle',$prearticle);
		$this->assign('nextarticle',$nextarticle);
//面包屑
		$this->assign('bread',$this->now_download_here($article['catalogid'],$article['title']));
		$this->display('download');//
	}

	public function addComment(){
		if($_SESSION["_USERID"]){
			//对回复速度进行判断
			$aid=I('aid','','intval');
			$uid=$_SESSION["_USERID"];
			$lastPubtime=M('Comment')->where("uid=$uid and aid=$aid")->order('commend_id desc')->
			limit('1')->getField('pubtime');
			if(time()-$lastPubtime<30){
				echo '发帖太快，请30秒后再发布';
				die;
			}
			$comment= I('comment');
			if($comment==''){
				echo '评论不能为空';
				die;
			}
			//更新推荐和反对的数量
			$proposal=I('proposal','','intval');
			if($proposal){
				M('Article')->execute("update __TABLE__  set approval=approval+1 where article_id=$aid");
			}else{
				M('Article')->execute("update __TABLE__  set opposition=opposition+1 where article_id=$aid");
			}
			$data['uid']=$uid;
			$data['aid']=$aid;
			$data['pubtime']=time();
			$data['islock']=0;
			$data['content']=htmlspecialchars($comment);
			$m=M('Comment')->add($data);
			if($m){
				echo '评论成功';
				die;
			}else{
				echo '评论失败';
				die;
			}
		}else{
			echo '请登陆后评论';
			die;
		}
	}

	public function addzan(){
		$aid=I('aid','','intval');			
		$is=isset($_COOKIE['YOUR_ZAN']);		
		$proposal=I('proposal','','intval');		
		if($is) {
			if($proposal) die('你已经投过了');
			else die('你已经踩过了');
		}
		else {
			setcookie('YOUR_ZAN','1',time()+864000);
			$is=isset($_COOKIE['YOUR_ZAN']);
			if($proposal){//更新推荐和反对的数量
				M('Article')->execute("update __TABLE__  set approval=approval+1 where id=$aid");
				$count=M('Article')->where("id=".$aid)->getField('approval');
				die($count);					
			}else{
				M('Article')->execute("update __TABLE__  set opposition=opposition+1 where id=$aid");
				$count=M('Article')->where("id=".$aid)->getField('opposition');
				die($count);	
			}
		}
	}

	public function checkuser(){
		if (isset($_SESSION['username'])) {
			echo '	 <li><a>'.$_SESSION['username'].'</a></li>
         			 <li><a href="'.U('Member/person/index').'" style="color:red">个人中心</a></li>
         			 <li><a href="'.U('Index/login/doLogout').'">退出</a></li>';
		}else{
			echo '	 <li><a href="'.U('Index/Login/checkreg').'">注册</a></li>
        			 <li><a href="'.U('Index/Login/index').'">登陆</a></li>';
		}
	}
}
?>