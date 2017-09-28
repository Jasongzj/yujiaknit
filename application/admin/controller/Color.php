<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/9/11
 * Time: 23:17
 */

namespace app\admin\controller;

use page\Page;
use think\Db;

class Color extends Basic
{
    public function index()
    {
        $map = array(
            'status' => array('neq', -1)
        );
        $cateList = Db::table('color')->where($map)->order('listorder')->select();

        $p = new Page($cateList, 15);
        $this->assign('p', $p);
        return $this->fetch();
    }

    public function add()
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            if ($post) {
                $proId = Db::table('color')->insertGetId($post);
                if ($proId) {
                    $this->success('添加成功');
                } else {
                    $this->error('添加失败，请重试！');
                }
            }
        } else {
            return $this->fetch();
        }
    }


    public function del()
    {
        $param = $this->request->param();
        $colorIds = array_unique((array)$param['id']);
        if (!empty($colorIds)) {
            $map = array(
                'id' => array('in', $colorIds)
            );
            Db::table('color')->where($map)->update($param);

            $this->result('', '200','删除成功','json');
        } else {
            $this->result('', '600','参数错误！','json');
        }
    }

    /**
     * 排序功能
     */
    public function listorder($id, $listorder)
    {
        $arr = array('id'=>$id, 'listorder'=>$listorder);
        //验证传入信息
        $validate = validate('Category');
        if(!$validate->scene('listorder')->check($arr)){
            $this->error($validate->getError());
        }
        $res = Db::table('color')->where('id', $id)->update($arr);
        //更新数据后通过ajax返回当前页面
        $this->result($this->request->server('HTTP_REFERER'), 200, 'success');
    }
}