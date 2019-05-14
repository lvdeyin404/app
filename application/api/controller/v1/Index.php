<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/13 0013
 * Time: 23:01
 */
namespace app\api\controller\v1;
use app\api\controller\Base;
use app\common\exception\ApiException;
use think\Controller;
use think\Exception;

class Index extends Base
{
    /**
     * 获取首页信息
     */
    public function index()
    {
        //获取首页头图信息
        $newsHeaders = model('News')->getNewsTitleImage(4);
        //获取分类名称
        $newsHeaders = $this->getCatName($newsHeaders);
        //获取首页推荐信息
        $newsPosition = model('News')->getNewsPosition(10);
        //获取分类名称
        $newsPosition = $this->getCatName($newsPosition);
        //组合数据
        $data = [
            'header' => $newsHeaders,
            'body' => $newsPosition
        ];
        return apiShow('1', 'ok', $data, 200);
    }

    /**
     *  客户端初始化
     *  检查APP是否需要升级
     */
    public function init()
    {
        //根据app_type查询最后一个版本号
        try{
            $version = model('version')->getVersion($this->header['apptype']);
        }catch (\Exception $e){
            throw new ApiException($e->getMessage(), '500');
        }
        //比较版本号是否需要升级
        if($this->header['version'] < $version[0]['version']){
            //需要更新 0 不需要更新 1 需要更新  2 强制更新
            $version[0]['is_upload'] = $version[0]['is_force'] = 1 ? 2 : 1;
        }else{
            //不需要更新
            $version[0]['is_upload'] = 0;
        }

        //记录信息  用于统计
        $active = [
            'version' => $this->header['version'],
            'app_type' => $this->header['apptype'],
            'did' => $this->header['did'],
            'model' => $this->header['model'],
        ];
        //插入数据表
        try{
            model('active')->add($active);
        }catch (\Exception $e){
            throw new ApiException($e->getMessage(), '500');
        }

        return apiShow('1', 'ok', $version, '200');
    }
}