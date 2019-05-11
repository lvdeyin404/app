<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/14 0014
 * Time: 18:00
 */
namespace app\admin\controller;
use app\admin\model\AdminUser;
use think\Controller;
use think\Exception;
use think\facade\Request;

class Login extends Controller
{
    public function index()
    {
        //判断是否登录
        if(session('?userInfo')){
            $this->redirect('Index/index');
        }
        return $this->fetch();
    }

    //登录验证
    public function check()
    {
        //获取提交数据
        if(Request::isPost()){
            $data = Request::post();
            //验证数据完整性
            $validate = validate('Login');
            if(!$validate->check($data)){
                $this->error($validate->getError());
            }else{
                //验证验证码是否正确
                if(!captcha_check($data['code'])){
                    $this->error("验证码错误");
                }
                //验证登录名密码
                $adminuser = new AdminUser();
                try{
                    $userInfo = $adminuser->UserCheck($data);
                }catch (Exception $e){
                    $this->error($e->getMessage());
                }
                //保存会话session
                session('userInfo', $userInfo);
                //跳转
                $this->success('登录成功','Index/index');
            }
        }
    }

    //退出登录
    public function logout()
    {
        //清楚登录会话
        session('userInfo',null);
        //跳转login页
        $this->redirect('Login/index');
    }
}