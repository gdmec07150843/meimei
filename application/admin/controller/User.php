<?php  
namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Config;
use think\Session;
use app\admin\model\UserModel;
class User extends Common
{
	/**
	 * 用戶列表
	 */
	public function index()
	{
		$data = $this->request->param();
		$UserModel = new UserModel();
		$list = $UserModel->getuser($data);
		if($list){
			$this->assign('page',$list['page']);
			$this->assign('list',$list['list']);
		}
		$this->assign('phone',isset($data['phone']) ? $data['phone'] : '');
		$this->assign('u_name',isset($data['u_name']) ? $data['u_name'] : '');
		$this->assign('gender',isset($data['gender']) ? $data['gender'] : '');
		$this->assign('VIP',isset($data['VIP']) ? $data['VIP'] : '');
		$this->assign('status',isset($data['status']) ? $data['status'] : '');
		return $this->fetch();
	}

    /**
     * 添加用户
     */
    public function add()
    {
        return $this->fetch();
    }

    /**
     * 添加用户提交
     */
    public function addPost()
    {
        $data = $this->request->param();
        $UserModel = new UserModel();
        $list = $UserModel->addPost($data);
        if($list==1){
            return returnJson($code=1,$msg="添加成功",$list);
        }else if($list==2){
            return returnJson($code=2,$msg="添加失败",$list);
        }else if($list==3){
        	return returnJson($code=3,$msg="手机号已存在",$list);
        }
    }


    /**
     * 用户详情
     */
    public function getuserdetail()
    {
    	$data = $this->request->param();
        $UserModel = new UserModel();
        $list = $UserModel->getuserdetail($data['id']);
        $this->assign('list',$list);
        return $this->fetch('detail');
    }

	/**
	 * 修改约币
	 */
	public function editusercurrency()
	{
		$data = $this->request->param();
		$UserModel = new UserModel();
		$list = $UserModel->editusercurrency($data['uid']);
		$this->assign('list',$list);
		return $this->fetch();
	}

	/**
	 * 修改约币提交
	 */
	public function editusercurrencyPost()
	{
		$data = $this->request->param();
		$UserModel = new UserModel();
		$list = $UserModel->editusercurrencyPost($data['uid'],$data);
		if($list){
			return returnJson($code=1,$msg="修改成功",$list);
		}else{
			return returnJson($code=2,$msg="修改失败",$list);
		}
	}


	/**
	 * 喜欢列表
	 */
	public function love()
	{
		$data = $this->request->param();
        $UserModel = new UserModel();
        $list = $UserModel->getlove($data['id']);
        $this->assign('list',$list);
		return $this->fetch();
	}

	/**
	 * 心动列表
	 */
	public function Heartbeat()
	{
		$data = $this->request->param();
        $UserModel = new UserModel();
        $list = $UserModel->getHeartbeat($data['id']);
        $this->assign('list',$list);
		return $this->fetch();
	}


	/**
	 * 好感度列表
	 */
	public function favorability()
	{
		$data = $this->request->param();
        $UserModel = new UserModel();
        $list = $UserModel->getFavorability($data['id'],$data);
        $this->assign('phone',isset($data['phone']) ? $data['phone'] : '');
		$this->assign('u_name',isset($data['u_name']) ? $data['u_name'] : '');
		$this->assign('uid',$data['id']);
        $this->assign('list',$list);
		return $this->fetch();
	}


	/**
	 * 删除用户(单个)
	 */
	public function deleteuserone()
	{
		$data = $this->request->param();
		$UserModel = new UserModel();
		$list = $UserModel->deleteuser($data['id']);
		if($list){
			return returnJson($code=1,$msg="删除成功",$list);
		}else{
			return returnJson($code=2,$msg="删除失败",$list);
		}
	}

	/**
	 * 修改用户状态(单个)
	 */
	public function edituserstatus()
	{
		$data = $this->request->param();
		$UserModel = new UserModel();
		$list = $UserModel->edituserstatus($data['id'],$data);
		if($list){
			return returnJson($code=1,$msg="修改成功",$list);
		}else{
			return returnJson($code=2,$msg="修改失败",$list);
		}
	}
}