<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/8/16
 * Time: 18:26
 */

namespace app\index\controller;

use think\Controller;
use app\index\model\Category as CatelogModel;
use think\Request;
use think\Url;
use app\common\controller\Base;
use think\Db;

class Basic extends Controller
{

    public function __construct(Request $request = null)
    {
        parent::__construct( $request );
        //获取头部目录
        $category = Db::table('category')->where('status', 'neq', -1)->select();
        $this->assign('catelog', $category);
    }

}