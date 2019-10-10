<?php
namespace app\admin\model;

use think\Model;
use think\Db;
use think\Request;
use think\Session;

class UserModel extends Model
{
	/**
	 * 用户管理
	 */
	public function getuser($data)
	{
		$where = [];

		/* 用户账号 */
		$phone = empty($data['phone']) ? '' : $data['phone'];
		$where['phone'] = ['like',"%$phone%"];

		/* 用户呢称 */
		$u_name = empty($data['u_name']) ? '' : $data['u_name'];
		$where['u_name'] = ['like',"%$u_name%"];

		/* 性别 */
		$gender = empty($data['gender']) ? '' : $data['gender'];
		if(!empty($gender)){
			$where['gender'] = $gender;
        }

        /* 账户启用状态 */
		$status = empty($data['status']) ? '' : $data['status'];
		if(!empty($status)){
			$where['status'] = $status;
        }

        //是否是VIP
        $VIP = empty($data['VIP']) ? '' : $data['VIP'];
        
        $res = Db::table('aaz_user')->where($where)->order('addtime desc')->paginate(10,false,['query' => request()->param()]);
        $page = $res->render();
        $list = $res->all();

        $time = time();
        foreach ($list as $k => $v) {
        	$timediff = time() - $v['lasttime'];
        	//分钟数
			$minute = intval($timediff/60);
			//小时数
			$hour = intval($timediff/3600);
			//天数
			$day = intval($timediff/86400);

			if(empty($v['lasttime'])){
				$list[$k]['lasttime'] = '未登录';
			}else{
				if($minute < 1){
					$list[$k]['lasttime'] = '刚刚';
				}else{
					if($minute<60){
						$list[$k]['lasttime'] = $minute.'分钟前';
					}else{
						if($hour < 24){
							$list[$k]['lasttime'] = $hour.'小时前';
						}else{
							$list[$k]['lasttime'] = $day.'天前';
						}
					}
				}
			}
			

			

			//永久VIP
			if($list[$k]['vip']==1){
				$list[$k]['viptime'] = '是';
			}else{
				if(empty($v['viptime'])){
					$list[$k]['viptime'] = '否';
				}else{
					if($list[$k]['viptime'] > $time){
						$list[$k]['viptime'] = '是';
					}else{
						$list[$k]['viptime'] = '否';
					}
				}
			}	
        }

        if($VIP == 1 && $list[$k]['viptime'] == '是'){
        	unset($list[$k]);
        }
        if($VIP == 2 && $list[$k]['viptime'] == '否'){
        	unset($list[$k]); 
        }

        return ['page'=>$page,'list'=>$list];
	}


    /**
     * 添加用户
     * @param $data  数据
     */
    public function addPost($data)
    {
        if($data){
        	//查询表里是否有这个手机号的用户
        	$user = Db::name('user')->where('phone',$data['phone'])->find();
        	if(!$user){
        		/*用户信息*/
	            $map = [
	                'icon'=>$data['c_pic'],
	                'u_name'=>$data['u_name'],
	                'phone'=>$data['phone'],
	                'gender'=>$data['gender'],
	                'birthday'=>$data['birthday'],
	                'status'=>$data['status'],
	                'addtime'=>strtotime(date('Y-m-d H:i',time()))
	            ];
	            $uid = Db::name('user')->insertGetId($map);
	            if($uid){
	            	return 1;
	            }else{
	            	return 2;
	            }
	            
        	}else{
        		return 3;
        	}
        }
    }


	/**
	 * 获取某个用户的数据
	 */
	public function getuserdetail($id)
	{
		if($id){
			$res = Db::table('aaz_user')->where('id',$id)->find();
			//年龄
			$res['birthday'] = birthday($res['birthday']);
			//当前时间
			$time = time();

			$timediff = time() - $res['lasttime'];
        	//分钟数
			$minute = intval($timediff/60);
			//小时数
			$hour = intval($timediff/3600);
			//天数
			$day = intval($timediff/86400);

			if(empty($res['lasttime'])){
				$res['lasttime'] = '未登录';
			}else{
				if($minute < 1){
					$res['lasttime'] = '刚刚';
				}else{
					if($minute<60){
						$res['lasttime'] = $minute.'分钟前';
					}else{
						if($hour < 24){
							$res['lasttime'] = $hour.'小时前';
						}else{
							$res['lasttime'] = $day.'天前';
						}
					}
				}
			}
			

			//永久VIP
			if($res['vip']==1){
				$res['vips'] = '是';
			}else{
				if(empty($list['viptime'])){
					$res['vips'] = '否';
				}else{
					if($res['viptime'] > $time){
						$res['vips'] = '是';
					}else{
						$res['vips'] = '否';
					}
				}
			}	

			return $res;
		}
	}

	/**
	 * 	修改用户信息
	 */
	public function edituserPost($id,$data)
	{
		if($id){
			$map = [
				'u_name'=>trim($data['u_name']),
				'phone'=>trim($data['phone']),
				'gender'=>$data['gender'],
				'status'=>$data['status']
			];
			Db::table('aaz_user')->where('id',$id)->update($map);
			return true;
		}
	}

	/**
	 * 修改用户状态(单个)
	 */
	public function edituserstatus($id,$data)
	{
		if($id){
			switch ($data['name']) {
				case 'hall':
					Db::table('aaz_user')->where('id',$id)->update(['hall'=>$data['status']]);			
					return true;
					break;
				
				case 'vip':
					Db::table('aaz_user')->where('id',$id)->update(['vip'=>$data['status']]);			
					return true;
					break;

				case 'icon_status':
					Db::table('aaz_user')->where('id',$id)->update(['icon_status'=>$data['status']]);			
					return true;
					break;

				case 'status':
					Db::table('aaz_user')->where('id',$id)->update(['status'=>$data['status']]);			
					return true;
					break;
			}	
		}
	}

	/**
	 * 修改约币
	 */
	public function editusercurrency($id)
	{
		if($id){
			$res = Db::name('user')->where('id',$id)->find();
			return $res;
		}
	}

	/**
	 * 修改约币提交
	 */
	public function editusercurrencyPost($id,$data)
	{
		if($id){
			Db::name('user')->where('id',$id)->update(['currency'=>$data['currency']]);
			return true;
		}
	}


	/**
	 * 喜欢列表
	 */
	public function getlove($id)
	{
		if($id){
			$res = Db::name('heartbeat')->where('uid_1|uid_2',$id)->where('type',1)->order('id','desc')->select();
			foreach ($res as $k => $v) {
				if($res[$k]['uid_1'] == $id){
					$user = Db::name('user')->where('id',$v['uid_2'])->find();
				}else{
					$user = Db::name('user')->where('id',$v['uid_1'])->find();
				}
				$res[$k]['icon'] = $user['icon'];
				$res[$k]['u_name'] = $user['u_name'];
				$res[$k]['phone'] = $user['phone'];
				$res[$k]['addtime'] = date('Y-m-d H:i:s',$v['addtime']);
			}
			return $res;
		}
	}
	

	/**
	 * 心动列表
	 */
	public function getHeartbeat($id)
	{
		if($id){
			$res = Db::name('heartbeat')->where('uid_1|uid_2',$id)->where('type',2)->order('id','desc')->select();
			foreach ($res as $k => $v) {
				if($res[$k]['uid_1'] == $id){
					$user = Db::name('user')->where('id',$v['uid_2'])->find();
				}else{
					$user = Db::name('user')->where('id',$v['uid_1'])->find();
				}
				$res[$k]['icon'] = $user['icon'];
				$res[$k]['u_name'] = $user['u_name'];
				$res[$k]['phone'] = $user['phone'];
				$res[$k]['addtime'] = date('Y-m-d H:i:s',$v['addtime']);
			}
			return $res;
		}
	}


	/**
	 * 好感度列表
	 */
	public function getFavorability($id,$data)
	{
		if($id){
			//昵称
			$u_name = empty($data['u_name']) ? '' : $data['u_name'];
			//手机号
			$phone = empty($data['phone']) ? '' : $data['phone'];


			$res = Db::name('heartbeat')->where('uid_1|uid_2',$id)->order('id','desc')->select();
			$arr=[];
			foreach ($res as $k => $v) {
				if($res[$k]['uid_1'] == $id){
					$user = Db::name('user')->where('id',$v['uid_2'])->find();
				}else{
					$user = Db::name('user')->where('id',$v['uid_1'])->find();
				}
				$res[$k]['icon'] = $user['icon'];
				$res[$k]['u_name'] = $user['u_name'];
				$res[$k]['phone'] = $user['phone'];
			}

			if(!empty($u_name)){
				foreach ($res as $k => $v) {
					if(strstr( $v['u_name'] , $u_name ) === false ){
						unset($res[$k]);
					}
				}
			}

			if(!empty($phone)){
				foreach ($res as $k => $v) {
					if(strstr($v['phone'], $phone ) === false ){
						unset($res[$k]);
					}
				}
			}
			return $res;

		}
	}

	/**
	 * 删除用户
	 */
	public function deleteuser($id)
	{
		if($id){
			Db::table('aaz_user')->where('id',$id)->delete();
			Db::table('aaz_heartbeat')->where('uid_1|uid_2',$id)->delete();	
			Db::table('aaz_initiate')->where('uid_1|uid_2',$id)->delete();	
			return true;
		}
	}

}

