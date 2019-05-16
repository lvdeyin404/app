<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/9 0009
 * Time: 21:03
 */
namespace app\common\lib;
use app\common\exception\ApiException;
use think\Controller;
use think\facade\Cache;
use think\facade\Config;

class IAuth
{
    /**
     * 生成sign
     * @param array $data
     * @return HexString
     * @throws ApiException
     */
    public static function setSign($data = [])
    {
        // 按字段进行排序
        ksort($data);
        // 组装数据 & 连接
        $data = http_build_query($data);
        // aes加密
        $str = (new Aes())->encrypt($data);
        return $str;
    }

    /**
     * 校验sign
     * @param array $data
     * @return bool
     */
    public static function checkSign($data = [] )
    {
        //解密sign (AES)
        $str = (new Aes())->decrypt($data['sign']);
        if(empty($str)){
            return false;
        }
        //转换为数组
        parse_str($str, $arr);

        if(!is_array($arr) || empty($arr['did']) || $arr['did'] != $data['did']){
            return false;
        }

        //测试模式暂时不验证 方便测试
        if(Config::get('app.app_debug')){
            //判断时间是否过期
            if(time() - ceil(($arr['time'])/1000) > Config::get('salt.app_sign_time')){
                return false;
            }
            //判断是否访问过
            if(Cache::get($data['sign'])){  //如果缓存存在 则已经访问
                return false;
            }
        }
        return true;
    }

    /**
     * 生成唯一性token
     * @param string $phone
     * @return string
     */
    public static function getLoginToken($phone = '')
    {
        $data = md5(uniqid(md5(microtime(true)), true));
        $data = sha1($data);
        return $data;
    }
}