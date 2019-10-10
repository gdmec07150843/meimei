<?php
namespace app\admin\controller;

use think\Controller;
use think\Session;
use think\Request;
use think\Config;
use app\admin\model\FinancialModel;
use app\admin\model\GoodsModel;
class Financial extends Common
{
	/**
	 * 综合统计
	 */
	public function getfinancial()
	{
		$FinancialModel = new FinancialModel();
		$list = $FinancialModel->getfinancial();
		$this->assign('list',$list);
		return $this->fetch();
	}

	/**
	 * 销售统计
	 */
	public function salesindex()
	{
		$data = $this->request->param();
		$FinancialModel = new FinancialModel();
		$list = $FinancialModel->salesindex($data);
		$GoodsModel = new GoodsModel();
		$category = $GoodsModel->getcategory();
		$this->assign('category',$category);
		$this->assign('page',$list['page']);
		$this->assign('list',$list['list']);
		$this->assign('cid',isset($data['cid']) ? $data['cid'] : '');
		$this->assign('g_name',isset($data['g_name']) ? $data['g_name'] : '');
		return $this->fetch();
	}
}