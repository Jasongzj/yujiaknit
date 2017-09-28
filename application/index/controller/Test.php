<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/9/8
 * Time: 2:20
 */

namespace app\index\controller;


class Test extends Basic
{
    public function index()
    {
        return $this->fetch('test');
    }
}