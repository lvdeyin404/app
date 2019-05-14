<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/13 0013
 * Time: 22:47
 */
namespace app\api\model;
use think\Model;

class News extends Model
{
    /**
     * 获取首页头图
     */
    public function getNewsTitleImage($number = 4)
    {
        $where = [
            'status' => 1,
            'is_head_figure' => 1
        ];
        $order = [
            'id' => 'desc',
        ];
        return $this->where($where)->field(['id','title','cate_id','image','read_count'])->order($order)->limit($number)->select();
    }

    public function getNewsPosition($number = 10)
    {
        $where = [
            'status' => 1,
            'is_position' => 1
        ];
        $order = [
            'id' => 'desc',
        ];
        return $this->where($where)->field(['id','title','cate_id','image','read_count'])->order($order)->limit($number)->select();
    }
}