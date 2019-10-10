<?php
namespace app\admin\model;

use think\Model;
use think\Session;
use think\Config;
use think\Requst;
use think\Db;

class GoodsModel extends Model
{
	/**
	 * 获取商品分类名称
	 */
	public function getcategory()
	{
		$res = Db::table('sz_category')->select();
		return $res;
	}

	/**
	 * 获取商品列表
	 */
	public function getgoods($data)
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

		/* 商品状态 */
		$g_status = empty($data['g_status']) ? '' : $data['g_status'];
		if(!empty($g_status)){
			$where['g.g_status'] = $g_status;
		}
		$res = Db::table('sz_goods')->alias('g')
			 ->join('sz_category c','g.cid=c.id','left')
			 ->field('g.*,c.c_name')
			 ->where($where)
			 ->paginate(25,false,['query' => request()->param()]);
		$page = $res->render();
		$list = $res->all();
		foreach($list as $key=>$val){
			$list[$key]['g_pic'] = json_decode($val['g_pic'],true);
		}

		return ['page'=>$page,'list'=>$list];
	}

	/**
	 * 添加商品
	 */
	public function addgoods($data)
	{
		if($data){
			if (!empty($data['photo_names']) && !empty($data['photo_urls'])) {
		        $map['g_pic']['photos'] = [];
		        foreach ($data['photo_urls'] as $key => $url) {
		            $photoUrl = cmf_asset_relative_url($url);
		            array_push($map['g_pic']['photos'], ["url" => $photoUrl, "name" => $data['photo_names'][$key]]);
		        }
	    	}
			/* 商品基本信息 */
			$arr = [
				'cid'=>$data['cid'],
				'g_name'=>$data['g_name'],
				'g_number'=>$data['g_number'],
				'g_status'=>$data['g_status'],
				'g_description'=>$data['g_description'],
				'g_content'=>$data['g_content'],
				'g_manual'=>$data['g_manual'],
				'g_pic'=>json_encode($map['g_pic']),
				'addtime'=>strtotime(date('Y-m-d H:i',time()))
			];
			$res = Db::table('sz_goods')->insertGetId($arr);

			/* 添加规格 */
			if($res){
				$arr_id = [];
				if(!empty($data['g_price'][0])){
					foreach($data['g_price'] as $key=>$val){
						$goods_info = [
							'gid'=>$res,
							'g_price'=>$data['g_price'][$key],
							'g_total'=>$data['g_total'][$key],
							's_value'=>$data['s_value'][$key],
							'g_stock'=>$data['g_stock'][$key],
							'unit'=>$data['unit'][$key]
						];
						$list = Db::table('sz_goodsinfo')->insert($goods_info);
					}
					$arr_id = $list;
				}
			}
			if($res==0||$res==false){//当有一个失败时就回滚
	            return false;
	        }
	        return true;
		}
	}

	/**
	 * 获取单条数据
	 */
	public function getonegoods($id)
	{
		if($id){
			$res = Db::table('sz_goods')->where('id',$id)->find();
			$res['goodsinfo'] = Db::table('sz_goodsinfo')->where('gid',$id)->select();
			return $res;
		}
	}

	/**
	 * 修改商品
	 */
	public function editgoods($id,$data)
	{
		if($data){
			if (!empty($data['photo_names']) && !empty($data['photo_urls'])) {
		        $map['g_pic']['photos'] = [];
		        foreach ($data['photo_urls'] as $key => $url) {
		            $photoUrl = cmf_asset_relative_url($url);
		            array_push($map['g_pic']['photos'], ["url" => $photoUrl, "name" => $data['photo_names'][$key]]);
		        }
	    	}
			/* 商品基本信息 */
			$arr = [
				'id'=>$data['id'],
				'cid'=>$data['cid'],
				'g_name'=>$data['g_name'],
				'g_number'=>$data['g_number'],
				'g_status'=>$data['g_status'],
				'g_description'=>$data['g_description'],
				'g_content'=>$data['g_content'],
				'g_manual'=>$data['g_manual'],
				'g_pic'=>json_encode($map['g_pic']),
				'addtime'=>strtotime(date('Y-m-d H:i',time()))
			];
			$res = Db::table('sz_goods')->where('id',$id)->update($arr);

			/* 添加规格 */
			if($res){
				$arr_id = [];
				if(!empty($data['g_price'][0])){
					foreach($data['g_price'] as $key=>$val){
						if(!empty($data['ginfo_id'][$key])){
							$goods_info = [
								'gid'=>$id,
								'g_price'=>$data['g_price'][$key],
								'g_total'=>$data['g_total'][$key],
								's_value'=>$data['s_value'][$key],
								'g_stock'=>$data['g_stock'][$key],
								'unit'=>$data['unit'][$key]
							];
							$list = Db::table('sz_goodsinfo')->where('id',$data['ginfo_id'][$key])->update($goods_info);
						}else{
							$goods_info = [
								'gid'=>$id,
								'g_price'=>$data['g_price'][$key],
								'g_total'=>$data['g_total'][$key],
								's_value'=>$data['s_value'][$key],
								'g_stock'=>$data['g_stock'][$key],
								'unit'=>$data['unit'][$key]
							];
							$list = Db::table('sz_goodsinfo')->insert($goods_info);
						}

					}
					$arr_id = $list;
				}
			}
			if($res==0||$res==false){//当有一个失败时就回滚
	            return false;
	        }
	        return true;
		}
	}

	/**
	 * 删除药品
	 */
	public function deletegoods($id)
	{
		if($id){
			Db::table('sz_goods')->where('id',$id)->delete();
			return true;
		}
	}

	/**
	 * 删除药品(多个)
	 */
	public function deletesgoods($ids)
	{
		if($ids){
			foreach($ids as $key=>$val){
				Db::table('sz_goods')->where('id',$val)->delete();
			}
			return true;
		}
	}

	/**
	 * 修改用户状态(多个)
	 */
	public function checkStatus($ids,$data)
	{
		if($ids){
			foreach($ids as $key=>$val){
				Db::table('sz_goods')->where('id',$val)->update(['g_status'=>$data['g_status']]);
			}
			return true;
		}
	}

	/**
	 * 修改商品是否是新品
	 */
	public function checkNgoods($ids,$data)
	{
		if($ids){
			foreach($ids as $key=>$val){
				Db::table('sz_goods')->where('id',$val)->update(['new_goods'=>$data['new_goods']]);
			}

			return true;
		}
	}

	/**
	 * 修改商品类型
	 */
	public function checkGtype($ids,$data)
	{
		if($ids){
			foreach($ids as $key=>$val){
				Db::table('sz_goods')->where('id',$val)->update(['g_type'=>$data['g_type']]);
			}
			return true;
		}
	}

	/**
	 * 设置为活动促销
	 */
	public function checkGactivity($ids,$data)
	{
		if($ids){
			foreach($ids as $key=>$val){
				Db::table('sz_goods')->where('id',$val)->update(['g_activity'=>$data['g_activity']]);
			}
			return true;
		}
	}

	/**
	 * 获取商品的规格
	 * @param   $data['gid']  商品id
	 */
	public function getgoodsinfo($gid)
	{
		if($gid){
			$res = Db::name('goodsinfo')->where('gid',$gid)->select();
			return $res;
		}
	}

}
