<?php
/**
 * Api输出异常类处理
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/8 0008
 * Time: 22:55
 */
namespace app\common\exception;
use think\Exception;

class ApiException extends Exception
{
    public $message = '';

    public $HttpCode = 500;

    public $code = 0;

    public function __construct($message = "", $HttpCode = 0, $code = 0)
    {
        $this->message = $message;
        $this->HttpCode = $HttpCode;
        $this->code = $code;
    }
}