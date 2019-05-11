<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/14 0014
 * Time: 16:34
 */
namespace app\admin\controller;
use app\admin\model\AdminUser;
use think\Exception;
use think\Request;
use app\common;

class Admin extends Base
{
    public function add(Request $request)
    {
        //判断是否为post提交
        if($request->isPost()){
            $data = input('post.');
            //验证数据完整性
            $validate = validate('AdminUser');
            if(!$validate->check($data)){
                $this->error($validate->getError());
            }else{
                $data['password'] = md5($data['password'].'_#ldy');
                $data['status'] = 1;
                //数据入库
                try{
                    $AdminUser = new AdminUser();
                    if($id = $AdminUser->add($data)){
                        $this->success('添加成功,管理员ID--'.$id);
                    }
                }catch (Exception $e){
                    $this->error($e->getMessage());
                }
            }
        }else{
            return $this->fetch();
        }
    }
}