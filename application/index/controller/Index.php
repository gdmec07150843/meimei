<?php
namespace app\index\controller;
use Firebase\JWT\JWT;
class Index
{
    public function index()
    {
        return '<style type="text/css">*{ padding: 0; margin: 0; } .think_default_text{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p> ThinkPHP V5<br/><span style="font-size:30px">十年磨一剑 - 为API开发设计的高性能框架</span></p><span style="font-size:22px;">[ V5.0 版本由 <a href="http://www.qiniu.com" target="qiniu">七牛云</a> 独家赞助发布 ]</span></div><script type="text/javascript" src="https://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script><script type="text/javascript" src="https://e.topthink.com/Public/static/client.js"></script><think id="ad_bd568ce7058a1091"></think>';
    }
    public function getToken(){
        $key = md5("474293e87b1dd5ef2f3bf9b2c120d1fa");  //这里是自定义的一个随机字串，应该写在config文件中的，解密时也会用，相当    于加密中常用的 盐  salt
        $token = [
            "iss"=>"",  //签发者 可以为空
            "aud"=>"", //面象的用户，可以为空
            "iat" => time(), //签发时间
            "nbf" => time(), //在什么时候jwt开始生效  （这里表示生成100秒后才生效）
            "exp" => time()+720000000, //token 过期时间
            "uid" => 123 //记录的userid的信息，这里是自已添加上去的，如果有其它信息，可以再添加数组的键值对
        ];
        $jwt = JWT::encode($token,$key,"HS256"); //根据参数生成了 token
        return json([
            "token"=>$jwt
        ]);
    }

	public function check(){
        $jwt = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiIiLCJhdWQiOiIiLCJpYXQiOjE1NzEwNTM1NTYsIm5iZiI6MTU3MTA1MzU1NiwiZXhwIjoyMjkxMDUzNTU2LCJ1aWQiOjEyM30.gGpvJmGTyPfGBZzCXl3_y3j8H-UsDmFIFDWESLd7x6c';  //上一步中返回给用户的token
        $key = md5("474293e87b1dd5ef2f3bf9b2c120d1fa");  //上一个方法中的 $key 本应该配置在 config文件中的
        $info = JWT::decode($jwt,$key,["HS256"]); //解密jwt
        return json($info);
    }
}
