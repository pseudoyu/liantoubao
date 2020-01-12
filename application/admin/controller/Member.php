<?php
namespace app\admin\controller;

use think\Request;
use mod\member\providers\Manage as Provider;
class Member {
    protected $prodiver;
    public function __construct(Provider $manage) {
        $this->prodiver = $manage;
    }
    /**
     * 读取会员统计
     */
    public function dashboard() {
        return output($this->prodiver->dashboard());
    }
    /**
     * 读取会员列表
     * @return \think\Response
     */
    public function index(Request $request) {
        $args = $request->only(['nick', 'mobile', 'viper'], 'get');
        return output($this->prodiver->getListForPage($args));
    }
    /**
     * 读取会员详情
     * @param  int $id
     * @return \think\Response
     */
    public function read($id) {
        return output($this->prodiver->find($id));
    }
}
