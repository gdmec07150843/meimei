<?php
namespace app\admin\model;

//加载配置类
use think\Config;
//导入Controller
use think\Model;
//导入Db
use think\Db;
//引入Session类
use think\Session;

class LoginModel extends Model
{
	/**
	*	后台管理员登录
	*/
	public function getAdminUser($data)
	{
		$where = [];
		$where['username'] = $data['username'];
		// md5加密
		$pass = md5($data['password']);
		if(!empty($data)){
			$res = Db::table('aaz_adminuser')->where($where)->find();
			if(!empty($res)){
				if($pass == $res['password']){

					if($res['status'] == 1){
						$map = [];
						$map['last_login_ip'] = get_client_ip();
						$map['last_login_time'] = strtotime(date('Y-m-d H:i',time()));
						Db::table('aaz_adminuser')->where('username',$data['username'])->update($map);
						Session::set('admin_id',$res['id']);
						// 登录成功
					    return 0;
					}else{
						// 该账号已经被禁用
						return 1;
					}

				}else{

					//密码错误
					return 2;
				}
			}else{

				//账号不存在
				return 3;
			}
		}
	}
}
