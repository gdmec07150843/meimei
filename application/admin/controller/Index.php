<?php
namespace app\admin\controller;

use think\Controller;
use think\Session;
use think\Request;
use app\admin\model\IndexModel;

class Index extends Common
{
    public function index()
    {
    	$IndexModel = new IndexModel();
    	$list = $IndexModel->getAdminUser();
        $menu = $IndexModel->getausermenu();
    	$this->assign('list',$list);
        $this->assign('menu',$menu);
    	return $this->fetch();
    }

    public function index_v1()
    {
        $IndexModel = new IndexModel();
        $list = $IndexModel->getindexdata();
        $this->assign('list',$list);
    	return $this->fetch();
    }

    /**
    *   修改密码页面
    */
    public function editpass()
    {
        return $this->fetch();
    }

    /**
    *   修改密码提交
    */
    public function editPassPost()
    {
        if ($this->request->isPost()) {
            $admin_id = Session::get('admin_id');
            $data = $this->request->param();

            // 数据验证
            $result = $this->validate($data, 'EditPassValidate');

            if ($result !== true) {
                $this->error($result);
            }

            $IndexModel = new IndexModel();
            $list = $IndexModel->editpassPost($admin_id,$data);

            if($list === 2){
                $this->error('原密码不正确');
            }elseif($list === 3){
                $this->error('新密码和确认密码不一致');
            }else{
                $this->success('修改成功');
            }
        }
    }
}
