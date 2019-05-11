<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/30 0030
 * Time: 21:47
 */
namespace app\admin\model;

use think\facade\Config;

class News extends Common
{
    /**
     * 后台数据分页
     * @param array $data
     * @throws \think\exception\DbException
     */
    public function getNews($data = [])
    {
        //查询条件
        $data['status'] = [
            'neq',Config::get('code.status_delete')
        ];
        //排序
        $order = ['id' => 'desc'];

        $res = $this->where($data)->order($order)->paginate(Config::get('page.size'));
        return $res;
    }

    /**
     * 获取数据
     * @param array $data
     */
    public function getNewsByCondition($where = [], $from = 0, $size = 5)
    {
        //查询条件
        $where['status'] = [
            'neq',Config::get('code.status_delete')
        ];
        //排序
        $order = ['id' => 'desc'];
        //limit
        $res = $this->where($where)->limit($from, $size)->order($order)->select();
        //halt($this->getLastSql());
        return $res;
    }

    /**
     * 根据条件获取总数
     * @param array $data
     */
    public function getNewsCount($data = [])
    {
        //查询条件
        $data['status'] = [
            'neq',Config::get('code.status_delete')
        ];

        return $this->where($data)->count();
    }
}