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
use think\Session;

class Basic extends Controller
{
   public function __construct(Request $request = null)
   {
       parent::__construct( $request );
       $this->_init();
   }

   /*初始化方法*/
   private function _init()
   {

       //判断是否登录
       $isLogin = $this->isLogin();
       if (!$isLogin) {
           $this->redirect('/admin/login/index');
       }
   }

   /*判断是否登录*/
   public function isLogin()
   {
       $user = $this->getLoginUser();
       if (!empty($user) && is_array($user)) {
           return true;
       } else {
           return false;
       }
   }

   /*获取session中的登录信息*/
   public function getLoginUser()
   {
       return Session::get('admin');
   }
}