<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/9/11
 * Time: 23:17
 */

namespace app\admin\controller;

use page\Page;
use think\Db;

class Email extends Basic
{
    public function index()
    {
        return $this->fetch();

    }
    public function send(){
        $data = input('post.');
        \phpmailer\Email::send($data['email'],$data['title'],$data['content']);
    }
}