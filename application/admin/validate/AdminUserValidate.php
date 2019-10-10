<?php
namespace app\admin\validate;

use think\Validate;

class AdminUserValidate extends Validate
{
    protected $rule = [
        'username' => 'require',
        'password' => 'require',
    ];

    protected $message = [
        'username.require' => '用户名不能为空',
        'password.require' => '密码不能为空',    
    ];
}
