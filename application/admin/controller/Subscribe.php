<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/9/11
 * Time: 22:06
 */

namespace app\admin\controller;


use page\Page;
use think\Db;
class Subscribe extends Basic
{
    public function index()
    {
        $subList = Db::table( 'subscribe' )->where('status', 'neq', -1)->select();

        $p = new Page( $subList, 15 );

        $this->assign( 'p', $p );
        return $this->fetch();
    }

    public function del()
    {
        $post = $this->request->post();
        $ids = array_unique((array)$post['id']);

        $data = array(
            'status' => $post['status']
        );
        if (!empty($ids)) {
            $map = array(
                'id' => array('in', $ids)
            );
            Db::table('subscribe')->where($map)->update($data);

            $this->result('', '200','删除成功','json');
        } else {
            $this->result('', '600','参数错误！','json');
        }
    }

    public function contact()
    {
        $subList = Db::table( 'contact' )->where('status', 'neq', -1)->select();

        $p = new Page( $subList, 15 );

        $this->assign( 'p', $p );
        return $this->fetch();
    }

    public function delContact()
    {
        $post = $this->request->post();
        $ids = array_unique((array)$post['id']);

        $data = array(
            'status' => $post['status']
        );
        if (!empty($ids)) {
            $map = array(
                'id' => array('in', $ids)
            );
            Db::table('contact')->where($map)->update($data);

            $this->result('', '200','删除成功','json');
        } else {
            $this->result('', '600','参数错误！','json');
        }
    }



}