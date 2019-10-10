<?php
namespace app\admin\controller;

use think\Controller;
//引入Session类
use think\Session;
use think\Request;
use think\Validate;

class Common extends Controller
{
	/**
	 * 登录验证
	 */
	public function _initialize()
	{
		$admin_id = Session::get('admin_id');
		if(empty($admin_id)){
			$this->redirect("/admin/login/login");
			exit;
		}
	}

	/**
	 * 空操作
	 */
	public function _empty()
	{
		return $this->fetch('/index/404');
	}

}