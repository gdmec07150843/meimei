<?php
namespace app\admin\model;

use think\Model;
use think\Session;
use think\Db;
use think\Config;
class IndexModel extends Model
{
	/**
	*	登录管理员信息
	*/
	public function getAdminUser()
	{
		$user_id = Session::get('admin_id');
		if($user_id){
			$list = Db::table('aaz_adminuser')->where('id',$user_id)->find();
			return $list;
		}
	}

	/**
	*	修改密码提交
	*/
	public function editpassPost($admin_id,$data)
	{
		$result = Db::table('aaz_adminuser')->where('id',$admin_id)->find();
		if(md5($data['oldpass']) === $result['password']){

			if($data['newpass'] === $data['confpass']){
				$newpass = md5($data['newpass']);
				$res = Db::table('aaz_adminuser')->where('id',$admin_id)->update(['password'=>$newpass]);
				return $res;

			}else{
				//新密码和确认密码不一致
				return 3;
			}

		}else{
			// 原密码不正确
			return 2;
		}
	}

	/**
	 * 首页数据
	 */
	public function getindexdata()
	{
		/* 今日订单数 */
		$res['o_number'] = Db::name('order')->whereTime('pay_time','today')->count();

		/* 今日销售金额 */
		$res['o_total'] = Db::name('order')->whereTime('pay_time','today')->sum('order_price');

		/* 昨日销售金额 */
		$res['o_ytotal'] = Db::name('order')->whereTime('pay_time','yesterday')->sum('order_price');

		/* 近7天销售金额 */
		$res['o_wtotal'] = Db::name('order')->whereTime('pay_time','week')->sum('order_price');

		/* 待付款订单数 */
		$res['o_pendnumnber'] = Db::name('order')->where('order_status',1)->count();

		/* 已完成订单数 */
		$res['o_completnumnber'] = Db::name('order')->where('order_status',4)->count();

		/* 待发货订单 */
		$res['o_delivernumnber'] = Db::name('order')->where('order_status',2)->count();

		/* 已发货订单 */
		$res['o_shippnumnber'] = Db::name('order')->where('order_status',3)->count();

		return $res;
	}

	/**
	 * 管理员权限模块
	 */
	public function getausermenu()
	{
		$admin_id = Session::get('admin_id');
		$adminuser = Db::table('aaz_adminuser')->where('id',$admin_id)->find();
		if($adminuser['grade']==1){
			$adminmenu = Db::table('aaz_admin_menu')->where('parent_id',0)->select();
			foreach($adminmenu as $key=>$val){
				$adminmenu[$key]['child'] = Db::table('aaz_admin_menu')->where('parent_id',$val['id'])->select();
			}
		}else{
			$adminmenu = Db::table('aaz_auth_access')->alias('a')
					   ->join('aaz_admin_menu m','a.menu_id=m.id','left')
					   ->field('a.*,m.name,m.app,m.controller,m.action')
					   ->where('a.admin_id',$admin_id)
					   ->where('m.parent_id',0)
					   ->select();
			foreach($adminmenu as $key=>$val){
				$adminmenu[$key]['child'] = Db::table('aaz_auth_access')->alias('a')
										   ->join('aaz_admin_menu m','a.menu_id=m.id','left')
										   ->field('a.*,m.name,m.app,m.controller,m.action')
										   ->where('a.admin_id',$admin_id)
										   ->where('m.parent_id',$val['menu_id'])
										   ->select();
			}
		}
		return $adminmenu;
	}
}
