<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/8/4
 * Time: 15:51
 */

namespace app\index\controller;

use think\Controller;

class About extends Basic
{
    public function index()
    {
        $this->assign('nav','about');
        return $this->fetch();
    }
}