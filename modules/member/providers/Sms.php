<?php

namespace mod\member\providers;

use mod\member\model\Sms as Model;
// use mod\common\traits\BaseProviders;

class Sms
{
    // 引入公共库
    // use BaseProviders;

    /**
     * @var Model
     */
    protected $model;

    // 指定验证器
    // protected $validate = null;

    // 验证不过能跳出异常
    // protected $failException = true;

    /**
     * 配置模块别名映射表
     * @var array
     */
    // protected static $app_map = [];

    /**
     * Sms constructor.
     * @param Model $model
     */
    public function __construct(Model $model) {
        $this->model = $model;
    }
}
