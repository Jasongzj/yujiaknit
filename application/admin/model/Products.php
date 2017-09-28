<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/9/11
 * Time: 14:37
 */

namespace app\admin\model;


use think\Model;
use think\Db;
class Products extends Model
{
    public function productInfo($ids)
    {
        if (empty($ids)) {
            return $this->error( '缺少必要参数' );
        }
        if (!is_array($ids)) {
            return $this->error('条件格式错误');
        }
        $products = Db::name('Products')->where('id','in', $ids)->select();
        $list = array();
        foreach ($products as $product) {
            $list[$product['id']] = $product;
        }
        return $list;
    }
}