<?php
namespace app\admin\controller;

use think\Request;
use mod\payment\providers\Manage as Provider;
class Payment {
    protected $provider;
    public function __construct(Provider $manage) {
        $this->provider = $manage;
    }
    /**
     * 显示资源列表
     * @return \think\Response
     */
    public function index(Request $request) {
        $args  = $request->only(['nick', 'mobile'], 'get');
        $_time = $request->only(['start' => 0, 'end' => 0], 'get');
        // 重组时间范围
        $timer = [0, 0];
        if ($_time['start'])
            $timer[0] = strtotime($_time['start']);
        if ($_time['end'])
            $timer[1] = strtotime($_time['end'] . ' 23:59:59');
        $args['timer'] = $timer;
        // 读取列表
        return output($this->provider->getListForPage($args));
    }
    /**
     * 获取指定用户的付款记录
     * @param int $id
     */
    public function member($id) {
        return output($this->provider->getListByMember($id));
    }
}
