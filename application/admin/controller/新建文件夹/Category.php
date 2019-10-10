<?php
namespace app\admin\controller;

use think\Controller;
use think\Session;
use think\Request;
use app\admin\model\CategoryModel;

class Category extends Common
{
	/**
	 * 药品分类列表
	 */
	public function index()
	{
		$CategoryModel = new CategoryModel();
		$list = $CategoryModel->getcategory();
		if($list){
			$page = $list->render();
			$this->assign('page',$page);
		}
		$this->assign('list',$list);
		return $this->fetch();
	}

	/**
	 * 添加药品分类
	 */
	public function add()
	{
		return $this->fetch();
	}

	/**
	 * 添加药品分类
	 */
	public function addPost()
	{
		$data = $this->request->param();
		$CategoryModel = new CategoryModel();
		$list = $CategoryModel->addcategory($data);
		if($list){
			return returnJson($code=1,$msg="添加成功",$list);
		}else{
			return returnJson($code=2,$msg="添加失败",$list);
		}
	}

	/**
	 * 修改药品分类
	 */
	public function edit()
	{
		$data = $this->request->param();
		$CategoryModel = new CategoryModel();
		$list = $CategoryModel->getonecate($data['id']);
		$this->assign('list',$list);
		return $this->fetch();
	}

	/**
	 * 修改药品分类提交
	 */
	public function editPost()
	{
		$data = $this->request->param();
		$CategoryModel = new CategoryModel();
		$list = $CategoryModel->editcategory($data['id'],$data);
		if($list){
			return returnJson($code=1,$msg="修改成功",$list);
		}else{
			return returnJson($code=2,$msg="修改失败",$list);
		}
	}

	/**
	 * 删除药品分类
	 */
	public function deletecate()
	{
		$data = $this->request->param();
		$CategoryModel = new CategoryModel();
		$list = $CategoryModel->deletecate($data['id']);
		if($list){
			return returnJson($code=1,$msg="删除成功",$list);
		}else{
			return returnJson($code=2,$msg="删除失败",$list);
		}
	}
}