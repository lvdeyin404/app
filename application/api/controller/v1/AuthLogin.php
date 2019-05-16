<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/16 0016
 * Time: 23:03
 */
namespace app\api\controller\v1;
use app\api\controller\Base;
use app\api\model\User;

class AuthLogin extends Base
{
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * @return bool
     */
    public function isLogin()
    {
        if(empty($this->header['access_user_token'])){
            return false;
        }
        //客户端工程师可以先解密token(AES) 在通过自己的加密方式传递数据给后端
        //后端在解密出数据
        //此处省略

        $token = "5375fa7b395fabec15d8073bfc9d8f664cfc61c6";

        //查询用户信息
        $user = User::get(['token'=>$token]);
        if(!$user || $user->status != 1){
            return false;
        }

        //登陆是否超时
        if(time() > $user->time_out){
            return false;
        }

        $this->userInfo = $user;
        return true;
    }
}