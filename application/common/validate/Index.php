<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/9/1
 * Time: 17:17
 */

namespace app\common\validate;

use think\Validate;
class Index extends Validate
{
    protected $rule = [
        ['name', 'require', 'nameRequired'],
        ['email', 'require|email', 'emailRequired|emailUnformat'],
    ];

    /**
     * 场景设置
     */
    protected $scene = [
        'subscribe' => ['email'], //询盘场景

    ];
}