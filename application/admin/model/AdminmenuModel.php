<?php
namespace app\admin\model;

use think\Model;
use think\Session;
use think\Config;
use think\Db;
use think\Request;

class AdminmenuModel extends Model
{

	/**
	*	所有菜单
	*/
	public function getmenu()
	{
		$res = Db::name('admin_menu')
			->field('*,concat(`path`,`id`) as paths')
			->order('paths')
			->select();
		foreach($res as $key=>&$val){
			// 计算逗号出现的次数
			$num = substr_count($val['path'],',');
			// 根据逗号出现的次数，填空格
			$zwf = str_repeat('★|',$num - 1);

			$val['name'] = $zwf.$val['name'];
		}
		return $res;
	}

	/**
	*	添加菜单
	*	@param $data 数据
	*/
	public function addMenu($data)
	{
		if($data['parent_id']=="0"){//添加一级菜单
			$map = [
				'name'	   	=>$data['name'],
				'app'	   	=>$data['app'],
				'controller'=>$data['controller'],
				'action'	=>$data['action'],
				'path'		=>'0,'

			];

			Db::name('admin_menu')->insert($map);
			return true;
		}else{
			//添加二级菜单
			$res = Db::name('admin_menu')->where('id',$data['parent_id'])->find();
			$re = [
				'parent_id' =>$data['parent_id'],
				'name'	   	=>$data['name'],
				'app'	   	=>$data['app'],
				'controller'=>$data['controller'],
				'action'	=>$data['action'],
				'path' 		=>$res['path'].$data['parent_id'].','
			];

			Db::name('admin_menu')->insert($re);
			return true;
		}

	}

	/**
	*	修改菜单
	*/
	public function getone($id)
	{
		if($id){
			$res = Db::name('admin_menu')->where('id',$id)->find();
			return $res;
		}
	}


	/**
	*	修改菜单提交
	*	@param $data 数据
	*/
	public function editMenu($id,$data)
	{
		if($data['parent_id']=="0"){//添加一级菜单
			$map = [
				'name'	   	=>$data['name'],
				'app'	   	=>$data['app'],
				'controller'=>$data['controller'],
				'action'	=>$data['action'],
				'path'		=>'0,'

			];

			Db::name('admin_menu')->where('id',$id)->update($map);
			return true;
		}else{
			//添加二级菜单
			$res = Db::name('admin_menu')->where('id',$data['parent_id'])->find();
			$re = [
				'parent_id' =>$data['parent_id'],
				'name'	   	=>$data['name'],
				'app'	   	=>$data['app'],
				'controller'=>$data['controller'],
				'action'	=>$data['action'],
				'path' 		=>$res['path'].$data['parent_id'].','
			];

			Db::name('admin_menu')->where('id',$id)->update($re);
			return true;
		}

	}

	/**
	*	删除菜单
	*/
	public function deleteMenu($id)
	{
		if($id){
			//查询删除的类是否有子类
			$result = Db::name('admin_menu')->where('parent_id',$id)->find();

			if($result){
				//该分类下有子类，不能删除！
				return 2;
			}else{

				$list = Db::name('admin_menu')->where('id',$id)->delete();

				if($list){
					return $list;
				}else{
					return false;
				}
			}
		}
	}
}
