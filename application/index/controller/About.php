<?php
namespace app\index\controller;

use think\Request;
use mod\about\providers\Index as Provider;
class About {
    protected $provider;
    public function __construct(Provider $index) {
        $this->provider = $index;
    }
    /**
     * 读取介绍信息
     * @return \think\Response
     */
    public function read(Request $request) {
        return output($this->provider->find(1));
    }
}
