<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/8/16
 * Time: 17:04
 */

namespace app\index\controller;


use think\Request;
use think\Controller;
use think\Db;
class Products extends Basic
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function index()
    {
        //获取左侧目录
        $cateModel = model('category');
        $map = array(
            'status' => array('neq', -1)
        );
        $cate = $cateModel->where($map)->field('id, name')->select();

        $cate_id = $this->request->param('cate');
        $Model = Db::table('Products');
        $map = array(
            'cate_id' => $cate_id,
            'status' => array('neq', -1)
        );
        $products = $Model->where($map)->select();

        $this->assign('nav','products');
        $this->assign('cate', $cate);
        $this->assign('cate_id', $cate_id);
        $this->assign('products', $products);
        return $this->fetch();
    }

    /**
     * 商品细则页
     * @return mixed
     */
    public function detail()
    {
        $id = $this->request->param('id');
        $Model = Db::table('Products');
        $detail = $Model->where('id', $id)->select();

        $cateId = $detail[0]['cate_id'];
        $cateInfo = Db::table('category')->where('id', $cateId)->find();

        //获取颜色
        $cateColor = Db::table('category_color')->where('cate_id', $cateId)->select();
        $colorIds = array_column($cateColor,'color_id');
        $color = Db::table('Color')->where('id','in', $colorIds)->order('listorder')->select();

        $this->assign('color', $color);
        $this->assign('detail', $detail[0]);
        $this->assign('cate', $cateInfo);
        return $this->fetch();
    }

    /**
     * 询盘页
     * @return mixed
     */
    public function inquiry()
    {
        if ($this->request->isPost()) {
            $param = $this->request->post();
            $param['market'] = implode(",", $param['market']);
            $res = Db::table('inquiry')->insert($param);
            if ($res) {
                $this->success('Thanks for your inquiry! We will contact you later.');
            } else {
                $this->error('sorry...:(  There are something wrong...');
            }
        } else {
            $productId = $this->request->param('detail');
            $this->assign('product_id', $productId);
            return $this->fetch();
        }
    }

    /**
     * 验证询盘数据
     */
    public function validateParam()
    {
        $param = $this->request->post();
        $param = clean_input($param);

        $validate = validate('Products');
        $res = $validate->scene('inquiry')->check($param);

        if (!$validate->scene('inquiry')->check($param)) {
            if (!isset($param['market'])) {
                $this->result('',600, 'marketRequired','json');
            }
            $this->result('',600, $validate->getError(),'json');
        } else {
            $this->result($param,200,'','json');
        }
    }

}