<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/9/7
 * Time: 1:27
 */

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\File;
class Basic extends Controller
{
   public function __construct(Request $request = null)
   {
       parent::__construct( $request );
   }
}