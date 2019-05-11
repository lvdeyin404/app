<?php
/**
 * 工具类
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/29 0029
 * Time: 23:41
 */
namespace app\common\tools;
class Util
{
    /**
     * API输出格式
     * @param $status
     * @param string $message
     * @param array $data
     */
    public static function show($status, $message='', $data=[])
    {
        $data = [
            'status' => $status,
            'message' => $message,
            'data' => $data
        ];
        return json_encode($data);
    }
}