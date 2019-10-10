<?php
namespace app\admin\controller;

use think\Controller;
use think\Session;
use think\Request;
use app\admin\model\AgreementModel;

class Agreement extends Common
{
	/**
	 * 协议列表
	 */
	public function index()
	{
		$AgreementModel = new AgreementModel();
		$list = $AgreementModel->getAgreement();
		$this->assign('list',$list['list']);
		$this->assign('count',$list['count']);
		return $this->fetch();
	}

	/**
	 * 添加协议  
	 */
	public function add()
	{
		return $this->fetch();
	}

	/**
	 * 添加协议提交
	 */
	public function addPost()
	{
		$data = $this->request->param();
		$AgreementModel = new AgreementModel();
		$list = $AgreementModel->addPost($data);
		if($list){
			return returnJson($code=1,$msg="添加成功",$list);
		}else{
			return returnJson($code=2,$msg="添加失败",$list);
		}
	}

	/**
	 * 修改协议
	 */
	public function edit()
	{
		$data = $this->request->param();
		$AgreementModel = new AgreementModel();
		$list = $AgreementModel->getone($data['id']);
		$this->assign('list',$list);
		return $this->fetch();
	}

	/**
	 * 修改协议提交
	 */
	public function editPost()
	{
		$data = $this->request->param();
		$AgreementModel = new AgreementModel();
		$list = $AgreementModel->editPost($data['id'],$data);
		if($list){
			return returnJson($code=1,$msg="修改成功",$list);
		}else{
			return returnJson($code=2,$msg="修改失败",$list);
		}
	}

	/**
	 * 删除协议
	 */
	public function deleteagreement()
	{
		$data = $this->request->param();
		$AgreementModel = new AgreementModel();
		$list = $AgreementModel->deleteagreement($data['id']);
		if($list){
			return returnJson($code=1,$msg="删除成功",$list);
		}else{
			return returnJson($code=2,$msg="删除失败",$list);
		}
	}

}