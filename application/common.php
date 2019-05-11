<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
/**
 * 获取分类名称
 * @param $cate
 */
function getCate($cate)
{
    if(empty($cate)){
        return "";
    }
    return \think\facade\Config::get('cate.lists')[$cate];
}

/**
 * 获取状态
 * @param $status
 * @return string
 */
function getStatus($status)
{
    if($status == 1){
        return "<span class='label label-success radius'>"."已发布"."</span>";
    }else if ($status == 0){
        return "<span class='label label-error radius'>"."已停用"."</span>";
    }else{
        return "<span class='label label-danger radius'>"."已删除"."</span>";
    }
}

/**
 * API接口数据输出
 * @param $status 内部业务状态码
 * @param $message 提示消息
 * @param array $data 数据
 * @param int $httpCode http状态码
 */
function apiShow($status, $message, $data=[], $httpCode=200)
{
    $data = [
        'status' => $status,
        'message' => $message,
        'data' => $data
    ];
    return json($data, $httpCode);
}