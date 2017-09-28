<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/8/31
 * Time: 22:58
 */

namespace app\admin\controller;

use think\Controller;
class Index extends Controller
{
    public function index()
    {
        return $this->fetch();
    }
}