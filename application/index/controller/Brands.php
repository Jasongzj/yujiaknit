<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/9/2
 * Time: 15:59
 */

namespace app\index\controller;


use app\index\controller\Basic;

class Brands extends Basic
{
    public function index()
    {
        $this->assign('nav','brands');
        return $this->fetch();
    }
}