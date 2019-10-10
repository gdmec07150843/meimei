<?php
namespace app\admin\controller;

use think\Controller;
use think\Session;
use think\Request;
use think\Config;
use think\Db;
use app\admin\model\GoodsModel;

class Goods extends Common
{
	/**
	 * 商品列表
	 */
	public function index()
	{
		$data = $this->request->param();
		$GoodsModel = new GoodsModel();
		$category = $GoodsModel->getcategory();
		$this->assign('category',$category);
		$list = $GoodsModel->getgoods($data);
		$this->assign('list',$list['list']);
		$this->assign('page',$list['page']);
		$this->assign('cid',isset($data['cid']) ? $data['cid'] : '');
		$this->assign('g_name',isset($data['g_name']) ? $data['g_name'] : '');
		$this->assign('g_status',isset($data['g_status']) ? $data['g_status'] : '');
		return $this->fetch();
	}

	/**
	 * 商品规格列表
	 */
	public function goodsinfo()
	{
		$data = $this->request->param();
		$GoodsModel = new GoodsModel();
		$list = $GoodsModel->getgoodsinfo($data['gid']);
		$goods = $GoodsModel->getonegoods($data['gid']);
		$this->assign('list',$list);
		$this->assign('goods',$goods);
		return $this->fetch();
	}

	/**
	 * 添加商品
	 */
	public function add()
	{
		$GoodsModel = new GoodsModel();
		$category = $GoodsModel->getcategory();
		$this->assign('category',$category);
		return $this->fetch();
	}

	/**
	 * 添加商品
	 */
	public function addPost()
	{
		$data = $this->request->param();
		$GoodsModel = new GoodsModel();
		$list = $GoodsModel->addgoods($data);
		if($list){
			return returnJson($code=1,$msg="添加成功",$list);
		}else{
			return returnJson($code=2,$msg="添加失败",$list);
		}
	}

	/**
	 * 修改商品
	 */
	public function edit()
	{
		$data = $this->request->param();
		$GoodsModel = new GoodsModel();
		$category = $GoodsModel->getcategory();
		$this->assign('category',$category);
		$list = $GoodsModel->getonegoods($data['id']);
		$post = [];
		//把pc中的图片json转为数组
		$post = json_decode($list['g_pic'],true);
		$this->assign('post',$post);
		$this->assign('list',$list);
		$this->assign('image',$list['g_pic']);
		return $this->fetch();
	}

	/**
	 * 修改商品提交
	 */
	public function editPost()
	{
		$data = $this->request->param();
		$GoodsModel = new GoodsModel();
		$list = $GoodsModel->editgoods($data['id'],$data);
		if($list){
			return returnJson($code=1,$msg="修改成功",$list);
		}else{
			return returnJson($code=2,$msg="修改失败",$list);
		}
	}

	/**
	 * 删除商品
	 */
	public function deletegoods()
	{
		$data = $this->request->param();
		$GoodsModel = new GoodsModel();
		$list = $GoodsModel->deletegoods($data['id']);
		if($list){
			return returnJson($code=1,$msg="删除成功",$list);
		}else{
			return returnJson($code=2,$msg="删除失败",$list);
		}
	}

	/**
	 * 删除商品(多个)
	 */
	public function deletesgoods()
	{
		$data = $this->request->param();
		$GoodsModel = new GoodsModel();
		$list = $GoodsModel->deletesgoods($data['ids']);
		if($list){
			return returnJson($code=1,$msg="删除成功",$list);
		}else{
			return returnJson($code=2,$msg="删除失败",$list);
		}
	}

	/**
	 * 修改用户状态(多个)
	 */
	public function checkStatus()
	{
		$data = $this->request->param();
		$GoodsModel = new GoodsModel();
		$list = $GoodsModel->checkStatus($data['ids'],$data);
		if($list){
			return returnJson($code=1,$msg="修改成功",$list);
		}else{
			return returnJson($code=2,$msg="修改失败",$list);
		}
	}

	/**
	 * 修改商品是否是新品(多个)
	 */
	public function checkNgoods()
	{
		$data = $this->request->param();
		$GoodsModel = new GoodsModel();
		$list = $GoodsModel->checkNgoods($data['ids'],$data);
		if($list){
			return returnJson($code=1,$msg="修改成功",$list);
		}else{
			return returnJson($code=2,$msg="修改失败",$list);
		}
	}

	/**
	 * 修改商品类型(多个)
	 */
	public function checkGtype()
	{
		$data = $this->request->param();
		$GoodsModel = new GoodsModel();
		$list = $GoodsModel->checkGtype($data['ids'],$data);
		if($list){
			return returnJson($code=1,$msg="修改成功",$list);
		}else{
			return returnJson($code=2,$msg="修改失败",$list);
		}
	}

	/**
	 * 设置为活动促销(多个)
	 */
	public function checkGactivity()
	{
		$data = $this->request->param();
		$GoodsModel = new GoodsModel();
		$list = $GoodsModel->checkGactivity($data['ids'],$data);
		if($list){
			return returnJson($code=1,$msg="修改成功",$list);
		}else{
			return returnJson($code=2,$msg="修改失败",$list);
		}
	}
	
}