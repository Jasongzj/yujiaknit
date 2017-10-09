<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/9/7
 * Time: 1:27
 */

namespace app\admin\controller;

use page\Page;
use think\Db;
class Category extends Basic
{
    public function index()
    {
        $map = array(
            'status' => array('neq', -1)
        );
        $cateList = Db::table('category')->where($map)->select();

        $p = new Page($cateList, 15);
        $this->assign('p', $p);
        return $this->fetch();
    }

    public  function add()
    {
        if ($this->request->isPost()) {
            $categoryPost = $this->request->post();
            if ($categoryPost) {
                $colors = $categoryPost['color'];
                unset($categoryPost['color']);
                $cateId = Db::table('category')->insertGetId($categoryPost);

                foreach ($colors as $key => $color) {
                    $cateColor[$key]['cate_id'] = $cateId;
                    $cateColor[$key]['color_id'] = $color;
                }
                $cateColor = Db::table('category_color')->insertAll($cateColor);
                if ($cateId && $cateColor) {
                        $this->success('添加成功');
                } else {
                    $this->error('添加失败，请重试');
                }
            } else {
                $this->error('缺少必要参数');
            }
        } else {
            //获取所有颜色
            $colorMap = array(
                'status' => array('neq', -1)
            );
            $color = Db::table('color')->where($colorMap)->order('listorder')->select();
            $this->assign('color', $color);
            return $this->fetch();
        }
    }

    public function edit()
    {
        if($this->request->isPost()) {
            $categoryPost = $this->request->post();
            $cateId = $categoryPost['id'];
            if ($cateId && is_numeric($cateId)) {
                $colors = $categoryPost['color'];
                unset($categoryPost['color']);

                // 1.删除旧的品类颜色关系
                $del = array(
                    'status' => -1
                );
                Db::table('category_color')->where('cate_id',$cateId)->update($del);
                // 2.更新品类表数据
                Db::table('category')->where('id', $cateId)->update($categoryPost);
                // 3.写入新的品类颜色关系
                foreach ($colors as $key => $color) {
                    $cateColor[$key]['cate_id'] = $cateId;
                    $cateColor[$key]['color_id'] = $color;
                }
                $res = Db::table('category_color')->insertAll($cateColor);
                if ($res) {
                    $this->success('修改成功');
                } else {
                    $this->error('修改失败');
                }
            } else {
                $this->error('缺少必要参数');
            }
        } else {
            $cateId = $this->request->param('id');
            if ($cateId && is_numeric($cateId)) {
                $category = Db::table('category')->where('id', $cateId)->find();
                if ($category) {
                    //获取品类颜色
                    $colorIds = Db::table('category_color')->where('cate_id',$cateId)->column('color_id');
                    $category['color_id'] = $colorIds;

                    //获取所有颜色
                    $colorMap = array(
                        'status' => array('neq', -1)
                    );
                    $color = Db::table('color')->where($colorMap)->order('listorder')->select();
                    $this->assign('category', $category);
                    $this->assign('color', $color);
                    return $this->fetch();
                } else {
                    $this->error('暂时查无内容');
                }
            } else {
                $this->error('传入数据有误');
            }
        }
    }

    public function del()
    {
        $catePost = $this->request->post();
        $cateIds = array_unique((array)$catePost['id']);
        if (!empty($cateIds)) {
            $map = array(
                'id' => array('in', $cateIds)
            );
            Db::table('category')->where($map)->update($catePost);

            //删除品类颜色关系
            Db::table('category_color')->where('cate_id','in', $cateIds)->update(array('status'=>-1));

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
        $res = Db::table('category')->where('id', $id)->update($arr);
        //更新数据后通过ajax返回当前页面
        $this->result($this->request->server('HTTP_REFERER'), 200, 'success');
    }


}