<?php
namespace app\admin\model;

use think\Model;
use think\Db;
use think\Session;
use think\Config;
use think\Request;

class OrderModel extends Model
{
	/**
	 * 订单列表
	 */
	public function getorders($data)
	{
		$where = [];

		/* 订单编号 */
		$order_number = empty($data['order_number']) ? '' : $data['order_number'];
		$order_number = trim($order_number);
		if(!empty($order_number)){
			$where['o.order_number'] = ['like',"%$order_number%"];
		}

		/* 收货人 */
		$name = empty($data['name']) ? '' : $data['name'];
		if(!empty($name)){
			$where['a.name'] = $name;
		}

		/* 联系电话 */
		$phone = empty($data['phone']) ? '' : $data['phone'];
		if(!empty($phone)){
			$where['a.phone'] = $phone;
		}

		/* 药品状态 */
		$order_status = empty($data['order_status']) ? '' : $data['order_status'];
		if(!empty($order_status)){
			$where['o.order_status'] = $order_status;
		}

		/* 支付方式 */
		$pay_type = empty($data['pay_type']) ? '' : $data['pay_type'];
		if(!empty($pay_type)){
			$where['o.pay_type'] = $pay_type;
		}

		$res = Db::name('order')->alias('o')
			 ->join('sz_address a','o.aid=a.id','left')
			 ->join('sz_user u','o.uid=u.id','left')
			 ->field('o.*,a.name,a.phone,u.u_name')
			 ->where($where)
			 ->order('o.addtime desc')
			 ->paginate(25,false,['query' => request()->param()]);

		return $res;
	}

	/**
	 * 获取单条订单数据
	 */
	public function getoneorder($id)
	{
		if($id){
			$res = Db::name('order')->alias('o')
			     ->join('sz_address a','o.aid=a.id','left')
			     ->join('sz_user u','o.uid=u.id','left')
			     ->field('o.*,a.name,a.phone,a.address,a.code,a.province,a.city,a.area,u.u_name')
			     ->where('o.id',$id)
			     ->find();
			$province = Db::name('district')->where('area_id',$res['province'])->find();
			$city = Db::name('district')->where('area_id',$res['city'])->find();
			$area = Db::name('district')->where('area_id',$res['area'])->find();
			$res['province_name'] = $province['area_name'];
			$res['city_name'] = $city['area_name'];
			$res['area_name'] = $area['area_name'];
			$res['goods'] = Db::name('orderinfo')->alias('so')
								        ->join('sz_goods g','so.gid=g.id','left')
								        ->join('sz_goodsinfo sg','so.gi_id=sg.id','left')
								        ->join('sz_category sc','g.cid=sc.id','left')
										->field('so.*,g.g_name,g.g_pic,sg.g_price,sc.c_name')
					  					->where('oid',$res['id'])
					  					->select();
			foreach($res['goods'] as $k=>$v){
				$res['goods'][$k]['g_pic'] = json_decode($v['g_pic'],true);
				$res['goods'][$k]['price'] = $v['g_price']*$v['goods_number'];
			}
			return $res;
		}
	}

	/**
	 * 修改订单状态
	 * @param   $ids 订单id集
	 * @param   $data['order_status']  订单状态
	 */
	public function checkStatus($ids,$data)
	{
		if($ids){
			if($data['order_status']==3){
				foreach($ids as $key=>$val){
					$map = [
						'order_status'=>$data['order_status'],
						'did'=>$data['did'],
						'delive_time'=>strtotime(date('Y-m-d H:i',time()))
					];
					Db::name('order')->where('id',$val)->update($map);
				}
				return true;
			}else{
				foreach($ids as $key=>$val){
					Db::name('order')->where('id',$val)->update(['order_status'=>$data['order_status']]);
				}
				return true;
			}
		}
	}

	/**
	 * 修改订单信息
	 */
	public function editPost($id,$data)
	{
		if($data['order_status']==3){
			$map = [
				'order_status'=>$data['order_status'],
				'did'=>$data['did'],
				'delive_time'=>strtotime(date('Y-m-d H:i',time()))
			];
			Db::name('order')->where('id',$id)->update($map);
			return true;
		}elseif($data['order_status']==2){
			$map = [
				'order_status'=>$data['order_status'],
				'pay_type'=>$data['pay_type'],
				'pay_time'=>strtotime(date('Y-m-d H:i',time()))
			];
			Db::name('order')->where('id',$id)->update($map);
			return true;
		}else{
			$map = [
				'order_status'=>$data['order_status'],
				'pay_type'=>$data['pay_type'],
				'did'=>$data['did']
			];
			Db::name('order')->where('id',$id)->update($map);
			return true;
		}
	}

	/**
	 * 删除多个订单
	 * @param   $ids 订单id集
	 */
	public function deletesorders($ids)
	{
		if($ids){
			foreach($ids as $key=>$val){
				Db::name('order')->where('id',$val)->delete();
			}
			return true;
		}
	}

	/**
	 * 获取配送员
	 */
	public function getdelivery()
	{
		$res = Db::name('delivery')->select();
		return $res;
	}

	/**
	 * 配送员列表
	 * @param $data 数据
	 */
	public function deliveryindex($data)
	{
		$where = [];
		/* 手机号码 */
		$d_phone = empty($data['d_phone']) ? '' : $data['d_phone'];
		$d_phone = trim($d_phone);
		if(!empty($d_phone)){
			$where['d_phone'] = ['like',"%$d_phone%"];
		}

		/* 配送员名称 */
		$d_name = empty($data['d_name']) ? '' : $data['d_name'];
		if(!empty($d_name)){
			$where['d_name'] = ['like',"%$d_name%"];
		}

		$res = Db::name('delivery')->where($where)->paginate(25,false,['query' => request()->param()]);
		return $res;
	}

	/**
	 * 添加配送员
	 * @param $data['d_name']  配送员名称
	 * @param $data['d_phone'] 配送员手机号码
	 */
	public function adddeliveryPost($data)
	{
		if($data){
			$map = [
				'd_name'=>$data['d_name'],
				'd_phone'=>$data['d_phone']
			];
			Db::name('delivery')->insert($map);
			return true;
		}
	}

	/**
	 * 获取一个配送员
	 * $param $id 配送员id
	 */
	public function editdelivery($id)
	{
		if($id){
			$res = Db::name('delivery')->where('id',$id)->find();
			return $res;
		}
	}

	/**
	 * 修改配送员提交
	 * @param $data['id']  配送员id
	 * @param $data['d_name'] 配送员名称
	 * @param $data['d_phone'] 配送员手机号码
	 */
	public function editdeliveryPost($id,$data)
	{
		if($id){
			$map = [
				'd_name'=>$data['d_name'],
				'd_phone'=>$data['d_phone']
			];
			Db::name('delivery')->where('id',$id)->update($map);
			return true;
		}
	}

	/**
	 * 删除配送员
	 * @param $data['id'] 配送员id
	 */
	public function deletedelivery($id)
	{
		if($id){
			Db::name('delivery')->where('id',$id)->delete();
			return true;
		}
	}
}
