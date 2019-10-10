<?php
namespace app\admin\controller;

use app\admin\model\LoginModel;
use think\Controller;
use think\Session;

class Login extends Controller
{
	/**
	*	后台获取登录页面
	*/
	public function login()
	{
		return $this->fetch('login/login');
	}

	/**
	*	后台管理员登录
	*/
	public function postCheck()
	{
		/*接收值*/
		$data = $this->request->param();
		$LoginModel = new LoginModel();
	    $list = $LoginModel->getAdminUser($data);
	    if($list === 0){
	    	// 登录成功
	    	return returnJson($code=1,$msg='登录成功',$list);
	    }elseif($list === 1){
	    	// 该账号已经被禁用
	    	return returnJson($code=1,$msg='该账号已经被禁用',$list);
	    }elseif($list === 2){
	    	//密码错误
	    	return returnJson($code=1,$msg='密码错误',$list);
	    }elseif($list === 3){
	    	//账号不存在
	    	return returnJson($code=1,$msg='账号不存在',$list);
	    }
	}

	/**
	*  注销
	*/ 
	public function logout()
	{
		Session::delete('admin_id');
		return redirect(url('/admin/login/login', [], false, true));
	}

}