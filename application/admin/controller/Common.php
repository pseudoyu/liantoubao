<?php
namespace app\admin\controller;

use think\Request;
use mod\coins\providers\Index as Provider;
use mod\member\providers\Stats;
use mod\payment\providers\Stats as PStats;
class Common {
    protected $provider;
    public function __construct(Provider $index) {
        $this->provider = $index;
    }
    /**
     * 获取统计信息
     * @return \think\Response
     */
    public function dashboard() {
        $member = array_sum(app(Stats::class)->length());
        $date   = date('Y-m-d', strtotime('-1 day'));
        $income = app(PStats::class)->income($date);
        return output(compact('member', 'income'));
    }
    /**
     * 获取币种列表
     * @return \think\Response
     */
    public function coins() {
        // 读取总列表
        $coins = $this->provider->getLists();
        // 读取最新的单价
        $prices = $this->provider->getPrice();
        foreach ($coins as &$coin) {
            $coin['price'] = isset($prices[$coin['id']]) ? $prices[$coin['id']] : 0;
        }
        return output($coins);
    }
}
