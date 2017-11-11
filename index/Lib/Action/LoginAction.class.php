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
   		// 控制器初始化方法
   		// 判断是否手机访问
   		if (ismobile()) {
            C('DEFAULT_THEME','mobile');
        }
	}


	public function index(){
		$this->assign('set',$this->setting);
		$this->display('login');
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
			$_SESSION['_USERID']=$result["user_id"];
			$catalog_mod = M('catalog');
			$catalog = $catalog_mod->where("managerid='".$result["username"]."'")->find();
			
			$this->success('登陆成功',U('Albumn/index',array('catsid'=>$catalog["id"])));
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
		if (!$result){
			 $this->error($User->getError());
		}else{
			$addresult=$User->where($result)->add();
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
		unset($_SESSION['_USERID']);
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
