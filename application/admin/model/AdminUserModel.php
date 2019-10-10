<?php
namespace app\admin\model;

use think\Model;
use think\Db;
use think\Session;
use think\Config;

class AdminUserModel extends Model
{
	/**
	*	获取后台管理员列表
	*/
	public function getAdminuser($data)
	{
		$where = [];

		/* 用户名 */
		$username = empty($data['username']) ? '' : $data['username'];
		$username = trim($username);
		if(!empty($username)){
			$where['username'] = $username;
		}

		/* 状态 */
		$status = empty($data['status']) ? '' : $data['status'];
	    if(!empty($status)){
	    	$where['status'] = $status;
	    }

		$where['grade'] = ['<=',2];

		$res = Db::name('adminuser')->where($where)->paginate(10,false,['query' => request()->param()]);
		
		foreach ($res as $k => $v) {
			$temp=$res[$k];
			$temp['creat_time'] = date("Y-m-d H:i:s",$res[$k]['creat_time']);
			$res[$k]=$temp;	
		}

		return $res;
	}


	/**
	*	添加管理员
	*  @param $data 数组
	*/
	public function addAdminUser($data)
	{
		$data['password'] = md5($data['password']);
		$data['creat_time'] = time();
		if(!empty($data)){
			$result = Db::name('adminuser')->where('username',$data['username'])->find();
			if(empty($result)){
				$res = Db::name('adminuser')->insert($data);
				return $res;
			}else{
				return 2;
			}


		}
	}

	/**
	*	修改管理员
	*  @param $id 管理员id
	*/
	public function getAdminuserone($id)
	{
		if($id){
			$res = Db::name('adminuser')->where('id',$id)->find();
			return $res;
		}
	}

	/**
	*	修改管理员
	*  @param $id 管理员id
	*  @param $data 数组
	*/
	public function editAdminUser($id,$data)
	{
		if($id){
			Db::name('adminuser')->where('id',$id)->update($data);
			return true;
		}else{
			return false;
		}
	}

	/**
	*	删除管理员
	*/
	public function deleteAdminUser($id)
	{
		if(!empty($id)){
			Db::name('adminuser')->where('id',$id)->delete();
			Db::name('auth_access')->where('admin_id',$id)->delete();
			return true;
		}
	}

	/**
	*	禁用管理员
	*/
	public function banAdminUser($id)
	{
		if(!empty($id)){
			$res = Db::name('adminuser')->where('id',$id)->find();
			if($res['status'] == 1){
				$res = Db::name('adminuser')->where('id',$id)->update(['status'=>2]);
				return $res;
			}
		}
	}

	/**
	*	启用管理员
	*/
	public function cancelBanAdminUser($id)
	{
		if(!empty($id)){
			$res = Db::name('adminuser')->where('id',$id)->find();
			if($res['status'] == 2){
				$res = Db::name('adminuser')->where('id',$id)->update(['status'=>1]);
				return $res;
			}
		}
	}

	/**
	*	获取所有菜单
	*	管理员
	*/
	public function getmenu($admin_id)
	{
		/* 顶级分类 */
		$res = Db::name('admin_menu')->where('parent_id',0)->select();
		$info = [];
		foreach($res as $key=>$val){
			$re = Db::name('auth_access')->where('admin_id',$admin_id)->where('menu_id='.$val['id'])->find();
			if(empty($re)){
				$res[$key]['menu_id'] = '';
			}else{
				$res[$key]['menu_id'] = $re['menu_id'];
			}
			$res[$key]['info'] = Db::name('admin_menu')->where('parent_id='.$val['id'])->select();
			foreach($res[$key]['info'] as $k=>$v){
				//查看该管理员的权限菜单
				$list = Db::name('auth_access')->where('admin_id',$admin_id)->where('menu_id='.$v['id'])->find();
				if(empty($list)){
					$res[$key]['info'][$k]['menu_id'] = '';
				}else{
					$res[$key]['info'][$k]['menu_id'] = $list['menu_id'];
				}
			}

		}

		return $res;
	}

	/**
	*	某个管理员的菜单
	*/
	public function getadminmenu($admin_id)
	{
		if($admin_id){
			$res = Db::name('auth_access')->where('admin_id',$admin_id)->select();
			return $res;
		}
	}

	/**
	*	添加客户的权限项
	*/
	public function addadminmenu($memuids,$admin_id)
	{

		Db::name('auth_access')->where('admin_id',$admin_id)->where('menu_id','not in',$memuids)->delete();
		$memuids = explode(',', $memuids);
		$res = [];
		foreach($memuids as $key=>$val){
			$res = Db::name('auth_access')->where('admin_id',$admin_id)->where('menu_id',$val)->find();
			if(empty($res)){
				$data = [
					'admin_id'=>$admin_id,
					'menu_id'=>$val
				];
				Db::name('auth_access')->insert($data);
			}
		}
		return true;
	}

}
