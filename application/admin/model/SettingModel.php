<?php
namespace app\admin\model;

use think\Model;
use think\Db;
use think\Request;
use think\Session;

class SettingModel extends Model
{

	/**
	 * 礼物列表
	 */
	public function getGift()
	{
		$res = Db::name('gift')->order('money','asc')->select();
		return $res;
	}


	/**
	 * 添加礼物提交
	 */
	public function addgiftPost($data)
	{
        if($data){
        	//查询表里是否有这个礼物
        	$gift = Db::name('gift')->where('g_name',$data['g_name'])->find();
        	if(!$gift){
        		/*礼物信息*/
	            $map = [
	                'pic'=>$data['pic'],
	                'g_name'=>$data['g_name'],
	                'money'=>$data['money'],
	                'type'=>$data['type'],
	                'addtime'=>strtotime(date('Y-m-d H:i',time()))
	            ];
	            $gift = Db::name('gift')->insertGetId($map);
	            if($gift){
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
	 * 修改礼物页面
	 */
	public function editgift($id)
	{
		if($id){
			$res = Db::name('gift')->where('id',$id)->find();
			return $res;
		}
	}

	/**
	 * 修改礼物提交
	 */
	public function editgiftPost($data)
	{
		if($data){
			$map = [
				'pic'=>$data['pic'],
                'g_name'=>$data['g_name'],
                'money'=>$data['money'],
                'type'=>$data['type'],
			];
			$gift = Db::name('gift')->where('id',$data['id'])->update($map);
			return $gift;
		}
	}

	/**
	 * 删除礼物
	 */
	public function giftdelete($id)
	{
		if($id){
			$res = Db::name('gift')->where('id',$id)->delete();
			return $res;
		}
	}


	/**
	 * 帮助中心
	 */
	public function getHelp()
	{
		$res = Db::name('help')->select();
		return $res;
	}


	/**
	 * 添加帮助提交
	*/
	public function addPost($data)
	{
		$map = [
			'title'=>$data['title'],
			'content'=>$data['content'],
			'addtime'=>time()
		];
		$res = Db::name('help')->insert($map);
		return $res;
	}


	/**
	 * 帮助中心修改
	 */
	public function getEdit($id)
	{
		if($id){
			$res = Db::name('help')->where('id',$id)->find();
			return $res;
		}
	}


	/**
	 * 帮助中心修改提交
	 */
	public function editPost($data)
	{
		$map = [
			'title'=>$data['title'],
			'content'=>$data['content'],
		];
		$res = Db::name('help')->where('id',$data['id'])->update($map);
		return $res;
	}


	/**
	 * 帮助删除
	 */
	public function getdelete($id)
	{
		if($id){
			$res = Db::name('help')->where('id',$id)->delete();
			return $res;
		}
	}

	/**
	 * 新手指引
	 */
	public function getGuide()
	{
		$res = Db::name('guide')->select();
		return $res;
	}


	/**
	 * 添加新手指引提交
	*/
	public function addPostGuide($data)
	{
		$map = [
			'title'=>$data['title'],
			'content'=>$data['content'],
			'addtime'=>time()
		];
		$res = Db::name('guide')->insert($map);
		return $res;
	}


	/**
	 * 新手指引修改
	 */
	public function getEditGuide($id)
	{
		if($id){
			$res = Db::name('guide')->where('id',$id)->find();
			return $res;
		}
	}


	/**
	 * 新手指引修改提交
	 */
	public function editPostGuide($data)
	{
		$map = [
			'title'=>$data['title'],
			'content'=>$data['content'],
		];
		$res = Db::name('guide')->where('id',$data['id'])->update($map);
		return $res;
	}


	/**
	 * 新手指引删除
	 */
	public function getdeleteGuide($id)
	{
		if($id){
			$res = Db::name('guide')->where('id',$id)->delete();
			return $res;
		}
	}

	/**
	 * 用户协议
	 */
	public function getAgreement()
	{
		$res = Db::name('setting')->where('id',1)->find();
		return $res;
	}

	/**
	 * 用户协议修改
	 */
	public function editAgreement($data)
	{
		$map = [
			'content'=>$data['content']
		];
		$res = Db::name('setting')->where('id',1)->update($map);
		return $res;
	}


	/**
	 * 反馈建议
	 */
	public function getFeedback()
	{
		$res = Db::name('feedback')->order('id','desc')->paginate(25,false,['query' => request()->param()]);
		$page = $res->render();
        $res = $res->all();
        foreach ($res as $k => $v) {
        	$res[$k]['phone'] = Db::name('user')->where('id',$v['uid'])->value('phone');
        	$res[$k]['pic'] = explode(',',$v['pic']);
        }
        return ['page'=>$page,'list'=>$res];
	}

	/**
	 * 修改功能设置状态(单个)
	 */
	public function edituserstatus($id,$data)
	{
		if($id){
			$res = Db::table('aaz_features')->where('id',$id)->update(['status'=>$data['status']]);			
			return $res;
		}
	}


	/**
	 * 当前永久VIP人数提交
	 */
	public function over($id,$num)
	{
		if($id){
			$res = Db::name('features')->where('id',$id)->update(['num'=>$num]);
			return $res;
		}
	}
}