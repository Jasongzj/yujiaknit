<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/8/31
 * Time: 23:19
 */

namespace app\common\validate;

use think\Validate;
class Products extends Validate
{
    protected $rule = [
        ['name', 'require', 'nameRequired'],
        ['email', 'require|email', 'emailRequired|emailUnformat'],
        ['quantity', 'require', 'quantityRequired'],
        ['market', 'require', 'marketRequired']
    ];

    /**
     * 场景设置
     */
    protected $scene = [
        'inquiry' => ['name', 'email', 'quantity', 'market'], //询盘场景

    ];
}