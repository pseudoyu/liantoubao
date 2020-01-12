<?php

namespace mod\member\providers;

use mod\member\model\Member as Model;
use think\facade\Cache;
// use mod\common\traits\BaseProviders;

class Stats
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
     * Stats constructor.
     * @param Model $model
     */
    public function __construct(Model $model) {
        $this->model = $model;
    }
    // 统计会员数量,1小时更新一次
    public function length() {
        return Cache::remember('member_length', function(){
            $stats = $this->model->field('viper,count(*) as tp_count')
                               ->group('viper')->select();
            $data = [];
            foreach ($stats as $stat) {
                $data[$stat->viper] = $stat->tp_count;
            }
            return $data;
        }, 3600);
    }
}
