<?php
namespace mod\coins\crontab;
/**
 * 预警信息
 * @author Akatsuki 2020-02-20
 */

use app\index\controller\Trade;
use think\facade\Cache;
use think\console\Command;
use think\console\Input;
use think\console\Output;
use GuzzleHttp\Exception\RequestException;

class Rank extends Command {
    protected function configure() {
        $this->setName('crontab:coins:rank')
            ->setDescription('用户排行榜缓存');
    }
    protected function execute(Input $input, Output $output) {
        try {
            $rank = app(Trade::class)->rank_cache();
            $output->info('更新排行榜缓存成功');
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