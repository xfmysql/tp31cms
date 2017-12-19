<?php  
/**
 * 前台登陆注册
 * @author  <[l@easycms.cc]>
 */
class LoginAction extends CommonAction {
	//空操作
	public function _empty(){
		$this->redirect("Index/Index/index");
	}

	Public function _initialize(){
   		
	}
	

	public function index(){
		 if(empty($_COOKIE['username'])||empty($_COOKIE['password'])){//如果session为空，并且用户没有选择记录登录状
			$this->assign('set',$this->setting);
			$this->display('login');
		  }else{//用户选择了记住登录状态
			$User = M("member_user");
			$where['username']=$_COOKIE['username'];
			$where['password']=$_COOKIE['password'];
			$result =$User->where($where)->find();
			
			if(!empty($result)){//用户名密码不对没到取到信息，转到登录页面	
					
				$_SESSION['_USERNAME']=$result['username'];
				setcookie("username",$_COOKIE['username'],time()+3600*24*30); 
				setcookie("password",$_COOKIE['password'],time()+3600*24*30);	
				$this->success('登陆成功',U('Index/index'));
			}else{
				$this->assign('set',$this->setting);
				$this->display('login');
			}
		 }
	}
	public function checkLogin(){
		if($_SESSION["verify"]!=md5($_POST['code'])){
			$this->error("验证码错误");
		}
		$User = M("member_user"); 
		if (!$User->create()){
			 $this->error(($User->getError()));
		}else{
			$name=$User->create();
			$where['username']=strtolower($name['username']);
			$where['password']=md5($name['password']);
			$result =$User->where($where)->find();
			if($result['islock']==1){
				$this->error('您的账号已经被管理锁定，请联系管理员',U('Login/index'));
			}
			if($result!=null){
				$_SESSION['_USERNAME']=$result['username'];
				$isremember=$_POST['isremember'];//是否自动登录标示
				if(!empty($isremember)){//如果用户选择了，记录登录状态就把用户名和加了密的密码放到cookie里面
				   setcookie("username",$_SESSION['_USERNAME'],time()+3600*24*30); 
				   setcookie("password",md5($name['password']),time()+3600*24*30);
				}				
				$catalog_mod = M('catalog');
				$catalog = $catalog_mod->where("managerid='".$result["username"]."'")->find();
				
				$this->success('登陆成功',U('Index/index'));
			}else{
				$this->error('登陆失败',U('Login/index'));
			}
		}
	}

public function checkreg(){
		$this->display('checkreg');
}
public function checkregs(){
	if($_SESSION["verify"]!=md5($_POST['code'])){
			$this->error("验证码错误");
		}
		$User = D("member_user"); 
		$result=$User->create();	
		$result['password'] = md5($result['password']);
		if (!$result){
			 $this->error($User->getError());
		}else{
			$addresult= $User->add($result);
			if($addresult>0){
				$_SESSION['_USERNAME']=$result['username'];
				$_SESSION['_USERID']=$addresult;
				$this->success('注册成功',$_POST['redirect_to']);
			}else{
				$this->error('注册失败',U('Login/index'));

			}
		}
}

public function verify(){
		import('ORG.Util.Image');
		 ob_clean();  
		Image::buildImageVerify();
	}	

public function doLogout(){
		//清除前台的服务端的session值
		unset($_SESSION['_USERNAME']);
		setcookie("username", '');
		setcookie("password", '');
		$this->success('退出成功',U('Index/Index/index'));
	}

public function checkName(){
			$username=$_GET['username'];
			$user=M('Member_user');
			$where['username']=$username;
			$count=$user->where($where)->count();
			if($count){
				echo '不允许';
			}else{
				echo '允许';
			}
		}

}
