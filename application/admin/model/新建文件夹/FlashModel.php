<?php
namespace app\admin\model;

use think\Model;
use think\Session;
use think\Config;
use think\Requst;
use think\Db;

class FlashModel extends Model
{
	/**
	 * 轮播图列表
	 */
	public function getFlash($data)
	{
		$where = [];
		/* 商品状态 */
		$status = empty($data['status']) ? '' : $data['status'];
		if(!empty($status)){
			$where['status'] = $status;
		}

		$res = Db::table('sz_flash')->where($where)->paginate(25,false,['query' => request()->param()]);
		return $res;
	}

	/**
	 * 添加轮播图
	 */
	public function addPost($data)
	{
		if($data){
			$data['addtime'] = strtotime(date('Y-m-d H:i',time()));
			Db::table('sz_flash')->insert($data);
			return true;
		}
	}

	/**
	 * 获取一条数据
	 */
	public function getone($id)
	{
		if($id){
			$res = Db::table('sz_flash')->where('id',$id)->find();
			return $res;
		}
	}

	/**
	 * 修改轮播图
	 */
	public function editPost($id,$data)
	{
		if($data){
			$data['addtime'] = strtotime(date('Y-m-d H:i',time()));
			Db::table('sz_flash')->where('id',$id)->update($data);
			return true;
		}
	}

	/**
	 * 删除轮播图(多个)
	 */
	public function editflashsstatus($ids,$data)
	{
		if($ids){
			foreach($ids as $key=>$val){
				Db::table('sz_flash')->where('id',$val)->update(['status'=>$data['status']]);
			}
			return true;
		}
	}

	/**
	 * 删除轮播图
	 */
	public function deleteflashone($id)
	{
		if($id){
			Db::table('sz_flash')->where('id',$id)->delete();
			return true;
		}
	}

	/**
	 * 删除轮播图(多个)
	 */
	public function deleteflash($ids)
	{
		if($ids){
			foreach($ids as $key=>$val){
				Db::table('sz_flash')->where('id',$val)->delete();
			}
			return true;
		}
	}
}