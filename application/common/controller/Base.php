<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/9/1
 * Time: 0:33
 */

namespace app\common\controller;

use app\common\service\ReturnMsg;
use think\Controller;
use think\Request;

class Base extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

}