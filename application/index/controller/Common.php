<?php

namespace app\index\controller;

use think\Controller;
use mod\coins\providers\Index as Coins;

class Common extends Controller
{
    // 读取币种列表
    public function coins() {
        return output(app(Coins::class)->getLists());
    }
    // 读取币种即时报价
    public function quotes() {
        return output(app(Coins::class)->getPrice());
    }
}
