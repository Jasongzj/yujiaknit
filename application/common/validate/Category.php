<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/9/19
 * Time: 16:07
 */

namespace app\common\validate;

use think\Validate;
class Category extends Validate
{
    protected $rule = [
        ['listorder', 'number']
    ];

    protected $scene = [
        'listorder' => ['id', 'listorder'], //排序场景
    ];
}