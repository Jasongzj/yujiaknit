<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/9/4
 * Time: 17:40
 */

namespace app\index\controller;

use think\Db;
class News extends Basic
{
    public function index()
    {
        $map = array(
            'status' => array('neq', -1)
        );
        $list = Db::name('news')->where($map)->order('create_time desc')->paginate('20');
        $this->assign('list', $list);
        $this->assign('nav', 'news');
        return $this->fetch();
    }

    public function detail()
    {
        $id = $this->request->param('id');
        $map = array(
            'id' => $id,
            'status' => array('neq', -1)
        );
        $detail = Db::name('news')->where($map)->find();
        $content = Db::name('news_content')->where('news_id', $id)->find();
        $detail['content'] = html_entity_decode($content['content']);

        $this->assign('news', $detail);
        $this->assign('nav', 'news');
        return $this->fetch();
    }
}