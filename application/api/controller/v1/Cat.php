<?php
/**
 * Car相关
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/11 0011
 * Time: 22:15
 */
namespace app\api\controller\v1;

use app\api\controller\Base;
use think\facade\Config;

class Cat extends Base
{
    /**
     * 首页栏目接口
     * @return \think\response\Json
     */
    public function index()
    {
        $cat = Config::get('cate.lists');
        $data[] = [
            'cat_id' => 0,
            'name' => '首页'
        ];
        foreach ($cat as $catkey => $catval){
            $data[] = [
                'cat_id' => $catkey,
                'name' => $catval
            ];
        }
        return apiShow('1', 'ok', $data, 200);
    }
}