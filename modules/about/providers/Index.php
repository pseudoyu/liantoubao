<?php

namespace mod\about\providers;

use mod\about\model\About as Model;
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
    // 读取
    public function find($id) {
        return $this->model->find($id);
    }
    // 更新
    public function update($id, $data) {
        return $this->model->modify(['id'=>$id], $data);
    }
}
