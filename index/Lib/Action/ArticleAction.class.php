<?php
/**
* 前台文章发布
* @author  <[c@easycms.cc]>
*/
class ArticleAction extends CommonAction
{
	
	Public function index(){
		$article_id=I('id','','intval');		
		$this->assign('set',$this->setting);		
		$article=M('Article')->where("id=".$article_id)->find();		
		if(!empty($article)){
			M('Article')->execute("update __TABLE__  set clicks=clicks+1 where id=$article_id");
		}else{
			header("HTTP/1.1 404 Not Found");
			exit();
		}
		$this->assign('article',$article);//文章		
		$cate = D('catalog')->where("id=".$article['pid'])->find();
		$this->assign('cate',$cate);//分类
		
		//上一篇下一篇
		$prearticle=M('Article')->where(" pid=".$article['pid']." and status=1 and id<".$article_id)->find();	
		$nextarticle=M('Article')->where(" pid=".$article['pid']." and status=1 and id>".$article_id)->find();	
		$this->assign('prearticle',$prearticle);
		$this->assign('nextarticle',$nextarticle);
		//面包屑
		$this->assign('bread',$this->now_here($article['pid'],$article['title']));

		$tabinfo_mod = D('tabinfo');
		$sql = 'select t.*  from cms_tabinfo t join cms_tabrelation r on t.id=r.attributeid where r.articleid='.$article_id.' order by r.id asc,r.addtime asc';
		$tabinfo_list = $tabinfo_mod->query($sql);
		$this->assign('tabinfos',$tabinfo_list);


		$keyword_mod = D('keyword');
		$sql = 'select t.*  from cms_keyword t join cms_keywordrelation r on t.id=r.attributeid where r.articleid='.$article_id.' order by r.id asc,r.addtime asc';
		$keyword_list = $keyword_mod->query($sql);
		$this->assign('keywords',$keyword_list);
		foreach ($keyword_list as $key => $value) {
			$seokeywords.=$value["name"].",";
		}
		$this->assign('seokeywords',$seokeywords);

		$article_mod = D('article');
		//推荐文章 istop
		$topList=$article_mod->limit('6')->where(" (pubtime is null or pubtime<CURRENT_TIMESTAMP()) and  status=1 and istop=1 and pid=".$article['pid'])->order('pubtime desc')->select();
		$this->assign('topList',$topList);	
		//热门文章 hotList
		$hotList=$article_mod->limit('6')->where(" (pubtime is null or pubtime<CURRENT_TIMESTAMP()) and status=1 and pid=".$article['pid'])->order('clicks desc')->select();	
		$this->assign('hotList',$hotList);
		//最新文章
		$newList=$article_mod->limit('6')->where(" (pubtime is null or pubtime<CURRENT_TIMESTAMP()) and status=1 and pid=".$article['pid'])->order('pubtime desc')->select();	
		$this->assign('newList',$newList);
		//相关阅读
		$likeList=$article_mod->limit('6')->where(" (pubtime is null or pubtime<CURRENT_TIMESTAMP()) and status=1 and pid=".$article['pid'])->order('addtime desc')->select();	
		$this->assign('likeList',$likeList);

		$this->display('article');
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