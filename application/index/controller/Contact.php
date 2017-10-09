<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/8/11
 * Time: 0:05
 */

namespace app\index\controller;

use think\Controller;

class Contact extends Basic
{
    public function index()
    {
        $this->assign('nav', 'contact');
        return $this->fetch();
    }

    public function addContact()
    {
        $param = $this->request->post();
        $param = clean_input($param);
        $this->error('sorry');
    }
}