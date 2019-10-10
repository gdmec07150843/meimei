<?php
namespace app\admin\controller;
use think\Controller;
use think\Session;
use think\Request;
use think\Config;
use app\admin\model\AdminUserModel;

class Adminuser extends Common
{
	/**
	*	管理员列表
	*/
	public function index()
	{
		$data = $this->request->param();
		$AdminUserModel = new AdminUserModel();
		$list = $AdminUserModel->getAdminuser($data);
		if(!empty($list)){
			// 获取分页显示
	        $page = $list->render();
			$this->assign('list',$list);
			$this->assign('page', $page);
		}
		$this->assign('username',isset($data['username']) ? $data['username'] : '');
		$this->assign('status',isset($data['status']) ? $data['status'] : '');
		return $this->fetch();
	}

	/**
	*	添加管理员
	*/
	public function add()
	{
		return $this->fetch();
	}

	/**
	*	添加管理员
	*/
	public function addPost()
	{
		if($this->request->isPost()){
			$data = $this->request->param();
			$result = $this->validate($data, 'AdminUserValidate');
	        if ($result !== true) {
	            $this->error($result);
	        }

			$AdminUserModel = new AdminUserModel();
			$list = $AdminUserModel -> addAdminUser($data);
			if ($list === 2) {
				$this->error('该管理员已存在');
			}elseif ($list){
	        	$this->success('添加成功',url('index'));
	        }else{
	        	$this->error('添加失败',url('index'));
	        }
		}
	}

	/**
	*	修改管理员
	*/
	public function edit()
	{
		$data = $this->request->param();
		if($data){
			$AdminUserModel = new AdminUserModel();
			$list = $AdminUserModel->getAdminuserone($data['id']);
			if($list){
				$this->assign('list',$list);
			}
		}
		return $this->fetch();
	}

	/**
	*	修改管理员提交
	*/
	public function editPost()
	{
		if($this->request->isPost()){
			$data = $this->request->param();
			$AdminUserModel = new AdminUserModel();
			$list = $AdminUserModel->editAdminUser($data['id'],$data);
			$this->success('修改成功',url('index'));
		}
	}

	/**
	*	删除管理员
	*/
	public function delete()
	{
		$data = $this->request->param();
		$AdminUserModel = new AdminUserModel();
		$list = $AdminUserModel->deleteAdminUser($data['id']);
		if($list){
			$this->success('删除成功',url('index'));
		}else{
			$this->error('删除失败',url('index'));
		}
	}

	/**
	*	后台禁用管理员
	*/
	public function ban()
	{
		$data = $this->request->param();
		$AdminUserModel = new AdminUserModel();
		$list = $AdminUserModel->banAdminUser($data['id']);
		if ($list){
	    	$this->success('禁用成功',url('index'));
	    }else{
	    	$this->error('禁用失败');
	    }
	}

	/**
	*	启用管理员
	*/
	public function cancelBan()
	{
		$data = $this->request->param();
		$AdminUserModel = new AdminUserModel();
		$list = $AdminUserModel->cancelBanAdminUser($data['id']);
		if ($list){
	    	$this->success('启用成功',url('index'));
	    }else{
	    	$this->error('启用失败');
	    }
	}


	/**
	*	权限列表
	*/
	public function menu()
	{
		$data = $this->request->param();
		$AdminUserModel = new AdminUserModel();
		$list = $AdminUserModel->getmenu($data['id']);
		$adminuser = $AdminUserModel->getAdminuserone($data['id']);
		$this->assign('admin_id',$data['id']);
		$this->assign('list',$list);
		$this->assign('adminuser',$adminuser);
		return $this->fetch();
	}

	/**
	*	某个管理员的权限
	*/
	public function getadminmenu()
	{
		$data = $this->request->param();
		
		$AdminUserModel = new AdminUserModel();
		$list = $AdminUserModel->getadminmenu($data['admin_id']);
		if($list){
			return returnJson($code=0,$msg="获取成功",$list);
		}else{
			return returnJson($code=1,$msg="获取失败",$list);
		}
	}

	/**
	*	添加客户的权限项
	*/
	public function addadminmenu()
	{
		$data = $this->request->param();
		
		$AdminUserModel = new AdminUserModel();
		$list = $AdminUserModel->addadminmenu($data['menuids'],$data['admin_id']);
		if($list){
			return returnJson($code=0,$msg="修改成功",$list);
		}else{
			return returnJson($code=1,$msg="修改失败",$list);
		}
	}

}
