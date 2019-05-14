<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/14 0014
 * Time: 23:52
 */
namespace app\api\model;
use app\common\exception\ApiException;
use think\Model;

class Active extends Model
{
    /**
     * 添加数据
     */
    public function add($data)
    {
        if(!is_array($data)){
            throw new ApiException("传递数据不合法", '404');
        }else{
            $this->save($data);
        }
    }
}