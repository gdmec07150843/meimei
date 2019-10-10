<?php
namespace app\admin\model;

use think\Model;
use think\Db;
use think\Session;
use think\Config;
use think\Request;

class FinancialModel extends Model
{
	/**
	 * 综合统计
	 */
	public function getfinancial()
	{
		/* 销售总额 */
		$res['o_total'] = Db::name('order')->where('pay_time','<>','')->sum('order_price');

		/* 有效订单总数 */
		$res['o_number'] = Db::name('order')->where('pay_time','<>','')->count();

		/* 有效订单总数 */
		$res['order_total'] = Db::name('order')->where('pay_time','<>','')->sum('order_price');

		/* 无效订单总数 */
		$res['oi_number'] = Db::name('order')->where('order_status',6)->count();

		/* 无效订单总数 */
		$res['oi_total'] = Db::name('order')->where('order_status',6)->sum('order_price');

		/* 新增会员数  */
		$res['zu_number'] = Db::name('user')->whereTime('addtime','month')->count();

		/* 有订单会员数 */
		$res['ou_number'] = Db::name('order')->group('uid')->count();

		/* 会员总数 */
		$res['u_number'] = Db::name('user')->count();
		return $res;
	}

	/**
	 * 销售统计
	 */
	public function salesindex($data)
	{
		$where = [];

		/* 商品名称 */
		$g_name = empty($data['g_name']) ? '' : $data['g_name'];
		$g_name = trim($g_name);
		if(!empty($g_name)){
			$where['g.g_name'] = ['like',"%$g_name%"];
		}

		/* 商品分类 */
		$cid = empty($data['cid']) ? '' : $data['cid'];
		if(!empty($cid)){
			$where['g.cid'] = $cid;
		}

		$res = Db::table('sz_goods')->alias('g')
			 ->join('sz_category c','g.cid=c.id','left')
			 ->field('g.*,c.c_name')
			 ->where($where)
			 ->paginate(25,false,['query' => request()->param()]);
		$page = $res->render();
		$list = $res->all();
		foreach($list as $key=>$val){
			$list[$key]['o_number'] = Db::name('orderinfo')->where('gid',$val['id'])->group('oid')->count();
			$list[$key]['o_total'] = Db::name('orderinfo')->alias('oi')
								   ->join('sz_order o','oi.oid=o.id','left')
								   ->field('oi.*,o.order_price')
								   ->where('oi.gid',$val['id'])
								   ->where('pay_time','<>','')
								   ->group('oi.oid')
								   ->select();
		}
		foreach($list as $key=>$val){
			$total = [];
			foreach($val['o_total'] as $k=>$v){
				$total[] = $v['order_price'];
			}
			$list[$key]['total'] = array_sum($total);
		}
		return ['page'=>$page,'list'=>$list];
	}
}
