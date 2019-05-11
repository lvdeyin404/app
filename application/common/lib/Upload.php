<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/29 0029
 * Time: 0:21
 */
namespace app\common\lib;

//引入鉴权类
use Qiniu\Auth;
//引入上传类
use Qiniu\Storage\UploadManager;

use think\facade\Config;

/**
 * 七牛云图片上传基础类库
 * Class Upload
 * @package app\common\lib
 */
class Upload
{
    /**
     * 图片上传
     */
    public static function image()
    {
        if(empty($_FILES['file']['tmp_name'])){
            exception("图片不合法",404);
        }
        //上传文件名
        $tmp_name = $_FILES['file']['tmp_name'];
        //上传文件后缀
        $ext = explode('.', $_FILES['file']['name'])[1];
        //获取七牛配置文件
        $config = Config::get('qiniu.');
        //鉴权对象
        $auth = new Auth($config['ak'], $config['sk']);
        //生成上传的token
        $token = $auth->uploadToken($config['bucket']);
        //七牛云保存的文件名
        $key = date('Y').'/'.date('M').'/'.date('D').substr(md5($tmp_name),0, 5).'.'.$ext;
        // 初始化 UploadManager 对象并进行文件的上传。
        $uploadMgr = new UploadManager();
        // 调用 UploadManager 的 putFile 方法进行文件的上传。
        list($ret, $err) = $uploadMgr->putFile($token, $key, $tmp_name);
        if ($err !== null) {
            return null;
        } else {
            return $key;
        }
    }
}
