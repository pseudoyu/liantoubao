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
        return output($this->provider->getLists());
    }
    /**
     * 获取币种最新的报价
     */
    public function quotes() {
        // 读取最新的单价
        // $prices = $this->provider->getPrice();
        return output($this->provider->getPrice());
    }
}
