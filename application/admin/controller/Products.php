<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/9/7
 * Time: 1:28
 */

namespace app\admin\controller;

use think\Db;
use page\Page;
use app\admin\model\Products as ProductsModel;
class Products extends Basic
{
    public function index()
    {
        $productList = Db::table( 'products' )->where('status', 'neq', -1)->select();

        $p = new Page( $productList, 15 );

        $this->assign( 'p', $p );
        return $this->fetch();
    }

    public function add()
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            if ($post) {
                $post = clean_input($post);
                $proId = Db::table('products')->insertGetId($post);
                if ($proId) {
                    $this->success('添加成功');
                } else {
                    $this->error('添加失败，请重试！');
                }
            }
        } else {
            //获取品类列表
            $cate = Db::table('category')->where('status',0)->select();
            $this->assign('cate', $cate);


            return $this->fetch();
        }
    }

    public function edit()
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            if ($post) {
                $post = clean_input( $post );
                $file = Db::table( 'products' )->where( 'id', $post['id'] )->find();
                /*if ($post['img_url'] != $file['img_url']) {
                    //删除旧照片 todo::
                    unlink("..".$file['img_url']);
                }*/

                $proId = Db::table( 'products' )->where( 'id', $post['id'] )->update( $post );
                if ($proId) {

                    $this->success( '修改成功' );
                } else {
                    $this->error( '修改失败，请重试！' );
                }
            }
        } else {
            $proId = $this->request->param('id');
            if ($proId && is_numeric($proId)) {
                $product = Db::table('products')->where('id', $proId)->find();

                $this->assign('product', $product);
            } else {
                $this->error('缺少必要参数');
            }
            //获取品类列表
            $cate = Db::table('category')->where('status',0)->select();
            $this->assign('cate', $cate);

            return $this->fetch();
        }
    }

    public function detail()
    {
        $proId = $this->request->param('id');
        if ($proId && is_numeric($proId)) {
            $product = Db::table('products')->where('id', $proId)->find();
            $cate = Db::table('category')->where('id', $product['cate_id'])->find();
            $product['cate'] = $cate['name'];

            $this->assign('product', $product);
        } else {
            $this->error('缺少必要参数');
        }
        return $this->fetch();
    }

    public function del()
    {
        $param = $this->request->param();
        $newsIds = array_unique((array)$param['id']);
        if (!empty($newsIds)) {
            $map = array(
                'id' => array('in', $newsIds)
            );
            Db::table('products')->where($map)->update($param);

            $this->result('', '200','删除成功','json');
        } else {
            $this->result('', '600','参数错误！','json');
        }

    }


    public function inquiry()
    {
        $inquiryList = Db::table('inquiry')->where('status','neq', -1)->select();
        if (!empty($inquiryList)) {
            $productIds = array_column($inquiryList, 'product_id');
            $proModel = new ProductsModel();
            $productList = $proModel->productInfo($productIds);
            //获取跳转询盘页的商品
            foreach ($inquiryList as $key => $inquiry) {
                $inquiryList[$key]['enter_product'] = $productList[$inquiry['product_id']];
            }
        }
        $p = new Page($inquiryList,15);
        $this->assign('p', $p);
        return $this->fetch();
    }

    public function delInquiry()
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
            Db::table('inquiry')->where($map)->update($data);

            $this->result('', '200','删除成功','json');
        } else {
            $this->result('', '600','参数错误！','json');
        }
    }

    public function upload()
    {
        $file = $this->request->file('file');

        $filename = md5(microtime(true));

        $info = $file->move('public/upload/products', $filename);

        if($info && $info->getPathname()) {
            $this->result('/'.str_replace('\\', '/', $info->getPathname()),'200', 'success','json');
        } else {
            $this->result('', 600,'upload fail','json');
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
        $res = Db::table('products')->where('id', $id)->update($arr);
        //更新数据后通过ajax返回当前页面
        $this->result($this->request->server('HTTP_REFERER'), 200, 'success');
    }
}