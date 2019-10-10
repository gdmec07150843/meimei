<?php
namespace app\admin\controller;

use think\Controller;
use think\Session;
use think\Request;
use think\Config;
use think\Db;
use app\admin\model\OrderModel;

class Order extends Common
{
	/**
	 * 订单列表
	 */
	public function index()
	{
		$data = $this->request->param();
		$OrderModel = new OrderModel();
		$list = $OrderModel->getorders($data);
		if($list){
			$page = $list->render();
			$this->assign('page',$page);
		}
		$delivery = $OrderModel->getdelivery();
		$this->assign('delivery',$delivery);
		$this->assign('list',$list);
		$this->assign('order_number',isset($data['order_number'])?$data['order_number']:'');
		$this->assign('name',isset($data['name'])?$data['name']:'');
		$this->assign('phone',isset($data['phone'])?$data['phone']:'');
		$this->assign('order_status',isset($data['order_status'])?$data['order_status']:'');
		$this->assign('pay_type',isset($data['pay_type'])?$data['pay_type']:'');
		return $this->fetch();
	}

	/**
	 * 修改订单
	 */
	public function edit()
	{
		$data = $this->request->param();
		$OrderModel = new OrderModel();
		$list = $OrderModel->getoneorder($data['id']);
		$delivery = $OrderModel->getdelivery();
		$this->assign('list',$list);
		$this->assign('delivery',$delivery);
		return $this->fetch();
	}

	/**
	 * 修改订单信息
	 */
	public function editPost()
	{
		$data = $this->request->param();
		$OrderModel = new OrderModel();
		$list = $OrderModel->editPost($data['id'],$data);
		if($list){
			return returnJson($code=1,$msg="修改成功",$list);
		}else{
			return returnJson($code=1,$msg="修改失败",$list);
		}
	}

	/**
	 * 修改订单状态
	 */
	public function checkStatus()
	{
		$data = $this->request->param();
		$OrderModel = new OrderModel();
		$list = $OrderModel->checkStatus($data['ids'],$data);
		if($list){
			return returnJson($code=1,$msg="修改成功",$list);
		}else{
			return returnJson($code=2,$msg="修改失败",$list);
		}
	}

	/**
	 * 删除多个订单
	 */
	public function deletesorders()
	{
		$data = $this->request->param();
		$OrderModel = new OrderModel();
		$list = $OrderModel->deletesorders($data['ids']);
		if($list){
			return returnJson($code=1,$msg="修改成功",$list);
		}else{
			return returnJson($code=2,$msg="修改失败",$list);
		}
	}

	/**
	 * 配送员列表
	 */
	public function deliveryindex()
	{
		$data = $this->request->param();
		$OrderModel = new OrderModel();
		$list = $OrderModel->deliveryindex($data);
		if($list){
			$page = $list->render();
			$this->assign('page',$page);
			$this->assign('list',$list);
		}
		$this->assign('d_name',isset($data['d_name']) ? $data['d_name'] : '');
		$this->assign('d_phone',isset($data['d_phone']) ? $data['d_phone'] : '');
		return $this->fetch();
	}

	/**
	 * 添加配送员
	 */
	public function adddelivery()
	{
		return $this->fetch();
	}

	/**
	 * 添加配送员提交
	 */
	public function adddeliveryPost()
	{
		$data = $this->request->param();
		$OrderModel = new OrderModel();
		$list = $OrderModel->adddeliveryPost($data);
		if($list){
			return returnJson($code=1,$msg="添加成功",$list);
		}else{
			return returnJson($code=2,$msg="添加失败",$list);
		}
	}

	/**
	 * 修改配送员
	 */
	public function editdelivery()
	{
		$data = $this->request->param();
		$OrderModel = new OrderModel();
		$list = $OrderModel->editdelivery($data['id']);
		$this->assign('list',$list);
		return $this->fetch();
	}

	/**
	 * 修改配送员提交
	 */
	public function editdeliveryPost()
	{
		$data = $this->request->param();
		$OrderModel = new OrderModel();
		$list = $OrderModel->editdeliveryPost($data['id'],$data);
		if($list){
			return returnJson($code=1,$msg="修改成功",$list);
		}else{
			return returnJson($code=2,$msg="修改失败",$list);
		}
	}

	/**
	 * 删除配送员
	 */
	public function deletedelivery()
	{
		$data = $this->request->param();
		$OrderModel = new OrderModel();
		$list = $OrderModel->deletedelivery($data['id']);
		if($list){
			return returnJson($code=1,$msg="删除成功",$list);
		}else{
			return returnJson($code=2,$msg="删除失败",$list);
		}
	}
}
