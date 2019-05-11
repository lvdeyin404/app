<?php
/**
 * time相关
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/9 0009
 * Time: 21:03
 */
namespace app\common\lib;
use app\common\exception\ApiException;

class Time
{
    /**
     * 获取13位时间戳
     * @return int
     */
    public static function get13Time()
    {
        list($t1, $t2) = explode(' ',microtime());
        $time = $t2.ceil($t1*1000);
        return $time;
    }
}