<?php
namespace app\admin\controller;

use think\Controller;
use think\Session;
use think\Request;
use app\admin\model\GoodSearchModel;

class Goodsearch extends Common
{
	/**
	 * 热门搜索列表
	 */
	public function index()
	{
		$GoodSearchModel = new GoodSearchModel();
		$list = $GoodSearchModel->getsearch();
		if($list){
			$page = $list->render();
			$this->assign('page',$page);
		}
		$this->assign('list',$list);
		return $this->fetch();
	}

	/**
	 * 添加热门搜索
	 */
	public function add()
	{
		return $this->fetch();
	}

	/**
	 * 添加热门搜索
	 */
	public function addPost()
	{
		$data = $this->request->param();
		$GoodSearchModel = new GoodSearchModel();
		$list = $GoodSearchModel->addsearch($data);
		if($list){
			return returnJson($code=1,$msg="添加成功",$list);
		}else{
			return returnJson($code=2,$msg="添加失败",$list);
		}
	}

	/**
	 * 修改热门搜索
	 */
	public function edit()
	{
		$data = $this->request->param();
		$GoodSearchModel = new GoodSearchModel();
		$list = $GoodSearchModel->getonecate($data['id']);
		$this->assign('list',$list);
		return $this->fetch();
	}

	/**
	 * 修改热门搜索提交
	 */
	public function editPost()
	{
		$data = $this->request->param();
		$GoodSearchModel = new GoodSearchModel();
		$list = $GoodSearchModel->editsearch($data['id'],$data);
		if($list){
			return returnJson($code=1,$msg="修改成功",$list);
		}else{
			return returnJson($code=2,$msg="修改失败",$list);
		}
	}

	/**
	 * 删除热门搜索
	 */
	public function deletecate()
	{
		$data = $this->request->param();
		$GoodSearchModel = new GoodSearchModel();
		$list = $GoodSearchModel->deletecate($data['id']);
		if($list){
			return returnJson($code=1,$msg="删除成功",$list);
		}else{
			return returnJson($code=2,$msg="删除失败",$list);
		}
	}
}