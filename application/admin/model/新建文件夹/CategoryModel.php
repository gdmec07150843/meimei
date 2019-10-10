<?php
namespace app\admin\model;

use think\Model;
use think\Session;
use think\Config;
use think\Requst;
use think\Db;

class CategoryModel extends Model
{
	/**
	 * 药品分类列表
	 */
	public function getcategory()
	{
		$res = Db::name('category')->paginate(25,false,['query' => request()->param()]);
		return $res;
	}

	/**
	 * 添加药品分类
	 */
	public function addcategory($data)
	{
		if($data){
			$map = [
				'c_name'=>trim($data['c_name']),
				'c_pic'=>$data['c_pic']
			];
			Db::name('category')->insert($map);
			return true;
		}
	}

	/**
	 * 修改药品分类
	 */
	public function getonecate($id)
	{
		if($id){
			$res = Db::name('category')->where('id',$id)->find();
			return $res;
		}
	}

	/**
	 * 修改药品分类提交
	 */
	public function editcategory($id,$data)
	{
		if($data){
			$map = [
				'c_name'=>trim($data['c_name']),
				'c_pic'=>$data['c_pic']
			];
			Db::name('category')->where('id',$id)->update($map);
			return true;
		}
	}

	/**
	 * 删除药品分类
	 */
	public function deletecate($id)
	{
		if($id){
			Db::name('category')->where('id',$id)->delete();
			return true;
		}
	}
}