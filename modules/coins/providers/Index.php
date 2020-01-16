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
     * 格式化币种列表
     */
    public function formatLists() {
        return Cache::remember(Config::FORMAT_COINS, function () {
            $list = $this->getLists();
            $character_list = [];
            foreach ($list as $l) {
                $character = strtoupper(substr($l['code'],0,1));
                if( ! array_key_exists($character, $character_list)) {
                    $character_list[$character] = [
                        'title' => $character,
                        'key' => $character,
                        'items' => [],
                    ];
                }
                $character_list[$character]['items'][] = $l;
            }
            $character_list = array_values($character_list);
            return $character_list;
        });
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
