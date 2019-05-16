<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/9 0009
 * Time: 0:27
 */
namespace app\api\controller;
use app\common\exception\ApiException;
use app\common\lib\Aes;
use app\common\lib\IAuth;
use app\common\lib\Time;
use Qiniu\Auth;
use think\App;
use think\Cache;
use think\Controller;
use think\facade\Config;
use think\Request;

class Base extends Controller
{
    /**
     * 客户端传递的header头数据
     * @var string
     */
    public $header = '';

    /**
     * 保存已登陆用户的信息
     * @var string
     */
    public $userInfo = '';

    public function __construct()
    {
        $this->checkRequestAuth();
        //$this->AesTest();
    }

    /**
     * 检查客户端请求的数据是否合法
     */
    public function checkRequestAuth()
    {
        //获取header中的数据
        $header = request()->header();
        //参数校验
        if(empty($header['sign'])){
            throw new ApiException('sign不存在', '400');
        }
        if(empty($header['apptype']) || !in_array($header['apptype'], Config::get('salt.app_type'))){
            throw new ApiException('app_type不合法', '400');
        }
        //验证sign
        if(!IAuth::checkSign($header)){
            throw new ApiException('sign验证失败', '401');
        }
        //请求后存入缓存中  设定缓存时间  防止黑客抓包多次访问
        //Cache::set($header['sign'], 1, Config::get('salt.app_sign_cache_time'));
        \cache($header['sign'], 1, Config::get('salt.app_sign_cache_time'));

        //header数据保存便于使用  三种方法
        //1 文件  2 mysql  3 redis
        //这里使用第一种方式保存  如果服务器是多服务器情况可以使用后面两种方法
        $this->header = $header;
    }

    /**
     * 获取分类名称
     * @param $data
     */
    protected function getCatName($data)
    {
        if(empty($data)){
            return '';
        }
        $cates = Config::get('cate.lists');
        foreach ($data as $key=>$val){
            $data[$key]['cate_name'] = $cates[$data[$key]['cate_id']];
        }
        return $data;
    }

    public function AesTest()
    {
        //测试数据  实际应该从客户端传过来
        $data = [
            'name' => 'lvdeyin',
            'version' => '1.0',
            'did' => '22323erwer',
            'time' => Time::get13Time()
        ];
        dump(IAuth::setSign($data));

    }
}