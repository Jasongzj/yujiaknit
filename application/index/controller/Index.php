<?php
namespace app\index\controller;

use app\index\controller\Basic;
use think\Request;
use think\Db;
class Index extends Basic
{
    public function index()
    {
        $model = model('category');
        $category = $model->where('status', 'neq', -1)->select();
        $this->assign('category', $category);
        $this->assign('nav', 'index');
        return $this->fetch();
    }

    public function subscribe()
    {
        if ($this->request->isPost()) {
            $param = $this->request->param();
            $validate = validate('index');
            $res = $validate->scene('subscribe')->check($param);
            if (!$res) {
                $this->result('', 600,$validate->getError(),'json');
            } else {
                $res = Db::name('subscribe')->insert($param);
                $this->result( '', 200, '', 'json' );
            }
        } else {
            return $this->fetch();
        }

    }

}
