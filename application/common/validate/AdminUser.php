<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/14 0014
 * Time: 16:59
 */
namespace app\common\validate;
use think\Validate;

class AdminUser extends Validate
{
    protected $rule = [
        'username' => 'require|max:20',
        'password' => 'require|max:20',
    ];
}