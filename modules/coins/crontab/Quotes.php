<?php
namespace mod\coins\crontab;
/**
 * 获取币种的最新报价
 * @author Lazy 2019-11-23
 */

use think\console\Command;
use think\console\Input;
use think\console\Output;
use mod\coins\service\CoinMarketCap as Service;

class Quotes extends Command {
    protected function configure() {
        $this->setName('crontab:coin:quotes')
             ->setDescription('Get the latest currency quotes from your data provider.');
    }
    protected function execute(Input $input, Output $output) {
        $service = new Service();
        $result = $service->quotes();
        if ($result === true) {
            $output->info('最新报价获取成功');
        } else {
            $output->error($result);
        }
    }
}