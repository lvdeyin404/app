<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/14 0014
 * Time: 17:25
 */
namespace app\admin\model;
use think\Exception;

class AdminUser extends Common
{

    //验证用户名及密码是否正确
    public function UserCheck($data)
    {
        $userInfo = $this::where('username', $data['username'])->find();
        if(!$userInfo['id']){
            throw new Exception("用户名不存在");
        }
        if($userInfo['password'] != $this->getPassword($data['password'])){
            throw new Exception("密码错误");
        }
        return $userInfo;
    }

    //密码加密md5
    public function getPassword($password)
    {
        return md5($password.'_#ldy');
    }
}