<?php
namespace mod\coins\crontab;
/**
 * 预警信息
 * @author Akatsuki 2020-02-20
 */

use Cassandra\Date;
use EasyWeChat\Foundation\Application;
use mod\coins\providers\Index;
use think\facade\Cache;
use think\console\Command;
use think\console\Input;
use think\console\Output;
use mod\money\model\Money;
use mod\member\model\Coins as CoinsModel;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use mod\coins\providers\Index as Coins;

class Alert extends Command {
    protected function configure() {
        $this->setName('crontab:coins:alert')
            ->setDescription('用户币种阈值超出提醒');
    }
    protected function execute(Input $input, Output $output) {
        try {
            $coin_price_array = app(Index::class)->getPrice();
            if( ! $coin_price_array) {
                $output->error('获取币种列表失败');
            }
            $time_now = date('Y-m-d H:i:s');
            $coin_code_array = app(Index::class)->getIdCode();
            foreach ($coin_price_array as $coin_id => $coin_price) {
                $cache = Cache::get('coin_limit_'.$coin_id);
                if( ! $cache) {
                    continue;
                }
                // 缓存锁
                $cache['lock'] = 1;
                Cache::set('coin_limit_'.$coin_id, $cache);
                $coin_code = array_key_exists($coin_id, $coin_code_array) ? $coin_code_array[$coin_id] : '您关注的货币';
                // 循环上阈值
                if($cache['profit']) {
                    $update = [];
                    foreach ($cache['profit'] as $cache_price => $uids) {
                        // 超过后发送通知
                        if($cache_price < $coin_price) {
                            // 检索用户信息
                            $user_info = app(\mod\member\providers\Index::class)->getByUids($uids);
                            foreach ($user_info as $user) {
                                $config = config('wechat.');
                                $app = new Application($config);
                                $notice = $app->notice;
                                $messageId = $notice->send([
                                    'touser' => $user['open_id'],
                                    'template_id' => 'mCDEoNosTR8avwWfWzXCEqKJ-wpZ5pPC8SxhZkAQscI',
                                    // 'template_id' => 'HpFbhc4UOPHNyDpsivZwQJuXnebULOQ_drXir23FfPU',
                                    'url' => 'https://app.chumuinfo.com/#/pages/quotation/detail?id='.$coin_id,
                                    'data' => [
                                        'first' => '您有一个新的阈值提示',
                                        'keyword1' => $user['mobile'] ? $user['mobile'] : '链投宝用户', // 账号ID
                                        'keyword2' => $time_now, // 告警时间
                                        'keyword3' => '您关注的币种有新的变更', // 告警主题
                                        'keyword4' => [$coin_code.'当前价格已高于您设定价格', '#FF6A6A'], // 告警订阅
                                        'keyword5' => '当前'.$coin_code.'的价格为【'.$coin_price.'USD】，已高于您的预设值【'.$cache_price.'USD】', // 告警信息
                                        'remark' => ['请点击进入链投宝查看详细信息','#FF0000'],
                                    ],
                                ]);
                                $update[] = $user['id'];
                            }
                            //unset 缓存
                            unset($cache['profit'][sprintf("%.5f",$cache_price)]);
                        }
                    }
                    // 更新数据表
                    if($update) {
                        $coin_model = new CoinsModel();
                        $coin_model->modify(['member_id' => $update, 'coin_id'=> $coin_id], ['profit_sms' => 1]);
                    }
                }
                // 循环下阈值
                if($cache['loss']) {
                    $update = [];
                    foreach ($cache['loss'] as $cache_price => $uids) {
                        // 超过后发送通知
                        if($cache_price > $coin_price) {
                            // 检索用户信息
                            $user_info = app(\mod\member\providers\Index::class)->getByUids($uids);
                            foreach ($user_info as $user) {
                                $config = config('wechat.');
                                $app = new Application($config);
                                $notice = $app->notice;
                                $messageId = $notice->send([
                                    'touser' => $user['open_id'],
                                    'template_id' => 'mCDEoNosTR8avwWfWzXCEqKJ-wpZ5pPC8SxhZkAQscI',
                                    // 'template_id' => 'HpFbhc4UOPHNyDpsivZwQJuXnebULOQ_drXir23FfPU',
                                    'url' => 'https://app.chumuinfo.com/#/pages/quotation/detail?id='.$coin_id,
                                    'data' => [
                                        'first' => '您有一个新的阈值提示',
                                        'keyword1' => $user['mobile'] ? $user['mobile'] : '链投宝用户', // 账号ID
                                        'keyword2' => $time_now, // 告警时间
                                        'keyword3' => '您关注的币种有新的变更', // 告警主题
                                        'keyword4' => [$coin_code.'当前价格已低于您设定价格', '#FF6A6A'], // 告警订阅
                                        'keyword5' => '当前'.$coin_code.'的价格为【'.$coin_price.'USD】，已低于您的预设值【'.$cache_price.'USD】', // 告警信息
                                        'remark' => ['请点击进入链投宝查看详细信息','#FF0000'],
                                    ],
                                ]);
                                $update[] = $user['id'];
                            }
                            //unset 缓存
                            unset($cache['loss'][sprintf("%.5f",$cache_price)]);
                        }
                    }
                    // 更新数据表
                    if($update) {
                        $coin_model = new CoinsModel();
                        $coin_model->modify(['member_id' => $update, 'coin_id'=> $coin_id], ['loss_sms' => 1]);
                    }
                }
                $cache['lock'] = 0;
                Cache::set('coin_limit_'.$coin_id, $cache);
            }
            $output->info('发送用户通知成功');
        } catch (\think\exception\ErrorException $e) {
            $output->error($this->formatError($e));
        }
    }
    /**
     * 格式化错误输出
     */
    protected function formatError($e) {
        return sprintf(
            "\n\n  Error: %s\n  Line: %d\n  File: %s\n",
            $e->getMessage(),
            $e->getLine(),
            $e->getFile()
        );
    }
}