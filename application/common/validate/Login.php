<?php
/**
 * 登录数据验证
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/15 0015
 * Time: 21:42
 */
namespace app\common\validate;
use think\Validate;

class Login extends Validate
{
    protected $rule = [
        'username' => 'require|max:20',
        'password' => 'require|max:20',
        'code' => 'require'
    ];

    protected $message  =   [
        'code.require' => '验证码不能为空'
    ];
}
