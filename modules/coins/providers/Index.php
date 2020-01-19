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
            ksort($character_list);
            $character_list = array_values($character_list);
            return $character_list;
         });
    }
    /**
     * 获取币当前单价
     */
    public function getPrice() {
        return Cache::remember(Config::CoinQuote, function () {
            return Change::order('timer desc')->group('id')->column('unit_price', 'id');
        });
    }
    public function getCoinPrice($coin_id) {
        if(Cache::get('coin_new_'.$coin_id)) {
            return Cache::get('coin_new_'.$coin_id);
        }
        $price = Change::order('timer desc')->find(['id' => $coin_id]);
        if( $price) {
            Cache::set('coin_new_'.$coin_id, $price['unit_price'], 600);
            return $price['unit_price'];
        }
        return 0;
    }
    public function getCoinPriceList($coin_id) {
        return Change::where('id',$coin_id)->where('timer','>',time() - 60 * 60 * 6)->select();
    }
    public function getOneCoinMaxPrice($coin_id) {
        return Change::where('id',$coin_id)->where('timer','>',time() - 60 * 60 * 24)->order('unit_price desc')->find();
    }
    public function getOneCoinMinPrice($coin_id) {
        return Change::where('id',$coin_id)->where('timer','>',time() - 60 * 60 * 24)->order('unit_price asc')->find();
    }
    public function getOneCoinFirstPrice($coin_id) {
        return Change::where('id',$coin_id)->where('timer','>',strtotime(date('Y-m-d')))->order('timer asc')->find();
    }
}
