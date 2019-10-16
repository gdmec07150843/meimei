<?php  
namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Config;
use think\Db;
use think\Session;
use app\admin\model\SettingModel;
class Setting extends Common
{	

	/**
	 * 礼物列表
	 */
	public function gift()
	{
		$SettingModel = new SettingModel();
		$list = $SettingModel->getGift();
		$this->assign('list',$list);
		return $this->fetch();
	}

	/**
	 * 添加礼物
	 */
    public function addgift()
    {
        return $this->fetch();
    }

    /**
     * 添加礼物提交
     */
    public function addgiftPost()
    {
        $data = $this->request->param();
        $SettingModel = new SettingModel();
        $list = $SettingModel->addgiftPost($data);
        if($list==1){
            return returnJson($code=1,$msg="添加成功",$list);
        }else if($list==2){
            return returnJson($code=2,$msg="添加失败",$list);
        }else if($list==3){
        	return returnJson($code=3,$msg="礼物已存在",$list);
        }
    }



    /**
     * 修改礼物页面
     */
    public function editgift()
    {
    	$data = $this->request->param();
    	$SettingModel = new SettingModel();
        $list = $SettingModel->editgift($data['id']);
        $this->assign('list',$list);
		return $this->fetch();
    }


    /**
     * 修改礼物提交
     */
    public function editgiftPost()
    {
    	$data = $this->request->param();
        $SettingModel = new SettingModel();
        $list = $SettingModel->editgiftPost($data);
        if($list){
            return returnJson($code=1,$msg="添加成功",$list);
        }else{
            return returnJson($code=2,$msg="添加失败",$list);
        }
    }

    /**
     * 删除礼物
     */
    public function giftdelete()
    {
    	$data = $this->request->param();
        $SettingModel = new SettingModel();
        $list = $SettingModel->giftdelete($data['id']);
        if($list){
            return returnJson($code=1,$msg="删除成功",$list);
        }else{
            return returnJson($code=2,$msg="删除失败",$list);
        }
    }

    /**
     * 帮助中心
     */
    public function index()
    {
        $SettingModel = new SettingModel();
        $list = $SettingModel->getHelp();
        $this->assign('list',$list);
        return $this->fetch();
    }


    /**
     * 帮助中心添加
     */
    public function add()
    {
        return $this->fetch();
    }

    /**
     * 帮助中心添加提交
     */
    public function addPost()
    {
        $data = $this->request->param();
        $SettingModel = new SettingModel();
        $list = $SettingModel->addPost($data);
        if($list){
            return returnJson($code=1,$msg="添加成功",$list);
        }else{
            return returnJson($code=2,$msg="添加失败",$list);
        }
    }



    /**
     * 帮助中心修改
     */
    public function edit()
    {
        $data = $this->request->param();
        $SettingModel = new SettingModel();
        $list = $SettingModel->getEdit($data['id']);
        $this->assign('id',$data['id']);
        $this->assign('list',$list);
        return $this->fetch();
    }

    /**
     * 帮助中心修改提交
     */
    public function editPost()
    {
        $data = $this->request->param();
        $SettingModel = new SettingModel();
        $list = $SettingModel->editPost($data);
        if($list){
            return returnJson($code=1,$msg="添加成功",$list);
        }else{
            return returnJson($code=2,$msg="添加失败",$list);
        }
    }


    /**删除帮助*/
    public function getdelete()
    {
        $data = $this->request->param();
        $SettingModel = new SettingModel();
        $list = $SettingModel->getdelete($data['id']);
        if($list){
            return returnJson($code=1,$msg="删除成功",$list);
        }else{
            return returnJson($code=2,$msg="删除失败",$list);
        }
    }



    /**
     * 新手指引
     */
    public function guideindex()
    {
        $SettingModel = new SettingModel();
        $list = $SettingModel->getGuide();
        $this->assign('list',$list);
        return $this->fetch('guide/index');
    }


    /**
     * 新手指引添加
     */
    public function addGuide()
    {
        return $this->fetch('guide/add');
    }

    /**
     * 新手指引添加提交
     */
    public function addPostGuide()
    {
        $data = $this->request->param();
        $SettingModel = new SettingModel();
        $list = $SettingModel->addPostGuide($data);
        if($list){
            return returnJson($code=1,$msg="添加成功",$list);
        }else{
            return returnJson($code=2,$msg="添加失败",$list);
        }
    }



    /**
     * 新手指引修改
     */
    public function editGuide()
    {
        $data = $this->request->param();
        $SettingModel = new SettingModel();
        $list = $SettingModel->getEditGuide($data['id']);
        $this->assign('id',$data['id']);
        $this->assign('list',$list);
        return $this->fetch('guide/edit');
    }

    /**
     * 新手指引修改提交
     */
    public function editPostGuide()
    {
        $data = $this->request->param();
        $SettingModel = new SettingModel();
        $list = $SettingModel->editPostGuide($data);
        if($list){
            return returnJson($code=1,$msg="修改成功",$list);
        }else{
            return returnJson($code=2,$msg="修改失败",$list);
        }
    }


    /**删除新手指引*/
    public function getdeleteGuide()
    {
        $data = $this->request->param();
        $SettingModel = new SettingModel();
        $list = $SettingModel->getdeleteGuide($data['id']);
        if($list){
            return returnJson($code=1,$msg="删除成功",$list);
        }else{
            return returnJson($code=2,$msg="删除失败",$list);
        }
    }


    /**
     * 用户协议显示
     */
    public function agreement()
    {
        $SettingModel = new SettingModel();
        $list = $SettingModel->getAgreement();
        $this->assign('list',$list);
        return $this->fetch();
    }

    /**
     * 用户协议修改
     */
    public function editAgreement()
    {
        $data = $this->request->param();
        $SettingModel = new SettingModel();
        $list = $SettingModel->editAgreement($data);
        if($list){
            return returnJson($code=1,$msg="修改成功",$list);
        }else{
            return returnJson($code=2,$msg="修改失败",$list);
        }
    }


    /**
     * 建议反馈
     */
    public function feedback()
    {
        $SettingModel = new SettingModel();
        $list = $SettingModel->getFeedback();
        $this->assign('page',$list['page']);
        $this->assign('list',$list['list']);     
        return $this->fetch();
    }

    /**
     * 功能设置
     */
    public function features()
    {
        //礼金直约、同城约玩倒计时
        $countdown = Db::name('features')->where('id',1)->find();

        //定位屏蔽功能
        $shield = Db::name('features')->where('id',2)->find();

        //排行榜显示数量
        $lbnum = Db::name('features')->where('id',3)->find();

        //排行榜查看头像详情
        $lbdetail = Db::name('features')->where('id',4)->find();

        //寻聊优先功能
        $priority = Db::name('features')->where('id',5)->find();

        //当前永久VIP人数
        $vipnum = Db::name('features')->where('id',6)->find();

        $this->assign('countdown',$countdown);  
        $this->assign('shield',$shield);  
        $this->assign('lbnum',$lbnum);  
        $this->assign('lbdetail',$lbdetail);  
        $this->assign('priority',$priority);    
        $this->assign('vipnum',$vipnum);   
        return $this->fetch();
    }

    /**
     * 修改功能设置状态(单个)
     */
    public function edituserstatus()
    {
        $data = $this->request->param();
        $SettingModel = new SettingModel();
        $list = $SettingModel->edituserstatus($data['id'],$data);
        if($list){
            return returnJson($code=1,$msg="修改成功",$list);
        }else{
            return returnJson($code=2,$msg="修改失败",$list);
        }
    }

    /**
     * 当前永久vip人数弹窗
     */
    public function open()
    {
        $num = Db::name('features')->where('id',6)->value('num');
        $this->assign('num',$num);
        $this->assign('id',6);
        return $this->fetch();
    }


    /**
     * 当前永久VIP人数提交
     */
    public function over()
    {
        $data = $this->request->param();
        $SettingModel = new SettingModel();
        $list = $SettingModel->over($data['id'],$data['num']);
        if($list){
            return returnJson($code=1,$msg="提交成功",$list);
        }else{
            return returnJson($code=2,$msg="提交失败",$list);
        }
    }



    /**
     * 基础图片设置页面
     */
    public function basicpic()
    {
        $pic = Db::name('basicpic')->select();
        $this->assign('pic',$pic);
        return $this->fetch();
    }


    /**
     * 基础图片页面编辑
     */
    public function editpic()
    {
        $data = $this->request->param();
        $list = Db::name('basicpic')->where('id',$data['id'])->find();
        $this->assign('list',$list);
        return $this->fetch();
    }


    /**
     * 基础图片页面编辑提交
     */
    public function editpicPost()
    {
        $data = $this->request->param();
        if($data['id'] == 1){
            $map = [
                'img1'=>$data['img1'],
                'img2'=>$data['img2'],
                'img3'=>$data['img3']   
            ];
        }

        if($data['id'] == 2 || $data['id'] == 3){
            $map = [
                'img1'=>$data['img1']
            ];
        }

        if($data['id'] == 4){
            $map = [
                'img1'=>$data['img1'],
                'img2'=>$data['img2'],
                'img3'=>$data['img3'],
                'img4'=>$data['img4'],
                'img5'=>$data['img5']    
            ];
        }        
        // dump($map);
        // exit;
        $list = Db::name('basicpic')->where('id',$data['id'])->update($map);
        if($list){
            return returnJson($code=1,$msg="修改成功",$list);
        }else{
            return returnJson($code=2,$msg="修改失败",$list);
        }
    }


    /**
     * 基础文案设置页面
     */
    public function basiccopy()
    {
        $list = Db::name('basiccopy')->select();
        $this->assign('list',$list);
        return $this->fetch();
    }   


    /**
     * 基础文案编辑
     */
    public function editcopy()
    {
        $data = $this->request->param();
        $list = Db::name('basiccopy')->where('id',$data['id'])->find();
        $this->assign('list',$list);
        return $this->fetch();
    }


    /**
     * 基础文案编辑提交
     */
    public function editPostcopy()
    {
        $data = $this->request->param();
        $map = [
            'content'=>$data['content']
        ];
        $list = Db::name('basiccopy')->where('id',$data['id'])->update($map);
        if($list){
            return returnJson($code=1,$msg="修改成功",$list);
        }else{
            return returnJson($code=2,$msg="修改失败",$list);
        }
    }
}