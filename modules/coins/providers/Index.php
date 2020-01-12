<?php

namespace mod\coins\providers;

use mod\coins\model\Coins as Model;
use mod\common\traits\BaseProviders;
use think\facade\Cache;
use mod\coins\providers\Config;
use mod\coins\model\Change;

class Index
{
    // 引入公共库
    use BaseProviders;
    /**
     * @var Model
     */
    protected $model;

    // 指定验证器
    protected $validate = null;

    // 验证不过能跳出异常
    protected $failException = true;

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
        return Cache::remember(Config::COINS, function () {
            return $this->model->getList([], false)->toArray();
        }, Config::EXPIRE);
    }
    /**
     * 获取币当前单价
     */
    public function getPrice() {
        //return Cache::remember(Config::CoinQuote, function () {
            return Change::group('id')->order('timer desc')->column('unit_price', 'id');
        //});
    }
}
