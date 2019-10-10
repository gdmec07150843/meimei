<?php
namespace app\admin\controller;

use think\Controller;
use think\Session;
use think\Request;
use think\Config;
use think\Db;
use app\admin\model\FlashModel;

class Flash extends Common
{
	/**
	 * 轮播图列表
	 */
	public function index()
	{
		$data = $this->request->param();
		$FlashModel = new FlashModel();
		$list = $FlashModel->getFlash($data);
		$page = $list->render();
		$this->assign('page',$page);
		$this->assign('list',$list);
		$this->assign('status',isset($data['status'])?$data['status']:'');
		return $this->fetch();
	}

	/**
	 * 添加轮播图
	 */
	public function add()
	{
		return $this->fetch();
	}

	/**
	 * 添加轮播图提交
	 */
	public function addPost()
	{
		$data = $this->request->param();
		$FlashModel = new FlashModel();
		$list = $FlashModel->addPost($data);
		if($list){
			return returnJson($code=1,$msg="添加成功",$list);
		}else{
			return returnJson($code=2,$msg="添加失败",$list);
		}
	}

	/**
	 * 修改轮播图
	 */
	public function edit()
	{
		$data = $this->request->param();
		$FlashModel = new FlashModel();
		$list = $FlashModel->getone($data['id']);
		$this->assign('list',$list);
		return $this->fetch();
	}

	/**
	 * 修改轮播图提交
	 */
	public function editPost()
	{
		$data = $this->request->param();
		$FlashModel = new FlashModel();
		$list = $FlashModel->editPost($data['id'],$data);
		if($list){
			return returnJson($code=1,$msg="修改成功",$list);
		}else{
			return returnJson($code=2,$msg="修改失败",$list);
		}
	}

	/**
	 * 修改轮播图状态(多个)
	 */
	public function editflashsstatus()
	{
		$data = $this->request->param();
		$FlashModel = new FlashModel();
		$list = $FlashModel->editflashsstatus($data['ids'],$data);
		if($list){
			return returnJson($code=1,$msg="删除成功",$list);
		}else{
			return returnJson($code=2,$msg="删除失败",$list);
		}
	}

	/**
	 * 删除轮播图
	 */
	public function deleteflashone()
	{
		$data = $this->request->param();
		$FlashModel = new FlashModel();
		$list = $FlashModel->deleteflashone($data['id']);
		if($list){
			return returnJson($code=1,$msg="删除成功",$list);
		}else{
			return returnJson($code=2,$msg="删除失败",$list);
		}
	}

	/**
	 * 删除轮播图(多个)
	 */
	public function deleteflash()
	{
		$data = $this->request->param();
		$FlashModel = new FlashModel();
		$list = $FlashModel->deleteflash($data['ids']);
		if($list){
			return returnJson($code=1,$msg="删除成功",$list);
		}else{
			return returnJson($code=2,$msg="删除失败",$list);
		}
	}
}