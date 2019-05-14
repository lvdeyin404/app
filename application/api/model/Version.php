<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/14 0014
 * Time: 23:14
 */
namespace app\api\model;
use think\Model;

class Version extends Model
{
    /**
     * 根据app_type获取最后一个版本信息
     * @param $version
     */
    public function getVersion($type)
    {
        $where = [
            'app_type' => $type,
            'status' => 1
        ];

        $order = [
            'id' => 'desc'
        ];
        $data = $this->where($where)->order($order)->limit(1)->select();
        return $data;
    }
}