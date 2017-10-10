<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/9/7
 * Time: 1:27
 */

namespace app\admin\controller;


use think\Controller;
use think\Db;
use think\Session;

class Login extends Controller
{
    public function index()
    {
        if(Session::has('admin')){
            $this->redirect('/admin/index');
        }
        return $this->fetch();
    }

    public function login()
    {
        $username = $this->request->param('username');
        $password = $this->request->param('password');

        if (!trim($username)) {
            $this->result('',0,'用户名不能为空','json');
        }
        if (!trim($password)) {
            $this->result('',0,'密码不能为空','json');
        }

        //查询用户是否存在
        $userExist = Db::table('admin')->where('username', $username)->find();
        if (!$userExist) {
            $this->result('', 0, '用户名不存在','json');
        }

        //判断密码是否正确
        $encryptPassword = getMD5password($password);
        if ($encryptPassword != $userExist['password']) {
            $this->result('', 0, '密码错误', 'json');
        }

        //更新登录时间及登录ip
        $data = array(
            'lastlogintime' => time(),
            'lastloginip' => $this->request->ip()
        );
        Db::table('admin')->where('id', $userExist['id'])->update($data);

        //记录session
        Session::set('admin', $userExist);
        //todo: 保持登录状态

        $this->result('', 200, '登录成功', 'json');
    }

    /*
     * 退出登录
     */
    public function loginOut()
    {
        Session::set('admin', null);
        $this->redirect('/admin/login');
    }
}