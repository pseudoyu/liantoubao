<?php
namespace mod\money\crontab;
/**
 * 获取币种映射对照表
 * @author Lazy 2019-11-23
 */
use think\console\Command;
use think\console\Input;
use think\console\Output;
use mod\money\model\Money;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use mod\coins\providers\Index as Coins;

class Rate extends Command {
    protected function configure() {
        $this->setName('crontab:money:rate')
             ->setDescription('获取最新的货币利率');
    }
    protected function execute(Input $input, Output $output) {
        try {
            $conf    = config('coin.money_rate');
            $results = [];
            // 初始化http客户端
            $client   = new Client([
                'base_uri' => $conf['url']
            ]);
            $response = $client->get('/finance/exchange/frate', [
                'query' => [
                    'type' => 1,
                    'key'  => $conf['key']
                ]
            ]);
            // 获取美元跟人民币的利率
            if ($response->getStatusCode() == 200) {
                $context = json_decode($response->getBody()->getContents(), true);
                if ( ! $context['error_code'] && $context['resultcode'] == '200') {
                    $result = $context['result'][0];
                    // 获取指定货币的利率
                    $results[] = ['code' => 'CNY', 'price' => $result['USDCNY']['closePri']];
                }
            }
            // 获取美元与跟USDT的利率
            $usdt      = 1 / app(Coins::class)->getCoinPrice(6);
            $results[] = ['code' => 'USDT', 'price' => $usdt];
            $model     = new Money();
            $model->saveAll($results);
            $output->info('最新利率获取成功');
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