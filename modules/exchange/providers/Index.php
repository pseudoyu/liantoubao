<?php

namespace mod\exchange\providers;

use mod\exchange\providers\Config;
use mod\exchange\model\Exchange as Model;
use think\facade\Cache;

// use mod\common\traits\BaseProviders;

class Index
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
     * Index constructor.
     * @param Model $model
     */
    public function __construct(Model $model) {
        $this->model = $model;
    }
    /**
     * 读取币种列表
     */
    public function getLists() {
        return Cache::remember(Config::EXCHANGE, function () {
            return $this->model->getList([], false)->toArray();
        }, Config::EXPIRE);
    }
}
