<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/15 0015
 * Time: 23:08
 */
namespace app\admin\controller;
use app\common\tools\Util;
use think\db\Where;
use think\Exception;
use think\facade\Config;
use think\Controller;
use think\Request;
use app\admin\model;

class News extends Base
{
    public $cate;

    /**
     * 获取配置文件
     * News constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->cate = Config::get('cate.lists');
    }

    public function index(Request $request)
    {
        $data = $request->param();//halt($data);
        dump($data);
        //将参数转换为url参数
        $query = http_build_query($data);
        dump($query);
        //转换查询条件
        $where = new Where();
        if(!empty($data['start_time']) && !empty($data['end_time']) && $data['end_time']>$data['start_time']){
            $where['create_time'] = [
                ['gt', strtotime($data['start_time'])],
                ['lt', strtotime($data['end_time'])]
            ];
        }
        if(!empty($data['cate_id'])){
            $where['cate_id'] = $data['cate_id'];
        }
        if(!empty($data['title'])){
            $where['title'] = $data['title'];
        }
        $news = new model\News();

        //模式一  采用tp5分页
        //$data = $news->getNews();
        //模式二  采用laypage插件
        $this->setPageParam($data);
        //获取数据
        $pageData = $news->getNewsByCondition($where, $this->from, $this->size);
        //获取总数
        $total = $news->getNewsCount($where);
        //获取总页数
        $pageTotal = ceil($total/Config::get('page.size'));
        return $this->fetch('',[
            'cate' => $this->cate,
            'list' => $pageData,
            'pageData' => $pageData,
            'total' => $total,
            'pageTotal' => $pageTotal,
            'curr' => $this->page,
            'start_time' => empty($data['start_time']) ? '': $data['start_time'],
            'end_time' => empty($data['end_time']) ? '' : $data['end_time'],
            'cate_id' => empty($data['cate_id']) ? '' : $data['cate_id'],
            'title' => empty($data['title']) ? '' : $data['title'],
            'query' => empty($query) ? '' : $query
        ]);
    }

    /**
     * 添加咨询
     * @param Request $request
     * @return false|mixed|string
     */
    public function add(Request $request)
    {
        if($request->isPost()){
            $data = input('post.');
            //验证数据完整性
            $validate = validate('News');
            if($validate->check($data)){
                $this->error($validate->getError());
            }else{
                //数据入库
                try{
                    $news = new model\News();
                    //添加数据
                    $data['create_time'] = time();
                    $id = $news->add($data);
                    if($id){
                        return Util::show(1, 'ok', ['url'=>url('news/index')]);
                    }else{
                        return Util::show(0, 'error', '插入失败');
                    }
                }catch (Exception $e){
                    return Util::show(-1, '异常', $e->getMessage());
                }
            }
        }else{
            $this->assign('cate', $this->cate);
            return $this->fetch();
        }
    }
}