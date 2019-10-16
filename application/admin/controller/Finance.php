<?php  
namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Config;
use think\Db;
use think\Session;
class Finance extends Common
{	

	/**
	 * 提现审核
	 */
	public function index()
	{
		$data = $this->request->param();
		$where = [];
		/*提现单号*/
		$order_num = empty($data['order_num']) ? '' : $data['order_num'];
		$order_num = trim($order_num);
		if(!empty($order_num)){
			$where['w.order_num'] = ['like',"%$order_num%"];
		}
		/*提现账号*/
		$account = empty($data['account']) ? '' : $data['account'];
		$account = trim($account);
		if(!empty($account)){
			$where['w.account'] = ['like',"%$account%"];
		}
		/*提现状态*/
		$status = empty($data['status']) ? '' : $data['status'];
		$status = trim($status);
		if(!empty($status)){
			$where['w.status'] = $status;
		}

		$res = Db::name('withdraw')->alias('w')
			->join('user u','w.uid=u.id','left')
			->where($where)
			->field('w.*,u.phone')
			->order('w.id','desc')
			->paginate(25,false,['query' => request()->param()]);

		$page = $res->render();
		$list = $res->all();
		$this->assign('list',$list);
		$this->assign('page',$page);
		$this->assign('order_num',isset($data['order_num']) ? $data['order_num'] : '');
		$this->assign('account',isset($data['account']) ? $data['account'] : '');
		$this->assign('status',isset($data['status']) ? $data['status'] : '');
		return $this->fetch();
	}


	/**
	 * 审核状态改变
	 */
	public function editstatus()
	{
		$data = $this->request->param();
		$list = Db::name('withdraw')->where('id',$data['id'])->update(['status'=>$data['status'],'endtime'=>time()]);
		if($list){
			return returnJson($code=1,$msg="修改成功",$list);
		}else{
			return returnJson($code=2,$msg="修改失败",$list);
		}
	}
}