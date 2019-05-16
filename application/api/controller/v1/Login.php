<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/16 0016
 * Time: 21:16
 */
namespace app\api\controller\v1;
use app\api\controller\Base;
use app\api\model\User;
use app\common\lib\Aes;
use app\common\lib\IAuth;
use think\Model;
use think\Request;

class Login extends Base
{
    /**
     * 用户登陆验证  (短信验证码登陆)
     * @return \think\response\Json
     */
    public function save(Request $request)
    {
        //判断是否通过post提交
        if(!$request->isPost()){
            return apiShow('0', '您没有权限', '', 403);
        }
        $param = input('param.');

        //数据验证  这里做测试  实际可以用validate验证机制
        if(empty($param['phone'])){
            return apiShow('0', '手机号码不合法', '', 404);
        }
        if(empty($param['code'])){
            return apiShow('0', '验证码不合法', '', 404);
        }

        //获取缓存的手机验证码  ---这里没有做短信发送 使用测试
        $code = 9511;

        //判断验证码是否正确
        if($code != $param['code']){
            return apiShow('0', '验证码错误', '', 404);
        }

        //获取token
        $token = IAuth::getLoginToken($param['phone']);

        //修改信息
        $data = [
            'token' => $token,
            'time_out' => strtotime("+7days"),
        ];

        //判断是否是第一次登陆
        $user = User::get(['phone'=>$param['phone']]);
        if($user && $user->status == 1){
            //用户存在  修改信息
            $id = model('user')->save($data, ['phone'=>$param['phone']]);
        }else{
            //用户不存在  注册
            $data['username'] = "新用户--".$param['phone'];
            $data['status'] = 1;
            $data['create_time'] = time();
            $data['phone'] = $param['phone'];
            $id = model('user')->save($data);
        }
        if($id){
            $res = [
                'token' => (new Aes())->encrypt($token)
            ];
            return apiShow('1', 'ok', $res, 200);
        }else{
            return apiShow('0', 'error', '', 500);
        }
    }
}