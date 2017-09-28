<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/9/7
 * Time: 14:29
 */

namespace app\admin\controller;

use page\Page;
use think\Db;
class News extends Basic
{
    public function index()
    {
        $newsList = Db::table('news')->where('status','neq', -1)->select();
        $p = new Page($newsList, 15);

        $this->assign('p',$p);
        return $this->fetch();
    }

    public  function add()
    {
        if ($this->request->isPost()) {
            $newsPost = $this->request->post();
            if ($newsPost) {
                $content['content'] = htmlentities($newsPost['content']);
                unset($newsPost['content']);
                $newsId = Db::table('news')->insertGetId($newsPost);
                if ($newsId) {
                    $content['news_id'] = $newsId;
                    $contentID = Db::table('news_content')->insert($content);
                    if ($contentID) {
                        $this->success('添加成功');
                    }
                } else {
                    $this->error('添加失败，请重试');
                }
            }
        } else {
            return $this->fetch();
        }
    }

    public function edit()
    {
        if ($this->request->isPost()) {
            $newsPost = $this->request->post();
            if ($newsPost) {
                $content['content'] = htmlentities($newsPost['content']);
                unset($newsPost['content']);
                $newsRes = Db::table('news')->where('id', $newsPost['id'])->update($newsPost);
                $contentRes = Db::table('news_content')->where('news_id', $newsPost['id'])->update($content);
                $this->success('编辑成功');
            }
        } else {
            $newsId = $this->request->param('id');
            if ($newsId && is_numeric($newsId)) {
                $news = Db::table('news')->where('id', $newsId)->find();
                $newsContent = Db::table('news_content')->where('news_id', $newsId)->find();
                $news['content'] = html_entity_decode($newsContent['content']);

                $this->assign('news', $news);
            } else {
                $this->error('缺少必要参数');
            }

            return $this->fetch();
        }
    }

    public function del()
    {
        $param = $this->request->param();
        $newsIds = array_unique((array)$param['id']);
        if (!empty($newsIds)) {
            $map = array(
                'id' => array('in', $newsIds)
            );
            Db::table('news')->where($map)->update($param);
            $contentMap = array(
                'news_id' => array('in', $newsIds)
            );
            Db::table('news_content')->where($contentMap)->update($param);
            $this->result('', '200','删除成功','json');
        } else {
            $this->result('', '600','参数错误！','json');
        }

    }
}