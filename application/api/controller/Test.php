<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/8 0008
 * Time: 18:25
 */
namespace app\api\controller;
use app\common\exception\ApiException;
use app\common\lib\Aes;
use think\Controller;
use think\Exception;

class Test extends Base
{
    public function index()
    {
        return apiShow('101', 'ok', '', 200);
    }

    public function save()
    {
        //echo $this->AesTest();
//        $str = 'QmdrXMXarByg+EHxaOaIF+mZSwSfbH7Blj9QgCcrlIo=';
//        echo (new Aes())->decrypt($str);
//        exit();
//        if(input('param.')['age'] = 10){
//            throw new ApiException('您提交的数据不合法', '400');
//        }
//        try{
//            model('xxx');
//        }catch (\Exception $e){
//            throw new ApiException($e->getMessage(), '404');
//        }
        return apiShow('1','ok',input('param.'),'200');
    }

}