<?php  
namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Config;
use think\Db;
use think\Session;
class Ranking extends Common
{	

	/**
	 * 直约配对榜
	 */
	public function matchinglist()
	{
		$data = $this->request->param();

		$where = [];

		/*发布人手机号*/
		$phone = empty($data['phone']) ? '' : $data['phone'];
		$phone = trim($phone);
		if(!empty($phone)){
			$where['phone'] = ['like',"%$phone%"];
		}

		/*邀约人手机号*/
		$phone2 = empty($data['phone2']) ? '' : $data['phone2'];
		$phone2 = trim($phone2);
		if(!empty($phone2)){
			$where['phone2'] = ['like',"%$phone2%"];
		}


		$res = Db::name('matchinglist')->order('id','desc')->where($where)->paginate(25,false,['query' => request()->param()]);

		$page = $res->render();
		$list = $res->all();

		foreach ($list as $k => $v) {
			$list[$k]['gift'] = Db::name('gift')->where('id',$v['gid'])->value('g_name');
		}

		$this->assign('list',$list);
		$this->assign('page',$page);
		$this->assign('phone',isset($data['phone']) ? $data['phone'] : '');
		$this->assign('phone2',isset($data['phone2']) ? $data['phone2'] : '');
		return $this->fetch('ranking/matchinglist/index');
	}


	/**
	 * 修改开启状态
	 */
	public function edituserstatus()
	{
		$data = $this->request->param();
		$list = Db::table('aaz_matchinglist')->where('id',$data['id'])->update(['status'=>$data['status']]);			
		if($list){
			return returnJson($code=1,$msg="修改成功",$list);
		}else{
			return returnJson($code=2,$msg="修改失败",$list);
		}
	}

	/**
	 * 添加直约配对榜
	 */
	public function addmatchinglist()
	{
		$gift = Db::name('gift')->where('type',2)->select();
		$this->assign('gift',$gift);
		return $this->fetch('ranking/matchinglist/add');
	}

	/**
	 * 添加直约配对榜提交
	 */
	public function addmatchinglistPost()
	{
		$data = $this->request->param();
		
		$phone = Db::name('user')->where('phone',$data['phone'])->find();		

		if($phone == ''){
			return returnJson($code=3,$msg="发布人手机号不存在");
		}

		$phone2 = Db::name('user')->where('phone',$data['phone2'])->find();		

		if($phone2 == ''){
			return returnJson($code=3,$msg="邀约人手机号不存在");
		}


		$data['addtime'] = time();

		$list = Db::name('matchinglist')->insertGetId($data);
				
		if($list){
			return returnJson($code=1,$msg="添加成功",$list);
		}else{
			return returnJson($code=2,$msg="添加失败",$list);
		}
	}

	/**
	 * PC榜
	 */
	public function pclist()
	{
		$data = $this->request->param();

		$where = [];

		/*男性手机号*/
		$m_phone = empty($data['m_phone']) ? '' : $data['m_phone'];
		$m_phone = trim($m_phone);
		if(!empty($m_phone)){
			$where['m_phone'] = ['like',"%$m_phone%"];
		}

		/*女性手机号*/
		$w_phone = empty($data['w_phone']) ? '' : $data['w_phone'];
		$w_phone = trim($w_phone);
		if(!empty($w_phone)){
			$where['w_phone'] = ['like',"%$w_phone%"];
		}


		$res = Db::name('pclist')->order('heartbeat','desc')->where($where)->paginate(25,false,['query' => request()->param()]);

		$page = $res->render();
		$list = $res->all();

		$this->assign('list',$list);
		$this->assign('page',$page);
		$this->assign('m_phone',isset($data['m_phone']) ? $data['m_phone'] : '');
		$this->assign('w_phone',isset($data['w_phone']) ? $data['w_phone'] : '');
		return $this->fetch('ranking/pclist/index');
	}


	/**
	 * 修改PC榜开启状态
	 */
	public function editpcstatus()
	{
		$data = $this->request->param();
		$list = Db::table('aaz_pclist')->where('id',$data['id'])->update(['status'=>$data['status']]);			
		if($list){
			return returnJson($code=1,$msg="修改成功",$list);
		}else{
			return returnJson($code=2,$msg="修改失败",$list);
		}
	}

	/**
	 * 添加PC榜
	 */
	public function addpclist()
	{
		return $this->fetch('ranking/pclist/add');
	}

	/**
	 * 添加直约配对榜提交
	 */
	public function addpclistPost()
	{
		$data = $this->request->param();
		
		$m_phone = Db::name('user')->where('phone',$data['m_phone'])->find();		

		if($m_phone == ''){
			return returnJson($code=3,$msg="男性手机号不存在");
		}

		if($m_phone['gender'] != 1){
			return returnJson($code=3,$msg="男性手机号性别不为男");
		}

		$w_phone = Db::name('user')->where('phone',$data['w_phone'])->find();	
		if($w_phone == ''){
			return returnJson($code=3,$msg="女性手机号不存在");
		}

		if($w_phone['gender'] != 2){
			return returnJson($code=3,$msg="女性手机号性别不为女");
		}


		$data['addtime'] = time();

		$list = Db::name('pclist')->insertGetId($data);
				
		if($list){
			return returnJson($code=1,$msg="添加成功",$list);
		}else{
			return returnJson($code=2,$msg="添加失败",$list);
		}
	}
}