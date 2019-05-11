<?php
/**
 * 添加新闻数据验证
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/15 0015
 * Time: 21:42
 */
namespace app\common\validate;
use think\Validate;

class News extends Validate
{
    protected $rule = [
        'title' => 'require',
        'cate_id' => 'require',
        'is_comments' => 'require',
    ];

    protected $message  =   [
        'title.require' => '文章标题不能为空',
        'cate_id.require' => '分类标题不能为空',
        'is_comments.require' => '是否允许评论'
    ];
}