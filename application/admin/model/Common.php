<?php
/**
 * 公共model
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/30 0030
 * Time: 21:49
 */
namespace app\admin\model;
use think\Model;

class Common extends Model
{
    //添加
    public function add($data)
    {
        if(!is_array($data)){
            throw new Exception("传递数据不合法");
        }else{
            $this->save($data);
            return $this->id;
        }
    }
}