<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/19 0019
 * Time: 22:28
 */
namespace app\admin\controller;
use app\common\lib\Upload;
use app\common\tools\Util;
use think\facade\Config;
use think\Request;

class Image extends Base
{
    public function add(Request $request)
    {
        $file = $request->post();
        return json_encode($file);
    }

    /**
     * 七牛云图片上传
     */
    public function upload()
    {
        try{
            $image = Upload::image();
            $data = Config::get('qiniu.url').'/'.$image;
            return Util::show(1,"ok",$data);
        }catch (\Exception $e){
            return Util::show(0,"ok",$e->getMessage());
        }
    }
}