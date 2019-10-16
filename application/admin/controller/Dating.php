<?php  
namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Config;
use think\Db;
use think\Session;
use app\admin\model\SettingModel;
class Dating extends Common
{	
	//异性直约列表
	public function heterosexual()
	{
		$data = $this->request->param();
		$where = [];
		/*发布人*/
		$phone = empty($data['phone']) ? '' : $data['phone'];
		$phone = trim($phone);
		if(!empty($phone)){
			$where['u.phone'] = ['like',"%$phone%"];
		}
		/*道具*/
		$prop = empty($data['prop']) ? '' : $data['prop'];
		$prop = trim($prop);
		if(!empty($prop)){
			$where['h.gid'] = $prop;
		}

		/*约会方式*/
		$method = empty($data['method']) ? '' : $data['method'];
		$method = trim($method);
		if(!empty($method)){
			$where['h.method'] = $method;
		}

		/*约会期望*/
		$hope = empty($data['hope']) ? '' : $data['hope'];
		$hope = trim($hope);
		if(!empty($hope)){
			$where['h.hope'] = $hope;
		}

		/*约会状态*/
		$d_status = empty($data['d_status']) ? '' : $data['d_status'];
		$d_status = trim($d_status);
		if(!empty($d_status)){
			if($d_status == 4){
				$where['h.p_status'] = 2;
			}else{
				$where['h.d_status'] = $d_status;
				$where['h.p_status'] = 1;
			}
			
		}


		/*发布状态*/
		$p_status = empty($data['p_status']) ? '' : $data['p_status'];
		$p_status = trim($p_status);
		if(!empty($p_status)){
			$where['h.p_status'] = $p_status;
		}

		$gift = Db::name('gift')->where('type',2)->select();

		$res = Db::name('heterosexual')->alias('h')
			->join('user u','h.uid=u.id','left')
			->where($where)
			->field('h.*,u.phone')
			->order('h.id','desc')
			->paginate(25,false,['query' => request()->param()]);

		$page = $res->render();
		$list = $res->all();

		foreach ($list as $k => $v) {
			$list[$k]['dating_phone'] = Db::name('user')->where('id',$v['dating_id'])->value('phone');
			if($v['p_status'] == 2){
				$list[$k]['d_status'] = 4;
			}
		}
		$this->assign('list',$list);
		$this->assign('page',$page);
		$this->assign('gift',$gift);
		$this->assign('phone',isset($data['phone']) ? $data['phone'] : '');
		$this->assign('prop',isset($data['prop']) ? $data['prop'] : '');
		$this->assign('method',isset($data['method']) ? $data['method'] : '');
		$this->assign('hope',isset($data['hope']) ? $data['hope'] : '');
		$this->assign('d_status',isset($data['d_status']) ? $data['d_status'] : '');
		$this->assign('p_status',isset($data['p_status']) ? $data['p_status'] : '');
		return $this->fetch('dating/heterosexual/index');
	}


	/**
	 * 修改发布状态
	 */
	public function edituserstatus()
	{
		$data = $this->request->param();
		$list = Db::table('aaz_heterosexual')->where('id',$data['id'])->update(['p_status'=>$data['status']]);			
		if($list){
			return returnJson($code=1,$msg="修改成功",$list);
		}else{
			return returnJson($code=2,$msg="修改失败",$list);
		}
	}

    /**
     * 修改天数弹窗
     */
    public function open()
    {
    	$data = $this->request->param();
    	$num = Db::name('heterosexual')->where('id',$data['id'])->value('daynum');
    	$this->assign('id',$data['id']);
		$this->assign('num',$num);
        return $this->fetch('dating/heterosexual/open');
    } 

    /**
     * 弹窗天数提交
     */
    public function editnum()
    {
    	$data = $this->request->param();
    	$list = Db::name('heterosexual')->where('id',$data['id'])->update(['daynum'=>$data['num']]);
    	if($list){
			return returnJson($code=1,$msg="修改成功",$list);
		}else{
			return returnJson($code=2,$msg="修改失败",$list);
		}
    
    }


    /**
     * 异性直约详情
     */
    public function details()
    {
    	$data = $this->request->param();
    	$gift = Db::name('gift')->where('type',2)->select();
    	$list = Db::name('heterosexual')->alias('h')
			->join('user u','h.uid=u.id','left')
			->where('h.id',$data['id'])
			->field('h.*,u.phone')
			->find();

		if($list['p_status'] == 2){
			$list['d_status'] = 4;
		}
		$list['dating_phone'] = Db::name('user')->where('id',$list['dating_id'])->value('phone');
    	$this->assign('list',$list);
		$this->assign('gift',$gift);
        return $this->fetch('dating/heterosexual/details');
    }


    /**
     * 邀约列表
     */
    public function invitation()
    {
    	$data = $this->request->param();
    	$list = Db::name('datinglist')->alias('d')
			->join('user u','d.uid=u.id','left')
			->where('d.hid',$data['id'])
			->field('d.*,u.phone,u.icon,u.u_name')
			->order('id','desc')
			->select();

    	$this->assign('list',$list);
        return $this->fetch('dating/heterosexual/invitation');
    } 



    /**
     * 同城约玩列表
     */
    public function samecity()
    {
    	$data = $this->request->param();
		$where = [];
		/*发布人*/
		$phone = empty($data['phone']) ? '' : $data['phone'];
		$phone = trim($phone);
		if(!empty($phone)){
			$where['u.phone'] = ['like',"%$phone%"];
		}

		/*约会期望*/
		$hope = empty($data['hope']) ? '' : $data['hope'];
		$hope = trim($hope);
		if(!empty($hope)){
			$where['s.hope'] = $hope;
		}

		/*买单方式*/
		$payway = empty($data['payway']) ? '' : $data['payway'];
		$payway = trim($payway);
		if(!empty($payway)){
			$where['s.payway'] = $payway;
		}

		/*允许带朋友*/
		$bring_friend = empty($data['bring_friend']) ? '' : $data['bring_friend'];
		$bring_friend = trim($bring_friend);
		if(!empty($bring_friend)){
			$where['s.bring_friend'] = $bring_friend;
		}

		/*剩余时间*/
		$daynum = empty($data['daynum']) ? '' : $data['daynum'];
		$daynum = trim($daynum);
		if(!empty($daynum)){
			$where['s.daynum'] = $daynum;
		}

		/*约会状态*/
		$d_status = empty($data['d_status']) ? '' : $data['d_status'];
		$d_status = trim($d_status);
		if(!empty($d_status)){
			$where['s.d_status'] = $d_status;		
		}
		$res = Db::name('samecity')->alias('s')
			->join('user u','s.uid=u.id','left')
			->where($where)
			->order('s.id','desc')
			->field('s.*,u.phone')
			->paginate(25,false,['query' => request()->param()]);

		$page = $res->render();
		$list = $res->all();
		$this->assign('list',$list);
		$this->assign('page',$page);
		$this->assign('phone',isset($data['phone']) ? $data['phone'] : '');
		$this->assign('hope',isset($data['hope']) ? $data['hope'] : '');
		$this->assign('payway',isset($data['payway']) ? $data['payway'] : '');
		$this->assign('bring_friend',isset($data['bring_friend']) ? $data['bring_friend'] : '');
		$this->assign('d_status',isset($data['d_status']) ? $data['d_status'] : '');
		$this->assign('daynum',isset($data['daynum']) ? $data['daynum'] : '');
    	return $this->fetch('dating/samecity/index');
    }

	/**
	 * 修改同城约玩发布状态
	 */
	public function editsamecity()
	{
		$data = $this->request->param();
		$res = Db::table('aaz_samecity')->where('id',$data['id'])->find();
		if($res['daynum'] == 0){
			return returnJson($code=3,$msg="剩余天数为0时不能修改");
		}
		$list = Db::table('aaz_samecity')->where('id',$data['id'])->update(['d_status'=>$data['status']]);			
		if($list){
			return returnJson($code=1,$msg="修改成功",$list);
		}else{
			return returnJson($code=2,$msg="修改失败",$list);
		}
	}

    /**
     * 修改同城约玩天数弹窗
     */
    public function opencity()
    {
    	$data = $this->request->param();
    	$num = Db::name('samecity')->where('id',$data['id'])->value('daynum');
    	$this->assign('id',$data['id']);
		$this->assign('num',$num);
        return $this->fetch('dating/samecity/open');
    } 
 
    /**
     * 弹窗天数提交
     */
    public function editnum2()
    {
    	$data = $this->request->param();
    	$list = Db::name('samecity')->where('id',$data['id'])->update(['daynum'=>$data['num']]);
    	if($list){
			return returnJson($code=1,$msg="修改成功",$list);
		}else{
			return returnJson($code=2,$msg="修改失败",$list);
		}
    
    }   

    /**
     * 删除异性直约
     */
    public function deleteheterosexual()
    {
    	$data = $this->request->param();
    	$list = Db::name('heterosexual')->where('id',$data['id'])->delete();
    	Db::name('datinglist')->where('hid',$data['id'])->delete();
    	if($list){
			return returnJson($code=1,$msg="删除成功",$list);
		}else{
			return returnJson($code=2,$msg="删除失败",$list);
		}
    }


    /**
     * 参与列表
     */
    public function participate()
    {
    	$data = $this->request->param();
    	$list = Db::name('participate')->alias('p')
			->join('user u','p.uid=u.id','left')
			->where('p.sid',$data['id'])
			->field('p.*,u.phone,u.icon,u.u_name')
			->order('id','desc')
			->select();

    	$this->assign('list',$list);
        return $this->fetch('dating/samecity/participate');
    }


    /**
     * 同城约玩详情
     */
    public function p_details()
    {
    	$data = $this->request->param();
    	$list = Db::name('samecity')->alias('p')
			->join('user u','p.uid=u.id','left')
			->where('p.id',$data['id'])
			->field('p.*,u.phone')
			->find();

		// $list['dating_phone'] = Db::name('user')->where('id',$list['dating_id'])->value('phone');
    	$this->assign('list',$list);
        return $this->fetch('dating/samecity/details');
    }

    /**
     * 删除同城约玩
     */
    public function deletesamecity()
    {
    	$data = $this->request->param();
    	$list = Db::name('samecity')->where('id',$data['id'])->delete();
    	Db::name('participate')->where('sid',$data['id'])->delete();
    	if($list){
			return returnJson($code=1,$msg="删除成功",$list);
		}else{
			return returnJson($code=2,$msg="删除失败",$list);
		}
    }

    /**
     * 附近服务列表
     */
    public function near()
    {
    	$data = $this->request->param();
		$where = [];
		/*发布人*/
		$phone = empty($data['phone']) ? '' : $data['phone'];
		$phone = trim($phone);
		if(!empty($phone)){
			$where['u.phone'] = ['like',"%$phone%"];
		}
		/*服务方式*/
		$type = empty($data['type']) ? '' : $data['type'];
		$type = trim($type);
		if(!empty($type)){
			$where['n.type'] = $type;
		}
		/*发布状态*/
		$status = empty($data['status']) ? '' : $data['status'];
		$status = trim($status);
		if(!empty($status)){
			$where['n.status'] = $status;		
		}
		$res = Db::name('near')->alias('n')
			->join('user u','n.uid=u.id','left')
			->where($where)
			->order('n.id','desc')
			->field('n.*,u.phone')
			->paginate(25,false,['query' => request()->param()]);

		$page = $res->render();
		$list = $res->all();

		foreach ($list as $k => $v) {
			$list[$k]['pic'] = explode(',',$v['pic']);
		}
		$this->assign('list',$list);
		$this->assign('page',$page);
		$this->assign('phone',isset($data['phone']) ? $data['phone'] : '');
		$this->assign('type',isset($data['type']) ? $data['type'] : '');
		$this->assign('status',isset($data['status']) ? $data['status'] : '');
    	return $this->fetch('dating/near/index');
    }

    /**
     * 修改附加服务发布状态
     */
	public function editnear()
	{
		$data = $this->request->param();
		$res = Db::table('aaz_near')->where('id',$data['id'])->find();
		$list = Db::table('aaz_near')->where('id',$data['id'])->update(['status'=>$data['status']]);			
		if($list){
			return returnJson($code=1,$msg="修改成功",$list);
		}else{
			return returnJson($code=2,$msg="修改失败",$list);
		}
	}

    /**
     * 删除附近服务
     */
    public function deletenear()
    {
    	$data = $this->request->param();
    	$list = Db::name('near')->where('id',$data['id'])->delete();
    	if($list){
			return returnJson($code=1,$msg="删除成功",$list);
		}else{
			return returnJson($code=2,$msg="删除失败",$list);
		}
    }

    /**
     * 静夜寻聊列表
     */
    public function nightchat()
    {
    	$data = $this->request->param();
		$where = [];
		/*发布人*/
		$phone = empty($data['phone']) ? '' : $data['phone'];
		$phone = trim($phone);
		if(!empty($phone)){
			$where['u.phone'] = ['like',"%$phone%"];
		}
		$res = Db::name('nightchat')->alias('n')
			->join('user u','n.uid=u.id','left')
			->where($where)
			->order('n.id','desc')
			->field('n.*,u.phone')
			->paginate(25,false,['query' => request()->param()]);

		$page = $res->render();
		$list = $res->all();

		foreach ($list as $k => $v) {
			$list[$k]['phone2'] = Db::name('user')->where('id',$v['uid2'])->value('phone');
		}
		$this->assign('list',$list);
		$this->assign('page',$page);
		$this->assign('phone',isset($data['phone']) ? $data['phone'] : '');
    	return $this->fetch('dating/nightchat/index');
    }

    /**
     * 删除静夜寻聊
     */
    public function deletenight()
    {
    	$data = $this->request->param();
    	$list = Db::name('nightchat')->where('id',$data['id'])->delete();
    	if($list){
			return returnJson($code=1,$msg="删除成功",$list);
		}else{
			return returnJson($code=2,$msg="删除失败",$list);
		}
    }
}