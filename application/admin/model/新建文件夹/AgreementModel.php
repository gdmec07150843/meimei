<?php
namespace app\admin\model;

use think\Model;
use think\Session;
use think\Config;
use think\Requst;
use think\Db;

class AgreementModel extends Model
{
	/**
	 * 协议列表
	 */
	public function getAgreement()
	{
		$res = Db::name('agreement')->paginate(25,false,['query' => request()->param()]);
		$list = $res->all();
		$count= Db::name('agreement')->count();
		return ['count'=>$count,'list'=>$list];
	}

	/**
	 * 添加协议
	 */
	public function addPost($data)
	{
		if($data){
			$map = [
				'content'=>$data['content']
			];
			Db::name('agreement')->insert($map);
			return true;
		}
	}

	/**
	 * 修改协议
	 */
	public function getone($id)
	{
		if($id){
			$res = Db::name('agreement')->where('id',$id)->find();
			return $res;
		}
	}

	/**
	 * 修改协议提交
	 */
	public function editPost($id,$data)
	{
		if($data){
			$map = [
				'content'=>$data['content']
			];
			Db::name('agreement')->where('id',$id)->update($map);
			return true;
		}
	}

	/**
	 * 删除协议
	 * @param  $data['id']  协议id
	 */
	public function deleteagreement($id)
	{
		if($id){
			Db::name('agreement')->where('id',$id)->delete();
			return true;
		}
	}

}