<?php
namespace app\admin\controller;

use think\Controller;
use think\Session;
use think\Request;
use think\Config;
use app\admin\model\AdminmenuModel;

class Adminmenu extends Common
{
	/**
	*	菜单列表
	*/
	public function index()
	{
		$AdminmenuModel = new AdminmenuModel();
		$menu = $AdminmenuModel->getmenu();
		$this->assign('list',$menu);
		return $this->fetch();
	}

	/**
	*	添加菜单
	*/
	public function add()
	{
		$AdminmenuModel = new AdminmenuModel();
		$menu = $AdminmenuModel->getmenu();
		$this->assign('menu',$menu);
		return $this->fetch();
	}

	/**
	*	添加菜单提交
	*/
	public function addPost()
	{
		if($this->request->isPost()){
			$data = $this->request->param();
	        $AdminmenuModel = new AdminmenuModel();
	        $list = $AdminmenuModel->addMenu($data);
			if($list){
				$this->success('添加成功');
			}else{
				$this->error('添加失败');
			}
		}
	}

	/**
	*	修改菜单
	*/
	public function edit()
	{
		$data = $this->request->param();
		$AdminmenuModel = new AdminmenuModel();
		$list = $AdminmenuModel->getone($data['id']);
		$menu = $AdminmenuModel->getmenu();
		$this->assign('menu',$menu);
		$this->assign('list',$list);
		return $this->fetch();
	}

	/**
	*	修改菜单提交
	*/
	public function editPost()
	{
		if($this->request->isPost()){
			$data = $this->request->param();
	        $AdminmenuModel = new AdminmenuModel();
	        $list = $AdminmenuModel->editMenu($data['id'],$data);
			$this->success('修改成功');
		}
	}

	/**
	*	删除菜单
	*/
	public function delete()
	{
		$data = $this->request->param();
		$AdminmenuModel = new AdminmenuModel();
		$list = $AdminmenuModel->deleteMenu($data['id']);
		if($list == 2){
			$this->error('该分类下有子类，不能删除！',url('index'));
		}elseif($list){
			$this->success('删除成功',url('index'));
		}else{
			$this->error('删除失败',url('index'));
		}
	}

}
