<?php
namespace app\index\controller;

use Yansongda\Pay\Pay;
use Yansongda\Pay\Log;
use EasyWeChat\Foundation\Application;
class Index
{
    public function index()
    {
        $config = config('wechat.');
        $app = new Application($config);
        $notice = $app->notice;
        $messageId = $notice->send([
            'touser' => 'oG6W01OpKzRo-qN_c1BAyZkvf1Lg',
            'template_id' => 'mCDEoNosTR8avwWfWzXCEqKJ-wpZ5pPC8SxhZkAQscI',
            // 'template_id' => 'HpFbhc4UOPHNyDpsivZwQJuXnebULOQ_drXir23FfPU',测试
            'url' => 'https://app.chumuinfo.com/#/pages/quotation/detail?id=1',
            'data' => [
                'first' => '您有一个新的阈值提示',
                'keyword1' => '13207776774', // 账号ID
                'keyword2' => '2020-02-28 20:43', // 告警时间
                'keyword3' => '您关注的币种有新的变更', // 告警主题
                'keyword4' => ['BTC当前价格已低于您设定价格', '#FF6A6A'], // 告警订阅
                'keyword5' => '当前BTC的价格为【8777.47USD】，已低于您的预设值【8800】', // 告警信息
                'remark' => ['请点击进入链投宝查看详细信息','#FF0000'],
            ],
        ]);
        dump($messageId);exit;
    }

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }
}
