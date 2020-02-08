<?php

namespace app\admin\controller;

use think\Request;
use mod\services\providers\Manage;

class Services
{
    protected $provider;

    public function __construct(Manage $provider)
    {
        $this->provider = $provider;
    }
    /**
     * 获取服务规则列表
     * @return \think\Response
     */
    public function index($id)
    {
        return output($this->provider->find($id));
    }

    /**
     * 修改已有服务规则信息
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        $put = $request->put('quoted');
        return $this->provider->update($id, $put) ? complete('修改成功') : wrong('修改失败');
    }

}
