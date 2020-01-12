<?php
namespace mod\coins\crontab;
/**
 * 获取币种映射对照表
 * @author Lazy 2019-11-23
 */
use think\console\Command;
use think\console\Input;
use think\console\Output;
use mod\coins\service\CoinMarketCap as Service;

class Map extends Command {
    protected function configure() {
        $this->setName('crontab:coin:map')
             ->setDescription('Get currency mapping table.');
    }
    protected function execute(Input $input, Output $output) {
        $service = new Service();
        $result  = $service->coinMap();
        if (is_numeric($result)) {
            $output->info('成功获取币种数据： ' . $result . ' 条');
        } else {
            $output->error($result);
        }
    }
}