<?php
/**
 * 后台公共控制器
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/14 0014
 * Time: 23:51
 */

namespace app\admin\controller;
use think\App;
use think\Controller;
use think\facade\Config;

class Base extends Controller
{
    /**
     * 分页数
     * @var
     */
    public $size = '';

    /**
     * page
     * @var
     */
    public $page = '';

    /**
     * 查询条件的起始值
     * @var int
     */
    public $from = 0;
    public function __construct()
    {
        parent::__construct(); //先执行父类构造方法
        //登录检查
        $this->checkUser();
    }

    public function checkUser()
    {
        if(!session('?userInfo')){
            //未登录，请先登录
            $this->error('非法用户,请先登录','Login/index');
        }
    }

    public function setPageParam($data)
    {
        $this->page = !empty($data['page']) ? $data['page'] : 1;
        $this->size = !empty($data['size']) ? $data['size'] : Config::get('page.size');
        $this->from = ($this->page - 1) * $this->size;
    }
}