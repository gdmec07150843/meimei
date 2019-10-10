<?php
namespace app\admin\model;

use think\Model;
use think\Session;
use think\Config;
use think\Requst;
use think\Db;

class GoodSearchModel extends Model
{
	/**
	 * 热门搜索列表
	 */
	public function getsearch()
	{
		$res = Db::name('search')->paginate(25,false,['query' => request()->param()]);
		return $res;
	}

	/**
	 * 添加热门搜索
	 */
	public function addsearch($data)
	{
		if($data){
			$map = [
				's_name'=>trim($data['s_name'])
			];
			Db::name('search')->insert($map);
			return true;
		}
	}

	/**
	 * 修改热门搜索
	 */
	public function getonecate($id)
	{
		if($id){
			$res = Db::name('search')->where('id',$id)->find();
			return $res;
		}
	}

	/**
	 * 修改热门搜索提交
	 */
	public function editsearch($id,$data)
	{
		if($data){
			$map = [
				's_name'=>trim($data['s_name'])
			];
			Db::name('search')->where('id',$id)->update($map);
			return true;
		}
	}

	/**
	 * 删除热门搜索
	 */
	public function deletecate($id)
	{
		if($id){
			Db::name('search')->where('id',$id)->delete();
			return true;
		}
	}
}