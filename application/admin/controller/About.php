<?php
namespace app\admin\controller;

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
    public function read($id) {
        return output($this->provider->find($id));
    }
    /**
     * 保存新的介绍信息
     * @param  \think\Request $request
     * @return \think\Response
     */
    public function update(Request $request, $id) {
        $put = $request->only(['title' => '', 'banner' => '', 'context' => ''], 'put');
        return $this->provider->update($id, $put) ? complete('修改成功') : wrong('修改失败');
    }
}
