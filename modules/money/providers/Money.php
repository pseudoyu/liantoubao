<?php

namespace mod\money\providers;

use mod\money\model\Money as Model;
// use mod\common\traits\BaseProviders;

class Money
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
     * Money constructor.
     * @param Model $model
     */
    public function __construct(Model $model) {
        $this->model = $model;
    }
    // 获取最新的利率
    public function quotes() {
        return $this->model->field('code,price')->order('timer desc')->group('code')->column('price', 'code');
    }
}
