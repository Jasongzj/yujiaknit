<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/9/1
 * Time: 0:37
 */

namespace app\common\service;


class ReturnMsg
{
    /**
     * 提示代码信息
     * @var type
     */
    public  static $msgType = array(
        //公共提示：
        "1" => array("false", "方法不存在"),
        "600" => array("false", "缺少必要参数"),
        "102" => array("false", "参数格式错误"),

        "200" => array("true", "操作成功"),
        "403" => array("false", "用户没有该权限"),

        "500" => array("false", "操作失败"),
    );
    /**
     * 获取提示信息 外部
     * @param type $type
     * @return type
     */
    public static function getMsg($type)
    {
        $msg = array();
        $msg['code'] = $type;
        $msg['success'] = self::$msgType[$type][0];
        $msg['msg'] = self::$msgType[$type][1];
        $msg['data'] = null;
        return $msg;
    }
}